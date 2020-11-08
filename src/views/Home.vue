<template>
  <!-- main dashboard elements -->
  <div>
    <div class="container-fluid" style="margin-top: 60px">
      <div class="row mr-1">
        <Nav @emitMini="emitValue($event)" />
        <!-- cards -->
        <div
          :class="
            mini == true ? 'col-sm-11 ml-auto row ' : 'col-sm-9 ml-auto row '
          "
        >
          <!-- tottal income card per month -->
          <div class="col-sm-3 row p-0 mr-auto">
            <v-btn
              absolute
              class="ml-3"
              style="z-index: 2; width: 20px !important; height: 60px !important"
              color="green"
              dark
            >
              <v-icon large>mdi-cash</v-icon>
            </v-btn>
            <v-card class="col-sm-12 mx-auto row">
              <div class="col-sm-9 ml-auto row">
                <v-card-subtitle
                  class="p-1 ml-auto col-sm-8"
                  style="font-size: .8rem !important"
                  >Revenue</v-card-subtitle
                >
                <v-card-title
                  class="p-0 ml-auto col-sm-8"
                  style="font-size: 1rem !important"
                  >99.99</v-card-title
                >
              </div>
              <div
                class="col-sm-9 mx-auto p-0"
                style="border-top: 1px solid black;"
              ></div>
              <v-card-subtitle
                class="p-0 mx-auto col-sm-8 text-center"
                style="font-size: .8rem !important"
              >
                <v-icon x-small color="red"> mdi-alert </v-icon> Per
                Month</v-card-subtitle
              >
            </v-card>
          </div>

          <!-- end tottal income card -->

          <!--Daily orders card -->

          <div class="col-sm-3 row p-0 mx-auto mt-3">
            <v-btn
              absolute
              class="ml-3"
              style="z-index: 2; width: 20px !important; height: 60px !important"
              color="blue darken-3"
              dark
            >
              <v-icon large>mdi-cart</v-icon>
            </v-btn>
            <v-card class="col-sm-12 mx-auto mt-5 row">
              <div class="col-sm-9 ml-auto row">
                <v-card-subtitle
                  class="p-1 ml-auto col-sm-8"
                  style="font-size: .8rem !important"
                  >Orders</v-card-subtitle
                >
                <v-card-title
                  class="p-0 ml-auto col-sm-8"
                  style="font-size: 1rem !important"
                  >20</v-card-title
                >
              </div>
              <div
                class="col-sm-9 mx-auto p-0"
                style="border-top: 1px solid black;"
              ></div>
              <v-card-subtitle
                class="p-0 mx-auto col-sm-8 text-center"
                style="font-size: .8rem !important"
              >
                <v-icon small color="red"> mdi-alert </v-icon> Per
                Day</v-card-subtitle
              >
            </v-card>
          </div>
          <!-- end of Daily orders -->

          <!--Daily orders card -->

          <div class="col-sm-3 row p-0 mx-auto mt-3">
            <v-btn
              absolute
              class="ml-3"
              style="z-index: 2; width: 20px !important; height: 60px !important"
              color="red darken-3"
              dark
            >
              <v-icon large>mdi-truck</v-icon>
            </v-btn>
            <v-card class="col-sm-12 mx-auto mt-5 row">
              <div class="col-sm-9 ml-auto row">
                <v-card-subtitle
                  class="p-1 ml-auto col-sm-8"
                  style="font-size: .8rem !important"
                  >Shipings</v-card-subtitle
                >
                <v-card-title
                  class="p-0 ml-auto col-sm-8"
                  style="font-size: 1rem !important"
                  >130</v-card-title
                >
              </div>
              <div
                class="col-sm-9 mx-auto p-0"
                style="border-top: 1px solid black;"
              ></div>
              <v-card-subtitle
                class="p-0 mx-auto col-sm-8 text-center"
                style="font-size: .8rem !important"
              >
                <v-icon small color="red"> mdi-alert </v-icon> Per
                Day</v-card-subtitle
              >
            </v-card>
          </div>
          <!-- end of Daily orders -->

          <!-- end of cards -->
          <div class="col-sm-3 row p-0 ml-auto mt-3">
            <v-btn
              absolute
              class="ml-3"
              style="z-index: 2; width: 20px !important; height: 60px !important"
              color="orange darken-3"
              dark
            >
              <v-icon large>mdi-account-circle</v-icon>
            </v-btn>
            <v-card class="col-sm-12 mx-auto mt-5 row">
              <div class="col-sm-9 ml-auto row">
                <v-card-subtitle
                  class="p-1 ml-auto col-sm-8"
                  style="font-size: .8rem !important"
                  >Visitors</v-card-subtitle
                >
                <v-card-title
                  class="p-0 ml-auto col-sm-8 text-right"
                  style="font-size: 1rem !important"
                  >35000</v-card-title
                >
              </div>
              <div
                class="col-sm-9 mx-auto p-0"
                style="border-top: 1px solid black;"
              ></div>
              <v-card-subtitle
                class="p-0 mx-auto col-sm-8 text-center"
                style="font-size: .8rem !important"
              >
                <v-icon small color="red"> mdi-alert </v-icon> Per
                Day</v-card-subtitle
              >
            </v-card>
          </div>
          <!-- end of cards -->

          <!-- charts section -->
          <v-card class="mx-auto text-center col-sm-12 mt-5" dark>
            <v-card-text>
              <div style="font-size: 1.5rem; font-weight: 500;">
                Sales Last 24h
              </div>
            </v-card-text>
            <LineChart style="z-index: 2; height: 350px" class="col-sm-12" />

            <v-divider></v-divider>

            <v-card-actions class="justify-center">
              <v-btn block text>
                Go to Report
              </v-btn>
            </v-card-actions>
          </v-card>
          <Map class="col-sm-12" />
        </div>
      </div>
    </div>
  </div>
</template>
<script>
import Nav from "../components/Nav";
import LineChart from "../components/LineChart.vue";
import Map from "../components/Map";
export default {
  name: "home",
  components: {
    Nav,
    LineChart,
    Map
  },
  data() {
    return {
      drawer: false,
      mini: null,
      items: [
        { title: "Search", icon: "mdi-magnify" },
        { title: "Home", icon: "mdi-view-dashboard" },
        { title: "About", icon: "mdi-forum" }
      ],
      windowWidth: window.innerWidth,
      sales: [
        { values: [423, 446, 675, 510, 590, 610, 760] },
        { values: [450, 200, 300, 600, 900, 420, 330] },
        { values: [320, 225, 478, 699, 520, 360, 813] }
      ]
    };
  },
  created() {},
  methods: {
    emitValue(value) {
      this.mini = value;
    }
  }
};
</script>
<style scoped></style>
