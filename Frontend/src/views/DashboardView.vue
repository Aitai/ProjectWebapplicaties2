<!-- create chart with vue-chartjs -->

<template>
  <div id="app" class="bg-white dark:bg-neutral-800 shadow overflow-hidden sm:rounded-lg">
    <div class="container-fluid px-4 py-5 sm:px-6">
      <h3 class="text-lg leading-6 font-medium text-gray-900 dark:text-white">
        Dashboard
      </h3>

      <h4 class="card-title text-gray-900 dark:text-white">Wind speed vs temperature</h4>

      <div class="card-body dark:bg-gray-700">
        <canvas id="myChart" width="600" height="400"></canvas>
      </div>
    </div>
    <div class="px-4 py-5 sm:px-6 pt-4 text-gray-900 dark:text-white">
      Graphs
      <button v-on:click="doExport"
        class="px-4 py-2 font-semibold text-sm dark:text-white bg-blue-300 dark:bg-gray-600 text-black rounded-full shadow-sm">Export</button>
    </div>
  </div>
</template>

<script>
export default {
  data() {
    return {
      chartData: {
        datasets: [
          {
            label: 'Temperature (°C)',
            backgroundColor: 'rgba(255, 99, 132, 0.2)',
            borderColor: 'rgba(255, 99, 132, 1)',
            borderWidth: 1,
          },
          {
            label: 'Wind speed (km/h)',
            backgroundColor: 'rgba(54, 162, 235, 0.2)',
            borderColor: 'rgba(54, 162, 235, 1)',
            borderWidth: 1,
          },
        ],
      },
      chart: null,
    };
  },
  computed: {
    windspeed() {
      return this.$store.state.graph.daily_wind_speed;
    },
    temperatures() {
      return this.$store.state.graph.daily_temperatures;
    },
  },
  mounted() {
    // this.renderChart();
    // console.log(this.chart.data)

    this.$store.dispatch("graph/getGraphData").then(() => {
      this.chartData.labels = this.temperatures[0]
      this.chartData.datasets[0].data = this.temperatures[1]
      this.chartData.datasets[1].data = this.windspeed
      // this.chart.destroy();
      this.renderChart();
      // this.chart.data = this.chartData;
      // this.chart.update();
    })
    // this.$axios.get('/stations/getLowestTemperatures').then(response => {
    //   this.chartData.labels = response.data.reverse().map(item => item.date);
    //   this.chartData.datasets[0].data = response.data.reverse().map(item => item.max_temp);
    // });
    // this.$axios.get('/stations/getPeakWindSpeeds').then(response => {
    //   this.chartData.datasets[1].data = response.data.reverse().map(item => item.max_wind_speed);
    //   this.renderChart();
    // });
  },
  methods: {
    renderChart() {
      var ctx = document.getElementById("myChart").getContext("2d");
      this.chart = new Chart(ctx, {
        type: "bar",
        data: this.chartData,
        options: {
          responsive: true,
        },
      });
    },
    doExport() {
      this.$store.dispatch("graph/getExport");
    },
    name: "GraphView",
    getTemps() {
      return this.$store.state.weather.temps;
    },
  },
};
</script>
