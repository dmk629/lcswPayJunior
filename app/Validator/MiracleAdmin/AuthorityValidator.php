<?php declare(strict_types=1);

namespace App\Validator\MiracleAdmin;

use Swoft\Validator\Annotation\Mapping\IsString;
use Swoft\Validator\Annotation\Mapping\Length;
use Swoft\Validator\Annotation\Mapping\Validator;
use Swoft\Validator\Annotation\Mapping\NotEmpty;
use Swoft\Validator\Annotation\Mapping\IsInt;
use Swoft\Validator\Annotation\Mapping\Min;
use Swoft\Validator\Annotation\Mapping\Max;

/**
 * 权限验证器
 *
 * @since 2.0
 *
 * @Validator(name="AuthorityValidator")
 */
class AuthorityValidator
{
    /**
     * @IsString(message="格式不正确")
     * @NotEmpty(message="名称不能为空")
     * @Length(min=1,max=30,message="长度不正确")
     * @var string
     */
    protected $name;

    /**
     * @IsString(message="格式不正确")
     * @NotEmpty(message="路由不能为空")
     * @Length(min=1,max=60,message="长度不正确")
     * @var string
     */
    protected $url;

    /**
     * @IsInt(message="格式不正确")
     * @NotEmpty(message="路由不能为空")
     * @Min(value=1,message="格式不正确")
     * @Max(value=255,message="格式不正确")
     * @var int
     */
    protected $cate_id;

    /**
     * @IsInt(message="格式不正确")
     * @Min(value=1,message="格式不正确")
     * @Max(value=2,message="格式不正确")
     * @var int
     */
    protected $hide;

    /**
     * @IsInt(message="格式不正确")
     * @Min(value=0,message="格式不正确")
     * @Max(value=255,message="格式不正确")
     * @var int
     */
    protected $sort;

}
