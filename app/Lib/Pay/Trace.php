<?php
namespace App\Lib\Pay;
use Swoft\Bean\BeanFactory;

class Trace
{
    /**
     * 记录
     * @param int $traceId
     * @param int $terminalId
     * @param string $url
     * @return void
     * */
    public static function recordTrace(int $traceId, int $terminalId, string $url)
    {
        $traceDao = BeanFactory::getBean("TraceDao");
        $traceDao->recordTrace($traceId, $terminalId, $url);
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
        return $date.$random;
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
