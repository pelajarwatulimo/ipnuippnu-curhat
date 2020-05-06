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
        if($this->isHttpException($exception)){
            switch ($exception->getStatusCode()) {
                case 404:
                    return response()->view('error', [
                        "title" => "Halaman Tidak Ditemukan",
                        "message" => 'Mohon maaf, kami tidak menemukan halaman yang diminta. Jika seharusnya ini tidak terjadi, anda dapat <a href="mailto:'.env('MAIL_FROM_ADDRESS').'">menghubungi kami</a>.',
                        "code" => $exception->getStatusCode()
                    ], $exception->getStatusCode());
                    break;
                case 419:
                    return response()->view('error', [
                        "title" => "Permintaan Kadaluarsa",
                        "message" => 'Sepertinya anda <b>stay</b> terlalu lama. Silahkan tekan tombol <b>Kembali<b> atau anda dapat <a href="mailto:'.env('MAIL_FROM_ADDRESS').'">menghubungi kami</a>.',
                        "code" => $exception->getStatusCode()
                    ], $exception->getStatusCode());
                    break;
                case 500:
                    return response()->view('error', [
                        "title" => "Kesalahan Internal",
                        "message" => 'Terjadi Kesalahan. Silahkan <a href="mailto:'.env('MAIL_FROM_ADDRESS').'">menghubungi kami</a> untuk memperbaiki masalah ini.',
                        "code" => $exception->getStatusCode()
                    ], $exception->getStatusCode());
                    break;
                default:
                    return response()->view('error', [
                        "title" => "Hmm...",
                        "message" => 'Terjadi Kesalahan. Silahkan <a href="mailto:'.env('MAIL_FROM_ADDRESS').'">menghubungi kami</a> untuk memperbaiki masalah ini.',
                    ], $exception->getStatusCode());
                    break;
            }
        }
        return parent::render($request, $exception);
    }
}
