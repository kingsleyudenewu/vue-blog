<?php


namespace App\Traits;


use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\JsonResponse as LaravelJsonResponse;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Fluent;
use Symfony\Component\HttpKernel\Exception\HttpException;

trait ApiResponse
{
    /**
     * Set the server error response.
     *
     * @param $message
     * @param Exception|null $exception
     *
     * @return JsonResponse
     */
    public function serverErrorAlert($message, Exception $exception = null, $code = null): JsonResponse
    {
        if (null !== $exception) {
            Log::error("{$exception->getMessage()} on line {$exception->getLine()} in {$exception->getFile()}");
            report($exception);
        }

        $response = ["status" => "error", 'message' => $message];

        if (null !== $exception) {
            $response['exception'] = $exception->getMessage();
            Log::error($exception->getMessage());
        }

        if (null !== $code) {
            return Response::json($response, $code);
        }

        return Response::json($response, 500);
    }

    /**
     * Set the server error response.
     *
     * @param $message
     * @param HttpException $exception
     *
     * @return JsonResponse
     */
    public function httpErrorAlert($message, HttpException $exception = null): JsonResponse
    {
        if (null !== $exception) {
            Log::error("{$exception->getMessage()} on line {$exception->getLine()} in {$exception->getFile()}");
        }

        $response = ["status" => "error", 'message' => $message];

        if (null !== $exception) {
            $response['exception'] = $exception->getMessage();
        }

        return Response::json($response, 400);
    }

    /**
     * Set the form validation error response.
     *
     * @param $errors
     * @param $data
     *
     * @return JsonResponse
     */
    public function formValidationErrorAlert($data = null): JsonResponse
    {
        $response = [
            "status" => "error",
            'message' => 'Whoops. Validation failed.'
        ];

        if (null !== $data) {
            $response['data'] = $data;
        }

        return Response::json($response, 422);
    }

    /**
     * Set the "not found" error response.
     *
     * @param $message
     * @param null $data
     *
     * @return JsonResponse
     */
    public function notFoundAlert($message, $data = null): JsonResponse
    {
        $response = ["status" => "error", 'message' => $message];

        if (null !== $data) {
            $response['data'] = $data;
        }


        return Response::json($response, 404);
    }

    /**
     * Set bad request error response.
     *
     * @param string $message
     * @param null $data
     *
     * @return JsonResponse
     */
    public function badRequestAlert(string $message, $data = null): JsonResponse
    {
        $response = ["status" => "error", 'message' => $message];

        if (null !== $data) {
            $response['data'] = $data;
        }

        return Response::json($response, 400);
    }

    /**
     * Set the success response alert.
     *
     * @param $message
     * @param $data
     *
     * @return JsonResponse
     */
    public function successResponse($message, $data = null): JsonResponse
    {
        $response = ["status" => "success", 'message' => $message];

        if (!is_null($data)) {
            $response['data'] = $data;
        }

        if ($data instanceof LaravelJsonResponse) {
            $data = $data->getData(true);

            $response['data'] = Arr::get($data, 'data');
            $response['meta'] = Arr::get($data, 'meta');
            $response['links'] = Arr::get($data, 'links');
        }

        return Response::json($response, 200);
    }

    /**
     * Set the created resource response alert.
     *
     * @param $message
     * @param $data
     *
     * @return JsonResponse
     */
    public function createdResponse($message, $data = null): JsonResponse
    {
        $response = ["status" => "success", 'message' => $message];

        if (null !== $data) {
            $response['data'] = $data;
        }

        return Response::json($response, 201);
    }

    /**
     * Set forbidden request error response.
     *
     * @param $message
     * @param $data
     *
     * @return JsonResponse
     */
    public function forbiddenRequestAlert($message, $data = null, $code = null): JsonResponse
    {
        $response = ["status" => "error", 'message' => $message,];

        if (null !== $data) {
            $response['data'] = $data;
        }

        return Response::json($response, 403);
    }

    /**
     * @param null $data
     * @param string|null $message
     * @return Fluent
     */
    public function ok($data = null, string $message = null)
    {
        return new Fluent([
            "status" => true,
            "data" => $data,
            "message" => $message
        ]);
    }

    /**
     * @param null $message
     * @param null $data
     * @return Fluent
     */
    public function bad($message = null, $data = null)
    {
        logger($data);
        return new Fluent([
            "status" => false,
            "data" => $data,
            "message" => $message
        ]);
    }

}
