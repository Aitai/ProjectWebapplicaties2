<template>
  <div
    class="bg-white dark:bg-neutral-800 shadow overflow-hidden sm:rounded-lg"
  >
    <div class="px-4 py-5 sm:px-6 flex flex-wrap">
      <div class="flex-grow mb-2">
        <h3 class="text-lg leading-6 font-medium text-gray-900 dark:text-white">
          Weather station {{ station.name }}
        </h3>
        <p class="mt-1 max-w-2xl text-sm text-gray-500 dark:text-gray-300">
          Longitude: {{ station.longitude }}, Latitude: {{ station.latitude }},
          Elevation: {{ station.elevation }}
        </p>

        <div v-if="station.geo_location">
          <ul class="dark:text-white">
            <li v-for="(geo_location, key) in station.geo_location" v-bind:key="key">
              <span v-if="geo_location.length && key !== 'station_name'">
                {{ capitalizeFirstLetter(key.replace("_", " ")) }} -
                {{ geo_location }}
              </span>
            </li>
          </ul>
        </div>

        <p class="my-3">
          <RouterLink
            :to="{ name: 'station.all' }"
            class="bg-yellow-300 py-2 px-3 rounded-md"
          >
            Back to overview
          </RouterLink>
        </p>
      </div>
      <div class="flex-grow" v-if="station.nearest_location">
        <h3 class="text-lg leading-6 font-medium text-gray-900 dark:text-white">
          Location: {{ station.nearest_location.name }}
        </h3>
        <ul class="dark:text-white">
          <li v-for="(location_data, key) in station.nearest_location" v-bind:key="key">
            <span v-if="location_data.length && key !== 'station_name'">
              {{ capitalizeFirstLetter(key.replace("_", " ")) }} -
              {{ location_data }}
            </span>
          </li>
        </ul>

        <station-map
          :locations="[station]"
          class="h-96"
          :zoom="6"
        ></station-map>
      </div>
    </div>
    <div
      class="border-t border-gray-200 dark:border-gray-700 overflow-x-scroll"
    >
      <table class="table-auto w-full">
        <thead>
          <th
            v-for="(field, key) in fields"
            :key="key"
            class="border-b border-r dark:border-slate-600 font-medium p-4 pb-3 text-slate-400 dark:text-slate-200 text-left"
          >
            {{ field }}
          </th>
        </thead>

        <tbody>
          <tr
            v-for="measurement in station.measurements"
            :key="measurement.id"
            class="odd:bg-white even:bg-slate-50 dark:odd:bg-neutral-800 dark:even:bg-gray-800 hover:bg-blue-100 ease-linear duration-75"
          >
            <td
              v-for="(_, field_key) in fields"
              :key="field_key"
              class="border-b border-r border-slate-100 dark:border-slate-700 p-4 text-slate-500 dark:text-slate-400"
            >
              <span v-if="_ != 'Speciale omstandigheden'">{{
                measurement[field_key]
              }}</span>
              <p
                v-else
                v-for="(occurance, key) in special_occurances"
                :key="key"
              >
                {{ measurement[key] ? occurance : "" }}
              </p>
            </td>
          </tr>
        </tbody>
      </table>
    </div>
  </div>
</template>

<script>
import { RouterLink } from "vue-router";
import StationMap from "@/components/StationMap.vue";

const fields = {
  datetime: "Date",
  temp: "Temperature",
  dew_point_temp: "Dew point temperature",
  station_air_pressure: "Station air pressure",
  sea_level_air_pressure: "Sealevel air pressure",
  visibility: "Visibility",
  wind_speed: "Wind speed",
  precipitation: "Precipitation",
  snow_depth: "Snow depth",
  cloud_cover_percentage: "Cloud coverage",
  wind_direction: "Wind direction",
  special_occurances: "Special circumstances",
};

const special_occurances = {
  frost: "Vorst",
  rain: "Regen",
  snow: "Sneeuw",
  hail: "Hagel",
  thunderstorm: "Onweer",
  tornado: "Tornado",
};

export default {
  name: "station-view",
  components: {
    StationMap,
    RouterLink,
  },
  mounted() {
    this.getStation(this.$route.params.stationName);
  },
  computed: {
    station() {
      return this.$store.state.station.station;
    },
    measurements() {
      return this.$store.state.station.measurements;
    },
  },
  methods: {
    getStation(stationName) {
      this.$store.dispatch("station/getData", stationName);
      document.title =
        "Weather station " +
        stationName +
        " - Society for the Protection of Birds";
    },
    capitalizeFirstLetter(string) {
      return string.charAt(0).toUpperCase() + string.slice(1);
    },
  },
  setup() {
    return {
      fields,
      special_occurances,
    };
  },
};
</script>
