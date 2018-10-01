<?php

namespace App\Http\Controllers\Admin;

use App\Models\Copy;
use App\Models\Config;
use App\Classes\Console;
use App\Http\Controllers\ApiController;
use App\Http\Resources\Admin\Config\ConfigResource;
use App\Http\Requests\Admin\Config\ConfigUpdateRequest;

class ConfigController extends ApiController
{
    /**
     * Return the configuration params.
     *
     * @return \App\Http\Responses\ApiResponse
     */
    public function getConfig()
    {
        return $this->response(new ConfigResource(Config::first()));
    }

    /**
     * Return the app languages.
     *
     * @return \App\Http\Responses\ApiResponse
     */
    public function getLanguages()
    {
        return $this->response(Config::languages());
    }

    /**
     * Update the configuration.
     *
     * @param ConfigUpdateRequest $request
     *
     * @return ConfigResource
     */
    public function update(ConfigUpdateRequest $request)
    {
        // Get the request languages
        $languages = $request->get('languages');

        // Check if the default languages are in the array
        foreach (API_DEFAULT_LANGUAGES as $defaultLanguage) {
            if (! \in_array($defaultLanguage, $languages, 'key')) {
                array_push($languages, $defaultLanguage);
            }
        }

        // Update the request
        $request->set('languages', $languages);

        $config = Config::first();

        $config->update($request->params());

        Copy::updateLanguages();

        return new ConfigResource($config);
    }

    public function deploy()
    {
        Console::deploy();

        return $this->withMessage('PROJECT_DEPLOYED');
    }
}
