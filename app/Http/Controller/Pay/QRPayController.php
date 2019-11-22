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
use App\Lib\Pay\QRPay;
use Throwable;

/**
 * WapController
 * @Controller(prefix="/qrpay/v1")
 * @Middleware(ControllerMiddleware::class)
 */
class QRPayController
{

    /**
     * payForBarcode
     * @RequestMapping(route="pay",method=RequestMethod::POST)
     *
     * @param Request $request
     *
     * @return mixed
     * @throws Throwable
     */
    public function payForQRPay(Request $request)
    {
        $totalFee = $request->POST("total",0);
        $terminalDao = BeanFactory::getBean("TerminalDao");
        $terminalInfo = $terminalDao->getTerminal();
        $wapInstance = new QRPay(config("pay.merchant_no"));
        $redirectResult = $wapInstance->payOrder($terminalInfo["terminal_id"], (int)($totalFee*100),$terminalInfo["access_token"]);
        if(empty($redirectResult))formatResponse(false,1,"Failed");
        return formatResponse(true,0,$redirectResult);
    }

    /**
     * test
     * @RequestMapping(route="/test,method=RequestMethod::POST)
     *
     * @param Request $request
     *
     * @return mixed
     * @throws Throwable
     */
    public function test(Request $request)
    {
        $request->withCookieParams(["test"=>"test"]);
        return formatResponse(true,0,"test");
    }

}
