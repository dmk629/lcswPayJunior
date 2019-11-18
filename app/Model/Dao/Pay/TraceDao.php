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
     * @var string $traceId
     * @var int $terminalId
     * @var string $url
     *
     * @return void
     * @throws Throwable
     */
    public function recordTrace(string $traceId, int $terminalId, string $url)
    {
        PayTrace::Insert([
            "id" => $traceId,
            "terminal_id" => $terminalId,
            "url" => $url
        ]);
    }

    /**
     * 获取流水（未完成）
     *
     * @return array
     * @throws Throwable
     */
    public function getTerminal()
    {
        $info = PayTrace::select("terminal_id","url")
            ->where("id","=","1")
            ->first();
        return empty($info) ? [] : $info->toArray();
    }

}
