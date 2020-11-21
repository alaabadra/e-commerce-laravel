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
            label="price"
            v-model="price"
          ></v-text-field>
          <v-text-field
            append-icon="mdi-weight-kilogram"
            name="input-10-2"
            v-model="quantity"
            class="col-sm-5 ml-auto qty mt-2"
            outlined
            dense
            :label="label"
            @click="changeLabel(label)"
          ></v-text-field>
          <v-text-field
            append-icon="mdi-weight-kilogram"
            name="input-10-2"
            v-model="weight"
            class="col-sm-5 ml-auto qty mt-2"
            outlined
            dense
            label="weight"
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
            label="Group"
            :items="groups"
            v-model="group"
            @change="fetchcategory()"
          ></v-combobox>
          <v-combobox
            class="col-sm-5 ml-auto mt-2"
            outlined
            dense
            label="Category"
            :items="categories"
            v-model="category"
            @change="getCategoryId()"
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
      crop: "",
      brand: "",
      price: 0,
      quantity: null,
      weight: null,
      category: null,
      group: null,
      state: null,
      description: null,
      company: null,
      brands: [],
      categories: [],
      stores: [],
      groups: [],
      maincates: [],
      subcates: [],
      categoryId: null,
      companies: [],
      status: ["On Demand", "Not Available", "Available"],
      label: "Quantity",
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
        uImg.innerHTML = `<img src="${e.target.result}"  
                 class="w-100 h-100" />`;
      });
      reader.readAsDataURL(file);
    });

    axios
      .get(
        "http://127.0.0.1:8000/api/admin/categories/get-for-create-main-category"
      )
      .then(res => {
        res.data.dataMainCategories.forEach(group => {
          this.maincates.push(group);
          this.groups.push(group.category_name);
        });
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
    saveProduct() {
      this.overlay = true;
      axios
        .post("http://127.0.0.1:8000/api/admin/products/store", {
          category_id: this.categoryId,
          product_name: this.name,
          product_description: this.description,
          product_price: this.price,
          product_quantity: this.quantity,
          product_weight: this.weight,
          product_status: this.state,
          product_code: this.code,
          product_crop: this.crop,
          product_brand: this.brand,
          product_image: this.picture
        })
        .then();
    },
    //get category upon choosing the group name
    // fetchcategory(mainCategoryId) {
    //   this.maincates.forEach(group => {
    //     if (this.group == group.category_name) {
    //       axios
    //         .get(
    //           `http://127.0.0.1:8000/api/admin/categories/get-for-create-sub-category/${group.id}`
    //         )
    //         .then(res => {
    //           res.data.dataSubCategories.forEach(category => {
    //             this.categories.push(category.category_name);
    //             this.subcates.push(category);
    //           });
    //         });
    //     }
    //   });
    // },
    //fetch category id upon selection
    getCategoryId() {
      this.subcates.forEach(category => {
        if (this.category == category.category_name) {
          this.categoryId = category.id;
        }
      });
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
