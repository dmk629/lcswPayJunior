<?php
namespace App\Lib\Pay;

use Swlib\SaberGM;
use Swlib\Saber;

class Barcode
{
    /** @param   string  版本号 */
    private $version = "100";
    /** @param   string  支付方式 */
    private $payType;
    /** @param   string  接口类型 */
    private $serviceId = "010";
    /** @param   string  商户号 */
    private $merchantNo;
    /** @param   string  请求模块 */
    const POST_PATH = "/lcsw/pay/100/barcodepay";
    /** @param   string  查询模块 */
    const QUERY_PATH = "/lcsw/pay/100/query";

    public function __construct($payType, $merchantNo)
    {
        $this->payType = $payType;
        $this->merchantNo = $merchantNo;
    }

    /**
     * 请求支付
     * @param int $terminalId
     * @param string $authNo
     * @param int $totalFee
     * @param string $key
     *
     * @return int
     * */
    public function payOrder(int $terminalId, string $authNo, int $totalFee, string $key)
    {
        $rootPath = config("pay.rootPath");
        $info = $this->getPayInfo($terminalId, $authNo, $totalFee, ["access_token" => $key]);
        $saber = Saber::create([
            'base_uri' => $rootPath,
            'json' => "json"
        ]);
        $payResponse = $saber->post(self::POST_PATH, $info);
        if($payResponse->getStatusCode()!=200)return false;
        $payContent = $payResponse->getParsedJsonArray();
        var_dump($payContent);
        switch($payContent["result_code"]) {
            case "01":
                Trace::recordTrace($info["terminal_trace"], (int)$payContent["terminal_id"], $rootPath.self::POST_PATH);//成功记录
            case "02":
            case "99":
                return (int)$payContent["result_code"];
            case "03":
                break;
            default:
                return 66;
        }
        $queryInfo = $this->getQueryInfo($payContent["terminal_id"], $info["terminal_trace"], $payContent["out_trade_no"], ["key" => $key]);
        Trace::recordTrace($info["terminal_trace"], (int)$payContent["terminal_id"], $rootPath.self::POST_PATH);
        $queryContent = $this->getPayResult($queryInfo);
        if($queryContent){
            return $queryContent;
        }else{
            return 67;
        }
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
        $payStatus = 0;
        echo 1;
        while($payStatus==="01"){
            echo "hello;\n";
            $content = SaberGM::post($rootPath.self::QUERY_PATH, $queryInfo)->getParsedJsonArray();
            if($content["result_code"]==="01")return $content;
            var_dump($content);
            \Swoole\Coroutine\System::sleep(5);
        }
        return false;
    }

    /**
     * 准备支付数据
     * @param int $terminalId
     * @param string $authNo
     * @param int $totalFee
     * @param array $key
     *
     * @return array
     * */
    private function getPayInfo(int $terminalId, string $authNo, int $totalFee, array $key)
    {
        $info = [
            "pay_ver" => $this->version,
            "pay_type" => $this->payType,
            "service_id" => $this->serviceId,
            "merchant_no" => $this->merchantNo,
            "terminal_id" => (string)$terminalId,
            "terminal_trace" => Trace::createTraceNumber(),
            "terminal_time" => date("YmdHis"),
            "auth_no" => $authNo,
            "total_fee" => $totalFee
        ];
        $info["key_sign"] = $this->createSign($info, $key);
        return $info;
    }

    /**
     * 准备查询数据
     * @param int $terminalId
     * @param string $traceId
     * @param string $orderNo
     * @param array $key
     *
     * @return array
     * */
    private function getQueryInfo(int $terminalId, string $traceId, string $orderNo, array $key)
    {
        $info = [
            "pay_ver" => $this->version,
            "pay_type" => "000",
            "service_id" => $this->serviceId,
            "merchant_no" => $this->merchantNo,
            "terminal_id" => $terminalId,
            "terminal_trace" => $traceId,
            "terminal_time" => date("YmdHis"),
            "out_trade_no" => $orderNo,
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
