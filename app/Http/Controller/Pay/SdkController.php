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
     * @RequestMapping(route="prepay",method=RequestMethod::POST)
     * @param Request $request
     *
     * @return mixed
     * @throws Throwable
     */
    public function prepay(Request $request)
    {
        //$authNo = $request->post("auth_no");
        //传入参数
        $fields = array(
            'terminal_trace' => $this->createTerminalTraceDemo('824707011000002', '30759608'),
            'pay_type' => '020',
            'fenqi_num' => '3',
            'notify_url' => 'http://pay.dnfmiracle.xyz/api/v1/sdk/notify',
            'total_fee' => '1'
        );
        $result = $this->send($fields, 'fenqiprepay');
        return formatResponse(true,6,$result);
    }

    /**
     *
     * @RequestMapping(route="add",method=RequestMethod::POST)
     * @param Request $request
     *
     * @return mixed
     * @throws Throwable
     */
    public function add(Request $request)
    {
        //传入参数
        $fields = array(
            'trace_no' => $this->createTraceNoDemo('52100005'),
            'merchant_name' => '阿西吧',
            'merchant_alias' => '阿西吧',
            'merchant_company' => '阿西吧',
            'merchant_province' => '阿西吧',
            'merchant_province_code	' => '1',
            'merchant_city' => '阿西吧',
            'merchant_city_code' => '1',
            'merchant_county' => '阿西吧',
            'merchant_county_code' => '1',
            'merchant_address' => '阿西吧阿西吧阿西吧',
            'merchant_person' => '阿西吧',
            'merchant_phone' => '133456789012',
            'merchant_email' => '123@qq.com',
            'business_name' => '阿西吧',
            'business_code' => '1',
            'merchant_business_type' => '1',
            'account_type' => '1',
            'settlement_type' => '1',
            'license_type' => '1',
            'account_name' => '阿西吧',
            'account_no' => '13345678901213345678',
            'bank_name' => '阿西吧',
            'bank_no' => '1',
            'settle_type' => '1'
        );
        $result = $this->send($fields, 'merchantadd');
        return formatResponse(true,6,$result);
    }

    private function send($fields, $method)
    {
        $sdk = new \Saobei\sdk\Dispatcher();
        $sdk->initMerchant('52100005', '22aa5dda974b4f0d9d5ed2f3f7cc1d89');
        return call_user_func([$sdk, $method], $fields);
    }


    /**
     * 流水号生成样例
     *  仅用于演示，一秒内多单会出现相同流水号，请勿生产使用
     * @param string $instNo 机构号
     * @param string $key
     * @return string
     * */
    function createTraceNoDemo($instNo)
    {
        return $instNo.date('YmdHis').mt_rand(1000000000,9999999999);
    }

}