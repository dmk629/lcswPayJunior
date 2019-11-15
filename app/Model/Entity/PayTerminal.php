<?php declare(strict_types=1);


namespace App\Model\Entity;

use Swoft\Db\Annotation\Mapping\Column;
use Swoft\Db\Annotation\Mapping\Entity;
use Swoft\Db\Annotation\Mapping\Id;
use Swoft\Db\Eloquent\Model;


/**
 * 终端信息表
 * Class PayTerminal
 *
 * @since 2.0
 *
 * @Entity(table="pay_terminal")
 */
class PayTerminal extends Model
{
    /**
     * 
     * @Id(incrementing=false)
     * @Column(name="id", prop="terminal_id")
     *
     * @var int
     */
    private $id;

    /**
     * 名称
     *
     * @Column()
     *
     * @var string
     */
    private $name;

    /**
     * 令牌
     *
     * @Column(name="access_token", prop="access_token")
     *
     * @var string
     */
    private $accessToken;

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
     * @param string $name
     *
     * @return void
     */
    public function setName(string $name): void
    {
        $this->name = $name;
    }

    /**
     * @param string $accessToken
     *
     * @return void
     */
    public function setAccessToken(string $accessToken): void
    {
        $this->accessToken = $accessToken;
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
     * @return string
     */
    public function getName(): ?string
    {
        return $this->name;
    }

    /**
     * @return string
     */
    public function getAccessToken(): ?string
    {
        return $this->accessToken;
    }

    /**
     * @return string
     */
    public function getCreateTime(): ?string
    {
        return $this->createTime;
    }

}
