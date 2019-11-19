<?php declare(strict_types=1);
namespace App\Model\Dao\Pay;
use Swoft\Bean\Annotation\Mapping\Bean;
use App\Model\Entity\PayRefund;
use Throwable;

/**
 * 退款数据访问类
 * @Bean(name="RefundDao", scope=Bean::SINGLETON)
 *
 * @since 2.0
 */
class RefundDao
{
    /**
     * 记录退款
     * @var array $refundInfo
     *
     * @return void
     * @throws Throwable
     */
    public function addRefund(array $refundInfo)
    {
        PayRefund::Insert([
            "terminal_id" => $refundInfo["terminal_id"],
            "terminal_trace" => $refundInfo["terminal_trace"],
            "out_trade_no" => $refundInfo["out_trade_no"],
            "total_fee" => $refundInfo["refund_fee"],
            "status" => empty($refundInfo["status"]) ? 1 : $refundInfo["status"],
            "out_refund_no" => $refundInfo["out_refund_no"]
        ]);
    }

}
