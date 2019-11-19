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
use App\Lib\Pay\QRPay;
use Throwable;

/**
 * WapController
 * @Controller(prefix="/qrpay/v1")
 */
class QRPayController
{

    /**
     * payForBarcode
     * @RequestMapping(route="pay",method=RequestMethod::GET)
     * @Middleware(ControllerMiddleware::class)
     *
     * @param Request $request
     *
     * @return mixed
     * @throws Throwable
     */
    public function payForQRPay(Request $request)
    {
        $totalFee = $request->get("total",0);
        $terminalDao = BeanFactory::getBean("TerminalDao");
        $terminalInfo = $terminalDao->getTerminal();
        $wapInstance = new QRPay(config("pay.merchant_no"));
        $redirectUrl = $wapInstance->payOrder($terminalInfo["terminal_id"], (int)($totalFee*100),$terminalInfo["access_token"]);
        return formatResponse(true,0,$redirectUrl);
    }

}
