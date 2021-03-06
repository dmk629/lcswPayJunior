<?php
namespace App\Lib\Pay;
use Swoft\Bean\BeanFactory;

class Trace
{
    /**
     * 记录
     * @param string $traceId
     * @param int $terminalId
     * @param string $url
     * @param string $createTime
     * @return void
     * */
    public static function recordTrace(string $traceId, int $terminalId, string $url, $createTime)
    {
        $traceDao = BeanFactory::getBean("TraceDao");
        $traceDao->recordTrace($traceId, $terminalId, $url, $createTime);
    }

    /**
     * 生成流水号
     * @return string
     * */
    public static function createTraceNumber()
    {
        $date = date("YmdHis");
        mt_srand(self::makeSeed());
        $random = (string)mt_rand(0,999999999999999999);
        if(strlen($random)<18){
            for($i=0;$i<18-strlen($random);$i++){
                $random = "0".$random;
            }
        }
        return (string)$date.$random;
    }

    /**
     * 生成种子
     * @return string
     * */
    private static function makeSeed()
    {
        list($microSecond,)  = explode(" ",microtime());
        return ((float) $microSecond * 100000);
    }

}
