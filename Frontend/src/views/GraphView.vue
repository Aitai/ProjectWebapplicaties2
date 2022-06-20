<template>
  Graphs
  <button v-on:click="doExport" class="px-4 py-2 font-semibold text-sm bg-blue-300 text-black rounded-full shadow-sm">Export</button>
</template>

<script>
export default {
  methods: {
    doExport() {
      this.$store.dispatch("graph/getExport");
    }
  },
  name: "GraphView"
}
</script>

<style scoped>

</style>