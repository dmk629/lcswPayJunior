<?php declare(strict_types=1);

namespace App\Http\Controller\Pay;

use App\Lib\Pay\Refund;
use Swoft\Http\Server\Annotation\Mapping\Controller;
use Swoft\Http\Server\Annotation\Mapping\RequestMapping;
use Swoft\Http\Server\Annotation\Mapping\RequestMethod;
use Swoft\Http\Message\Request;
use App\Exception\ApiException;
use Swoft\Http\Server\Annotation\Mapping\Middleware;
use App\Http\Middleware\ControllerMiddleware;
use Swoft\Validator\Annotation\Mapping\Validate;
use Swoft\Bean\BeanFactory;
use Throwable;

/**
 * OrderController
 * @Controller(prefix="/order/v1")
 * @Middleware(ControllerMiddleware::class)
 */
class OrderController
{

    /**
     * orderList
     * @RequestMapping(route="list",method=RequestMethod::GET)
     * @Validate(validator="OrderValidator",fields={"page","limit"})
     *
     * @param Request $request
     *
     * @return mixed
     * @throws Throwable
     */
    public function orderList(Request $request)
    {
        $orderDao = BeanFactory::getBean("OrderDao");
        $page = $request->get("page",0);
        $size = $request->post("limit",config("page.font"));
        $orderList = $orderDao->orderList($page, $size);
        if(empty($orderList))return formatResponse(false,1,"Empty order");
        return formatResponse(true, 0, $orderList);
    }

    /**
     * orderRefund
     * @RequestMapping(route="refund",method=RequestMethod::POST)
     * @Validate(validator="OrderValidator",fields={"id"})
     *
     * @param Request $request
     *
     * @return mixed
     * @throws Throwable
     * */
    public function orderRefund(Request $request)
    {
        $id = $request->post("id",0);
        $orderDao = BeanFactory::getBean("OrderDao");
        $orderInfo = $orderDao->getOrderById($id);
        $terminalInfo = BeanFactory::getBean("TerminalDao")->getTerminal();
        if(empty($orderInfo))formatResponse(false,1,"Empty order");
        if($orderInfo["status"] != 2)formatResponse(false,2,"Status error");
        if(strtotime($orderInfo["create_time"]) + 2592000 <= time())formatResponse(false,3,"Order expired");
        $refundInstance = new Refund(config("pay.merchant_no"));
        $refundResult = $refundInstance->refundOrder($terminalInfo["terminal_id"], $orderInfo["total_fee"], $orderInfo["out_trade_no"], $terminalInfo["access_token"]);
        switch ($refundResult) {
            case 1:
                formatResponse(false,4,"Network error");
                break;
            case 2:
                formatResponse(false,5,"Refund failed");
                break;
        }
        $updateResult = $orderDao->updateOrderStatus([$orderInfo["out_trade_no"]], 3);
        if(empty($updateResult))formatResponse(false,6,"Internal error");
        $refundResult["status"] = 2;
        BeanFactory::getBean("RefundDao")->addRefund($refundResult);
        formatResponse(true, 0, "Succeed");
    }

}
