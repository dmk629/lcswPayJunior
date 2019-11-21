<?php declare(strict_types=1);

namespace App\Validator\Pay;

use App\Annotation\Mapping\AlphaDash;
use Swoft\Validator\Annotation\Mapping\IsInt;
use Swoft\Validator\Annotation\Mapping\IsString;
use Swoft\Validator\Annotation\Mapping\IsFloat;
use Swoft\Validator\Annotation\Mapping\Length;
use Swoft\Validator\Annotation\Mapping\AlphaNum;
use Swoft\Validator\Annotation\Mapping\Min;
use Swoft\Validator\Annotation\Mapping\Max;
use Swoft\Validator\Annotation\Mapping\Validator;

/**
 * Class NotifyValidator
 *
 * @since 2.0
 *
 * @Validator(name="NotifyValidator")
 */
class NotifyValidator
{
    /**
     * @IsString(message="格式不正确")
     * @AlphaNum(message="状态码不正确")
     * @Length(min=2,max=2,message="长度不正确")
     * @var string
     */
    protected $return_code;

    /**
     * @IsString(message="格式不正确")
     * @Length(min=0,max=128,message="长度不正确")
     * @var string
     */
    protected $return_msg;

    /**
     * @IsString(message="格式不正确")
     * @AlphaNum(message="格式不正确")
     * @Length(min=2,max=2,message="长度不正确")
     * @var string
     */
    protected $result_code;

    /**
     * @IsString(message="格式不正确")
     * @AlphaNum(message="格式不正确")
     * @Length(min=3,max=3,message="长度不正确")
     * @var string
     */
    protected $pay_type;

    /**
     * @IsString(message="格式不正确")
     * @Length(min=0,max=32,message="长度不正确")
     * @var string
     */
    protected $user_id;

    /**
     * @IsString(message="格式不正确")
     * @Length(min=0,max=40,message="长度不正确")
     * @var string
     */
    protected $merchant_name;

    /**
     * @IsString(message="格式不正确")
     * @AlphaNum(message="格式不正确")
     * @Length(min=0,max=15,message="长度不正确")
     * @var string
     */
    protected $merchant_no;

    /**
     * @IsString(message="格式不正确")
     * @AlphaNum(message="格式不正确")
     * @Length(min=0,max=8,message="长度不正确")
     * @var string
     */
    protected $terminal_id;

    /**
     * @IsString(message="格式不正确")
     * @AlphaNum(message="格式不正确")
     * @Length(min=0,max=32,message="长度不正确")
     * @var string
     */
    protected $terminal_trace;

    /**
     * @IsString(message="格式不正确")
     * @AlphaNum(message="格式不正确")
     * @Length(min=0,max=14,message="长度不正确")
     * @var string
     */
    protected $terminal_time;

    /**
     * @IsString(message="格式不正确")
     * @AlphaNum(message="格式不正确")
     * @Length(min=0,max=12,message="长度不正确")
     * @var string
     */
    protected $total_fee;

    /**
     * @IsString(message="格式不正确")
     * @AlphaNum(message="格式不正确")
     * @Length(min=0,max=14,message="长度不正确")
     * @var string
     */
    protected $end_time;

    /**
     * @IsString(message="格式不正确")
     * @AlphaNum(message="格式不正确")
     * @Length(min=0,max=32,message="长度不正确")
     * @var string
     */
    protected $out_trade_no;

    /**
     * @IsString(message="格式不正确")
     * @AlphaNum(message="格式不正确")
     * @Length(min=0,max=32,message="长度不正确")
     * @var string
     */
    protected $channel_trade_no;

    /**
     * @IsString(message="格式不正确")
     * @Length(min=0,max=128,message="长度不正确")
     * @var string
     */
    protected $attach;

    /**
     * @IsString(message="格式不正确")
     * @AlphaNum(message="格式不正确")
     * @Length(min=0,max=32,message="长度不正确")
     * @var string
     */
    protected $key_sign;

}
