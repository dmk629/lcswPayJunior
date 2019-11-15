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
 * Class PreyValidator
 *
 * @since 2.0
 *
 * @Validator(name="PreyValidator")
 */
class PreyValidator
{
    /**
     * @IsString(message="格式不正确")
     * @ChsAlphaDash(message="角色名只能使用中文、英文、数字、短横-、下划线_")
     * @Length(min=0,max=40,message="长度不正确")
     * @var string
     */
    protected $nickname = "未知玩家";

}
