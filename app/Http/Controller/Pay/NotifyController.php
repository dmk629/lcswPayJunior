<?php declare(strict_types=1);
namespace App\Http\Controller\Pay;

use Swoft\Http\Server\Annotation\Mapping\Controller;
use Swoft\Http\Server\Annotation\Mapping\RequestMapping;
use Swoft\Http\Server\Annotation\Mapping\RequestMethod;
use Swoft\Http\Message\Request;
use App\Exception\ApiException;
use Swoft\Http\Server\Annotation\Mapping\Middleware;
use App\Http\Middleware\ControllerMiddleware;
use Swoft\Validator\Annotation\Mapping\Validate;
use Swoft\Bean\BeanFactory;
use App\Lib\Pay\Notify;
use Throwable;

/**
 * NotifyController
 * @Controller(prefix="/notify/v1")
 */
class NotifyController
{

    /**
     * receiveNotify
     * @RequestMapping(route="index",method=RequestMethod::POST)
     * @Middleware(ControllerMiddleware::class)
     * @Validate(validator="NotifyValidator")
     *
     * @param Request $request
     *
     * @return mixed
     * @throws Throwable
     */
    public function index(Request $request)
    {
        $message = $request->post();
        $terminalDao = BeanFactory::getBean("TerminalDao");
        $terminalInfo = $terminalDao->getTerminal();
        if(!Notify::verifySign($message,$terminalInfo["access_token"])){
            echo "验签失败\n";
            return context()->getResponse()->withData(Notify::returnMessage(false,"验签失败"));
        }
        $orderDao = BeanFactory::getBean("OrderDao");
        $orderDao->addOrder([
            "terminal_id" => $message["terminal_id"],
            "terminal_trace" => $message["terminal_trace"],
            "total_fee" => $message["total_fee"],
            "out_trade_no" => $message["out_trade_no"],
            "status" => empty($message["status"]) ? 2 : $message["status"]
        ]);
        return context()->getResponse()->withData(Notify::returnMessage(true,"成功"));
    }

}
