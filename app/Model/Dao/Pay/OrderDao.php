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
     * 订单列表
     * @param int $page
     * @param int $size
     *
     * @return array
     * @throws Throwable
     */
    public function orderList(int $page, int $size)
    {
        $orderList = PayOrder::select("id", "total_fee", "status", "out_trade_no", "create_time","terminal_trace")
            ->orderBy("create_time","desc")
            ->forPage($page, $size)
            ->get();
        return empty($orderList) ? [] : $orderList->toArray();
    }

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
            "terminal_id" => $orderInfo["terminal_id"],
            "terminal_trace" => $orderInfo["terminal_trace"],
            "total_fee" => $orderInfo["total_fee"],
            "out_trade_no" => $orderInfo["out_trade_no"],
            "status" => empty($orderInfo["status"]) ? 1 : $orderInfo["status"]
        ]);
    }

    /**
     * 更新订单状态
     * @var array $tradeNo
     * @var int $status
     *
     * @return bool
     * @throws Throwable
     */
    public function updateOrderStatus(array $tradeNo, int $status)
    {
        return PayOrder::whereIn("out_trade_no", $tradeNo)->update(["status" => $status]);
    }

    /**
     * 获取订单
     * @param string $tradeNo
     *
     * @return array
     * @throws Throwable
     */
    public function getOrderByTradeNo(string $tradeNo)
    {
        $info = PayOrder::select("terminal_id","total_fee","status")
            ->where("out_trade_no","=",$tradeNo)
            ->first();
        return empty($info) ? [] : $info->toArray();
    }

    /**
     * 获取订单
     * @param array $id
     *
     * @return array
     * @throws Throwable
     */
    public function getOrderById(array $id)
    {
        $info = PayOrder::select("terminal_trace","total_fee","status","out_trade_no","create_time")
            ->where("id","=",$id)
            ->first();
        return empty($info) ? [] : $info->toArray();
    }

}
