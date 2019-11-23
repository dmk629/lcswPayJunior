<?php declare(strict_types=1);

namespace App\Http\Controller\Pay;

use Swoft\Http\Server\Annotation\Mapping\Controller;
use Swoft\Http\Server\Annotation\Mapping\RequestMapping;
use Swoft\Http\Server\Annotation\Mapping\RequestMethod;
use App\Exception\ApiException;
use Swoft\Bean\BeanFactory;
use App\Lib\Pay\Terminal;
use Throwable;

/**
 * TerminalController
 * @Controller(prefix="/api/v1/terminal")
 */
class TerminalController
{

    /**
     * rewardResult
     * @RequestMapping(route="create",method=RequestMethod::GET)
     *
     * @return mixed
     * @throws Throwable
     */
    public function getTerminal()
    {
        $terminal_dao = BeanFactory::getBean("TerminalDao");
        $terminal_info = $terminal_dao->getTerminal();
        if(empty($terminal_info)){
            $pay_config = config("pay");
            $terminal_instance = new Terminal($pay_config["inst_no"],$pay_config["merchant_no"]);
            $post_result = $terminal_instance->getTerminal();
            if(empty($post_result))formatResponse(false,1,"Request error");
            $terminal_dao->addTerminal((int)$post_result["terminal_id"],$post_result["terminal_name"],$post_result["access_token"]);
            return formatResponse(true,0,["terminal_id"=>(int)$post_result["terminal_id"],"access_token"=>$post_result["access_token"]]);
        }else{
            return formatResponse(true,0,$terminal_info);
        }
    }

}