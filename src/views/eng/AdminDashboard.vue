<template>
  <!-- main dashboard elements -->
  <div class="mt-5">
    <div class="container-fluid" style="margin-top: 60px">
      <div class="row mr-1">
        <Nav @emitMini="emitValue($event)" />
        <!-- cards -->
        <div
          :class="
            mini == true ? 'col-sm-11 ml-auto row' : 'col-sm-9 ml-auto row'
          "
        >
          <!-- tottal income card per month -->
          <div
            :class="
              windowWidth > 700
                ? 'col-sm-3 row p-0 mr-auto mt-3'
                : 'col-sm-3 row p-0 mx-auto mt-3'
            "
          >
            <v-btn
              absolute
              class="ml-3"
              style="z-index: 2; width: 20px !important; height: 60px !important"
              color="green darken-3"
              dark
            >
              <v-icon large>mdi-cash</v-icon>
            </v-btn>
            <v-card class="col-sm-12 mx-auto row mt-5">
              <div class="col-sm-9 ml-auto row ">
                <v-card-subtitle
                  class="p-1 ml-auto col-sm-12 text-right"
                  style="font-size: .8rem !important"
                  >revenue</v-card-subtitle
                >
                <v-card-title
                  class="p-0 ml-auto text-right mt-1"
                  style="font-size: 1rem !important;"
                  >90000</v-card-title
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
                  class="p-1 ml-auto col-sm-12 text-right"
                  style="font-size: .8rem !important"
                  >Orders</v-card-subtitle
                >
                <v-card-title
                  class="p-0 ml-auto"
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
                  class="p-1 ml-auto col-sm-12  text-right"
                  style="font-size: .8rem !important"
                  >Shipings</v-card-subtitle
                >
                <v-card-title
                  class="p-0 ml-auto"
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
          <div
            :class="
              windowWidth > 700
                ? 'col-sm-3 row p-0 ml-auto mt-3'
                : 'col-sm-3 row p-0 mx-auto mt-3'
            "
          >
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
                  class="p-1 ml-auto col-sm-12  text-right"
                  style="font-size: .8rem !important"
                  >Visitors</v-card-subtitle
                >
                <v-card-title
                  class="p-0 ml-auto text-right"
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
            <LineChart
              :style="
                windowWidth > 700
                  ? 'z-index: 2; height: 350px'
                  : 'z-index: 2; height: 200px'
              "
              class="col-sm-12"
            />

            <v-divider></v-divider>

            <v-card-actions class="justify-center">
              <v-btn block text>
                Go to Report
              </v-btn>
            </v-card-actions>
          </v-card>
          <Extra />
        </div>
      </div>
    </div>
  </div>
</template>
<script>
import Nav from "../../components/Nav";
import LineChart from "../../components/LineChart.vue";
import Extra from "../../components/ExtraInfo";
export default {
  name: "home",
  components: {
    Nav,
    LineChart,
    Extra
  },
  data() {
    return {
      drawer: false,
      mini: true,
      settingsDrawer: null,
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
