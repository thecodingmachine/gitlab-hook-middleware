<?php

namespace TheCodingMachine\GitlabHook;

use PHPUnit\Framework\TestCase;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use TheCodingMachine\GitlabHook\Model\Base\Branch;
use TheCodingMachine\GitlabHook\Model\Base\Change;
use TheCodingMachine\GitlabHook\Model\Base\Commit;
use TheCodingMachine\GitlabHook\Model\Base\Label;
use TheCodingMachine\GitlabHook\Model\Base\Project;
use TheCodingMachine\GitlabHook\Model\Base\Repository;
use TheCodingMachine\GitlabHook\Model\Base\User;
use TheCodingMachine\GitlabHook\Model\Base\Wiki;
use TheCodingMachine\GitlabHook\Model\Event\Issue;
use TheCodingMachine\GitlabHook\Model\Event\MergeRequest;
use TheCodingMachine\GitlabHook\Model\Event\TagPush;
use TheCodingMachine\GitlabHook\Model\Event\WikiPage;
use Zend\Diactoros\Response;
use Zend\Diactoros\Response\HtmlResponse;
use Zend\Diactoros\ServerRequest;

class GitlabHookMiddlewareTest extends TestCase {

    public function testOk() {
        $data = fopen(__DIR__.'/fixtures/push.json', 'r');

        $request = new ServerRequest([], [], '/foo', 'GET', $data,
                        ['X-GITLAB-TOKEN' => 'test', 'X-Gitlab-Event' => 'Push Hook']);
        $handler = new class implements RequestHandlerInterface {
            public function handle(ServerRequestInterface $request): ResponseInterface
            {
                return new HtmlResponse('Not found', 404);
            }
        };

        $hookReceiver = new HookReceiver([]);
        $gitlabHookReceiver = new GitlabHookMiddleware($hookReceiver, 'test');
        $response = $gitlabHookReceiver->process($request, $handler);

        $this->assertInstanceOf(Response::class, $response);
        $this->assertSame(200, $response->getStatusCode());
    }

    public function testJsonError() {
        $data = fopen(__DIR__.'/fixtures/pushError.json', 'r');

        $request = new ServerRequest([], [], '/foo', 'GET', $data,
            ['X-GITLAB-TOKEN' => 'test', 'X-Gitlab-Event' => 'Push Hook']);
        $handler = new class implements RequestHandlerInterface {
            public function handle(ServerRequestInterface $request): ResponseInterface
            {
                return new HtmlResponse('Not found', 404);
            }
        };

        $hookReceiver = new HookReceiver([]);
        $gitlabHookReceiver = new GitlabHookMiddleware($hookReceiver, 'test');

        $this->expectException(GitlabHookException::class);
        $response = $gitlabHookReceiver->process($request, $handler);
    }

    public function testUnauthorized() {
        $request = new ServerRequest([], [], '/foo', 'GET', 'php://input',
            ['X-GITLAB-TOKEN' => 'wrongKey', 'X-Gitlab-Event' => 'Push Hook']);
        $handler = new class implements RequestHandlerInterface {
            public function handle(ServerRequestInterface $request): ResponseInterface
            {
                return new Response\HtmlResponse('Not found', 404);
            }
        };

        $hookReceiver = new HookReceiver([]);
        $gitlabHookReceiver = new GitlabHookMiddleware($hookReceiver, 'test');
        $response = $gitlabHookReceiver->process($request, $handler);

        $this->assertInstanceOf(Response::class, $response);
        $this->assertSame(401, $response->getStatusCode());
    }

    public function testNotUse() {
        $request = new ServerRequest([], [], '/foo', 'GET', 'php://input');
        $handler = new class implements RequestHandlerInterface {
            public function handle(ServerRequestInterface $request): ResponseInterface
            {
                return new Response\HtmlResponse('Not found', 404);
            }
        };

        $hookReceiver = new HookReceiver([]);
        $gitlabHookReceiver = new GitlabHookMiddleware($hookReceiver, 'test');
        $response = $gitlabHookReceiver->process($request, $handler);

        $this->assertInstanceOf(Response::class, $response);
        $this->assertSame(404, $response->getStatusCode());
    }
}
