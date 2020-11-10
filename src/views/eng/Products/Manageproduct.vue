<template>
  <div class="mt-5">
    <div class="container-fluid mt-5">
      <div class="row">
        <navigate @emitMini="emitValue($event)" />
        <div
          :class="
            mini == true
              ? 'col-sm-11 ml-auto row mt-5 mr-1'
              : 'col-sm-9 ml-auto row mt-5 mr-1'
          "
        >
          <v-alert
            class="col-sm-12 mx-auto white--text font-2 text-center"
            color="black"
          >
            <i class="fas fa-shopping-bag ml-3"></i> Products Management
          </v-alert>
          <v-data-table
            :headers="headers"
            :items="products"
            :search="search"
            :single-expand="singleExpand"
            :expanded.sync="expanded"
            :items-per-page="5"
            show-expand
            item-key="name"
            sort-by="name"
            class="elevation-1 col-sm-12"
          >
            <template v-slot:top>
              <v-toolbar flat color="white">
                <!-- <v-toolbar-title>الموظفين</v-toolbar-title>
                <v-divider class="mx-4" inset vertical></v-divider> -->
                <v-text-field
                  v-model="search"
                  append-icon="mdi-magnify"
                  label="Search"
                  class="col-sm-5 mr-auto"
                  single-line
                  hide-details
                ></v-text-field>
                <v-dialog v-model="dialog">
                  <template v-slot:activator="{ on, attrs }">
                    <v-btn
                      color="primary"
                      dark
                      class=""
                      v-bind="attrs"
                      v-on="on"
                      icon
                      to="/addproduct"
                      ><i class="far fa-plus-square font-3 black--text"></i
                    ></v-btn>
                  </template>

                  <template v-slot:expanded-item="{ headers, item }">
                    <td :colspan="headers.length">
                      More info about {{ item.name }}
                    </td>
                  </template>
                </v-dialog>
              </v-toolbar>
            </template>
            <template v-slot:item.actions="{ item }">
              <v-btn icon small class="mr-4" :to="`/editproduct/${item.id}`">
                <v-icon>mdi-pencil-square</v-icon>
              </v-btn>
              <v-btn icon small @click="deleteItem(item)">
                <v-icon>mdi-delete</v-icon>
              </v-btn>
            </template>
            <template v-slot:no-data>
              <v-btn color="primary" @click="initialize">Reset</v-btn>
            </template>
            <template v-slot:expanded-item="{ headers, item }">
              <td :colspan="headers.length">More info about {{ item.name }}</td>
            </template>
            <template v-slot:item.status="{ item }">
              <v-chip :color="getColor(item.status)" dark>{{
                item.status
              }}</v-chip>
            </template>
          </v-data-table>
        </div>
      </div>
    </div>
  </div>
</template>
<script>
import navigate from "../../../components/Nav";

export default {
  name: "manageproduct",
  components: {
    navigate
  },
  data() {
    return {
      mini: null,
      expanded: [],
      singleExpand: false,
      search: "",
      dialog: false,
      delDialog: false,
      headers: [
        {
          text: "Name",
          align: "start",
          sortable: true,
          value: "name"
        },
        { text: "Category", value: "category" },
        { text: "Code", value: "code" },
        { text: "Main Qty", value: "mainQuantity" },
        { text: "Selling Price", value: "mainSellingPrice" },
        { text: "Status", value: "status" },
        { text: "Actions", value: "actions", sortable: false }
      ],
      products: [],
      editedIndex: -1,
      editedItem: {
        name: null,
        code: null,
        mainQuantity: null,
        mainSellingPrice: null,
        status: null
      },
      defaultItem: {
        name: null,
        code: null,
        mainQuantity: null,
        mainSellingPrice: null,
        status: null
      }
    };
  },

  computed: {
    formTitle() {
      return this.editedIndex === -1 ? "New Item" : "Edit Item";
    }
  },

  watch: {
    dialog(val) {
      val || this.close();
    }
  },

  created() {
    this.initialize();
  },

  methods: {
    //method to get the mini property
    emitValue(value) {
      this.mini = value.mini;
    },
    getColor(status) {
      if (status == "منتهية" || status == "Not Available") return "red";
      else if (status == "متواجدة" || status == "Available") return "green";
      else if (status == "تحت الطلب" || status == "On Demand") return "amber";
    },
    initialize() {},

    editItem(item) {
      this.editedIndex = this.products.indexOf(item);
      this.editedItem = Object.assign({}, item);
      this.dialog = true;
    },

    // deleteItem(item) {
    //   // const index = this.products.indexOf(item);
    // },

    close() {
      this.dialog = false;
      this.$nextTick(() => {
        this.editedItem = Object.assign({}, this.defaultItem);
        this.editedIndex = -1;
      });
    }
  }
};
</script>
