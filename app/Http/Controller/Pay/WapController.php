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
        $redirectResult = $wapInstance->createUrl($terminalInfo["terminal_id"], (int)($totalFee*100),$terminalInfo["access_token"]);
        return context()->getResponse()->withCookie("trace_id",["value"=>$redirectResult["trace_id"],"path"=>"/"])->withData(["status"=>true,"errcode"=>0,"data"=>$redirectResult["redirect_url"]]);

    }

}
