<?php

namespace App\Http\Controllers\Admin;

use App\Models\Copy;
use App\Classes\Excel;
use App\Models\Config;
use App\Http\Controllers\ApiController;

class CopiesController extends ApiController
{
    /**
     * @return \App\Http\Responses\ApiResponse
     */
    public function get()
    {
        $languages = Config::languages();

        $copyModel['key'] = '';
        $copyModel['server'] = false;
        foreach ($languages as $language) {
            $copyModel[$language] = '';
        }

        $response = [
            'copies'    => Copy::orderBy('server', 'desc')->orderBy('key', 'asc')->get(),
            'languages' => $languages,
            'copyModel' => $copyModel,
        ];

        return $this->response($response);
    }

    /**
     * @param Copy $copy
     *
     * @return Copy
     */
    public function update(Copy $copy)
    {
        $request = request()->only(Config::languages());
        $copy->update($request);

        return $copy;
    }

    /**
     * @return mixed
     */
    public function create()
    {
        $request = request()->only(Config::languages());
        $request['key'] = request('key');
        $request['server'] = request('server');

        return Copy::create($request);
    }

    /**
     * @param Copy $copy
     *
     * @throws \Exception
     */
    public function delete(Copy $copy)
    {
        $copy->delete();
    }

    /**
     * Create or update the database copies using an excel file.
     *
     * @throws \PhpOffice\PhpSpreadsheet\Exception
     * @throws \PhpOffice\PhpSpreadsheet\Reader\Exception
     *
     * @return \App\Http\Responses\ApiResponse
     */
    public function importFromExcel()
    {
        $languages = Config::languages();

        $xls = new Excel(request()->file('copies'));

        foreach ($xls->rows() as $row) {
            $info = [
                'key'    => $row->key,
                'server' => $row->server ?? false,
            ];

            foreach ($languages as $language) {
                $translations[$language] = $row->{$language} ?? '';
            }

            Copy::updateOrCreate($info, $translations ?? []);
        }

        return $this->withMessage('ADMIN_COPIES_UPDATE_OK');
    }

    /**
     * Export the database copies as an excel file and return the file.
     *
     * @throws \PhpOffice\PhpSpreadsheet\Exception
     * @throws \PhpOffice\PhpSpreadsheet\Writer\Exception
     */
    public function exportExcel()
    {
        $headers = array_merge(['key'], Config::languages());
        array_push($headers, 'server');

        $rows = Copy::orderBy('server', 'desc')->orderBy('key', 'asc')->get($headers)->toArray();

        $excel = Excel::createFile('copies.xlsx', $headers, $rows);

        return $this->response($excel);
    }
}
