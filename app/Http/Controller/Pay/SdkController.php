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
 * @Controller(prefix="/api/v1/sdk")
 */
class SdkController
{

    /**
     * payForBarcode
     * @RequestMapping(route="barcode",method=RequestMethod::POST)
     * @Middleware(ControllerMiddleware::class)
     *
     * @param Request $request
     *
     * @return mixed
     * @throws Throwable
     */
    public function test(Request $request)
    {
        $sdk = new \Saobei\sdk\Dispatcher();
        $sdk->initTerminal('824707011000002', '30759608', '631fbfdb5c08483d8f7274f0cc400710');
        //传入参数
        $fields = array(
            'pay_type' => '010',//自动识别支付类型
            'terminal_trace' => $this->createTerminalTraceDemo($_POST['merchant_no'], $_POST['terminal_id']),
            'total_fee' => '1'
        );
        $result = $sdk->jsPay($fields);
        return formatResponse(true,6,$result);
    }

    function createTerminalTraceDemo($merchantNo, $terminalId)
    {
        return substr($merchantNo, 1).$terminalId.time();
    }

}