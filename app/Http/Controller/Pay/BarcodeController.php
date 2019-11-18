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
use App\Lib\Pay\Barcode;
use Throwable;

/**
 * BarcodeController
 * @Controller(prefix="/barcode/v1")
 */
class BarcodeController
{
    /**
     * Maximum number of participants
     * @param int
     */
    private $max_count = 12;

    /**
     * payOrder
     * @RequestMapping(route="pay",method=RequestMethod::GET)
     * @Middleware(ControllerMiddleware::class)
     * @Validate(validator="BarcodeValidator",fields={"barcode","total"})
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
        $payResult = $barcodeInstance->payOrder($terminalInfo["terminal_id"], $authNo, $totalFee*100,config("pay.key"));
        switch ($payResult){
            case 2:
                return formatResponse(false,1,"Failed");
            case 66:
                return formatResponse(false,66,"Unknown error");
            case 99:
                return formatResponse(false,99,"Not support");
        }
        $orderDao = BeanFactory::getBean("OrderDao");
        $orderDao->addOrder($payResult);
        return formatResponse(true,0,"Succeed");
    }

    /**
     * test
     * @RequestMapping(route="/test",method=RequestMethod::POST)
     *
     * @param Request $request
     *
     * @return mixed
     * @throws Throwable
     */
    public function test(Request $request)
    {
        BeanFactory::getBean("PlayerDao");
        //BeanFactory::getBean("TerminalDao");
    }

}