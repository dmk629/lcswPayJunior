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
     * @RequestMapping(route="list",method=RequestMethod::POST)
     * @Validate(validator="BarcodeValidator",field={"page","size"})
     *
     * @param Request $request
     *
     * @return mixed
     * @throws Throwable
     */
    public function orderList(Request $request)
    {
        $orderDao = BeanFactory::getBean("orderDao");
        $page = $request->post("page",0);
        $size = $request->post("size",config("page.font"));
        $orderList = $orderDao->orderList($page, $size);
        if(empty($orderList))formatResponse(false,1,"Empty order");
        formatResponse(true, 0, $orderList);
    }

    /**
     * orderRefund
     * @RequestMapping(route="refund",method=RequestMethod::POST)
     * @Validate(validator="BarcodeValidator",field={"id"})
     *
     * @param Request $request
     *
     * @return mixed
     * @throws Throwable
     * */
    public function orderRefund(Request $request)
    {
        $id = $request->post("id",0);
        $orderDao = BeanFactory::getBean("orderDao");
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
        if(empty($updateResult))formatResponse(false,5,"Refund failed");
        //入库退款

        formatResponse(true, 0, "Succeed");
    }

}