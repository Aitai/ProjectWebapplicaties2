<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class MeasurementResource extends JsonResource
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
            'station_id' => $this['STN'],
            'temperature' => $this['TEMP'],
            'dew_point_temp' => $this['DEWP'],
            'air_pressure' => $this['STP'],
            'sea_level_air_pressure' => $this['SLP'],
            'visibility' => $this['VISIB'],
            'wind_speed' => $this['WDSP'],
            'precipitation' => $this['PRCP'],
            'snow_depth' => $this['SNDP'],
            'cloud_cover_percentage' => $this['FRSHTT'],
            'wind_direction' => $this['CLDC'],
            'frost' => $this['WNDDIR'],
            'rain' => $this['TEMP'],
            'snow' => $this['TEMP'],
            'hail' => $this['TEMP'],
            'thunderstorm' => $this['TEMP'],
            'tornado' => $this['TEMP'],
        ];
    }
}
