<template>
    <div
        class="bg-white dark:bg-neutral-800 shadow overflow-hidden sm:rounded-lg"
    >
        <div class="px-4 py-5 sm:px-6">
            <h3
                class="text-lg leading-6 font-medium text-gray-900 dark:text-white"
            >
                Weerstation {{ station.name }}
            </h3>
            <p class="mt-1 max-w-2xl text-sm text-gray-500 dark:text-gray-300">
                Longitude: {{ station.longitude }}, Latitude:
                {{ station.latitude }}, Elevation: {{ station.elevation }}
            </p>
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
                        class="odd:bg-white even:bg-slate-50 dark:odd:bg-neutral-800 dark:even:bg-gray-800 hover:bg-slate-100 ease-linear duration-75"
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
const fields = {
    datetime: "Datum",
    temp: "Temperatuur",
    dew_point_temp: "Dauwpunt temperatuur",
    station_air_pressure: "Station Luchtdruk",
    sea_level_air_pressure: "Zeeniveau Luchtdruk",
    visibility: "Zicht",
    wind_speed: "Windsnelheid",
    precipitation: "Neerslag",
    snow_depth: "Sneeuwdiepte",
    cloud_cover_percentage: "Bewolking",
    wind_direction: "Windrichting",
    special_occurances: "Speciale omstandigheden",
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
            document.title = "Weerstation " + stationName + " - Society of Protection of Birds";
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
