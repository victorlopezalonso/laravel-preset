<?php

namespace App\Exceptions;

use App\Models\Copy;

class ApiVersionOutdatedException extends ApiException
{
    protected $status = HTTP_CODE_426_UPGRADE_REQUIRED;

    /**
     * ApiVersionOutdatedException constructor.
     */
    public function __construct()
    {
        parent::__construct();

        $this->message = Copy::server(APP_VERSION_OUTDATED);
    }
}
