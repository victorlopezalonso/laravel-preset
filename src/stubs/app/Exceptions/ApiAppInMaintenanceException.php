<?php

namespace App\Exceptions;

use App\Models\Copy;

class ApiAppInMaintenanceException extends ApiException
{
    protected $status = HTTP_CODE_503_SERVICE_UNAVAILABLE;

    /**
     * ApiAppInMaintenanceException constructor.
     */
    public function __construct()
    {
        parent::__construct();

        $this->message = Copy::server(APP_IN_MAINTENANCE);
    }
}
