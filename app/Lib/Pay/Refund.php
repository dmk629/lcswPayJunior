<?php
namespace App\Lib\Pay;

use Swlib\Saber;

class Refund
{
    /** @param   string  版本号 */
    private $version = "100";
    /** @param   string  支付方式 */
    private $payType = "000";
    /** @param   string  接口类型 */
    private $serviceId = "030";
    /** @param   string  商户号 */
    private $merchantNo;
    /** @param   string  请求模块 */
    const POST_PATH = "/lcsw/pay/100/refund";

    public function __construct($merchantNo)
    {
        $this->merchantNo = $merchantNo;
    }

    /**
     * 请求退款
     * @param int $terminalId
     * @param int $refundFee
     * @param string $tradeNo
     * @param string $key
     *
     * @return mixed
     * */
    public function refundOrder(int $terminalId, int $refundFee, string $tradeNo, string $key)
    {
        $rootPath = config("pay.rootPath");
        $info = $this->getRefundInfo($terminalId, $refundFee, $tradeNo, ["access_token" => $key]);
        //使用组件请求接口
        $saber = Saber::create([
            'base_uri' => $rootPath,
            'json' => "json"
        ]);
        $payResponse = $saber->post(self::POST_PATH, $info);
        if($payResponse->getStatusCode()!=200)return 1;
        $payContent = $payResponse->getParsedJsonArray();
        if($payContent["return_code"]!="01")return 1;
        if($payContent["result_code"]!="01")return 2;
        Trace::recordTrace($info["terminal_trace"], (int)$payContent["terminal_id"], $rootPath.self::POST_PATH, $info["terminal_time"]);
        return $payContent;
    }

    /**
     * 准备退款数据
     * @param int $terminalId
     * @param int $refundFee
     * @param string $tradeNo
     * @param array $key
     *
     * @return array
     * */
    private function getRefundInfo(int $terminalId, int $refundFee, string $tradeNo, array $key)
    {
        $info = [
            "pay_ver" => $this->version,
            "pay_type" => $this->payType,
            "service_id" => $this->serviceId,
            "merchant_no" => $this->merchantNo,
            "terminal_id" => (string)$terminalId,
            "terminal_trace" => Trace::createTraceNumber(),
            "terminal_time" => date("YmdHis"),
            "refund_fee" => $refundFee,
            "out_trade_no" => $tradeNo
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
