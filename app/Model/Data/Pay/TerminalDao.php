<?php declare(strict_types=1);
namespace App\Model\Dao\Pay;
use App\Model\Entity\PayTerminal;
use Swoft\Bean\Annotation\Mapping\Bean;
use Throwable;

/**
 * 终端数据访问类
 * @Bean()
 *
 * @since 2.0
 */
class TerminalDao
{

    /**
     * 创建终端
     * @var int $terminal_id
     * @var string $name
     * @var string $access_token
     *
     * @return void
     * @throws Throwable
     */
    public function createTerminal(int $terminal_id, string $name, string $access_token)
    {
        PayTerminal::updateOrInsert([
            "id" => $terminal_id,
            "name" => $name,
            "access_token" => $access_token
        ]);
    }

    /**
     * 获取终端信息
     *
     * @return array
     * @throws Throwable
     */
    public function getTerminal()
    {
        return PayTerminal::select("id","access_token")->first()->toArray();
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
        return PayTerminal::select("nickname")->whereIn("player_id",$player_id)->get()->toArray();
    }

}
