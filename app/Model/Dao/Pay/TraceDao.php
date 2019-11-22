<?php declare(strict_types=1);
namespace App\Model\Dao\Pay;
use Swoft\Bean\Annotation\Mapping\Bean;
use App\Model\Entity\PayTrace;
use Throwable;

/**
 * 流水数据访问类
 * @Bean(name="TraceDao", scope=Bean::SINGLETON)
 *
 * @since 2.0
 */
class TraceDao
{
    /**
     * 记录流水
     * @param string $traceId
     * @param int $terminalId
     * @param string $url
     * @var string $createTime
     *
     * @return void
     * @throws Throwable
     */
    public function recordTrace(string $traceId, int $terminalId, string $url, string $createTime = "")
    {
        $insertArray = [
            "id" => $traceId,
            "terminal_id" => $terminalId,
            "url" => $url
        ];
        if(!empty($createTime))$insertArray["create_time"] = $createTime;
        PayTrace::Insert($insertArray);
    }

    /**
     * 获取流水
     * @param string $traceId
     *
     * @return array
     * @throws Throwable
     */
    public function getTraceById(string $traceId)
    {
        $info = PayTrace::select("create_time","url","terminal_id")
            ->where("id","=",$traceId)
            ->first();
        return empty($info) ? [] : $info->toArray();
    }

}
