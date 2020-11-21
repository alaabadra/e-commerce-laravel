<template>
  <div class="mt-5">
    <!-- overlay -->
    <v-overlay :value="overlay">
      <v-progress-circular indeterminate size="64"></v-progress-circular>
    </v-overlay>
    <navigate @emitMini="emitValue($event)" />
    <div class="container">
      <div class="row">
        <div
          :class="
            mini == true
              ? 'col-sm-9 mx-auto row mt-5'
              : 'col-sm-9 ml-auto row mt-5'
          "
        >
          <v-alert
            class="col-sm-12 mx-auto white--text font-2 text-center"
            color="black"
          >
            <v-icon dark large>mdi-book-variant</v-icon> Products Management
          </v-alert>
          <!-- <v-combobox
            dense
            solo
            rounded
            color="black"
            label="Ad Type"
            :items="adTypes"
            class="col-sm-5 mr-auto"
          ></v-combobox> -->
          <v-text-field
            dense
            solo
            rounded
            color="black"
            label="WebSite Or Product Link"
            class="col-sm-12 ml-auto"
            prepend-inner-icon="mdi-link"
            v-model="link"
          ></v-text-field>
          <v-autocomplete
            :items="status"
            class="col-sm-5 mx-auto"
            outlined
            dense
            label="Status"
            v-model="status"
          >
          </v-autocomplete>
          <v-btn
            color="primary"
            class="col-sm-12 mr-auto text-center uploadedImg p-0"
            style="height:25rem;"
            dark
            @click="openFile()"
          >
            <v-icon x-large>mdi-file-image</v-icon>
          </v-btn>
          <input type="file" hidden ref="imgUpload" />

          <!-- multiple videos -->

          <label class="col-sm-12 font-2 text-left">Description</label>
          <VueEditor
            class="col-sm-12 p-0"
            style="height:10rem; margin-bottom: 5rem;"
            v-model="description"
          ></VueEditor>
          <div class="col-sm-4 mx-auto row mt-5">
            <v-tooltip top>
              <template v-slot:activator="{ on, attrs }">
                <v-btn
                  fab
                  v-bind="attrs"
                  v-on="on"
                  size="24"
                  class="mx-auto"
                  color="blue darken-3"
                  dark
                  @click="save()"
                >
                  <v-icon>mdi-content-save-all</v-icon>
                </v-btn>
              </template>
              <span>Save</span>
            </v-tooltip>
            <v-tooltip top>
              <template v-slot:activator="{ on, attrs }">
                <v-btn
                  fab
                  v-bind="attrs"
                  v-on="on"
                  size="24"
                  class="mx-auto"
                  color="amber darken-3"
                  dark
                  to="/manageproduct"
                >
                  <v-icon>mdi-reply-all</v-icon>
                </v-btn>
              </template>
              <span>Back</span>
            </v-tooltip>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>
<script>
import navigate from "../../../components/Nav";
import { VueEditor } from "vue2-editor";
import axios from "axios";
export default {
  name: "Addproduct",
  components: {
    navigate,
    VueEditor
  },
  data() {
    return {
      mini: true,
      overlay: false,
      picture: null,
      name: null,
      code: Math.floor(Math.random() * 1000000000),
      brand: null,
      description: null,
      link: "",
      company: null,
      brands: [],
      categories: [],
      stores: [],
      groups: [],
      companies: [],
      status: ["On Demand", "Not Available", "Available"],
      label: "Main Storage Qty",
      labels: ["Qty (Piece)", "Qty (g)", "Qty (Kg)"],
      i: 0,
      model: 0,
      colors: ["primary", "secondary", "yellow darken-2", "red", "orange"],
      adTypes: ["Single Picture", "Multiple Pictuers", "Video"],
      adType: null,
      multi: false,
      single: true,
      vid: false
    };
  },
  mounted() {
    this.$refs.imgUpload.addEventListener("change", e => {
      const uImg = document.querySelector(".uploadedImg");
      const file = e.target.files[0];
      const reader = new FileReader();
      reader.addEventListener("load", e => {
        this.picture = e.target.result;
        uImg.innerHTML = `<img src="${e.target.result}"  class="w-100 h-100" />`;
      });
      reader.readAsDataURL(file);
    });
  },
  methods: {
    //getting the mini property
    emitValue(value) {
      this.mini = value;
    },
    //getting the weight for an item
    getWItem() {
      this.itemWeight = parseFloat(this.mainQuantity / this.secQuantity);
    },
    //method to change the label of an item
    changeLabel() {
      if (this.i < 3) {
        this.label = this.labels[this.i];
        this.i = this.i + 1;
      } else {
        this.i = 0;
        this.label = "Qty";
      }
    },
    openFile() {
      this.$refs.imgUpload.click();
    },
    //a method that save products info
    save() {
      this.overlay = true;
      axios
        .post("http://127.0.0.1:8000/api/admin/addvertisments/store", {
          addvertisment_name: this.name,
          addvertisment_description: this.description,
          addvertisment_status: this.status,
          addvertisment_link: this.link,
          addvertisment_image: this.picture
        })
        .then();
    }
  },
  created() {},
  watch: {
    overlay(val) {
      val &&
        setTimeout(() => {
          this.overlay = false;
        }, 1500);
    }
  }
};
</script>
