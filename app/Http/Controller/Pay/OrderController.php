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
use Swoft\Context\Context;
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
     *
     * @param Request $request
     *
     * @return mixed
     * @throws Throwable
     */
    public function orderList(Request $request)
    {
        $orderDao = BeanFactory::getBean("OrderDao");
        $page = (int)$request->get("page",0);
        $size = (int)$request->get("limit",config("page.font"));
        $orderList = $orderDao->orderList($page, $size);
        if(empty($orderList))return $this->layUIReturn(0, "Empty order", 0, []);
        foreach($orderList as $index=>$value){
            $orderList[$index]["total_fee"] = $value["total_fee"]/100;
            switch ($value["order_status"]){
                case 1:
                    $orderList[$index]["order_status"] = "未支付";
                    break;
                case 2:
                    $orderList[$index]["order_status"] = "已支付";
                    break;
                case 3:
                    $orderList[$index]["order_status"] = "已退款";
                    break;
                case 0:
                    $orderList[$index]["order_status"] = "失败";
                    break;
                default:
                    $orderList[$index]["order_status"] = "未知";
            }
        }
        return $this->layUIReturn(0, "Succeed", count($orderList), $orderList);
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
        $orderInfo = $orderDao->getOrderById([$id]);
        $terminalInfo = BeanFactory::getBean("TerminalDao")->getTerminal();
        if(empty($orderInfo))return formatResponse(false,1,"Empty order");
        if($orderInfo["order_status"] != 2)return formatResponse(false,2,"Status error");
        if(strtotime($orderInfo["create_time"]) + 2592000 <= time())return formatResponse(false,3,"Order expired");
        $refundInstance = new Refund(config("pay.merchant_no"));
        $refundResult = $refundInstance->refundOrder($terminalInfo["terminal_id"], $orderInfo["total_fee"], $orderInfo["out_trade_no"], $terminalInfo["access_token"]);
        switch ($refundResult) {
            case 1:
                return formatResponse(false,4,"Network error");
                break;
            case 2:
                return formatResponse(false,5,"Refund failed");
                break;
        }
        $updateResult = $orderDao->updateOrderStatus([$orderInfo["out_trade_no"]], 3);
        if(empty($updateResult))return formatResponse(false,6,"Internal error");
        $refundResult["status"] = 2;
        BeanFactory::getBean("RefundDao")->addRefund($refundResult);
        return formatResponse(true, 0, "Succeed");
    }

    /**
     * orderQuery
     * @RequestMapping(route="query",method=RequestMethod::GET)
     *
     * @param Request $request
     *
     * @return mixed
     * @throws Throwable
     */
    public function orderQuery(Request $request)
    {
        $orderDao = BeanFactory::getBean("OrderDao");
        $page = (int)$request->get("page",0);
        $size = (int)$request->get("limit",config("page.font"));
        $orderList = $orderDao->orderList($page, $size);
        if(empty($orderList))return $this->layUIReturn(0, "Empty order", 0, []);
        foreach($orderList as $index=>$value){
            $orderList[$index]["total_fee"] = $value["total_fee"]/100;
            switch ($value["order_status"]){
                case 1:
                    $orderList[$index]["order_status"] = "未支付";
                    break;
                case 2:
                    $orderList[$index]["order_status"] = "已支付";
                    break;
                case 3:
                    $orderList[$index]["order_status"] = "已退款";
                    break;
                case 0:
                    $orderList[$index]["order_status"] = "失败";
                    break;
                default:
                    $orderList[$index]["order_status"] = "未知";
            }
        }
        return $this->layUIReturn(0, "Succeed", count($orderList), $orderList);
    }

    /**
     * LayUIReturn
     *
     * @param int $code
     * @param string $msg
     * @param int $count
     * @param array $data
     *
     * @return mixed
     * @throws Throwable
     * */
    private function layUIReturn(int $code, string $msg, int $count, array $data)
    {
        return context()->getResponse()->withData(["code"=>$code, "msg"=>$msg, "count"=>$count, "data"=>$data]);
    }

}
