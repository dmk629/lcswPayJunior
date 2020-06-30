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
use Toolkit\Cli\Terminal;

/**
 * BarcodeController
 * @Controller(prefix="/api/v1/sdk")
 */
class SdkController
{

    /**
     * payForBarcode
     * @RequestMapping(route="test",method=RequestMethod::POST)
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
            'pay_type' => '000',
            'terminal_trace' => $this->createTerminalTraceDemo('824707011000002', '30759608'),
            //'out_trade_no' => '307596080021120063010121400013',
            'auth_no' => '134605165294091854',
            //'open_id' => 'obnG9jor12YYw7bog3bENMKBD51A',
            'order_body' => 'test',
            'attach' => 'test',
            'total_fee' => '1'
        );
        /*$fields = array(
            'terminal_no' => \Saobei\sdk\Config\Terminal::getInstance()->getTerminalId()    ,
            'redirect_uri' => 'http://test.lcsw.cn:8045/demo/redirect',
            'auth_no' => '134605165294091854',
            //'open_id' => 'obnG9jor12YYw7bog3bENMKBD51A',
            //'refund_fee' => '1'
        );*/
        $result = $sdk->preauthbar($fields);
        return formatResponse(true,6,$result);
    }

    function createTerminalTraceDemo($merchantNo, $terminalId)
    {
        return substr($merchantNo, 1).$terminalId.time();
    }

}