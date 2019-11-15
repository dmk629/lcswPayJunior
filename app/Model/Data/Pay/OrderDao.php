<?php declare(strict_types=1);
namespace App\Model\Dao\Pay;
use App\Model\Entity\PayOrder;
use Swoft\Bean\Annotation\Mapping\Bean;
use Throwable;

/**
 * 玩家数据访问类
 * @Bean()
 *
 * @since 2.0
 */
class OrderDao
{

    /**
     * 根据字段获取数据
     * @var array $field
     * @var int $limit
     *
     * @return array
     * @throws Throwable
     */
    public function getPlayerListByField(array $field, int $limit = 12)
    {
        $last_field = array_pop($field);
        $player_model = PayOrder::select($last_field)->take($limit);
        if(!empty($field))$player_model = $player_model->addSelect($field);
        $player_list = $player_model->get()->toArray();
        return $player_list;
    }

    /**
     * 获取非重复player_id
     *
     * @param array $player_id
     * @param int $count
     *
     * @return array
     * @throws Throwable
     */
    public function getDifferentPlayerId(array $player_id, int $count)
    {
        $extra_player_cursor = PayOrder::select("player_id")
            ->whereNotIn("player_id",$player_id)
            ->inRandomOrder()
            ->take($count)
            ->cursor();
        foreach($extra_player_cursor as $cursor_column){
            $player_id[] = $cursor_column["player_id"];
        }
        return $player_id;
    }

    /**
     * 获取相应player_id信息
     * @var array $player_id
     *
     * @return array
     * @throws Throwable
     */
    public function getPlayerListByPlayerId(array $player_id)
    {
        return PayOrder::select("nickname")->whereIn("player_id",$player_id)->get()->toArray();
    }

}
