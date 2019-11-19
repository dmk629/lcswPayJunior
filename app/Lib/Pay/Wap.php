<?php
namespace App\Lib\Pay;

use Swlib\SaberGM;

class Wap
{
    /** @param   string  商户号 */
    private $merchantNo;
    /** @param   string  请求模块 */
    const GET_PATH = "/lcsw/open/wap/110/pay";

    public function __construct($merchantNo)
    {
        $this->merchantNo = $merchantNo;
    }

    /**
     * 请求支付
     * @param int $terminalId
     * @param int $totalFee
     * @param string $key
     *
     * @return mixed
     * */
    public function payOrder(int $terminalId, int $totalFee, string $key)
    {
        $rootPath = config("pay.rootPath");
        $info = $this->getPayInfo($terminalId, $totalFee, ["access_token" => $key]);
        $getParam = "?";
        foreach($info as $key=>$value){
            $getParam .= $key."=".$value."&";
        }
        $getParam = rtrim("&",$getParam);
        var_dump($rootPath.self::GET_PATH.$getParam);
        $payResponse = SaberGM::get($rootPath.self::GET_PATH.$getParam);
        var_dump($payResponse);
        if($payResponse->getStatusCode()!=200)return false;
        $payRedirect = $payResponse->redirect_headers;
        $redirectInfo = array_shift($payRedirect);
        return $redirectInfo["location"];
    }

    /**
     * 准备支付数据
     * @param int $terminalId
     * @param int $totalFee
     * @param array $key
     *
     * @return array
     * */
    private function getPayInfo(int $terminalId, int $totalFee, array $key)
    {
        $info = [
            "merchant_no" => $this->merchantNo,
            "terminal_id" => (string)$terminalId,
            "terminal_trace" => Trace::createTraceNumber(),
            "terminal_time" => date("YmdHis"),
            "total_fee" => $totalFee
        ];
        $info["key_sign"] = $this->createSign($info, $key);
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
        $signString = "";
        foreach($info as $k=>$v){
            $signString .= $k."=".$v."&";
        }
        $tokenKey = array_keys($key);
        $signString .= $tokenKey[0]."=".$key[$tokenKey[0]];
        return md5($signString);
    }

}