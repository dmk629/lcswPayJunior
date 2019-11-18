<?php declare(strict_types=1);
namespace App\Model\Dao\Pay;
use Swoft\Bean\Annotation\Mapping\Bean;
use App\Model\Entity\PayOrder;
use Throwable;

/**
 * 订单数据访问类
 * @Bean(name="OrderDao", scope=Bean::SINGLETON)
 *
 * @since 2.0
 */
class OrderDao
{
    /**
     * 记录订单
     * @var array $orderInfo
     *
     * @return void
     * @throws Throwable
     */
    public function addOrder(array $orderInfo)
    {
        PayOrder::Insert([
            "terminal_id" => $orderInfo,
            "terminal_trace" => $orderInfo,
            "total_fee" => $orderInfo,
            "out_trade_no" => $orderInfo
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
