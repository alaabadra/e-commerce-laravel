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
            <v-icon dark large>mdi-truck</v-icon> Shipings Management
          </v-alert>
          <v-data-table
            :headers="headers"
            :items="shipings"
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
                        <i class="far list-alt mr-3"></i> shipings Management
                      </v-alert>
                    </v-card-title>
                    <v-card-text>
                      <div class="row">
                        <v-text-field
                          class="col-sm-5 mr-auto"
                          outlined
                          dense
                          label="order_code"
                          v-model="editedItem.order_code"
                        ></v-text-field>
                        <v-text-field
                          class="col-sm-5 mr-auto"
                          outlined
                          dense
                          label="deliver_company"
                          v-model="editedItem.deliver_company"
                        ></v-text-field>
                        <v-text-field
                          class="col-sm-5 mr-auto"
                          outlined
                          dense
                          label="deliver_name"
                          v-model="editedItem.deliver_name"
                        ></v-text-field>
                        <v-text-field
                          class="col-sm-5 mr-auto"
                          outlined
                          dense
                          label="	deliver_num"
                          v-model="editedItem.deliver_num"
                        ></v-text-field>
                        <v-text-field
                          class="col-sm-5 mr-auto"
                          outlined
                          dense
                          label="	deliver_destination"
                          v-model="editedItem.deliver_destination"
                        ></v-text-field>
                        <v-text-field
                          class="col-sm-5 mr-auto"
                          outlined
                          dense
                          label="	delivery_time"
                          v-model="editedItem.delivery_time"
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
                                @click="save(editedItem.id)"
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
                <v-icon>mdi-pencil-box</v-icon>
              </v-btn>
              <v-btn icon small @click="deleteItem(item)">
                <v-icon> mdi-delete </v-icon>
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
import axios from "axios";
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
        { text: "order_code", value: "order_code" },
        { text: "deliver_company", value: "deliver_company" },
        { text: "	deliver_name", value: "deliver_name" },
        { text: "deliver_num", value: "	deliver_num" },
        { text: "deliver_destination", value: "deliver_destination" },
        { text: "delivery_status", value: "delivery_status" },
        { text: "delivery_time", value: "delivery_time" },
        { text: "Actions", value: "actions", sortable: false }
      ],
      shipings: [],
      editedIndex: -1,
      editedItem: {
        order_code: "",
        deliver_company: "",
        deliver_name: "",
        deliver_num: "",
        deliver_destination: "",
        delivery_status: "",
        delivery_time: null
      },
      defaultItem: {
        order_code: "",
        deliver_company: "",
        deliver_name: "",
        deliver_num: "",
        deliver_destination: "",
        delivery_status: "",
        delivery_time: null
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
    initialize() {
      axios.get("http://127.0.0.1:8000/api/admin/deliveries/view").then(res => {
        this.shipings = res.data.message.data;
      });
    },

    editItem(item) {
      axios
        .post(`http://127.0.0.1:8000/api/admin/deliveries/${item.id}`)
        .then();
      this.editedIndex = this.shipings.indexOf(item);
      this.editedItem = Object.assign({}, item);
      this.dialog = true;
    },

    deleteItem(item) {
      axios
        .post(`http://127.0.0.1:8000/api/admin/deliveries/delete/${item.id}`)
        .then();
      const index = this.shipings.indexOf(item);
      confirm("You Are Sure To Delete This Item?") &&
        this.shipings.splice(index, 1);
    },

    close() {
      this.dialog = false;
      this.$nextTick(() => {
        this.editedItem = Object.assign({}, this.defaultItem);
        this.editedIndex = -1;
      });
    },

    save(id) {
      if (this.editedIndex > -1) {
        Object.assign(this.shipings[this.editedIndex], this.editedItem);
        axios
          .post(`http://127.0.0.1:8000/api/admin/deliveries/update/${id}`, {
            order_code: this.editedItem.order_code,
            deliver_company: this.editedItem.deliver_company,
            deliver_name: this.editedItem.deliver_name,
            deliver_num: this.editedItem.deliver_num,
            deliver_destination: this.editedItem.deliver_destination,
            delivery_status: this.editedItem.delivery_status,
            delivery_time: this.editedItem.delivery_time
          })
          .then();
      } else {
        this.shipings.push(this.editedItem);
        // var id = null;
        axios
          .post("http://127.0.0.1:8000/api/admin/deliveries/store", {
            order_code: this.editedItem.order_code,
            deliver_company: this.editedItem.deliver_company,
            deliver_name: this.editedItem.deliver_name,
            deliver_num: this.editedItem.deliver_num,
            deliver_destination: this.editedItem.deliver_destination,
            delivery_status: this.editedItem.delivery_status,
            delivery_time: this.editedItem.delivery_time
          })
          .then();
      }
      this.close();
    }
  }
};
</script>
