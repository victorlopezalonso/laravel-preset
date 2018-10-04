<?php

namespace App\Http\Resources\Admin\Copies;

use App\Models\Copy;
use Illuminate\Http\Resources\Json\Resource;

class CopiesResource extends Resource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return array
     */
    public function toArray($request)
    {
        // @var Copy $this
        return [
            'id'  => $this->id,
            'key' => $this->key,
            'es'  => $this->es,
            'en'  => $this->en,
            'type'=> $this->type,
        ];
    }
}
