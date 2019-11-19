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
use App\Lib\Pay\Wap;
use Throwable;

/**
 * WapController
 * @Controller(prefix="/wap/v1")
 */
class WapController
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
    public function payForWap(Request $request)
    {
        $totalFee = $request->get("total",0);
        $terminalDao = BeanFactory::getBean("TerminalDao");
        $terminalInfo = $terminalDao->getTerminal();
        $wapInstance = new Wap(config("pay.merchant_no"));
        //$payResult = $wapInstance->payOrder($terminalInfo["terminal_id"], (int)($totalFee*100),$terminalInfo["access_token"]);
        $payResult = $wapInstance->payOrder($terminalInfo["terminal_id"], (int)($totalFee*100),config("pay.key"));
        if(empty($payResult))formatResponse(false,1,"Failed");
        return formatResponse(true,0,$payResult);
    }

}
