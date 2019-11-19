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
     * @RequestMapping(route="list",method=RequestMethod::POST)
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
        if(empty($orderInfo))formatResponse(false,1,"Empty order");

        formatResponse(true, 0, "Succeed");
    }

}