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
            <v-icon dark large>mdi-account-circle</v-icon> Users Management
          </v-alert>
          <input type="file" hidden ref="imgUpload" />

          <v-data-table
            :headers="headers"
            :items="users"
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
                      <v-icon>mdi-plus-circle</v-icon>
                    </v-btn>
                  </template>

                  <template v-slot:expanded-item="{ headers, item }">
                    <td :colspan="headers.length">
                      More info about {{ item.name }}
                    </td>
                  </template>
                  <div class="container">
                    <div class="row">
                      <v-card class="col-sm-9 mx-auto">
                        <v-card-title>
                          <v-alert
                            class="col-sm-12 mx-auto white--text font-2 text-center"
                            color="black"
                          >
                            <v-icon dark large>mdi-account-circle</v-icon> User
                            Management
                          </v-alert>
                        </v-card-title>
                        <v-card-text>
                          <div class="row">
                            <v-btn
                              color="primary"
                              class="col-sm-5 mx-auto text-center uploadedImg p-0 mb-3"
                              style="height:13rem;"
                              dark
                              @click="openFile()"
                            >
                              <v-icon x-large>mdi-file-image</v-icon>
                            </v-btn>
                            <div class="col-sm-5 mx-auto"></div>
                            <v-text-field
                              class="col-sm-5 mx-auto"
                              outlined
                              dense
                              label="Employee Name"
                              v-model="editedItem.name"
                            ></v-text-field>
                            <v-text-field
                              class="col-sm-5 mx-auto"
                              outlined
                              dense
                              label="Email"
                              v-model="editedItem.email"
                            ></v-text-field>
                            <v-text-field
                              :append-icon="show ? 'mdi-eye' : 'mdi-eye-off'"
                              :rules="[rules.required, rules.min]"
                              :type="show ? 'text' : 'password'"
                              name="input-10-2"
                              hint="At least 8 characters"
                              @click:append="show = !show"
                              v-model="password"
                              class="col-sm-5 mx-auto"
                              outlined
                              dense
                              label="New Password"
                            ></v-text-field>
                            <v-text-field
                              :append-icon="show ? 'mdi-eye' : 'mdi-eye-off'"
                              :rules="[
                                rules.required,
                                rules.min,
                                rules.passMatch
                              ]"
                              :type="show ? 'text' : 'password'"
                              name="input-10-2"
                              hint="At least 8 characters"
                              @click:append="show = !show"
                              v-model="confirmPass"
                              class="col-sm-5 mx-auto"
                              outlined
                              dense
                              label="Confirm Password"
                            ></v-text-field>
                            <v-text-field
                              class="col-sm-5 mx-auto"
                              outlined
                              dense
                              label="Address"
                              v-model="editedItem.address"
                            ></v-text-field>
                            <v-text-field
                              class="col-sm-5 mx-auto"
                              outlined
                              dense
                              label="Phone"
                              v-model="editedItem.phone"
                            ></v-text-field>
                            <v-text-field
                              class="col-sm-5 mx-auto"
                              outlined
                              dense
                              label="Number Card"
                              v-model="editedItem.numCard"
                            ></v-text-field>
                            <v-combobox
                              class="col-sm-5 mx-auto"
                              outlined
                              dense
                              label="User Status"
                              :items="status"
                              v-model="state"
                            ></v-combobox>
                            <div class="col-sm-5 mx-auto row">
                              <v-btn
                                color="blue lighten-1"
                                class="col-sm-5 mx-auto  white--text"
                                @click="save(editedItem.id)"
                                >Save <i class="fas fa-file mr-3"></i
                              ></v-btn>
                              <v-btn
                                color="amber darken-3"
                                class="col-sm-5 mx-auto  white--text"
                                @click="close()"
                                >Back<i class="fas fa-share mr-3"></i
                              ></v-btn>
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
          </v-data-table>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import axios from "axios";
import navigate from "../../../components/Nav";
export default {
  name: "manageemp",
  components: {
    navigate
  },
  data() {
    return {
      picture: null,
      status: ["DeActivated", "Active"],
      state: null,
      mini: true,
      password: null,
      confirmPass: null,
      show: false,
      groups: [],
      rules: {
        required: value => !!value || "Required.",
        min: v => v.length >= 8 || "Min 8 characters",
        passMatch: () =>
          this.password == this.confirmPass ||
          "Please Check the Password Again!!!"
      },
      expanded: [],
      singleExpand: false,
      search: "",
      dialog: false,
      delDialog: false,
      headers: [
        {
          text: "User-Name ",
          align: "start",
          sortable: true,
          value: "name"
        },
        {
          text: "Email",
          value: "email"
        },
        {
          text: "Phone",
          value: "phone"
        },
        {
          text: "Address",
          value: "address"
        },
        {
          text: "Actions",
          value: "actions",
          sortable: false
        }
      ],
      users: [],
      editedIndex: -1,
      editedItem: {
        name: "",
        email: "",
        phone: "",
        address: "",
        numCard: null
      },
      defaultItem: {
        name: "",
        email: "",
        phone: "",
        address: ""
      }
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
    openFile() {
      this.$refs.imgUpload.click();
    },
    //getting the mini property
    emitValue(value) {
      this.mini = value;
    },
    initialize() {
      //this.users.push();
      axios.get("http://127.0.0.1:8000/api/admin/users/view").then(res => {
        this.users = res.data.message.data;
      });
    },
    editItem(item) {
      this.editedIndex = this.users.indexOf(item);
      this.editedItem = Object.assign({}, item);
      this.dialog = true;
    },

    deleteItem(item) {
      axios
        .post(`http://127.0.0.1:8000/api/admin/users/delete/${item.id}`)
        .then();
      const index = this.users.indexOf(item);
      confirm("Are You Sure To Delete This Item ?") &&
        this.users.splice(index, 1);
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
        Object.assign(this.users[this.editedIndex], this.editedItem);
        axios
          .post(`http://127.0.0.1:8000/api/admin/users/update/${id}`, {
            name: this.editedItem.name,
            email: this.editedItem.email,
            image: this.picture,
            password: this.password,
            address: this.editedItem.address,
            phone: this.editedItem.phone,
            num_card: this.editedItem.numCard,
            user_status: this.state
          })
          .then();
      } else {
        this.users.push(this.editedItem);
        axios
          .post("http://127.0.0.1:8000/api/admin/users/store", {
            name: this.editedItem.name,
            email: this.editedItem.email,
            image: this.picture,
            password: this.password,
            address: this.editedItem.address,
            phone: this.editedItem.phone,
            num_card: this.editedItem.numCard,
            user_status: this.state
          })
          .then();
      }
      this.close();
    }
  }
};
</script>
