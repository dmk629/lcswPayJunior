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
     * @RequestMapping(route="wap",method=RequestMethod::POST)
     *
     * @return mixed
     * @throws Throwable
     */
    public function wap()
    {
        //传入参数
        $fields = array(
            'terminal_trace' => $this->createTerminalTraceDemo('824707011000002', '30759608'),
            'total_fee' => '1'
        );
        $result = $this->send($fields, 'wapPay');
        return formatResponse(true,6,$result);
    }

    /**
     *
     * @RequestMapping(route="auth",method=RequestMethod::POST)
     *
     * @return mixed
     * @throws Throwable
     */
    public function auth()
    {
        //传入参数
        $fields = array(
            'terminal_trace' => $this->createTerminalTraceDemo('824707011000002', '30759608'),
            'pay_type' => '010',
            'auth_no' => '1234567'
        );
        $result = $this->send($fields, 'authCodeToOpenId');
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