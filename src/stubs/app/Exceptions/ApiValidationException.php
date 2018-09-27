<?php

namespace App\Exceptions;

use App\Models\Copy;
use Illuminate\Validation\ValidationException;

class ApiValidationException extends ApiException
{

    /** @var int HTTP Status */
    protected $status = HTTP_CODE_422_UNPROCESSABLE_ENTITY;

    /**
     * ValidationException constructor.
     * @param ValidationException $exception
     */
    public function __construct(ValidationException $exception)
    {
        parent::__construct();

        $this->setMessageAndValidations($exception);
    }

    /**
     * Set the message bag from the ValidationException
     * @param ValidationException $exception
     */
    protected function setMessageAndValidations(ValidationException $exception)
    {
        $messageBag = $exception->validator->getMessageBag();

        $this->message = SHOW_FIRST_MESSAGE_IN_VALIDATION ? $messageBag->first() : Copy::server(VALIDATION_FAILS);

        array_map(function ($key, $value) {
            $this->validations[$key] = $value;
        }, $messageBag->keys(), $messageBag->all());
    }

}
