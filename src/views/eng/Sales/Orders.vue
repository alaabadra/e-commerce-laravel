<template>
  <div class="mt-5">
    <navigate @emitMini="emitValue($event)" />
    <div class="container-fluid mt-5">
      <div class="row">
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
            <v-icon large dark>mdi-cart</v-icon> Orders Management
          </v-alert>
          <v-data-table
            :headers="headers"
            :items="categories"
            :search="search"
            :items-per-page="5"
            item-key="name"
            sort-by="name"
            class="elevation-1 col-sm-12"
          >
            <template v-slot:item.status="{ item }">
              <v-chip :color="getColor(item.status)" dark>{{
                item.status
              }}</v-chip>
            </template>
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
                    >
                      <v-icon large>mdi-plus-circle</v-icon>
                    </v-btn>
                  </template>

                  <v-card class="w-50 mx-auto">
                    <v-card-title>
                      <v-alert
                        class="col-sm-12 mx-auto white--text font-2 text-center"
                        color="black"
                      >
                        <i class="far list-alt mr-3"></i> Categories Management
                      </v-alert>
                    </v-card-title>
                    <v-card-text>
                      <div class="row">
                        <v-text-field
                          class="col-sm-5 mr-auto"
                          outlined
                          dense
                          label="Category Name"
                          v-model="editedItem.name"
                        ></v-text-field>
                        <v-autocomplete
                          :items="status"
                          class="col-sm-5 ml-auto"
                          outlined
                          dense
                          label="Status"
                          v-model="editedItem.status"
                        >
                        </v-autocomplete>
                        <div class="col-sm-5 mx-auto row">
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
                                @click="close()"
                              >
                                <v-icon>mdi-reply-all</v-icon>
                              </v-btn>
                            </template>
                            <span>Back</span>
                          </v-tooltip>
                        </div>
                      </div>
                    </v-card-text>
                  </v-card>
                </v-dialog>
              </v-toolbar>
            </template>
            <template v-slot:item.actions="{ item }">
              <v-btn icon small @click="editItem(item)">
                <i class="fas fa-edit"></i>
              </v-btn>
              <v-btn icon small @click="deleteItem(item)">
                <i class="fas fa-trash-alt"></i>
              </v-btn>
            </template>
            <template v-slot:no-data>
              <v-btn color="primary" @click="initialize">Reset</v-btn>
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
  name: "managebrand",
  components: {
    navigate
  },
  data() {
    return {
      mini: true,
      Brand: "Brand",
      status: ["Available", "Not Available"],
      search: "",
      dialog: false,
      delDialog: false,
      headers: [
        {
          text: "Order Code",
          align: "start",
          sortable: true,
          value: "name"
        },
        { text: "Seller", value: "seller" },
        { text: "Buyer", value: "buyer" },
        { text: "Product Id", value: "product_id" },
        { text: "Actions", value: "actions", sortable: false }
      ],
      categories: [],
      editedIndex: -1,
      editedItem: {
        name: "",
        status: ""
      },
      defaultItem: {
        name: "",
        status: ""
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
    //getting the mini property
    emitValue(value) {
      this.mini = value;
    },
    getColor(status) {
      if (status == "Not Available" || status == "منتهي") return "red";
      else if (status == "Available" || status == "متوفر") return "green";
    },
    initialize() {},

    editItem(item) {
      this.editedIndex = this.categories.indexOf(item);
      this.editedItem = Object.assign({}, item);
      this.dialog = true;
    },

    deleteItem(item) {
      const index = this.categories.indexOf(item);
      confirm("You Are Sure To Delete This Item?") &&
        this.categories.splice(index, 1);
    },

    close() {
      this.dialog = false;
      this.$nextTick(() => {
        this.editedItem = Object.assign({}, this.defaultItem);
        this.editedIndex = -1;
      });
    },

    save() {
      if (this.editedIndex > -1) {
        Object.assign(this.categories[this.editedIndex], this.editedItem);
      } else {
        this.categories.push(this.editedItem);
      }
      this.close();
    }
  }
};
</script>
