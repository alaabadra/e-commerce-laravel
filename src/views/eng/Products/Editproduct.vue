<template>
  <div>
    <!-- overlay -->
    <v-overlay :value="overlay">
      <v-progress-circular indeterminate size="64"></v-progress-circular>
    </v-overlay>
    <navigate @emitMini="emitValue($event)" />
    <div class="container mt-5">
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
            <v-icon dark large>mdi-package-variant-closed</v-icon> Edit Product
          </v-alert>
          <v-btn
            color="primary"
            class="col-sm-5 mr-auto text-center uploadedImg p-0"
            style="height:13rem;"
            dark
            @click="openFile()"
          >
            <v-icon dark x-large>mdi-file-image</v-icon>
          </v-btn>
          <input type="file" hidden class="imgUpload" />
          <div class="col-sm-5"></div>
          <v-text-field
            class="col-sm-5 mr-auto mt-2"
            outlined
            dense
            label="Product Name"
            v-model="product.name"
          ></v-text-field>
          <v-text-field
            class="col-sm-5 ml-auto mt-2"
            outlined
            dense
            label="Code"
            v-model="product.code"
          ></v-text-field>
          <v-text-field
            class="col-sm-5 mr-auto mt-2"
            outlined
            dense
            label="Wholesale Price"
            v-model="product.wholesalePrice"
          ></v-text-field>
          <v-text-field
            class="col-sm-5 ml-auto mt-2"
            outlined
            dense
            label="Main Selling Price"
            v-model="product.mainSellingPrice"
          ></v-text-field>
          <v-text-field
            class="col-sm-5 mr-auto mt-2"
            outlined
            dense
            label="Sub-Sale Price"
            v-model="product.secSellingPrice"
          ></v-text-field>
          <v-text-field
            append-icon="mdi-weight-kilogram"
            class="col-sm-5 ml-auto mt-2"
            outlined
            dense
            :label="product.qtyLabel"
            v-model="product.mainQuantity"
            @click="changeLabel()"
          ></v-text-field>
          <v-text-field
            append-icon="mdi-weight-kilogram"
            name="input-10-2"
            v-model="product.secQuantity"
            class="col-sm-5 mr-auto qty mt-2"
            outlined
            dense
            label="Sub-Storage Qty (Piece)"
            @input="getWItem()"
          ></v-text-field>
          <v-text-field
            append-icon="mdi-weight-kilogram"
            name="input-10-2"
            v-model="product.itemWeight"
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
            v-model="product.brand"
          ></v-combobox>
          <v-combobox
            class="col-sm-5 ml-auto mt-2"
            outlined
            dense
            label="Category"
            :items="categories"
            v-model="product.category"
          ></v-combobox>
          <v-combobox
            class="col-sm-5 mr-auto mt-2"
            outlined
            dense
            label="Store"
            :items="stores"
            v-model="product.store"
          ></v-combobox>
          <v-combobox
            class="col-sm-5 ml-auto mt-2"
            outlined
            dense
            label="Group"
            :items="groups"
            v-model="product.group"
          ></v-combobox>
          <v-combobox
            class="col-sm-5 mr-auto mt-2"
            outlined
            dense
            label="Status"
            :items="status"
            v-model="product.status"
          ></v-combobox>
          <v-combobox
            class="col-sm-5 ml-auto mt-2"
            outlined
            dense
            label="(Corp & Importer)"
            :items="companies"
            v-model="product.corp"
          ></v-combobox>
          <label class="col-sm-12 font-2 text-left">Description</label>
          <VueEditor
            class="col-sm-12 p-0"
            style="height:10rem; margin-bottom: 5rem;"
            v-model="product.desc"
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
                  @click="updateProduct()"
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
      mini: true,
      overlay: false,
      product: {},
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
  mounted() {},
  methods: {
    //getting the mini property
    emitValue(value) {
      this.mini = value;
    },
    //getting the weight for an item
    getWItem() {
      this.product.itemWeight = parseFloat(
        this.product.mainQuantity / this.product.secQuantity
      );
    },
    //method to change the label of an item
    changeLabel() {
      if (this.i < 4) {
        this.product.qtyLabel = this.labels[this.i];
        this.i = this.i + 1;
      } else {
        this.i = 0;
        this.product.qtyLabel = "Qty";
      }
    },
    openFile() {
      let imgUpload = document.querySelector(".imgUpload");
      imgUpload.click();
      //methodology to handle image upload
      let uImg = document.querySelector(".uploadedImg");
      imgUpload.addEventListener("input", e => {
        const file = e.target.files[0];
        const reader = new FileReader();
        reader.addEventListener("load", e => {
          this.product.picture = e.target.result;
          uImg.innerHTML = `<img src="${e.target.result}"  class="w-100 h-100" />`;
        });
        reader.readAsDataURL(file);
      });
    },
    //a method that save products info
    updateProduct() {}
  },
  created() {
    //getting the data for the product by id
    //retrieving data for brands
    //retrieving data for categories
    //retrieving data for stores
    //retrieving data for groups
    //retrieving data for companies
  },
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
