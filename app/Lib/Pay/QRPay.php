<?php
namespace App\Lib\Pay;

use Swlib\Saber;

class QRPay
{
    /** @param   string  版本号 */
    private $version = "110";
    /** @param   string  支付方式 */
    private $payType = "000";
    /** @param   string  接口类型 */
    private $serviceId = "016";
    /** @param   string  商户号 */
    private $merchantNo;
    /** @param   string  请求模块 */
    const POST_PATH = "/lcsw/pay/110/qrpay";

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
        $saber = Saber::create([
            'base_uri' => $rootPath,
            'json' => "json"
        ]);
        $payResponse = $saber->post(self::POST_PATH, $info);
        if($payResponse->getStatusCode()!=200)return false;
        $payContent = $payResponse->getParsedJsonArray();
        if($payContent["result_code"]!=="01")return false;
        Trace::recordTrace($info["terminal_trace"], (int)$payContent["terminal_id"], $rootPath.self::POST_PATH);//成功记录
        return $payContent["qr_url"];
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
            "pay_ver" => $this->version,
            "pay_type" => $this->payType,
            "service_id" => $this->serviceId,
            "merchant_no" => $this->merchantNo,
            "terminal_id" => (string)$terminalId,
            "terminal_trace" => Trace::createTraceNumber(),
            "terminal_time" => date("YmdHis"),
            "total_fee" => $totalFee
        ];
        $info["key_sign"] = $this->createSign($info, $key);
        $info["notify_url"] = config("pay.notifyModule");
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
