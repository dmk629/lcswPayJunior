<?php declare(strict_types=1);

namespace App\Http\Controller\Pay;

use Swoft;
use Swoft\Http\Server\Annotation\Mapping\Controller;
use Swoft\Http\Server\Annotation\Mapping\RequestMapping;
use Swoft\Http\Server\Annotation\Mapping\RequestMethod;
use Swoft\Http\Message\Request;
use Swoft\Http\Message\Response;
use Swoft\Context\Context;
use Swoft\Validator\Annotation\Mapping\Validate;
use App\Exception\ApiException;
use App\Model\Entity\Feedback;
use Swoft\Http\Server\Annotation\Mapping\Middlewares;
use Swoft\Http\Server\Annotation\Mapping\Middleware;
use App\Http\Middleware\ControllerMiddleware;
use Throwable;

/**
 * Contact
 * @Controller(prefix="/api/v1/contact")
 */
class ContactController
{
    /**
     * PlayerList
     * @RequestMapping(route="feedback",method=RequestMethod::POST)
     * @Middleware(ControllerMiddleware::class)
     * @Validate(validator="PlayerValidator",fields={"nickname","qq","area","content"})
     *
     * @param Request $request
     *
     * @return Response
     * @throws Throwable
     */
    public function playerList(Request $request)
    {
        $fields = $request->post();
        list($ip) = $request->getHeader("X-real-ip");
        $attributes = [
            "nickname" => $fields["nickname"],
            "qq"        => $fields["qq"],
            "content"  => $fields["content"],
            "area"      => $fields["area"],
            "ip"      => $ip
        ];
        Feedback::New($attributes)->save();
        return formatResponse(true,0,"Succeed");
    }

}