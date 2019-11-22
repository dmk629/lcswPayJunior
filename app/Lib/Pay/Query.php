<?php
namespace App\Lib\Pay;

use Swlib\Saber;

class Query
{
    /** @param   string  版本号 */
    private $version = "100";
    /** @param   string  接口类型 */
    private $serviceId = "010";
    /** @param   string  支付类型 */
    private $payType = "000";
    /** @param   string  商户号 */
    private $merchantNo;
    /** @param   string  查询模块 */
    const QUERY_PATH = "/lcsw/pay/100/query";

    public function __construct($merchantNo)
    {
        $this->merchantNo = $merchantNo;
    }

    /**
     * 查询
     * @param int $terminalId
     * @param string $traceId
     * @param array $key
     * @param string $orderNo
     * @param string $traceTime （可选）
     *
     * @return mixed
     * */
    public function payQuery(int $terminalId, string $traceId, string $key, string $orderNo, string $traceTime)
    {
        $queryInfo = $this->getQueryInfo($terminalId, $traceId, ["access_token" => $key], $orderNo, $traceTime);
        $queryContent = $this->getPayResult($queryInfo);
        return $queryContent ? $queryContent : false;
    }

    /**
     * 获取支付结果
     * @param array $queryInfo
     *
     * @return mixed
     * */
    private function getPayResult($queryInfo)
    {
        $rootPath = config("pay.rootPath");
        $saber = Saber::create([
            'base_uri' => $rootPath,
            'json' => "json"
        ]);
        for($i = 0;$i < 15;$i++){
            var_dump($queryInfo);
            $content = $saber->post(self::QUERY_PATH, $queryInfo)->getParsedJsonArray();
            var_dump($content);
            if($content["result_code"]==="01")return $content;
            \Swoole\Coroutine::sleep(5);
        }
        return false;
    }

    /**
     * 准备查询数据
     * @param int $terminalId
     * @param string $traceId
     * @param string $orderNo
     * @param string $key
     * @param string $traceTime (可选，$orderNo为空时必填)
     *
     * @return array
     * */
    private function getQueryInfo(int $terminalId, string $traceId, array $key, string $orderNo = "", string $traceTime = "")
    {
        $info = [
            "pay_ver" => $this->version,
            "pay_type" => $this->payType,
            "service_id" => $this->serviceId,
            "merchant_no" => $this->merchantNo,
            "terminal_id" => $terminalId,
            "terminal_trace" => $traceId,
            "terminal_time" => date("YmdHis"),
            "out_trade_no" => $orderNo
        ];
        $info["key_sign"] = $this->createSign($info, $key);
        if(empty($orderNo)) {
            $info["pay_trace"] = $traceId;
            $info["pay_time"] = $traceTime;
        }
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
