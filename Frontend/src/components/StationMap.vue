<template>
  <div class="w-full h-auto">
    <l-map
      v-model="zoom"
      v-model:zoom="zoom"
      :center="
        locations ? [locations[0].latitude, locations[0].longitude] : [50, 50]
      "
    >
      <l-tile-layer
        url="https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png"
      ></l-tile-layer>

      <l-marker
        v-for="location in locations"
        :lat-lng="[location.latitude, location.longitude]"
        @click="
          $router.push({
            name: 'station.view',
            params: { stationName: location.name },
          })
        "
      >
        <l-tooltip> Station {{ location.name }} </l-tooltip>
      </l-marker>
    </l-map>
  </div>
</template>

<script>
import {
  LMap,
  LIcon,
  LTileLayer,
  LMarker,
  LControlLayers,
  LTooltip,
  LPopup,
  LPolyline,
  LPolygon,
  LRectangle,
} from "@vue-leaflet/vue-leaflet";
import "leaflet/dist/leaflet.css";

export default {
  components: {
    LMap,
    LIcon,
    LTileLayer,
    LMarker,
    LControlLayers,
    LTooltip,
    LPopup,
    LPolyline,
    LPolygon,
    LRectangle,
  },
  props: ["locations", "zoom"],
  data() {
    return {
      iconWidth: 25,
      iconHeight: 40,
    };
  },
};
</script>
