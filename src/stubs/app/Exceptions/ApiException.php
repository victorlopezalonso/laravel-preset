<?php

namespace App\Exceptions;

use Throwable;
use App\Models\Copy;
use App\Http\Responses\ApiResponse;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Validation\ValidationException;
use League\OAuth2\Server\Exception\OAuthServerException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;

class ApiException extends \Exception
{
    /** @var int HTTP Status */
    protected $status = HTTP_CODE_500_INTERNAL_SERVER_ERROR;

    /** @var \Exception original exception */
    protected $exception;

    /** @var string default message */
    protected $message;

    /** @var int error code */
    protected $code = 0;

    /** @var string error message */
    protected $errorMessage;

    /** @var array failed validations as array */
    protected $validations;

    /** @var ApiResponse */
    private $response;

    /**
     * ApiException constructor.
     *
     * @param string         $message
     * @param int            $code
     * @param null|Throwable $previous
     */
    public function __construct(string $message = '', int $code = 0, Throwable $previous = null)
    {
        $this->response = new ApiResponse();

        $this->response->withMessage(Copy::server(SERVER_ERROR))->withStatus($this->status);

        parent::__construct($message, $code, $previous);
    }

    /**
     * @param \Exception $exception
     *
     * @throws ApiValidationException
     * @throws ApiServerErrorException
     * @throws ApiUnauthorizedException
     * @throws ApiRouteOrMethodNotFoundException
     */
    public static function throwException(\Exception $exception)
    {
        switch ($exception) {
            case $exception instanceof OAuthServerException:
            case $exception instanceof AuthenticationException:
                throw new ApiUnauthorizedException();

                break;
            case $exception instanceof NotFoundHttpException:
            case $exception instanceof MethodNotAllowedHttpException:
                throw new ApiRouteOrMethodNotFoundException();
            case $exception instanceof ValidationException:
                throw new ApiValidationException($exception);

                break;
            default:
                throw new ApiServerErrorException($exception);
        }
    }

    /**
     * Send the ApiResponse array as a JSON response.
     *
     * @return ApiResponse
     */
    public function render()
    {
        if ($this->message) {
            $this->response->withMessage($this->message);
        }

        if ($this->errorMessage) {
            $this->response->withErrorCode($this->code)->withErrorMessage($this->errorMessage);
        }

        if ($this->validations) {
            $this->response->withValidations($this->validations);
        }

        return $this->response;
    }
}
