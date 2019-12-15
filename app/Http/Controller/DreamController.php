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
use Swoft\Bean\BeanFactory;
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
    public function notifyTest(Request $request)
    {
        $cityJson = file_get_contents(__DIR__."/city.json");
        $cityInfo = json_decode($cityJson,true);

        $returnArray = [];
        foreach($cityInfo as $key=>$value){
            //var_dump($value);
            $returnArray[$key]["name"] = $value["name"];
            foreach($value["cityList"] as $item){
                $returnArray[$key]["city"][] = $item["name"];
            }
            break;
        }
        var_dump($returnArray);
        return context()->getResponse()->withData(["return_code"=>"01","return_msg"=>"success"]);
    }

}