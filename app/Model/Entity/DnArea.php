<?php declare(strict_types=1);


namespace App\Model\Entity;

use Swoft\Db\Annotation\Mapping\Column;
use Swoft\Db\Annotation\Mapping\Entity;
use Swoft\Db\Annotation\Mapping\Id;
use Swoft\Db\Eloquent\Model;


/**
 * 地区表
 * Class DnArea
 *
 * @since 2.0
 *
 * @Entity(table="dn_area")
 */
class DnArea extends Model
{
    /**
     * 
     * @Id()
     * @Column(name="ar_id", prop="arId")
     *
     * @var int
     */
    private $arId;

    /**
     * 父级id
     *
     * @Column(name="ar_pid", prop="arPid")
     *
     * @var int
     */
    private $arPid;

    /**
     * 地区名
     *
     * @Column(name="ar_name", prop="arName")
     *
     * @var string
     */
    private $arName;

    /**
     * 地区等级->1:城市,2:地区
     *
     * @Column(name="ar_level", prop="arLevel")
     *
     * @var int
     */
    private $arLevel;


    /**
     * @param int $arId
     *
     * @return void
     */
    public function setArId(int $arId): void
    {
        $this->arId = $arId;
    }

    /**
     * @param int $arPid
     *
     * @return void
     */
    public function setArPid(int $arPid): void
    {
        $this->arPid = $arPid;
    }

    /**
     * @param string $arName
     *
     * @return void
     */
    public function setArName(string $arName): void
    {
        $this->arName = $arName;
    }

    /**
     * @param int $arLevel
     *
     * @return void
     */
    public function setArLevel(int $arLevel): void
    {
        $this->arLevel = $arLevel;
    }

    /**
     * @return int
     */
    public function getArId(): ?int
    {
        return $this->arId;
    }

    /**
     * @return int
     */
    public function getArPid(): ?int
    {
        return $this->arPid;
    }

    /**
     * @return string
     */
    public function getArName(): ?string
    {
        return $this->arName;
    }

    /**
     * @return int
     */
    public function getArLevel(): ?int
    {
        return $this->arLevel;
    }

}
