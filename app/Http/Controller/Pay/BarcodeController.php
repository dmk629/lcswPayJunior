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
use App\Lib\Pay\Barcode;
use Throwable;

/**
 * BarcodeController
 * @Controller(prefix="/api/v1/barcode")
 */
class BarcodeController
{

    /**
     * payForBarcode
     * @RequestMapping(route="pay",method=RequestMethod::POST)
     * @Middleware(ControllerMiddleware::class)
     * @Validate(validator="BarcodeValidator")
     *
     * @param Request $request
     *
     * @return mixed
     * @throws Throwable
     */
    public function payForBarcode(Request $request)
    {
        $payType = $request->post("type","");
        $authNo = $request->post("barcode","");
        $totalFee = $request->post("total",0);
        $terminalDao = BeanFactory::getBean("TerminalDao");
        $terminalInfo = $terminalDao->getTerminal();
        $barcodeInstance = new Barcode($payType,config("pay.merchant_no"));
        $payResult = $barcodeInstance->payOrder($terminalInfo["terminal_id"], $authNo, (int)($totalFee*100),$terminalInfo["access_token"]);
        switch ($payResult){
            case 2:
                return formatResponse(false,1,"Failed");
            case 66:
                return formatResponse(false,66,"Unknown error");
            case 67:
                return formatResponse(false,67,"Query error");
            case 99:
                return formatResponse(false,99,"Not support");
        }
        $orderDao = BeanFactory::getBean("OrderDao");
        $orderDao->addOrder($payResult);
        return formatResponse(true,0,"Succeed");
    }

}