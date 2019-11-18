<?php declare(strict_types=1);


namespace App\Model\Entity;

use Swoft\Db\Annotation\Mapping\Column;
use Swoft\Db\Annotation\Mapping\Entity;
use Swoft\Db\Annotation\Mapping\Id;
use Swoft\Db\Eloquent\Model;


/**
 * 流水表
 * Class PayTrace
 *
 * @since 2.0
 *
 * @Entity(table="pay_trace")
 */
class PayTrace extends Model
{
    /**
     * 
     * @Id(incrementing=false)
     * @Column(name="id", prop="trace_id")
     *
     * @var string
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
     * 请求地址
     *
     * @Column()
     *
     * @var string
     */
    private $url;

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
     * @param string $url
     *
     * @return void
     */
    public function setUrl(string $url): void
    {
        $this->url = $url;
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
    public function getUrl(): ?string
    {
        return $this->url;
    }

    /**
     * @return string
     */
    public function getCreateTime(): ?string
    {
        return $this->createTime;
    }

}
