<?php
namespace App\Lib\Pay;

class Notify
{
    /**
     * 验签
     * @param array $message
     * @param string $key
     *
     * @return bool
     * */
    public static function verifySign(array $message, string $key)
    {
        $signArray = [
            "return_code" => $message["return_code"],
            "return_msg" => $message["return_msg"],
            "result_code" => $message["result_code"],
            "pay_type" => $message["pay_type"],
            "user_id" => $message["user_id"],
            "merchant_name" => $message["merchant_name"],
            "merchant_no" => $message["merchant_no"],
            "terminal_id" => $message["terminal_id"],
            "terminal_trace" => $message["terminal_trace"],
            "terminal_time" => $message["terminal_time"],
            "total_fee" => $message["total_fee"],
            "end_time" => $message["end_time"],
            "out_trade_no" => $message["out_trade_no"],
            "channel_trade_no" => $message["channel_trade_no"],
            "attach" => $message["attach"],
            "receipt_fee" => $message["receipt_fee"],
        ];
        $signString = self::createSign($signArray, ["access_token" => $key]);
        if($signString!==$message["key_sign"])return false;
        return true;
    }

    /**
     * 生成响应
     * @param bool $status
     * @param string $message
     *
     * @return array
     * */
    public static function returnMessage(bool $status, string $message)
    {
        $returnArray = ["return_msg" => $message];
        $returnArray["return_code"] = $status ? "01" : "02";
        return $returnArray;
    }

    /**
     * 生成签名
     * @param array $info 参数
     * @param array $key 令牌
     * @return string
     * */
    private static function createSign($info, $key)
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
