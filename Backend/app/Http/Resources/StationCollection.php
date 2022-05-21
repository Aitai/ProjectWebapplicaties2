<?php

namespace App\Http\Resources;

use App\Models\Stations;
use Illuminate\Http\Resources\Json\ResourceCollection;

class StationCollection extends ResourceCollection
{


    public $collects = Stations::class;
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return parent::toArray($request);
    }
}
