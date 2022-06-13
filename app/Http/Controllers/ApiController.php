<?php

namespace App\Http\Controllers;

use Illuminate\Http\Response;

class ApiController extends Controller {
    /**
     * The status code
     * @var int
     */
    protected $statusCode = Response::HTTP_OK;

    /**
     * Get the value stored as the status code
     *
     * @return int
     */
    public function getStatusCode()
    {
        return $this->statusCode;
    }

    /**
     * Set the status code
     *
     * @param  int   $code   Status code to set
     * @return $this
     */
    public function setStatusCode(int $code)
    {
        $this->statusCode = $code;
        return $this;
    }

    /**
     * Return an error response for 'Not Found'
     *
     * @param  string   $message   Error message
     * @return \Illuminate\Http\JsonResponse
     */
    public function respondNotFound(string $message = 'The requested resource was not found')
    {
        return $this->setStatusCode(Response::HTTP_NOT_FOUND)->respondWithError($message);
    }

    /**
     * Send the response
     *
     * @param  mixed|null   $data
     * @param  array   $headers    [description]
     * @return \Illuminate\Http\JsonResponse
     */
    public function respond($data = null, $headers = [])
    {
        return response()->json($data, $this->getStatusCode(), $headers);
    }

    /**
     * Send the response
     *
     * @param mixed|null $data
     * @param array $headers Http headers
     * @return \Illuminate\Http\JsonResponse
     */
    public function respondWithData($data = null, array $headers = [])
    {
        return response()->json(['data' => $data], $this->getStatusCode(), $headers);
    }

    /**
     * Return an error response
     *
     * @param  string    $message    Error message
     * @return \Illuminate\Http\JsonResponse
     */
    public function respondWithError(string $message = 'Error!')
    {
        return $this->respond([
            'error' => [
                'message'     => $message,
                'status_code' => Response::HTTP_BAD_REQUEST,
            ],
        ]);
    }

    /**
     * Return an validation error structure
     *
     * @param array $errors
     * @return \Illuminate\Http\JsonResponse
     */
    public function respondWithValidationErrors(array $errors)
    {
        return $this->respond([
            "message" =>  "Validation failed",
            "errors" => $errors
        ]);
    }
}