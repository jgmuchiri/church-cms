<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Support\Facades\Mail;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that should not be reported.
     *
     * @var array
     */
    protected $dontReport = [
        \Illuminate\Auth\AuthenticationException::class,
        \Illuminate\Auth\Access\AuthorizationException::class,
        \Symfony\Component\HttpKernel\Exception\HttpException::class,
        \Illuminate\Database\Eloquent\ModelNotFoundException::class,
        \Illuminate\Session\TokenMismatchException::class,
        \Illuminate\Validation\ValidationException::class,
    ];

    /**
     * Report or log an exception.
     *
     * This is a great spot to send exceptions to Sentry, Bugsnag, etc.
     *
     * @param  \Exception  $exception
     * @return void
     */
    public function report(Exception $exception)
    {

        if ($exception instanceof \Exception && env('SEND_DEBUG_EMAIL') == true) {

            //send email for any errors

            if (ExceptionHandler::isHttpException($exception)) {
                $content = ExceptionHandler::toIlluminateResponse(ExceptionHandler::renderHttpException($exception), $exception);
            } else {
                $content = ExceptionHandler::toIlluminateResponse(ExceptionHandler::convertExceptionToResponse($exception), $exception);
            }
            $lc2 = (isset($content->original)) ? $content->original : $exception->getMessage();


            $lc1 = "";
            try {
                $request = request();
                $lc1 =
                    "<div>" .
                    "<p><h5>Message:</h5></p>" . $exception->getMessage() .
                    "<p><strong>File:</strong></p>" . $exception->getFile() .
                    "<p><strong>-- Request --</strong></p><br>" .
                    "<br>Method: " . $request->getMethod() .
                    "<br>Uri: " . $request->getUri() .
                    "<br>Ip: " . $request->getClientIp() .
                    "<br>Referrer: " . $request->server('HTTP_REFERER') .
                    "<br>Is secure: " . $request->isSecure() .
                    "<br>Is ajax: " . $request->ajax() .
                    "<br>User agent: " . $request->server('HTTP_USER_AGENT') .
                    "<br>Content:<br>" . nl2br(htmlentities($request->getContent())) .
                    "<p><h5>Trace:</h5></p><code>" . $exception->getTraceAsString() ."</code>".
                    "</div>";
            } catch (Exception $e2) {

            }

            if (strpos($lc2, '</body>') !== false) {
                $lc2 = str_replace('</body>', $lc1 . '</body>', $lc2);
            } else {
                $lc2 .= $lc1;
            }

            try{
                Mail::send('emails.exceptions', ['content'=>$lc2], function ($m) {
                    $m->from(env('EMAIL_FROM_ADDRESS'), env('APP_NAME'));
                    $m->to(env('DEBUG_EMAIL'), 'ERROR HANDLER')->subject('ERROR HANDLER - ' . env('APP_NAME'));
                });
            }catch (Exception $e){

            }

        }
        parent::report($exception);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Exception  $exception
     * @return \Illuminate\Http\Response
     */
    public function render($request, Exception $exception)
    {
        return parent::render($request, $exception);
    }

    /**
     * Convert an authentication exception into an unauthenticated response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Illuminate\Auth\AuthenticationException  $exception
     * @return \Illuminate\Http\Response
     */
    protected function unauthenticated($request, AuthenticationException $exception)
    {
        if ($request->expectsJson()) {
            return response()->json(['error' => 'Unauthenticated.'], 401);
        }

        return redirect()->guest('login');
    }
}
