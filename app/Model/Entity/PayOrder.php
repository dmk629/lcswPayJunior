<?php declare(strict_types=1);


namespace App\Model\Entity;

use Swoft\Db\Annotation\Mapping\Column;
use Swoft\Db\Annotation\Mapping\Entity;
use Swoft\Db\Annotation\Mapping\Id;
use Swoft\Db\Eloquent\Model;


/**
 * 订单表
 * Class PayOrder
 *
 * @since 2.0
 *
 * @Entity(table="pay_order")
 */
class PayOrder extends Model
{
    /**
     * 
     * @Id(incrementing=false)
     * @Column(name="id", prop="order_id")
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
     * 金额，单位分
     *
     * @Column(name="total_fee", prop="total_fee")
     *
     * @var int
     */
    private $totalFee;

    /**
     * 订单状态->1:未支付,2:已支付
     *
     * @Column(name="status", prop="order_status")
     *
     * @var int
     */
    private $status;

    /**
     * 利楚唯一订单号
     *
     * @Column(name="out_trade_no", prop="out_trade_no")
     *
     * @var string
     */
    private $outTradeNo;

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
     * @param int $totalFee
     *
     * @return void
     */
    public function setTotalFee(int $totalFee): void
    {
        $this->totalFee = $totalFee;
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
     * @param string $outTradeNo
     *
     * @return void
     */
    public function setOutTradeNo(string $outTradeNo): void
    {
        $this->outTradeNo = $outTradeNo;
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
     * @return int
     */
    public function getTotalFee(): ?int
    {
        return $this->totalFee;
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
    public function getOutTradeNo(): ?string
    {
        return $this->outTradeNo;
    }

    /**
     * @return string
     */
    public function getCreateTime(): ?string
    {
        return $this->createTime;
    }

}
