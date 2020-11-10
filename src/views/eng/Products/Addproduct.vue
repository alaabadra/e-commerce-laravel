<template>
  <div class="mt-5">
    <!-- overlay -->
    <v-overlay :value="overlay">
      <v-progress-circular indeterminate size="64"></v-progress-circular>
    </v-overlay>
    <navigate />
    <div class="container">
      <div class="row">
        <div class="col-sm-9 mx-auto row mt-5">
          <v-alert
            class="col-sm-12 mx-auto white--text font-2 text-center"
            color="black"
          >
            <v-icon dark large>mdi-package-variant-closed</v-icon> Products
            Management
          </v-alert>
          <v-btn
            color="primary"
            class="col-sm-5 mr-auto text-center uploadedImg p-0"
            style="height:13rem;"
            dark
            @click="openFile()"
          >
            <v-icon x-large>mdi-file-image</v-icon>
          </v-btn>
          <input type="file" hidden ref="imgUpload" />
          <div class="col-sm-5"></div>
          <v-text-field
            class="col-sm-5 mr-auto mt-2"
            outlined
            dense
            label="Product Name"
            v-model="name"
          ></v-text-field>
          <v-text-field
            class="col-sm-5 ml-auto mt-2"
            outlined
            dense
            label="Code"
            v-model="code"
          ></v-text-field>
          <v-text-field
            class="col-sm-5 mr-auto mt-2"
            outlined
            dense
            label="Wholesale price"
            v-model="wholesalePrice"
          ></v-text-field>
          <v-text-field
            class="col-sm-5 ml-auto mt-2"
            outlined
            dense
            label="Main Selling Price"
            v-model="mainSellingPrice"
          ></v-text-field>
          <v-text-field
            class="col-sm-5 mr-auto mt-2"
            outlined
            dense
            label="Sub-Sale Price"
            v-model="secSellingPrice"
          ></v-text-field>
          <v-text-field
            append-icon="mdi-weight-kilogram"
            name="input-10-2"
            v-model="mainQuantity"
            class="col-sm-5 ml-auto qty mt-2"
            outlined
            dense
            :label="label"
            @click="changeLabel(label)"
          ></v-text-field>
          <v-text-field
            append-icon="mdi-weight-kilogram"
            name="input-10-2"
            v-model="secQuantity"
            class="col-sm-5 mr-auto qty mt-2"
            outlined
            dense
            label="Sub-Storage Qty (Piece)"
            @input="getWItem()"
          ></v-text-field>
          <v-text-field
            append-icon="mdi-weight-kilogram"
            name="input-10-2"
            v-model="itemWeight"
            class="col-sm-5 ml-auto qty mt-2"
            outlined
            dense
            label="Item Weight"
          ></v-text-field>
          <v-combobox
            class="col-sm-5 mr-auto mt-2"
            outlined
            dense
            label="Brand"
            :items="brands"
            v-model="brand"
          ></v-combobox>
          <v-combobox
            class="col-sm-5 ml-auto mt-2"
            outlined
            dense
            label="Category"
            :items="categories"
            v-model="category"
          ></v-combobox>
          <v-combobox
            class="col-sm-5 mr-auto mt-2"
            outlined
            dense
            label="Store"
            :items="stores"
            v-model="store"
          ></v-combobox>
          <v-combobox
            class="col-sm-5 ml-auto mt-2"
            outlined
            dense
            label="Group"
            :items="groups"
            v-model="group"
          ></v-combobox>
          <v-combobox
            class="col-sm-5 mr-auto mt-2"
            outlined
            dense
            label="Status"
            :items="status"
            v-model="state"
          ></v-combobox>
          <v-combobox
            class="col-sm-5 ml-auto mt-2"
            outlined
            dense
            label="(Corp & Importer)"
            :items="companies"
            v-model="company"
          ></v-combobox>
          <label class="col-sm-12 font-2 text-left">Description</label>
          <VueEditor
            class="col-sm-12 p-0"
            style="height:10rem; margin-bottom: 5rem;"
            v-model="desc"
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
                  @click="saveProduct()"
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
export default {
  name: "Addproduct",
  components: {
    navigate,
    VueEditor
  },
  data() {
    return {
      overlay: false,
      picture: null,
      name: null,
      code: Math.floor(Math.random() * 1000000000),
      wholesalePrice: 0,
      mainSellingPrice: 0,
      secSellingPrice: 0,
      mainQuantity: null,
      secQuantity: null,
      itemWeight: null,
      brand: null,
      category: null,
      store: null,
      group: null,
      state: null,
      desc: null,
      company: null,
      brands: [],
      categories: [],
      stores: [],
      groups: [],
      companies: [],
      status: ["On Demand", "Not Available", "Available"],
      label: "Main Storage Qty",
      labels: ["Qty (Piece)", "Qty (g)", "Qty (Kg)"],
      i: 0
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
    saveProduct() {
      this.overlay = true;
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
