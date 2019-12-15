<?php
namespace App\Http\Controller;

use Swoft\Http\Server\Annotation\Mapping\Controller;
use Swoft\Http\Server\Annotation\Mapping\RequestMapping;
use Swoft\Http\Server\Annotation\Mapping\RequestMethod;
use Swoft\Http\Message\Request;
use App\Exception\ApiException;
use Swoft\Http\Server\Annotation\Mapping\Middleware;
use App\Http\Middleware\ControllerMiddleware;
use Swoft\Validator\Annotation\Mapping\Validate;
use App\Model\Entity\DnArea;
use Swoft\Db\DB;
use Throwable;

/**
 * DreamController
 * @Controller(prefix="/api")
 */
class DreamController
{

    /**
     * test
     * @RequestMapping(route="dream",method={RequestMethod::POST,RequestMethod::OPTIONS})
     * @Middleware(ControllerMiddleware::class)
     *
     * @param Request $request
     *
     * @return mixed
     * @throws Throwable
     */
    public function test(Request $request)
    {
        $cityJson = file_get_contents(__DIR__."/city.json");
        $cityInfo = json_decode($cityJson,true);

        $returnArray = [];
        DB::beginTransaction();
        foreach($cityInfo as $key=>$value){
            $provinceId = $this->add([
                "pid" => 0,
                "name" => $value["name"],
                "level" => 1
            ]);
            foreach($value["cityList"] as $item){
                $cityId = $this->add([
                    "pid" => $provinceId,
                    "name" => $item["name"],
                    "level" => 2
                ]);
                if(empty($cityId)){
                    DB::rollBack();
                    break 2;
                }
            }
        }
        var_dump($returnArray);
        DB::commit();
        return context()->getResponse()->withData(["return_code"=>"01","return_msg"=>"success"]);
    }

    public function add($cityInfo){
        return DnArea::insertGetId([
            "ar_pid" => $cityInfo["pid"],
            "ar_name" => $cityInfo["name"],
            "ar_level" => $cityInfo["level"]
        ]);
    }

}