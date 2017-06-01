<?php

namespace MLTools\Exceptions;

use Exception;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that should not be reported.
     *
     * @var array
     */
    protected $dontReport = [
        \Symfony\Component\HttpKernel\Exception\HttpException::class,
    ];

    /**
     * Report or log an exception.
     *
     * This is a great spot to send exceptions to Sentry, Bugsnag, etc.
     *
     * @param  \Exception  $e
     * @return void
     */
    public function report(Exception $e)
    {
        return parent::report($e);
    }

    /**
     * Render the error view that best fits that status code.
     *
     * @param Exception $e
     * @return \Illuminate\Http\Response
     */
    public function renderHttpExceptionView(Exception $e)
    {
        $status = $e->getStatusCode();

        if (view()->exists("errors.{$status}")) {
            return $this->toIlluminateResponse($this->renderHttpException($e), $e);
        }

        return response()->view("errors.default", ['exception' => $e], $status);

    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Exception  $e
     * @return \Illuminate\Http\Response
     */
    public function render($request, Exception $e)
    {
        if ($this->isHttpException($e)) {
            return $this->renderHttpExceptionView($e);
        }

        return parent::render($request, $e);
    }
}
