<?php
namespace App\Lib\Pay;

use Swoft\Bean\BeanFactory;
use Swlib\Saber;

class Terminal
{
    /** @param   string  机构号 */
    private $inst_no;
    /** @param   string  商户号 */
    private $merchant_no;
    /** @param   string  终端名称 */
    private $name = "测试终端";
    /** @param   string  请求模块 */
    const POST_PATH = "/lcsw/terminal/100/add";

    public function __construct($inst_no, $merchant_no)
    {
        $this->inst_no = $inst_no;
        $this->merchant_no = $merchant_no;
    }

    /**
     * 请求终端
     * */
    public function getTerminal()
    {
        $rootPath = config("pay.rootPath");
        $info = $this->getPostInfo(["key" => config("pay.key")]);
        $saber = Saber::create([
            'base_uri' => $rootPath,
            'json' => "json"
        ]);
        $response = $saber->post(self::POST_PATH, $info);
        if($response->getStatusCode()!=200)return false;
        $content = $response->getParsedJsonArray();
        if($content["result_code"]!=="01")return false;
        Trace::recordTrace((int)$content["trace_no"], (int)$content["terminal_id"], $rootPath.self::POST_PATH);
        return $content;
    }

    /**
     * 准备请求数据
     * @param array $key
     * @return array
     * */
    private function getPostInfo($key)
    {
        $info = [
            "inst_no" => $this->inst_no,
            "trace_no" => Trace::createTraceNumber(),
            "merchant_no" => $this->merchant_no
        ];
        $info["key_sign"] = $this->createSign($info, $key);
        $info["terminal_name"] = $this->name;
        return $info;
    }

    /**
     * 生成签名
     * @param array $info 参数
     * @param array $key 令牌
     * @return string
     * */
    private function createSign($info, $key)
    {
        ksort($info,SORT_STRING);
        $signString = "";
        foreach($info as $k=>$v){
            $signString .= $k."=".$v."&";
        }
        $tokenKey = array_keys($key);
        $signString .= $tokenKey[0]."=".$key[$tokenKey[0]];
        return md5($signString);
    }

}
