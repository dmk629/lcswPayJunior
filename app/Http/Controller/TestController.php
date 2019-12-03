<?php
namespace App\Http\Controller;

use Swoft\Http\Server\Annotation\Mapping\Controller;
use Swoft\Http\Server\Annotation\Mapping\RequestMapping;
use Swoft\Http\Server\Annotation\Mapping\RequestMethod;
use Swoft\Http\Message\Request;
use App\Exception\ApiException;
use Swoft\Http\Server\Annotation\Mapping\Middleware;
use App\Http\Middleware\ControllerMiddleware;
use Swoft\Validator\Annotation\Mapping\Validate;
use Swoft\Bean\BeanFactory;
use App\Lib\Pay\Barcode;
use Throwable;

/**
 * TestController
 * @Controller(prefix="/api")
 */
class TestController
{

    /**
     * test
     * @RequestMapping(route="test",method=RequestMethod::POST)
     * @Middleware(ControllerMiddleware::class)
     *
     * @param Request $request
     *
     * @return mixed
     * @throws Throwable
     */
    public function payForBarcode(Request $request)
    {
        $post = $request->post();
        $couponList = json_decode($post["coupon"], true);
        return formatResponse(true,0,$couponList);
    }

}