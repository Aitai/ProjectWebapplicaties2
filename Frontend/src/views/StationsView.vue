<template>
    <div
        class="bg-white dark:bg-neutral-800 shadow overflow-hidden sm:rounded-lg"
    >
        <div class="px-4 py-5 sm:px-6">
            <h3
                class="text-lg leading-6 font-medium text-gray-900 dark:text-white"
            >
                Weather stations
            </h3>
            <!-- <p class="mt-1 max-w-2xl text-sm text-gray-500"></p> -->

            <div class="mt-5 md:mt-0 md:col-span-2">
                <form action="#" method="POST">
                    <div class="shadow overflow-hidden sm:rounded-md">
                        <div
                            class="px-4 py-5 bg-sky-100 dark:bg-slate-800 space-y-6 sm:p-6"
                        >
                            <fieldset>
                                <legend
                                    class="text-base font-medium text-gray-900 dark:text-white"
                                >
                                    Filters
                                </legend>
                                <div
                                    class="grid md:grid-cols-4 xl:grid-cols-6 sm:grid-cols-2"
                                >
                                    <div
                                        v-for="(field, key) in fields"
                                        :key="key"
                                        class="flex items-start"
                                    >
                                        <div class="flex items-center h-5">
                                            <input
                                                :id="key"
                                                :name="key"
                                                type="checkbox"
                                                v-model="field[1]"
                                                :checked="field[1]"
                                                class="focus:ring-indigo-500 h-4 w-4 text-indigo-600 border-gray-300 rounded hover:cursor-pointer"
                                            />
                                        </div>
                                        <div class="ml-3 text-sm">
                                            <label
                                                :for="key"
                                                class="font-medium text-gray-700 dark:text-neutral-100 hover:cursor-pointer selection:bg-transparent"
                                                >{{ field[0] }}</label
                                            >
                                        </div>
                                    </div>
                                </div>
                            </fieldset>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <div class="border-t border-gray-200 dark:border-gray-700 relative">
            <div
                v-show="status.inProgress"
                class="w-full h-full absolute flex align-middle items-center text-center opacity-30 bg-slate-100"
            >
                <p class="w-full text-center text-black text-lg">Loading...</p>
            </div>
            <div class="overflow-auto">
                <table class="table-auto w-full mt-5">
                    <thead>
                        <th
                            v-for="(field, key) in fields"
                            :key="key"
                            v-show="field[1]"
                            class="border-b dark:border-slate-600 font-medium p-4 pl-8 pt-0 pb-3 text-slate-400 dark:text-slate-200 text-left selection:bg-transparent hover:cursor-pointer"
                            @click="filterBy(key)"
                        >
                            <span class="flex">
                                <ArrowDownIcon
                                    v-if="
                                        order.field == key && order.by == 'asc'
                                    "
                                    class="h-5 w-3"
                                />
                                <ArrowUpIcon
                                    v-if="
                                        order.field == key && order.by == 'desc'
                                    "
                                    class="h-5 w-3"
                                />
                                {{ field[0] }}
                            </span>
                        </th>
                    </thead>

                    <tbody>
                        <tr
                            v-for="station in stations"
                            :key="station.name"
                            @click="
                                $router.push({
                                    name: 'station.view',
                                    params: { stationName: station.name },
                                })
                            "
                            class="odd:bg-white even:bg-slate-50 dark:odd:bg-neutral-800 dark:even:bg-gray-800 hover:cursor-pointer hover:bg-blue-100 ease-linear duration-75"
                        >
                            <td
                                v-for="(field, key) in fields"
                                :key="key"
                                v-show="field[1]"
                                class="border-b border-slate-100 dark:border-slate-700 p-4 pl-8 text-slate-500 dark:text-slate-400"
                            >
                                <span v-if="key == 'is_active'">
                                    {{ station[key] ? "Ja" : "Nee" }}
                                </span>
                                <span v-else>
                                    {{ station[key] }}
                                </span>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <div class="my-3 flex text-center justify-center">
                <button
                    @click="changePage(pagination.current_page - 1)"
                    class="rounded-none bg-sky-100 dark:bg-slate-800 p-3 border border-slate-200 dark:border-slate-700 hover:bg-blue-100 dark:hover:bg-slate-700 dark:text-gray-200"
                >
                    <ChevronLeftIcon class="h-5 w-5" aria-hidden="true" />
                    <!-- Previous -->
                </button>
                <button
                    v-if="pagination.current_page != 1"
                    @click="changePage(1)"
                    class="rounded-none bg-sky-100 dark:bg-slate-800 p-3 border border-slate-200 dark:border-slate-700 hover:bg-blue-100 dark:hover:bg-slate-700 dark:text-gray-200"
                >
                    1
                </button>
                <div
                    v-if="pagination.current_page != 1"
                    class="rounded-none bg-sky-100 dark:bg-slate-800 p-3 border border-slate-200 dark:border-slate-700 dark:text-gray-200"
                >
                    ...
                </div>
                <div
                    class="font-bold rounded-none bg-yellow-200 dark:bg-slate-800 p-3 border border-slate-200 dark:border-slate-700 dark:text-gray-50"
                >
                    {{ pagination.current_page }}
                </div>
                <div
                    v-if="pagination.current_page != pagination.total_pages"
                    class="rounded-none bg-sky-100 dark:bg-slate-800 p-3 border border-slate-200 dark:border-slate-700 dark:text-gray-200"
                >
                    ...
                </div>
                <button
                    v-if="pagination.current_page != pagination.total_pages"
                    @click="changePage(pagination.total_pages)"
                    class="rounded-none bg-sky-100 dark:bg-slate-800 p-3 border border-slate-200 dark:border-slate-700 hover:bg-blue-100 dark:hover:bg-slate-700 dark:text-gray-200"
                >
                    {{ pagination.total_pages }}
                </button>
                <button
                    @click="changePage(pagination.current_page + 1)"
                    class="rounded-none bg-sky-100 dark:bg-slate-800 p-3 border border-slate-200 dark:border-slate-700 hover:bg-blue-100 dark:hover:bg-slate-700 dark:text-gray-200"
                >
                    <ChevronRightIcon class="h-5 w-5" aria-hidden="true" />
                    <!-- Next -->
                </button>
            </div>
        </div>
    </div>
</template>

<script>
import {
    ChevronLeftIcon,
    ChevronRightIcon,
    ArrowDownIcon,
    ArrowUpIcon,
} from "@heroicons/vue/solid";
import { RouterLink } from "vue-router";

export default {
    name: "station-all",
    components: {
        RouterLink,
        ChevronLeftIcon,
        ChevronRightIcon,
        ArrowDownIcon,
        ArrowUpIcon,
    },
    mounted() {
        this.getStations();
    },
    computed: {
        stations() {
            return this.$store.state.station.all;
        },
        status() {
            return this.$store.state.station.status;
        },
        pagination() {
            return this.$store.state.station.pagination;
        },
    },
    data() {
        return {
            fields: {
                name: ["Station", true],
                longitude: ["Longitude", false],
                latitude: ["Latitude", false],
                elevation: ["Elevation", false],
                is_active: ["Active", false],
                temp: ["Temperature", true],
                dew_point_temp: ["Dew point temperature", false],
                station_air_pressure: ["Station air pressure", true],
                sea_level_air_pressure: ["Sea level air pressure", true],
                visibility: ["Visibility", true],
                wind_speed: ["Wind speed", true],
                precipitation: ["Precipitation", true],
                snow_depth: ["Snow depth", false],
                cloud_cover_percentage: ["Cloud coverage(%)", true],
                wind_direction: ["Wind direction", true],
                frost: ["Frost", false],
                rain: ["Rain", false],
                snow: ["Snow", false],
                hail: ["Hail", false],
                thunderstorm: ["Thunderstorm", false],
                tornado: ["Tornado", false],
            },
            order: {
                by: "asc",
                field: "name",
            },
        };
    },
    methods: {
        getStations() {
            this.$store.dispatch("station/getAll", [1, "name", "asc"]);
            document.title = "Overview weather stations " + " - Society of Protection of Birds";
        },
        changePage(pageNum) {
            if (pageNum >= 1 && pageNum <= this.pagination.total_pages) {
                this.$store.dispatch("station/getAll", [
                    pageNum,
                    this.order.field,
                    this.order.by,
                ]);
            }
        },
        filterBy(key) {
            if (this.order.field == key) {
                this.order.by = this.order.by == "asc" ? "desc" : "asc";
            } else {
                this.order.field = key;
                this.order.by = "asc";
            }
            this.$store.dispatch("station/getAll", [
                this.pagination.current_page,
                this.order.field,
                this.order.by,
            ]);
        },
    },
};
</script>
