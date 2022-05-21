<?php

namespace App\Http\Controllers;

use App\Models\Station;
use App\Models\WeatherData;
use Illuminate\Http\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class WeatherStationsController extends Controller
{
//    public function create(Request $request)
//    {
//
//        Measurement::insert($request->json('WEATHERDATA')));
//        return Measurement::create();
//    }

    public function index()
    {
        return WeatherData::all();
    }

    public function receive(Request $request)
    {


        if ($request->post('WEATHERDATA') == null) {
            return "Error";
        }

        foreach ($request->post('WEATHERDATA') as $row) {
            $data = new WeatherData;

            $data->station_name = $row['STN'];
            $data->datetime = $row['DATE'] . ' ' . $row['TIME'];
            $data->temp = $row['TEMP'] == "None" ? null : $row['TEMP'];
            $data->dew_point_temp = $row['DEWP'] == "None" ? null : $row['DEWP'];
            $data->station_air_pressure = $row['STP'] == "None" ? null : $row['STP'];
            $data->sea_level_air_pressure = $row['SLP'] == "None" ? null : $row['SLP'];
            $data->visibility = $row['VISIB'] == "None" ? null : $row['VISIB'];
            $data->wind_speed = $row['WDSP'] == "None" ? null : $row['WDSP'];
            $data->precipitation = $row['PRCP'] == "None" ? null : $row['PRCP'];
            $data->snow_depth = $row['SNDP'] == "None" ? null : $row['SNDP'];

            if ($row['FRSHTT'] !== "") {
                $frshtt = str_split($row['FRSHTT']);
                $data->frost = $frshtt[0];
                $data->rain = $frshtt[1];
                $data->snow = $frshtt[2];
                $data->hail = $frshtt[3];
                $data->thunderstorm = $frshtt[4];
                $data->tornado = $frshtt[5];
            }

            $data->cloud_cover_percentage = $row['CLDC'] == "None" ? null : $row['CLDC'];
            $data->wind_direction = $row['WNDDIR'] == "None" ? null : $row['WNDDIR'];

            $data->save();
        }
        return "Success";
    }

    public function get()
    {
        return WeatherData::all();
    }

    public function showStation($station_name)
    {
        $station = Station::all()->where('name', '=', $station_name)->first();
        if ($station) {
            return ['station' => $station, 'measurements' => $station->weatherData];
        } else {
            throw new NotFoundHttpException('No station with that name');
        }
    }

    public function getStations(Request $request)
    {
        $orderedRow = $request->ordered_row ?: 'name';
        $order = $request->order_by === 'desc' ? 'desc' : 'asc';

        if ($orderedRow !== 'name') {
            $stations = Station::join('weather_data', 'station.name', '=', 'weather_data.station_name')
                ->groupBy('station_name')
                ->orderByRaw("AVG(${orderedRow}) ${order}")
                ->paginate(10);
        } else {
            $stations = Station::paginate(10);
        }

        $new_stations = ['data' => []];
        foreach ($stations as $station) {
            $new_station = $station->toArray();
            $new_station['is_active'] = $station->isActive();
            foreach ($station->averageMeasurements() as $measurement) {
                $new_station[key($measurement)] = $measurement[key($measurement)];
            }
            $new_stations['data'][] = $new_station;

        }

        return $new_stations + $stations->toArray();
    }
}
