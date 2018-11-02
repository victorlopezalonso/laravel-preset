<?php

namespace App\Http\Controllers\Admin;

use App\Classes\Excel;
use App\Http\Controllers\ApiController;
use App\Http\Requests\Headers;
use App\Http\Resources\Admin\Copies\CopiesResource;
use App\Models\Config;
use App\Models\Copy;

class CopiesController extends ApiController
{

    /**
     * @return \App\Http\Responses\ApiResponse
     */
    public function get()
    {
        $type = request('type');
        $searchText = request('search');

        $query = Copy::where(['type' => $type]);
        if($searchText){

            $query->where(function ($q) use ($searchText){
                $q->orWhere('key', 'like', '%'.$searchText.'%');
                foreach (Config::languages() as $language){
                    $q->orWhere($language, 'like', '%'.$searchText.'%');
                }
            });
        }
        //json_die($query);
        return $this->response(CopiesResource::collection($query->orderBy('key', 'asc')->paginate()));
    }

    public function getParameters(){
        $languages = Config::languages();

        $copyModel['key']    = '';
        $copyModel['type'] = CLIENT_COPY;
        foreach ($languages as $language) {
            $copyModel[$language] = '';
        }

        $response = [
            'languages' => $languages,
            'copyModel' => $copyModel
        ];

        return $this->response($response);
    }

    /**
     * @return \App\Http\Responses\ApiResponse
     */
    public function getAdminCopies()
    {
        return $this->response(Copy::where('type', ADMIN_COPY)->pluck(Headers::getLanguage(), 'key'));
    }

    /**
     * @param Copy $copy
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
        $request           = request()->only(Config::languages());
        $request['key']    = request('key');
        $request['type'] = request('type');

        return Copy::create($request);
    }

    /**
     * @param Copy $copy
     * @throws \Exception
     */
    public function delete(Copy $copy)
    {
        $copy->delete();
    }

    /**
     * Create or update the database copies using an excel file
     *
     * @return \App\Http\Responses\ApiResponse
     * @throws \PhpOffice\PhpSpreadsheet\Exception
     * @throws \PhpOffice\PhpSpreadsheet\Reader\Exception
     */
    public function importFromExcel()
    {
        $languages = Config::languages();

        $xls = new Excel(request()->file('copies'));

        foreach ($xls->rows() as $row) {

            $info = [
                'key'    => $row->key,
                'type' => $row->type ?? false
            ];

            foreach ($languages as $language) {
                $translations[$language] = $row->$language ?? '';
            }

            Copy::updateOrCreate($info, $translations ?? []);
        }

        return $this->withMessage('ADMIN_COPIES_UPDATE_OK');
    }

    /**
     * Export the database copies as an excel file and return the file
     * @throws \PhpOffice\PhpSpreadsheet\Exception
     * @throws \PhpOffice\PhpSpreadsheet\Writer\Exception
     */
    public function exportExcel()
    {
        $headers = array_merge(['key'], Config::languages());
        array_push($headers, 'type');

        $rows = Copy::orderBy('type', 'desc')->orderBy('key', 'asc')->get($headers)->toArray();

        $excel = Excel::createFile('copies.xlsx', $headers, $rows);

        return $this->response($excel);
    }
}
