<?php


namespace Grocy\Controllers;


use Psr\Http\Message\ServerRequestInterface;
use Psr\Log\LoggerInterface;
use Slim\Exception\HttpException;
use Slim\Exception\HttpForbiddenException;
use Slim\Exception\HttpNotFoundException;
use Throwable;

class ExceptionController extends BaseApiController
{
    /**
     * @var \Slim\App
     */
    private $app;

    public function __construct(\Slim\App $app, \DI\Container $container)
    {
        parent::__construct($container);
        $this->app = $app;
    }

    public function __invoke(ServerRequestInterface $request,
                             Throwable $exception,
                             bool $displayErrorDetails,
                             bool $logErrors,
                             bool $logErrorDetails,
                             ?LoggerInterface $logger = null)
    {
        $response = $this->app->getResponseFactory()->createResponse();

        $isApiRoute = string_starts_with($request->getUri()->getPath(), '/api/');
        if ($isApiRoute) {
            $status = 500;
            if ($exception instanceof HttpException) {
                $status = $exception->getCode();
            }
            $data = [
                'error_message' => $exception->getMessage(),
            ];
            if ($displayErrorDetails) {
                $data['error_details'] = [
                    'stack_trace' => $exception->getTrace(),
                    'previous' => $exception->getPrevious(),
                    'file' => $exception->getFile(),
                    'line' => $exception->getLine(),
                ];
            }
            return $this->ApiResponse($response->withStatus($status), $data);
        }
        if ($exception instanceof HttpNotFoundException) {
            return $this->renderPage($response->withStatus(404), 'errors/404', [
                'exception' => $exception
            ]);
        }
        if ($exception instanceof HttpForbiddenException) {
            return $this->renderPage($response->withStatus(403), 'errors/403', [
                'exception' => $exception
            ]);
        }

        return $this->renderPage($response->withStatus(500), 'errors/500', [
            'exception' => $exception
        ]);

    }
}