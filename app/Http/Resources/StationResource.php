<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class StationResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'name' => $this['STN'],
            'datetime' => date('Y-m-d H:i:s', strtotime("{$this['DATE']} {$this['TIME']}")),
            'measurement' => MeasurementResource::make($this)
        ];
    }
}
