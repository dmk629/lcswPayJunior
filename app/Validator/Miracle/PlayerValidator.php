<?php declare(strict_types=1);

namespace App\Validator\Miracle;

use App\Annotation\Mapping\AlphaDash;
use Swoft\Validator\Annotation\Mapping\IsInt;
use Swoft\Validator\Annotation\Mapping\IsString;
use Swoft\Validator\Annotation\Mapping\Length;
use Swoft\Validator\Annotation\Mapping\ChsAlphaDash;
use Swoft\Validator\Annotation\Mapping\Min;
use Swoft\Validator\Annotation\Mapping\Max;
use Swoft\Validator\Annotation\Mapping\Validator;

/**
 * Class PlayerValidator
 *
 * @since 2.0
 *
 * @Validator(name="PlayerValidator")
 */
class PlayerValidator
{
    /**
     * @IsString(message="格式不正确")
     * @ChsAlphaDash(message="只能使用中文、英文、数字、短横-、下划线_")
     * @Length(min=1,max=40,message="长度不正确")
     * @var string
     */
    protected $nickname;

    /**
     * @IsInt(message="格式不正确")
     * @Min(value=10000,message="格式不正确")
     * @Max(value=999999999999,message="格式不正确")
     * @var int
     */
    protected $qq;

    /**
     * @IsString(message="格式不正确")
     * @ChsAlphaDash(message="只能使用中文、英文、数字、短横-、下划线_")
     * @Length(min=1,max=40,message="请输入正确大区")
     *
     * @var string
     */
    protected $area;

    /**
     * @IsString(message="格式不正确")
     * @Length(min=1,max=160,message="内容太多啦")
     *
     * @var string
     */
    protected $content;

    /**
     * @IsString(message="格式不正确")
     * @Length(min=1,max=120,message="图片地址过长")
     *
     * @var string
     */
    protected $header;

    /**
     * @IsInt(message="格式不正确")
     * @Max(value=100,message="格式不正确")
     * @var int
     */
    protected $limit;

}
