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
     * @RequestMapping(route="test",method=RequestMethod::POST)
     * @param Request $request
     *
     * @return mixed
     * @throws Throwable
     */
    public function test(Request $request)
    {
        $post = $request->post();
        return formatResponse(true,6,$post);
    }

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
     * @RequestMapping(route="name",method=RequestMethod::POST)
     * @param Request $request
     *
     * @return mixed
     * @throws Throwable
     */
    public function name(Request $request)
    {
        //传入参数
        $fields = array(
            'trace_no' => $this->createTraceNoDemo('52100005'),
            'merchant_name' => '阿西吧'
        );
        $result = $this->send($fields, 'merchantcheckname');
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
            'account_name' => "技术创建18(勿审核)",
            'account_no' => '622848062284809378',
            'account_type' => '2',
            'bank_name' => '中国农业银行股份有限公司青海农大南路支行',
            'bank_no' => '103100005508',
            'business_code' => '90',
            'business_name' => '餐饮',
            'greenstatus' => '0',
            'img_3rd_part' => 'https://lcsw-img.oss-cn-hangzhou.aliyuncs.com/miniprogram/1f382090-6a2e-4c42-97d1-9340f0d73078.jpg',
            'img_bankcard_a' => 'https://lcsw-img.oss-cn-hangzhou.aliyuncs.com/miniprogram/1f382090-6a2e-4c42-97d1-9340f0d73078.jpg',
            'img_cashier' => 'https://lcsw-img.oss-cn-hangzhou.aliyuncs.com/miniprogram/1f382090-6a2e-4c42-97d1-9340f0d73078.jpg',
            'img_indoor' => 'https://lcsw-img.oss-cn-hangzhou.aliyuncs.com/miniprogram/1f382090-6a2e-4c42-97d1-9340f0d73078.jpg',
            'img_license' => 'https://lcsw-img.oss-cn-hangzhou.aliyuncs.com/miniprogram/1f382090-6a2e-4c42-97d1-9340f0d73078.jpg',
            'img_logo' => 'https://lcsw-img.oss-cn-hangzhou.aliyuncs.com/miniprogram/1f382090-6a2e-4c42-97d1-9340f0d73078.jpg',
            'img_private_idcard_a' => 'https://lcsw-img.oss-cn-hangzhou.aliyuncs.com/miniprogram/1f382090-6a2e-4c42-97d1-9340f0d73078.jpg',
            'img_private_idcard_b' => 'https://lcsw-img.oss-cn-hangzhou.aliyuncs.com/miniprogram/1f382090-6a2e-4c42-97d1-9340f0d73078.jpg',
            'img_salesman_logo' => 'https://lcsw-img.oss-cn-hangzhou.aliyuncs.com/miniprogram/1f382090-6a2e-4c42-97d1-9340f0d73078.jpg',
            'img_salesman_poster' => 'https://lcsw-img.oss-cn-hangzhou.aliyuncs.com/miniprogram/1f382090-6a2e-4c42-97d1-9340f0d73078.jpg',
            'inst_no' => '52100005',
            'license_type' => '1',
            'merchant_address' => '青海省海东地区丰智东路13号朗丽兹西山花园酒店2007室',
            'merchant_alias' => 'lala哈哈哈哈哈哈',
            'merchant_business_type' => '2',
            'merchant_city' => '海东地区',
            'merchant_city_code' => '8520',
            'merchant_company' => '自然人一号',
            'merchant_county' => '互助土族自治县',
            'merchant_county_code' => '8524',
            'merchant_email' => 'z38677772622@gmail.com',
            'merchant_id_expire' => '29991231',
            'merchant_id_no' => '370284198609141515',
            'merchant_name' => '技术部创建18(勿审核)',
            'merchant_person' => '余戈',
            'merchant_phone' => '17006929112',
            'merchant_province' => '青海省',
            'merchant_province_code' => '630',
            'merchant_service_phone' => '400-139239610',
            'notify_url' => 'http://test.lcsw.cn:8045/lcsw/hepan/100/notify',
            'rate_code' => 'M0039',
            'settle_amount' => '1',
            'settle_type' => '1',
            'settlement_type' => '1',
            'trace_no' => '804e3084249342f8a52a04b278ef821c'
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