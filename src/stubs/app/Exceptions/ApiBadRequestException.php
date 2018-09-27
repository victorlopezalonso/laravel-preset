<?php

namespace App\Exceptions;

use App\Models\Copy;

class ApiBadRequestException extends ApiException
{

    protected $status = HTTP_CODE_400_BAD_REQUEST;

    /**
     * BadRequestException constructor.
     * @param string $copy
     */
    public function __construct(string $copy)
    {
        parent::__construct();

        $this->message      = Copy::server($copy);
        $this->errorMessage = Copy::server($copy);
    }

}
