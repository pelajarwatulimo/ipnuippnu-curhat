<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Throwable;

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
     * @throws \Exception
     */
    public function report(Throwable $exception)
    {
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
        if( config('app.env') == 'production' )
        {
            if( $exception instanceof \ErrorException )
                return response()->view('error', [
                    "title" => "Kesalahan Internal",
                    "message" => 'Terjadi Kesalahan. Silahkan <a href="mailto:'.env('MAIL_FROM_ADDRESS').'">menghubungi kami</a> untuk memperbaiki masalah ini.',
                    "code" => 500
                ], 500);
                
            if( $exception instanceof \Symfony\Component\HttpKernel\Exception\NotFoundHttpException ||
                $exception instanceof \Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException )
                return response()->view('error', [
                    "title" => "Halaman Tidak Ditemukan",
                    "message" => 'Mohon maaf, kami tidak menemukan halaman yang diminta. Jika seharusnya ini tidak terjadi, anda dapat <a href="mailto:'.env('MAIL_FROM_ADDRESS').'">menghubungi kami</a>.',
                    "code" => 404
                ], 404);
                
            if( $exception instanceof \Illuminate\Foundation\Http\Exceptions\MaintenanceModeException )
                return response()->view('error', [
                    "title" => "Mohon Maaf",
                    "message" => 'Mohon maaf, layanan sedang dinonaktifkan dalam beberapa waktu untuk peningkatan beberapa layanan. Silahkan kembali lagi nanti.',
                    "code" => 503
                ], 503);

            if( $exception instanceof \Illuminate\Session\TokenMismatchException )
                return redirect()->back();

        }
        
        return parent::render($request, $exception);
    }
}
