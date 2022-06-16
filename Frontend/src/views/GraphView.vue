<template>
  Graphs
  <button v-on:click="doExport" class="px-4 py-2 font-semibold text-sm bg-cyan-500 text-white rounded-full shadow-sm">Export</button>
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