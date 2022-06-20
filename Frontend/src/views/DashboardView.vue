<!-- create chart with vue-chartjs -->

<template>
  <div id="app">
    <div class="container-fluid">
      <div class="row">
        <div class="col-md-12">
          <div class="card">
            <div class="card-header">
              <h4 class="card-title text-gray-900 dark:text-white">Wind speed vs temperature</h4>
            </div>
            <div class="card-body dark:bg-gray-700">
              <canvas id="myChart" width="600" height="400"></canvas>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="pt-4 text-gray-900 dark:text-white">
    Graphs
    <button v-on:click="doExport" class="px-4 py-2 font-semibold text-sm dark:text-white bg-blue-300 dark:bg-gray-600 text-black rounded-full shadow-sm">Export</button>
  </div>
</template>

<script>
import axios from 'axios';

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
    };
  },
  created() {
    axios.get('http://localhost:8000/stations/getLowestTemperatures').then(response => {
        this.chartData.labels = response.data.reverse().map(item => item.date);
        this.chartData.datasets[0].data = response.data.reverse().map(item => item.max_temp);
      });
    axios.get('http://localhost:8000/stations/getPeakWindSpeeds').then(response => {
        this.chartData.datasets[1].data = response.data.reverse().map(item => item.max_wind_speed);
        this.renderChart();
      });
  },
  methods: {
    renderChart() {
      var ctx = document.getElementById("myChart").getContext("2d");
      new Chart(ctx, {
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
    name: "GraphView"
  },
};
</script>
