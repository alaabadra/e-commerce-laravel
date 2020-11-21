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
            <v-icon dark large>mdi-handshake</v-icon>Contractors Management
          </v-alert>
          <v-data-table
            :headers="headers"
            :items="contractors"
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
                  <div class="container">
                    <div class="row">
                      <v-card class="col-sm-7 mx-auto">
                        <v-card-title>
                          <v-alert
                            class="col-sm-12 mx-auto white--text font-2 text-center"
                            color="black"
                          >
                            <v-icon dark large>mdi-handshake</v-icon> Contractor
                            Management
                          </v-alert>
                        </v-card-title>
                        <v-card-text>
                          <div class="row">
                            <v-text-field
                              class="col-sm-5 mx-auto"
                              outlined
                              dense
                              label="Contractor Name"
                              v-model="editedItem.contractor_name"
                            ></v-text-field>
                            <v-text-field
                              class="col-sm-5 mx-auto"
                              outlined
                              dense
                              label="Phone"
                              v-model="editedItem.contractor_phone"
                            ></v-text-field>
                            <v-text-field
                              class="col-sm-5 mx-auto"
                              outlined
                              dense
                              label="Contractor Address"
                              v-model="editedItem.contractor_address"
                            ></v-text-field>
                            <v-text-field
                              class="col-sm-5 mx-auto"
                              outlined
                              dense
                              label="Start Date"
                              v-model="editedItem.start_date"
                            ></v-text-field>
                            <v-text-field
                              class="col-sm-5 mx-auto"
                              outlined
                              dense
                              label="End Date"
                              v-model="editedItem.end_date"
                            ></v-text-field>
                            <v-text-field
                              class="col-sm-5 mx-auto"
                              outlined
                              dense
                              label="contractor_commission"
                              v-model="editedItem.contractor_commission"
                            ></v-text-field>
                            <v-autocomplete
                              :items="status"
                              class="col-sm-5 mx-auto"
                              outlined
                              dense
                              label="Status"
                              v-model="editedItem.contractor_status"
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
                    </div>
                  </div>
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
          text: "Name",
          align: "start",
          sortable: true,
          value: "contractor_name"
        },
        { text: "Phone", value: "contractor_phone" },
        { text: "Role", value: "contractor_commission" },
        { text: "Start Date", value: "start_data" },
        { text: "Due Date", value: "end_data" },
        { text: "Actions", value: "actions", sortable: false }
      ],
      contractors: [],
      editedIndex: -1,
      editedItem: {
        contractor_name: "",
        contractor_commission: "",
        contractor_phone: "",
        contractor_address: "",
        contractor_status: "",
        start_date: "",
        end_date: ""
      },
      defaultItem: {
        contractor_name: "",
        contractor_phone: "",
        contractor_address: "",
        contractor_status: "",
        start_date: "",
        end_date: ""
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
      axios
        .get("http://127.0.0.1:8000/api/admin/contractors/view")
        .then(res => {
          this.contractors = res.data.message;
        });
    },

    editItem(item) {
      this.editedIndex = this.contractors.indexOf(item);
      this.editedItem = Object.assign({}, item);
      this.dialog = true;
    },

    deleteItem(item) {
      const index = this.contractors.indexOf(item);
      confirm("Are You Sure To Delete This Item ?") &&
        this.remove(item.id, index);
    },

    remove(itemId, index) {
      this.overlay = true;
      axios
        .post(`http://127.0.0.1:8000/api/admin/contractors/delete/${itemId}`)
        .then(() => {
          this.contractors.splice(index, 1);
          this.overlay = false;
        });
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
        Object.assign(this.contractors[this.editedIndex], this.editedItem);
        axios
          .post(`http://127.0.0.1:8000/api/admin/contractors/update/${id}`, {
            contractor_name: this.editedItem.contractor_name,
            contractor_address: this.editedItem.contractor_address,
            contractor_phone: this.editedItem.contractor_phone,
            start_date: this.editedItem.start_date,
            end_date: this.editedItem.end_date,
            contractor_status: this.editedItem.contractor_status,
            contractor_commission: this.editedItem.contractor_commission
          })
          .then();
      } else {
        this.contractors.push(this.editedItem);
        axios
          .post("http://127.0.0.1:8000/api/admin/contractors/store", {
            contractor_name: this.editedItem.contractor_name,
            contractor_address: this.editedItem.contractor_address,
            contractor_phone: this.editedItem.contractor_phone,
            start_date: this.editedItem.start_date,
            end_date: this.editedItem.end_date,
            contractor_status: this.editedItem.contractor_status,
            contractor_commission: this.editedItem.contractor_commission
          })
          .then();
      }
      this.close();
    }
  }
};
</script>
