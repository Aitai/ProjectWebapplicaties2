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
     * @response 200 [
     *  {
     *      "id": Int,
     *      "station_name": "Int",
     *      "datetime": "Timestamp"
     *      "temp": "Float",
     *      "dew_point_temp": "Float",
     *      "station_air_pressure": "Float",
     *      "sea_level_air_pressure": "Float",
     *      "visibility": "Float",
     *      "wind_speed": "Float",
     *      "precipitation": "Float",
     *      "snow_depth": "Float",
     *      "cloud_cover_percentage": "Float",
     *      "wind_direction": Int,
     *      "frost": Int,
     *      "rain": Int,
     *      "snow": Int,
     *      "hail": Int,
     *      "thunderstorm": Int,
     *      "tornado": Int
     *  }
     * ]
     */
    public function get()
    {
        return WeatherData::all();
    }

    /**
     * Get weather data using the station name.
     *
     * @urlParam station_name string required Valid station name. Example: 170220
     *
     * @response 200 {
     *  "station":
     *      {
     *          "name": "Int",
     *          "longitude": Float,
     *          "latitude": Float,
     *          "elevation": Int
     *      },
     *      "measurements":
     *      [
     *          {
     *              "id": Int,
     *              "station_name": "Int",
     *              "datetime": "Timestamp",
     *              "temp": "Float",
     *              "dew_point_temp": "Float",
     *              "station_air_pressure": "Float",
     *              "sea_level_air_pressure": "Float",
     *              "visibility": "Float",
     *              "wind_speed": "Float",
     *              "precipitation": "Float",
     *              "snow_depth": "Float",
     *              "cloud_cover_percentage": "Float",
     *              "wind_direction": Int,
     *              "frost": Int,
     *              "rain": Int,
     *              "snow": Int,
     *              "hail": Int,
     *              "thunderstorm": Int,
     *              "tornado": Int
     *          }
     *      ],
     *      "nearest_location":
     *          {
     *              "id": Int,
     *              "station_name": "Int",
     *              "name": "String",
     *              "administrative_region1": "String",
     *              "administrative_region2": "String",
     *              "country_code": "String",
     *              "longitude": Float,
     *              "latitude": Float
     *          },
     *      "geo_location":
     *      {
     *          "id": Int,
     *          "station_name": "Int",
     *          "country_code": "String",
     *          "island": "String",
     *          "county": "String",
     *          "place": "String",
     *          "hamlet": "String",
     *          "town": "String",
     *          "municipality": "String",
     *          "state_district": "String",
     *          "administrative": "String",
     *          "state": "String",
     *          "village": "String",
     *          "region": "String",
     *          "province": "String",
     *          "city": "String",
     *          "locality": "String",
     *          "postcode": "Int",
     *          "country": "String"
     *      }
     *  }
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
            return [
                'station' => $station,
                'measurements' => $station->weatherData,
                'nearest_location' => $station->nearestLocation,
                'geo_location' => $station->geoLocation
            ];
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
     *  "data" :
     *  [
     *      {
     *          "name": "Int",
     *          "longitude": Float,
     *          "latitude": Float,
     *          "elevation": Int,
     *          "is_active": Boolean,
     *          "temp": Float,
     *          "dew_point_temp": Float,
     *          "station_air_pressure": Float,
     *          "sea_level_air_pressure": Float,
     *          "visibility": Float,
     *          "wind_speed": FLoat,
     *          "precipitation": Float,
     *          "snow_depth": Int,
     *          "cloud_cover_percentage": Int,
     *          "wind_direction": Float,
     *          "frost": Int,
     *          "rain": Int,
     *          "snow": Int,
     *          "hail": Int,
     *          "thunderstorm": Int,
     *          "tornado": Int
     *      }
     *  ],
     *  "current_page": 1,
     *  "first_page_url": "http:\/\/localhost:8000\/stations\/getStations?page=1",
     *  "from": 1,
     *  "last_page": Int,
     *  "last_page_url": "http:\/\/localhost:8000\/stations\/getStations?page=Int",
     *  "links":
     *  [
     *      {
     *          "url": Url,
     *          "label": "pagination.previous",
     *          "active": Boolean
     *      },
     *      {
     *          "url": "http:\/\/localhost:8000\/stations\/getStations?page=1",
     *          "label": "1",
     *          "active": Boolean
     *      },
     *  ],
     *  "next_page_url": "http:\/\/localhost:8000\/stations\/getStations?page=2",
     *  "path": "http:\/\/localhost:8000\/stations\/getStations",
     *  "per_page": 10,
     *  "prev_page_url": null,
     *  "to": 10,
     *  "total": Int
     * }
     */
    public function getStations(Request $request)
    {
        $orderedRow = $request->ordered_row ?: 'name';
        $order = $request->order_by === 'desc' ? 'desc' : 'asc';

        if ($orderedRow !== 'name' && $orderedRow !== 'is_active') {
            $stations = Station::join('weather_data', 'station.name', '=', 'weather_data.station_name')
                ->groupBy('station_name')
                ->orderByRaw("AVG(${orderedRow}) ${order}")
                ->paginate(10);
        } else {
            $stations = Station::orderBy('name', $order)->paginate(10);
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
     * Get lowest temperatures of the last four weeks.
     *
     * @response 200 [
     *  {
     *      "max_temp": "Float",
     *      "date": "Timestamp",
     *      "town": "String"
     *  },
     *  {
     *      "max_temp": "Float",
     *      "date": "Timestamp",
     *      "town": "String"
     *  }
     * ]
     */
    public function getLowestTemperatures(): array
    {
        return WeatherData::getLowestTemperatures();
    }

    /**
     * Get peak wind speeds of the last four weeks.
     *
     * @response 200 [
     *  {
     *      "max_wind_speed": "Float",
     *      "date": "Timestamp",
     *      "town": "String"
     *  },
     *  {
     *      "max_wind_speed": "Float",
     *      "date": "Timestamp",
     *      "town": "String"
     *  }
     * ]
     */
    public function getPeakWindSpeeds(): array
    {
        return WeatherData::getPeakWindSpeeds();
    }

    /**
     * Get an XML export of the last four weeks
     *
     * @response 200
     * <?xml version="1.0" encoding="UTF-8"?>
     * <weather>
     *  <Item0>
     *      <id>Int</id>
     *      <station_name>Int</station_name>
     *      <datetime>Timestamp</datetime>
     *      <temp>Float</temp>
     *      <dew_point_temp>Float</dew_point_temp>
     *      <station_air_pressure>Float</station_air_pressure>
     *      <sea_level_air_pressure>Float</sea_level_air_pressure>
     *      <visibility>Float</visibility>
     *      <wind_speed>Float</wind_speed>
     *      <precipitation>Float</precipitation>
     *      <snow_depth>Float</snow_depth>
     *      <cloud_cover_percentage>Float</cloud_cover_percentage>
     *      <wind_direction>Int</wind_direction>
     *      <frost>Int</frost>
     *      <rain>Int</rain>
     *      <snow>Int</snow>
     *      <hail>Int</hail>
     *      <thunderstorm>Int</thunderstorm>
     *      <tornado>Int</tornado>
     *      <Itemstation>
     *          <name>Int</name>
     *          <longitude>Float</longitude>
     *          <latitude>Float</latitude>
     *          <elevation>Int</elevation>
     *      </Itemstation>
     *      <Itemgeo_location>
     *          <id>Int</id>
     *          <station_name>Int</station_name>
     *          <country_code>String</country_code>
     *          <island>String</island>
     *          <county>String</county>
     *          <place>String</place>
     *          <hamlet>String</hamlet>
     *          <town>String</town>
     *          <municipality>String</municipality>
     *          <state_district>String</state_district>
     *          <administrative>String</administrative>
     *          <state>String</state>
     *          <village>String</village>
     *          <region>String</region>
     *          <province>String</province>
     *          <city>String</city>
     *          <locality>String</locality>
     *          <postcode>String</postcode>
     *          <country>String</country>
     *      </Itemgeo_location>
     *      <Itemcorrection>
     *          <Item0>
     *              <id>Int</id>
     *              <weather_data_id>Int</weather_data_id>
     *              <type>String</type>
     *              <original_value>Float</original_value>
     *          </Item0>
     *      </Itemcorrection>
     *  </Item0>
     *</weather>
     */
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
