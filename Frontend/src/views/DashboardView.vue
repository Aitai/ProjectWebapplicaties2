<template>
  Dashboard
</template>

<script>
export default {
  mounted() {
    this.getPeaks()
  },
  methods: {
    getPeaks() {
      this.$store.dispatch("weather/getPeaks");
    },
    getDates() {
      return this.$store.state.weather.dates;
    },
    getTemps() {
      return this.$store.state.weather.temps;
    }
  },
  name: "DashboardView",
};
</script>

<style scoped></style>
