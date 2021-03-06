<?php

namespace App\Models;

use Carbon\Carbon;
use App\Helpers\StorageHelper;
use App\Http\Requests\Headers;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Schema\Blueprint;

class ApiModel extends Model
{
    protected $dir = '';

    /** @var array All attributes are fillable */
    protected $guarded = [];

    /**
     * @param array $value
     * @param null  $language
     *
     * @return null|mixed
     */
    public function getLocalizedValueFromJson($value, $language = null)
    {
        $value = \is_string($value) ? json_decode($value) : $value;
        $language = $language ?? Headers::getLanguage();

        return $value[$language] ?? null;
    }

    /**
     * Upload a file a save uuid into the model.
     *
     * @param string $key
     * @param string $directory
     */
    public function saveFileOrUrl(string $key, string $directory)
    {
        if (request()->file($key)) { //request file
            $fileName = StorageHelper::saveUploadedFileToPublicDisk($directory, $key);
        } elseif (filter_var(request($key), FILTER_VALIDATE_URL)) { //request url
            $fileName = StorageHelper::saveUrlToPublicDisk($directory, request($key));
        } elseif (is_binary(request()->getContent())) { //request binary
            $fileName = StorageHelper::saveBinaryFileToPublicDisk($directory);
        } else {
            return;
        }

        //Delete old file
        StorageHelper::deleteFileFromPublicDisk($directory, $this->{$key});

        //Save fileName into model table
        $this->{$key} = $fileName;
        $this->save();
    }

    /**
     * Return the associated table to the model.
     *
     * @return mixed
     */
    public static function table()
    {
        return with(new static())->getTable();
    }

    /**
     * Return the columns of the table associated to the model.
     *
     * @return mixed
     */
    public static function getColumns()
    {
        return Schema::getColumnListing(self::table());
    }

    /**
     * Add a new column to the table associated with the model.
     *
     * @param $column
     * @param $type
     * @param $params
     */
    public static function addColumn($column, $type, $params)
    {
        $table = static::table();

        if (! Schema::hasColumn($table, $column)) {
            Schema::table($table, function (Blueprint $table) use ($column, $type, $params) {
                $table->addColumn($type, $column, $params);
            });
        }
    }

    /**
     * Drop a column from the table associated with the model.
     *
     * @param $column
     */
    public static function dropColumn($column)
    {
        $table = static::table();

        if (Schema::hasColumn($table, $column)) {
            Schema::table($table, function (Blueprint $table) use ($column) {
                $table->dropColumn($column);
            });
        }
    }

    /**
     * Insert an array of model items into the database.
     *
     * @param array $items
     * @param array $replacements
     */
    public static function insertMany(array $items, array $replacements = [])
    {
        $now = Carbon::now()->toDateTimeString();

        foreach ($items as &$item) {
            if ((new static())->usesTimestamps()) {
                $item['created_at'] = $item['created_at'] ?? $now;
                $item['updated_at'] = $item['updated_at'] ?? $now;
            }

            foreach ($replacements as $key => $value) {
                $item[$key] = $value;
            }
        }

        if (\count($items)) {
            static::insert($items);
        }
    }

    /**
     * Set the pagination limit from the request or from the API constant.
     *
     * @return int
     */
    public function getPerPage()
    {
        return request('limit') && request('limit') < 100 ? request('limit') : API_QUERY_RESULTS_PER_PAGE;
    }
}
