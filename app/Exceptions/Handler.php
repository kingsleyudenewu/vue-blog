<?php

namespace App\Exceptions;

use App\Traits\ApiResponse;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Http\Client\HttpClientException;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Support\Arr;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Throwable;

class Handler extends ExceptionHandler
{
    use ApiResponse;

    /**
     * A list of exception types with their corresponding custom log levels.
     *
     * @var array<class-string<\Throwable>, \Psr\Log\LogLevel::*>
     */
    protected $levels = [
        //
    ];

    /**
     * A list of the exception types that are not reported.
     *
     * @var array<int, class-string<\Throwable>>
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed to the session on validation exceptions.
     *
     * @var array<int, string>
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    /**
     * Register the exception handling callbacks for the application.
     *
     * @return void
     */
    public function register()
    {
        $this->renderable(function (Throwable $e) {
            $this->buildResponse($e);
        });
    }

    private function buildResponse(Throwable $e)
    {
        if ($e instanceof ValidationException) {
            return $this->formValidationErrorAlert(Arr::flatten($e->errors()));
        }

        if ($e instanceof ModelNotFoundException) {
            return $this->notFoundAlert('Model cannot be found');
        }

        if ($e instanceof NotFoundHttpException) {
            return response()->json(['message' => $e->getMessage() || "Resource cannot be found"],
                404);
        }

        if ($e instanceof HttpResponseException) {
            return $e->getResponse();
        }

        if ($e instanceof HttpException) {
            return $this->httpErrorAlert('Http Error', $e);
        }

        if ($e instanceof HttpClientException) {
            return $this->httpErrorAlert($e->getMessage());
        }
        return $this->serverErrorAlert($e->getMessage());
    }
}
