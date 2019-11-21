<?php declare(strict_types=1);

namespace App\Http\Middleware;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Swoft\Http\Server\Contract\MiddlewareInterface;
use Swoft\Bean\Annotation\Mapping\Bean;
use Swoft\Context\Context;

/**
 * NotifyMiddleware
 * @bean()
 */
class NotifyMiddleware implements MiddlewareInterface
{
    /**
     * Process an incoming server request.
     * @param ServerRequestInterface $request
     * @param RequestHandlerInterface $handler
     * @return ResponseInterface
     * @inheritdoc
     */
    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        var_dump($request);
        return Context::mustGet()->getResponse()->withStatus(404);
        return $handler->handle($request);
    }

}
