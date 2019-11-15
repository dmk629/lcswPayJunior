<?php declare(strict_types=1);

namespace App\Validator\MiracleAdmin;

use Swoft\Validator\Annotation\Mapping\IsString;
use Swoft\Validator\Annotation\Mapping\Length;
use Swoft\Validator\Annotation\Mapping\ChsAlphaDash;
use Swoft\Validator\Annotation\Mapping\Validator;
use Swoft\Validator\Annotation\Mapping\NotEmpty;
use Swoft\Validator\Annotation\Mapping\AlphaDash;
use Swoft\Validator\Annotation\Mapping\Confirm;

/**
 * Class MemberValidator
 *
 * @since 2.0
 *
 * @Validator(name="MemberValidator")
 */
class MemberValidator
{
    /**
     * @IsString(message="格式不正确")
     * @NotEmpty(message="用户名不能为空")
     * @ChsAlphaDash(message="只能使用中文、英文、数字、短横-、下划线_")
     * @Length(min=1,max=40,message="长度不正确")
     * @var string
     */
    protected $name;

    /**
     * @IsString(message="格式不正确")
     * @AlphaDash(message="只能使用英文、数字、短横-、下划线_")
     * @Length(min=1,max=20,message="长度不正确")
     * @var string
     */
    protected $password;

    /**
     * @IsString(message="格式不正确")
     * @AlphaDash(message="只能使用英文、数字、短横-、下划线_")
     * @Length(min=1,max=20,message="长度不正确")
     * @var string
     */
    protected $new_password;

    /**
     * @IsString(message="格式不正确")
     * @Confirm(name="new_password",message="两次密码不一致")
     * @var string
     */
    protected $new_rpassword;
}
