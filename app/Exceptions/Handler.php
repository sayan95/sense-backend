<?php

namespace App\Exceptions;

use Throwable;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Foundation\Http\Exceptions\MaintenanceModeException;


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
     * @param  \Throwable  $exception
     * @return void
     *
     * @throws \Throwable
     */
    public function report(Throwable $exception)
    {   
        // report exceptions to sentry
        // if (app()->bound('sentry') && $this->shouldReport($exception)) {
        //     app('sentry')->captureException($exception);
        // }

        parent::report($exception);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Throwable  $exception
     * @return \Symfony\Component\HttpFoundation\Response
     *
     * @throws \Throwable
     */
    public function render($request, Throwable $exception)
    {
        if($exception instanceof AuthenticationException && $request->expectsJson()){
            return response()->json([
                'alertType' => 'user-unauthenticated',
                'message' => 'You are unauthenticated.'
            ], 401);
        }
        if($exception instanceof MaintenanceModeException && $request->expectsJson()){
            return response()->json([
                'alertType' => 'app-in-maintainance',
                'message' => 'Our application is in maintainance mode. Try after some time.'
            ], 503);
        }
        return parent::render($request, $exception);
    }
}
