<?php

namespace App\Exceptions;

use App\Models\Copy;

class ApiNotValidatedUserException extends ApiException
{

    protected $status = HTTP_CODE_409_CONFLICT;

    /**
     * UnauthorizedException constructor.
     * @param int $code
     * @internal param bool $isRefreshTokenExpired
     */
    public function __construct(int $code = 0)
    {
        parent::__construct();

        $this->message = Copy::server('USER_NOT_VALIDATED');

        $this->code = $code;

        $this->errorMessage = $this->message;
    }

}
