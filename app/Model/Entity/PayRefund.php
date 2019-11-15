<?php declare(strict_types=1);


namespace App\Model\Entity;

use Swoft\Db\Annotation\Mapping\Column;
use Swoft\Db\Annotation\Mapping\Entity;
use Swoft\Db\Annotation\Mapping\Id;
use Swoft\Db\Eloquent\Model;


/**
 * 退款表
 * Class PayRefund
 *
 * @since 2.0
 *
 * @Entity(table="pay_refund")
 */
class PayRefund extends Model
{
    /**
     * 
     * @Id(incrementing=false)
     * @Column(name="id", prop="refund_id")
     *
     * @var int
     */
    private $id;

    /**
     * 终端号
     *
     * @Column(name="terminal_id", prop="terminal_id")
     *
     * @var int
     */
    private $terminalId;

    /**
     * 终端流水号
     *
     * @Column(name="terminal_trace", prop="terminal_trace")
     *
     * @var string
     */
    private $terminalTrace;

    /**
     * 利楚唯一订单号
     *
     * @Column(name="out_trade_no", prop="out_trade_no")
     *
     * @var string
     */
    private $outTradeNo;

    /**
     * 退款金额，单位分
     *
     * @Column(name="refund_fee", prop="refund_fee")
     *
     * @var int
     */
    private $refundFee;

    /**
     * 退款状态->1:未退款,2:已退款
     *
     * @Column(name="status", prop="refund_status")
     *
     * @var int
     */
    private $status;

    /**
     * 利楚唯一退款单号
     *
     * @Column(name="out_refund_no", prop="out_refund_no")
     *
     * @var string
     */
    private $outRefundNo;

    /**
     * 
     *
     * @Column(name="create_time", prop="create_time")
     *
     * @var string
     */
    private $createTime;


    /**
     * @param int $id
     *
     * @return void
     */
    public function setId(int $id): void
    {
        $this->id = $id;
    }

    /**
     * @param int $terminalId
     *
     * @return void
     */
    public function setTerminalId(int $terminalId): void
    {
        $this->terminalId = $terminalId;
    }

    /**
     * @param string $terminalTrace
     *
     * @return void
     */
    public function setTerminalTrace(string $terminalTrace): void
    {
        $this->terminalTrace = $terminalTrace;
    }

    /**
     * @param string $outTradeNo
     *
     * @return void
     */
    public function setOutTradeNo(string $outTradeNo): void
    {
        $this->outTradeNo = $outTradeNo;
    }

    /**
     * @param int $refundFee
     *
     * @return void
     */
    public function setRefundFee(int $refundFee): void
    {
        $this->refundFee = $refundFee;
    }

    /**
     * @param int $status
     *
     * @return void
     */
    public function setStatus(int $status): void
    {
        $this->status = $status;
    }

    /**
     * @param string $outRefundNo
     *
     * @return void
     */
    public function setOutRefundNo(string $outRefundNo): void
    {
        $this->outRefundNo = $outRefundNo;
    }

    /**
     * @param string $createTime
     *
     * @return void
     */
    public function setCreateTime(string $createTime): void
    {
        $this->createTime = $createTime;
    }

    /**
     * @return int
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return int
     */
    public function getTerminalId(): ?int
    {
        return $this->terminalId;
    }

    /**
     * @return string
     */
    public function getTerminalTrace(): ?string
    {
        return $this->terminalTrace;
    }

    /**
     * @return string
     */
    public function getOutTradeNo(): ?string
    {
        return $this->outTradeNo;
    }

    /**
     * @return int
     */
    public function getRefundFee(): ?int
    {
        return $this->refundFee;
    }

    /**
     * @return int
     */
    public function getStatus(): ?int
    {
        return $this->status;
    }

    /**
     * @return string
     */
    public function getOutRefundNo(): ?string
    {
        return $this->outRefundNo;
    }

    /**
     * @return string
     */
    public function getCreateTime(): ?string
    {
        return $this->createTime;
    }

}
