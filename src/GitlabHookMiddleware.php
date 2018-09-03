<?php
namespace TheCodingMachine\GitlabHook;

use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Zend\Diactoros\Response;

class GitlabHookMiddleware implements MiddlewareInterface
{

    /**
     * @var HookReceiver
     */
    private $hookReceiver;

    /**
     * @var string
     */
    private $gitlabSecret;

    public function __construct(HookReceiver $hookReceiver, string $gitlabSecret)
    {
        $this->hookReceiver = $hookReceiver;
        $this->gitlabSecret = $gitlabSecret;
    }

    /**
     * @param \Psr\Http\Message\ServerRequestInterface $request
     * @param \Psr\Http\Server\RequestHandlerInterface $handler
     *
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        if ($request->hasHeader('HTTP_X_GITLAB_TOKEN')) {
            if ($request->getHeader('HTTP_X_GITLAB_TOKEN')[0] == $this->gitlabSecret) {
                $payload = json_decode($request->getBody()->getContents(), true);
                if (($error = json_last_error()) != JSON_ERROR_NONE) {
                    throw new GitlabHookException("Error parsing json data with code: ".$error);
                }
                $this->hookReceiver->handle($payload, $request->getHeader('X-Gitlab-Event')[0]);
                return new Response();
            }
            return new Response('Wrong key', 401);
        }
        return $handler->handle($request);
    }
}
