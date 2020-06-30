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
 * @Middleware(ControllerMiddleware::class)
 */
class SdkController
{

    /**
     *
     * @RequestMapping(route="barcode",method=RequestMethod::POST)
     * @param Request $request
     *
     * @return mixed
     * @throws Throwable
     */
    public function barcode(Request $request)
    {
        $authNo = $request->post("auth_no");
        //传入参数
        $fields = array(
            'terminal_trace' => $this->createTerminalTraceDemo('824707011000002', '30759608'),
            'pay_type' => '020',
            'fenqi_num' => '3',
            'auth_no' => $authNo,
            'total_fee' => '1'
        );
        $result = $this->send($fields, 'fenqibar');
        return formatResponse(true,6,$result);
    }

    /**
     *
     * @RequestMapping(route="refund",method=RequestMethod::POST)
     *
     * @return mixed
     * @throws Throwable
     */
    public function refund()
    {
        //传入参数
        $fields = array(
            'terminal_trace' => $this->createTerminalTraceDemo('824707011000002', '30759608'),
            'refund_fee' => '1',
            'pay_type' => '000',
            'out_trade_no' => '307596080022120063017340400014',
        );
        $result = $this->send($fields, 'fenqirefund');
        return formatResponse(true,6,$result);
    }


    /**
     *
     * @RequestMapping(route="query",method=RequestMethod::POST)
     *
     * @return mixed
     * @throws Throwable
     */
    public function query()
    {
        //传入参数
        $fields = array(
            'terminal_trace' => $this->createTerminalTraceDemo('824707011000002', '30759608'),
            'out_trade_no' => '307596080022120063017340400014',
        );
        $result = $this->send($fields, 'fenqirefund');
        return formatResponse(true,6,$result);
    }

    /**
     *
     * @RequestMapping(route="close",method=RequestMethod::POST)
     *
     * @return mixed
     * @throws Throwable
     */
    public function close()
    {
        //传入参数
        $fields = array(
            'terminal_trace' => $this->createTerminalTraceDemo('824707011000002', '30759608'),
            'pay_type' => '000',
            'out_trade_no' => '307596080022120063017340400014',
        );
        $result = $this->send($fields, 'fenqiclose');
        return formatResponse(true,6,$result);
    }

    private function send($fields, $method)
    {
        $sdk = new \Saobei\sdk\Dispatcher();
        $sdk->initTerminal('824707011000002', '30759608', '631fbfdb5c08483d8f7274f0cc400710');
        return call_user_func([$sdk, $method], $fields);
    }

    private function createTerminalTraceDemo($merchantNo, $terminalId)
    {
        return substr($merchantNo, 1).$terminalId.time();
    }

}