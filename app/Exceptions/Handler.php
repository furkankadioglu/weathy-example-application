<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use ReflectionClass;
use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that are not reported.
     *
     * @var array
     */
    protected $dontReport = [
        ValidationException::class,
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
     * Register the exception handling callbacks for the application.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Throwable  $e
     * @return \Symfony\Component\HttpFoundation\Response
     *
     * @throws \Throwable
     */
    public function render($request, Throwable $e)
    {
        return $this->getJsonResponseForException($request, $e);
    }

    /**
     * Creates a new JSON response based on exception type.
     *
     * @param Request $request
     * @param Throwable $e
     * @return \Illuminate\Http\JsonResponse
     */
    protected function getJsonResponseForException(Request $request, Throwable $e): JsonResponse
    {
        switch (true) {
            case $e instanceof ValidationException:
                return $this->validationFailed($e);
            default:
                return $this->badRequest($e, 500, "Uncategorized exception");
        }
    }

    /**
     * Returns json response for generic bad request.
     *
     * @param Throwable $exception
     * @param int       $statusCode
     * @param string|null      $summary
     * @return \Illuminate\Http\JsonResponse
     */
    protected function badRequest(Throwable $exception, int $statusCode = 400, string $summary = null): JsonResponse
    {
        if ($exception->getMessage() === '') {
            $reflection = new ReflectionClass($exception);
            $message = $reflection->getShortName(); // Fastest way to get Exception without Namespace
        } else {
            $message = $exception->getMessage();
        }
        
        return $this->jsonResponse(['message' => $message, 'time' => now()], $statusCode);
    }

    /**
     * @param ValidationException $exception
     * @return \Illuminate\Http\JsonResponse
     */
    protected function validationFailed(ValidationException $exception): JsonResponse
    {
        return $this->jsonResponse(['message' => 'Validation failed', 'errors' => $exception->validator->getMessageBag()], 400);
    }


    /**
     * Returns json response.
     *
     * @param array|null $payload
     * @param int $statusCode
     * @return \Illuminate\Http\JsonResponse
     */
    protected function jsonResponse(array $payload = null, int $statusCode = 404): JsonResponse
    {
        $payload = $payload ?: [];

        return response()->json($payload, $statusCode);
    }

}
