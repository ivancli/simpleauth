<?php

namespace App\Exceptions;

use App\Exceptions\SocialAuthExceptions\NullEmailException;
use App\Exceptions\SocialAuthExceptions\UnauthorisedException;
use Exception;
use GuzzleHttp\Exception\ClientException;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that are not reported.
     *
     * @var array
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var array
     */
    protected $dontFlash = [
        'password',
        'password_confirmation',
    ];

    /**
     * Report or log an exception.
     *
     * This is a great spot to send exceptions to Sentry, Bugsnag, etc.
     *
     * @param  \Exception $exception
     * @return void
     */
    public function report(Exception $exception)
    {
        parent::report($exception);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Exception $exception
     * @return \Illuminate\Http\Response|string|\Symfony\Component\HttpFoundation\Response
     */
    public function render($request, Exception $exception)
    {
        $e = $this->prepareException($exception);
        if ($e instanceof ClientException) {
            return $e->getMessage();
        }
        if ($e instanceof UnauthorisedException || $e instanceof NullEmailException) {
            return redirect()->route('auth.login.get')->withErrors($e->getMessage());
        }

        return parent::render($request, $exception);
    }

    public function unauthenticated($request, AuthenticationException $exception)
    {
        return $request->expectsJson()
            ? response()->json(['message' => 'Unauthenticated.'], 401)
            : redirect()->guest(route('auth.login.get'));
    }
}
