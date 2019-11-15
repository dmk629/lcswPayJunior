<?php declare(strict_types=1);

namespace App\Http\Controller\Pay;

use Swoft\Http\Server\Annotation\Mapping\Controller;
use Swoft\Http\Server\Annotation\Mapping\RequestMapping;
use Swoft\Http\Server\Annotation\Mapping\RequestMethod;
use Swoft\Http\Message\Request;
use Swoft\Validator\Annotation\Mapping\Validate;
use App\Exception\ApiException;
use Swoft\Http\Server\Annotation\Mapping\Middleware;
use App\Http\Middleware\ControllerMiddleware;
use Swoft\Bean\BeanFactory;
use Throwable;

/**
 * Player
 * @Controller(prefix="/api/v1/player")
 */
class PlayerController
{
    /**
     * PlayerList
     * @RequestMapping(route="list",method=RequestMethod::POST)
     * @Middleware(ControllerMiddleware::class)
     * @Validate(validator="PlayerValidator",fields={"limit"})
     *
     * @param Request $request
     *
     * @return mixed
     * @throws Throwable
     */
    public function playerList(Request $request)
    {
        $field = $request->post("field",["nickname"]);
        $limit = $request->post("limit",0);
        if(!empty($field)){
            $player_dao = BeanFactory::getSingleton("PlayerDao");
            $player_list = $player_dao->getPlayerListByField($field,(int)$limit);
            return formatResponse(true,0,$player_list);
        }
        throw new ApiException('Empty field');
    }

}