<template>
  <div class="mt-5">
    <div class="container-fluid mt-5">
      <div class="row">
        <navigate @emitMini="emitValue($event)" />
        <div
          :class="
            mini == true
              ? 'col-sm-11 mx-auto row mt-5 mr-1'
              : 'col-sm-9 ml-auto row mt-5 mr-1'
          "
        >
          <v-alert
            class="col-sm-12 mx-auto white--text font-2 text-center"
            color="black"
          >
            <v-icon dark large>mdi-package-variant-closed</v-icon> Products
            Management
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
                  class="col-sm-5 mr-auto mt-5"
                  rounded
                  dense
                  solo
                  clearable
                  @click:append="
                    () => {
                      alert('hello');
                    }
                  "
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
              <v-btn icon small class="mr-4" :to="`/Edit-Product/${item.id}`">
                <v-icon small>mdi-pencil-box</v-icon>
              </v-btn>
              <v-btn icon small @click="deleteItem(item)">
                <v-icon small>mdi-delete</v-icon>
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
      mini: true,
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
        { text: "Selling Price", value: "mainSellingPrice" },
        { text: "Status", value: "status" },
        { text: "Actions", value: "actions", sortable: false }
      ],
      products: [],
      editedIndex: -1,
      editedItem: {
        name: null,
        code: null,
        mainSellingPrice: null,
        status: null
      },
      defaultItem: {
        name: null,
        code: null,
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
      this.mini = value;
    },
    getColor(status) {
      if (status == "منتهية" || status == "Not Available") return "red";
      else if (status == "متواجدة" || status == "Available") return "green";
      else if (status == "تحت الطلب" || status == "On Demand") return "amber";
    },
    initialize() {
      this.products = [
        {
          name: "lolo",
          code: "514515",
          mainQuantity: "1",
          mainSellingPrice: "priceless",
          status: "available"
        }
      ];
    },

    editItem(item) {
      this.editedIndex = this.products.indexOf(item);
      this.editedItem = Object.assign({}, item);
      this.dialog = true;
    },

    deleteItem(item) {
      const index = this.products.indexOf(item);
      confirm("Are You Sure To Delete This Item ?") &&
        this.products.splice(index, 1);
    },

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
