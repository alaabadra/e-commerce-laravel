<template>
  <div>
    <div class="container">
      <div class="row">
        <JSCharting
          :options="options"
          class="columnChart col-sm-12"
        ></JSCharting>
      </div>
    </div>
  </div>
</template>

<script>
import JSCharting from "jscharting-vue";

export default {
  data() {
    return {
      worldMaps: ["Asia", "Africa", "Europe", "Americas"],
      name: "map analystics",
      map: null,
      options: {
        mapping: {
          referenceLayers: "World",
          projection: false
        },
        type: "map",
        height: 330,
        legendVisible: false,
        chartArea: {
          fill: "#FFFFFF"
        },
        defaultPointOutlineWidth: 0,
        series: [
          {
            defaultPoint: {
              color: "rgba(245,106,13,0.97)"
            },
            map: "Continent:North America"
          },
          {
            defaultPoint: {
              color: "rgba(254,210,29,0.97)"
            },
            map: "Continent:South America"
          },
          {
            defaultPoint: {
              color: "rgba(126,177,27,0.97)"
            },
            map: "Continent:Europe"
          },
          {
            defaultPoint: {
              color: "rgba(61,55,108,0.97)"
            },
            map: "Continent:Asia"
          },
          {
            defaultPoint: {
              color: "rgba(50,96,182,0.97)"
            },
            map: "Continent:Africa"
          },
          {
            defaultPoint: {
              color: "rgba(52,130,114,0.97)"
            },
            map: "Continent:Oceania"
          }
        ],
        toolbarVisible: false
      }
    };
  },
  components: {
    JSCharting
  },
  mounted() {},
  methods: {
    getMap() {
      setInterval(() => {
        this.options.series[0].map = this.map;
      }, 1500);
    }
  }
};
</script>

<style>
/* .columnChart {
  height: 700px;
} */
</style>
