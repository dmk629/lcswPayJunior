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
 * Class WapValidator
 *
 * @since 2.0
 *
 * @Validator(name="WapValidator")
 */
class WapValidator
{

    /**
     * @IsFloat(message="格式不正确")
     * @Min(value=0,message="格式不正确")
     * @Max(value=99999999,message="格式不正确")
     * @var int
     */
    protected $total;

}
