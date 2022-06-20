<?php

namespace App\Http\Controllers;

use App\Models\Station;
use App\Models\WeatherData;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Carbon;
use LSS\Array2XML;
use PHPUnit\TextUI\XmlConfiguration\CodeCoverage\Report\Xml;
use SimpleXMLElement;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

/**
 * @group Weather Data
 *
 * API's for everything related to weather data and stations.
 */
class WeatherStationsController extends Controller
{

    public function index()
    {
        return WeatherData::all();
    }

    /**
     * Send weather data to backend
     *
     * @bodyParam WEATHERDATA array required Two dimensional array containing all values. Example: [ "100020", "1970-01-01 00:00", 10, 10, 10, 10, 10, 10, 10, 10, [ 0, 0, 0, 0, 0, 0 ] ]
     *
     */
    public function receive(Request $request)
    {
        if ($request->post('WEATHERDATA') == null) {
            return "Error";
        }

        foreach ($request->post('WEATHERDATA') as $row) {
            $station = Station::where("name", $row['STN'])->first();

            if (!Station::isInRange($station->latitude, $station->longitude)) {
                continue;
            }

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

    /**
     * Get all weather data
     *
     */
    public function get()
    {
        return WeatherData::all();
    }

    /**
     * Get weather data using the station name.
     *
     * @urlParam station_name string required Valid station name. Example: 100020
     *
     * @response 200 {
     *   "station": "String",
     *   "measurements": "Collection"
     * }
     * @response 404 "error": {
     *  "code": 404,
     *  "message": "No station with that name"
     * }
     */
    public function showStation($station_name)
    {
        $station = Station::all()->where('name', '=', $station_name)->first();
        if ($station) {
            return ['station' => $station, 'measurements' => $station->weatherData];
        } else {
            throw new NotFoundHttpException('No station with that name');
        }
    }

    /**
     * Get a list of available stations.
     *
     * @bodyParam page int Page number. Example: 1
     * @bodyParam ordered_row string On which row the data is sorted. Example: temp
     * @bodyParam order_by string The order in which the data is sorted. Example: asc
     *
     * @response 200 {
     *   "data": "Array",
     *   "isActive": "Boolean"
     * }
     */
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

    /**
     * Get peak temperatures of the last four weeks.
     *
     * @response 200 {
     *   "Collection"
     * }
     */
    public function getPeakTemperatures(): array
    {
        return WeatherData::getPeakTemperatures();
    }

    public function getPeakWindSpeeds(): array
    {
        return WeatherData::getPeakWindSpeeds();
    }

    public function getXmlExport()
    {
        $data = WeatherData::with("station")->with("geoLocation")->with("correction")->where("datetime", ">=", Carbon::now()->addWeek(-4))->get();

        $xml = new SimpleXMLElement("<?xml version=\"1.0\" encoding=\"UTF-8\"?><weather></weather>");

        $this->arrayToXML($data->toArray(),$xml);
        return response()->streamDownload(function () use ($xml) {
            echo $xml->asXML();
        }, "export.xml");
    }

    private function arrayToXML($array, &$xml_user_info) {
        foreach($array as $key => $value) {
            if(is_array($value)) {
                if(!is_numeric($key)){
                    $subnode = $xml_user_info->addChild("Item$key");
                    $this->arrayToXML($value, $subnode);
                }else{
                    $subnode = $xml_user_info->addChild("Item$key");
                    $this->arrayToXML($value, $subnode);
                }
            }else {
                $xml_user_info->addChild("$key","$value");
            }
        }
    }
}
