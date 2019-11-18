<?php declare(strict_types=1);

namespace App\Validator\Pay;

use App\Annotation\Mapping\AlphaDash;
use Swoft\Validator\Annotation\Mapping\IsInt;
use Swoft\Validator\Annotation\Mapping\IsString;
use Swoft\Validator\Annotation\Mapping\Length;
use Swoft\Validator\Annotation\Mapping\AlphaNum;
use Swoft\Validator\Annotation\Mapping\Min;
use Swoft\Validator\Annotation\Mapping\Max;
use Swoft\Validator\Annotation\Mapping\Validator;

/**
 * Class BarcodeValidator
 *
 * @since 2.0
 *
 * @Validator(name="BarcodeValidator")
 */
class BarcodeValidator
{
    /**
     * @IsString(message="格式不正确")
     * @AlphaNum(message="付款码不正确")
     * @Length(min=0,max=40,message="长度不正确")
     * @var string
     */
    protected $barcode = "";

    /**
     * @IsFloat(message="格式不正确")
     * @Min(value=0,message="格式不正确")
     * @Max(value=99999999,message="格式不正确")
     * @var int
     */
    protected $total;

}
