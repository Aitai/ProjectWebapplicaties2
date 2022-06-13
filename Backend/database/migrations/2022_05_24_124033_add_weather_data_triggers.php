<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

// Corrects the incoming data and logs corrected fields into 'corrected_weather_data' table.

return new class extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $db_name = config('database.connections.mysql.database');
        $sql = "
        use " . $db_name . ";
        CREATE TRIGGER correct_measurement BEFORE INSERT ON " . $db_name . ".weather_data
             FOR EACH ROW
             BEGIN
                SELECT ROUND(SUM(lastValues.temp) / COUNT(*), 1) INTO @result FROM (SELECT * FROM weather_data WHERE station_name = NEW.station_name ORDER BY id DESC LIMIT 30) AS lastValues;
		IF @result IS NULL THEN
		    SET @result = 0;
		END IF;
		IF NEW.temp IS NULL THEN
		    SELECT MAX(id) INTO @last_id FROM weather_data;
		    IF @last_id IS NULL THEN
		    	SET @last_id = 1;
		    END IF;
                    INSERT INTO corrected_weather_data (weather_data_id, type)
                	VALUES (@last_id + 1, 'temp');
                    SET NEW.temp = @result;
                ELSEIF NEW.temp > @result * 1.2 OR NEW.temp < @result * .8 THEN
		    SELECT MAX(id) INTO @last_id FROM weather_data;
		    IF @last_id IS NULL THEN
		    	SET @last_id = 1;
		    END IF;
                    INSERT INTO corrected_weather_data (weather_data_id, type, original_value)
                        VALUES (@last_id + 1, 'temp', NEW.temp);
                    SET NEW.temp = @result * ROUND(RAND(), 1) * .4 + .8;
                END IF;

                SELECT ROUND(SUM(lastValues.dew_point_temp) / COUNT(*), 1) INTO @result FROM (SELECT * FROM weather_data WHERE station_name = NEW.station_name ORDER BY id DESC LIMIT 30) AS lastValues;
		IF @result IS NULL THEN
		    SET @result = 0;
		END IF;
                IF NEW.dew_point_temp IS NULL THEN
		    SELECT MAX(id) INTO @last_id FROM weather_data;
		    IF @last_id IS NULL THEN
		    	SET @last_id = 1;
		    END IF;
                    INSERT INTO corrected_weather_data (weather_data_id, type)
                        VALUES (@last_id + 1, 'dew_point_temp');
                    SET NEW.dew_point_temp = @result;
                ELSEIF NEW.dew_point_temp > @result * 1.2 OR NEW.dew_point_temp < @result * .8 THEN
		    SELECT MAX(id) INTO @last_id FROM weather_data;
		    IF @last_id IS NULL THEN
		    	SET @last_id = 1;
		    END IF;
                    INSERT INTO corrected_weather_data (weather_data_id, type, original_value)
                        VALUES (@last_id + 1, 'dew_point_temp', NEW.dew_point_temp);
                    SET NEW.dew_point_temp = @result * ROUND(RAND(), 1) * .4 + .8;
                END IF;

                IF NEW.station_air_pressure IS NULL THEN
		    SELECT MAX(id) INTO @last_id FROM weather_data;
		    IF @last_id IS NULL THEN
		    	SET @last_id = 1;
		    END IF;
                    INSERT INTO corrected_weather_data (weather_data_id, type)
                        VALUES (@last_id + 1, 'station_air_pressure');
                    SELECT ROUND(SUM(lastValues.station_air_pressure) / COUNT(*), 1) INTO @result FROM (SELECT * FROM weather_data WHERE station_name = NEW.station_name ORDER BY id DESC LIMIT 30) AS lastValues;
		    IF @result IS NULL THEN
		    	SET @result = 0;
		    END IF;
                    SET NEW.station_air_pressure = @result;
                END IF;

                IF NEW.sea_level_air_pressure IS NULL THEN
		    SELECT MAX(id) INTO @last_id FROM weather_data;
		    IF @last_id IS NULL THEN
		    	SET @last_id = 1;
		    END IF;
                    INSERT INTO corrected_weather_data (weather_data_id, type)
                        VALUES (@last_id + 1, 'sea_level_air_pressure');
                    SELECT ROUND(SUM(lastValues.sea_level_air_pressure) / COUNT(*), 1) INTO @result FROM (SELECT * FROM weather_data WHERE station_name = NEW.station_name ORDER BY id DESC LIMIT 30) AS lastValues;
		    IF @result IS NULL THEN
		    	SET @result = 0;
		    END IF;
                    SET NEW.sea_level_air_pressure = @result;
                END IF;

                IF NEW.visibility IS NULL THEN
		    SELECT MAX(id) INTO @last_id FROM weather_data;
		    IF @last_id IS NULL THEN
		    	SET @last_id = 1;
		    END IF;
                    INSERT INTO corrected_weather_data (weather_data_id, type)
                        VALUES (@last_id + 1, 'visibility');
                    SELECT ROUND(SUM(lastValues.visibility) / COUNT(*), 1) INTO @result FROM (SELECT * FROM weather_data WHERE station_name = NEW.station_name ORDER BY id DESC LIMIT 30) AS lastValues;
		    IF @result IS NULL THEN
		    	SET @result = 0;
		    END IF;
                    SET NEW.visibility = @result;
                END IF;

                IF NEW.wind_speed IS NULL THEN
		    SELECT MAX(id) INTO @last_id FROM weather_data;
		    IF @last_id IS NULL THEN
		    	SET @last_id = 1;
		    END IF;
                    INSERT INTO corrected_weather_data (weather_data_id, type)
                        VALUES (@last_id + 1, 'wind_speed');
                    SELECT ROUND(SUM(lastValues.wind_speed) / COUNT(*), 1) INTO @result FROM (SELECT * FROM weather_data WHERE station_name = NEW.station_name ORDER BY id DESC LIMIT 30) AS lastValues;
		    IF @result IS NULL THEN
		    	SET @result = 0;
		    END IF;
                    SET NEW.wind_speed = @result;
                END IF;

                IF NEW.precipitation IS NULL THEN
	            SELECT MAX(id) INTO @last_id FROM weather_data;
		    IF @last_id IS NULL THEN
		    	SET @last_id = 1;
		    END IF;
                    INSERT INTO corrected_weather_data (weather_data_id, type)
                        VALUES (@last_id + 1, 'precipitation');
                    SELECT ROUND(SUM(lastValues.precipitation) / COUNT(*), 1) INTO @result FROM (SELECT * FROM weather_data WHERE station_name = NEW.station_name ORDER BY id DESC LIMIT 30) AS lastValues;
		    IF @result IS NULL THEN
		    	SET @result = 0;
		    END IF;
                    SET NEW.precipitation = @result;
                END IF;

                IF NEW.snow_depth IS NULL THEN
		    SELECT MAX(id) INTO @last_id FROM weather_data;
		    IF @last_id IS NULL THEN
		    	SET @last_id = 1;
		    END IF;
                    INSERT INTO corrected_weather_data (weather_data_id, type)
                        VALUES (@last_id + 1, 'snow_depth');
                    SELECT ROUND(SUM(lastValues.snow_depth) / COUNT(*), 1) INTO @result FROM (SELECT * FROM weather_data WHERE station_name = NEW.station_name ORDER BY id DESC LIMIT 30) AS lastValues;
		    IF @result IS NULL THEN
		    	SET @result = 0;
		    END IF;
                    SET NEW.snow_depth = @result;
                END IF;

                IF NEW.cloud_cover_percentage IS NULL THEN
		    SELECT MAX(id) INTO @last_id FROM weather_data;
		    IF @last_id IS NULL THEN
		    	SET @last_id = 1;
		    END IF;
                    INSERT INTO corrected_weather_data (weather_data_id, type)
                        VALUES (@last_id + 1, 'cloud_cover_percentage');
                    SELECT ROUND(SUM(lastValues.cloud_cover_percentage) / COUNT(*), 1) INTO @result FROM (SELECT * FROM weather_data WHERE station_name = NEW.station_name ORDER BY id DESC LIMIT 30) AS lastValues;
		    IF @result IS NULL THEN
		    	SET @result = 0;
		    END IF;
                    SET NEW.cloud_cover_percentage = @result;
                END IF;

                IF NEW.wind_direction IS NULL THEN
		    SELECT MAX(id) INTO @last_id FROM weather_data;
		    IF @last_id IS NULL THEN
		    	SET @last_id = 1;
		    END IF;
                    INSERT INTO corrected_weather_data (weather_data_id, type)
                        VALUES (@last_id + 1, 'wind_direction');
                    SELECT ROUND(SUM(lastValues.wind_direction) / COUNT(*), 1) INTO @result FROM (SELECT * FROM weather_data WHERE station_name = NEW.station_name ORDER BY id DESC LIMIT 30) AS lastValues;
		    IF @result IS NULL THEN
		    	SET @result = 0;
		    END IF;
                    SET NEW.wind_direction = @result;
                END IF;

                IF NEW.frost IS NULL THEN
		    SELECT MAX(id) INTO @last_id FROM weather_data;
		    IF @last_id IS NULL THEN
		    	SET @last_id = 1;
		    END IF;
                    INSERT INTO corrected_weather_data (weather_data_id, type)
                        VALUES (@last_id + 1, 'frost');
                    SELECT (SUM(lastValues.frost) > (COUNT(lastValues.frost) / 2)) INTO @result FROM (SELECT * FROM weather_data WHERE station_name = NEW.station_name ORDER BY id DESC LIMIT 30) AS lastValues;
		    IF @result IS NULL THEN
		    	SET @result = 0;
		    END IF;
                    SET NEW.frost = @result;
                END IF;

                IF NEW.rain IS NULL THEN
		    SELECT MAX(id) INTO @last_id FROM weather_data;
		    IF @last_id IS NULL THEN
		    	SET @last_id = 1;
		    END IF;
                    INSERT INTO corrected_weather_data (weather_data_id, type)
                        VALUES (@last_id + 1, 'rain');
                    SELECT (SUM(lastValues.rain) > (COUNT(lastValues.rain) / 2)) INTO @result FROM (SELECT * FROM weather_data WHERE station_name = NEW.station_name ORDER BY id DESC LIMIT 30) AS lastValues;
		    IF @result IS NULL THEN
		    	SET @result = 0;
		    END IF;
                    SET NEW.rain = @result;
                END IF;

                IF NEW.snow IS NULL THEN
		    SELECT MAX(id) INTO @last_id FROM weather_data;
		    IF @last_id IS NULL THEN
		    	SET @last_id = 1;
		    END IF;
                    INSERT INTO corrected_weather_data (weather_data_id, type)
                        VALUES (@last_id + 1, 'snow');
                    SELECT (SUM(lastValues.snow) > (COUNT(lastValues.snow) / 2)) INTO @result FROM (SELECT * FROM weather_data WHERE station_name = NEW.station_name ORDER BY id DESC LIMIT 30) AS lastValues;
		    IF @result IS NULL THEN
		    	SET @result = 0;
		    END IF;
                    SET NEW.snow = @result;
                END IF;

                IF NEW.hail IS NULL THEN
		    SELECT MAX(id) INTO @last_id FROM weather_data;
		    IF @last_id IS NULL THEN
		    	SET @last_id = 1;
		    END IF;
                    INSERT INTO corrected_weather_data (weather_data_id, type)
                        VALUES (@last_id + 1, 'hail');
                    SELECT (SUM(lastValues.hail) > (COUNT(lastValues.hail) / 2)) INTO @result FROM (SELECT * FROM weather_data WHERE station_name = NEW.station_name ORDER BY id DESC LIMIT 30) AS lastValues;
		    IF @result IS NULL THEN
		    	SET @result = 0;
		    END IF;
                    SET NEW.hail = @result;
                END IF;

                IF NEW.thunderstorm IS NULL THEN
		    SELECT MAX(id) INTO @last_id FROM weather_data;
		    IF @last_id IS NULL THEN
		    	SET @last_id = 1;
		    END IF;
                    INSERT INTO corrected_weather_data (weather_data_id, type)
                        VALUES (@last_id + 1, 'thunderstorm');
                    SELECT (SUM(lastValues.thunderstorm) > (COUNT(lastValues.thunderstorm) / 2)) INTO @result FROM (SELECT * FROM weather_data WHERE station_name = NEW.station_name ORDER BY id DESC LIMIT 30) AS lastValues;
		    IF @result IS NULL THEN
		    	SET @result = 0;
		    END IF;
                    SET NEW.thunderstorm = @result;
                END IF;

                IF NEW.tornado IS NULL THEN
		    SELECT MAX(id) INTO @last_id FROM weather_data;
		    IF @last_id IS NULL THEN
		    	SET @last_id = 1;
		    END IF;
                    INSERT INTO corrected_weather_data (weather_data_id, type)
                        VALUES (@last_id + 1, 'tornado');
                    SELECT (SUM(lastValues.tornado) > (COUNT(lastValues.tornado) / 2)) INTO @result FROM (SELECT * FROM weather_data WHERE station_name = NEW.station_name ORDER BY id DESC LIMIT 30) AS lastValues;
		    IF @result IS NULL THEN
		    	SET @result = 0;
		    END IF;
                    SET NEW.tornado = @result;
                END IF;
            END;
        ";

        DB::connection()->getPdo()->exec($sql);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        $db_name = config('database.connections.mysql.database');
        DB::statement("DROP TRIGGER IF EXISTS " . $db_name . ".correct_measurement;");
    }
};
