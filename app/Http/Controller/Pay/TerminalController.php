<?php declare(strict_types=1);

namespace App\Http\Controller\Pay;

use Swoft\Http\Server\Annotation\Mapping\Controller;
use Swoft\Http\Server\Annotation\Mapping\RequestMapping;
use Swoft\Http\Server\Annotation\Mapping\RequestMethod;
use Swoft\Http\Message\Request;
use App\Exception\ApiException;
use Swoft\Http\Server\Annotation\Mapping\Middleware;
use App\Http\Middleware\ControllerMiddleware;
use Swoft\Bean\BeanFactory;
use App\Lib\Pay\Terminal;
use Throwable;

/**
 * TerminalController
 * @Controller(prefix="/terminal/v1")
 */
class TerminalController
{
    /**
     * Maximum number of participants
     * @param int
     */
    private $max_count = 12;

    /**
     * rewardResult
     * @RequestMapping(route="create",method=RequestMethod::POST)
     * @Middleware(ControllerMiddleware::class)
     *
     * @param Request $request
     *
     * @return mixed
     * @throws Throwable
     */
    public function getTerminal(Request $request)
    {
        $terminal_dao = BeanFactory::getBean("TerminalDao");
        $terminal_info = $terminal_dao->getTerminal();
        if(empty($terminal_info)){
            $pay_config = config("pay");
            $terminal_instance = new Terminal($pay_config["inst_no"],$pay_config["merchant_no"]);
            $post_result = $terminal_instance->getTerminal();
            var_dump($post_result);
            return true;
        }else{
            return $terminal_info;
        }
    }

    /**
     * test
     * @RequestMapping(route="/test",method=RequestMethod::POST)
     *
     * @param Request $request
     *
     * @return mixed
     * @throws Throwable
     */
    public function test(Request $request)
    {
        BeanFactory::getBean("PlayerDao");
        //BeanFactory::getBean("TerminalDao");
    }

}