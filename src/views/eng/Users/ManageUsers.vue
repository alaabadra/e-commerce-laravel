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
          <v-data-table
            :headers="headers"
            :items="employees"
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
                      to="/addemp"
                      ><v-icon>mdi-plus-circle</v-icon></v-btn
                    >
                  </template>

                  <template v-slot:expanded-item="{ headers, item }">
                    <td :colspan="headers.length">
                      More info about {{ item.name }}
                    </td>
                  </template>
                  <v-card class="col-sm-7 mx-auto">
                    <v-card-title>
                      <v-alert
                        class="col-sm-12 mx-auto white--text font-2 text-center"
                        color="black"
                      >
                        <i class="fas fa-user-tie mr-3"></i> Employees
                        Management
                      </v-alert>
                    </v-card-title>
                    <v-card-text>
                      <div class="row">
                        <v-text-field
                          class="col-sm-5 mr-auto"
                          outlined
                          dense
                          label="Employee Name"
                          v-model="editedItem.name"
                        ></v-text-field>
                        <v-text-field
                          class="col-sm-5 ml-auto"
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
                          class="col-sm-5 mr-auto"
                          outlined
                          dense
                          label="New Password"
                        ></v-text-field>
                        <v-text-field
                          :append-icon="show ? 'mdi-eye' : 'mdi-eye-off'"
                          :rules="[rules.required, rules.min, rules.passMatch]"
                          :type="show ? 'text' : 'password'"
                          name="input-10-2"
                          hint="At least 8 characters"
                          @click:append="show = !show"
                          v-model="confirmPass"
                          class="col-sm-5 ml-auto"
                          outlined
                          dense
                          label="Confirm Password"
                        ></v-text-field>
                        <v-text-field
                          class="col-sm-5 mr-auto"
                          outlined
                          dense
                          label="Address"
                          v-model="editedItem.address"
                        ></v-text-field>
                        <v-text-field
                          class="col-sm-5 ml-auto"
                          outlined
                          dense
                          label="Phone"
                          v-model="editedItem.phone"
                        ></v-text-field>
                        <v-autocomplete
                          class="col-sm-5 mr-auto"
                          outlined
                          dense
                          label="Group"
                          :items="groups"
                          v-model="editedItem.group"
                        ></v-autocomplete>
                        <v-text-field
                          class="col-sm-5 ml-auto"
                          outlined
                          dense
                          label="National Id"
                          v-model="editedItem.nationalId"
                        ></v-text-field>
                        <div class="col-sm-5 mx-auto row">
                          <v-btn
                            color="blue lighten-1"
                            class="col-sm-5 mx-auto  white--text"
                            @click="save()"
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

                    <!-- <v-card-actions>
                      <v-spacer></v-spacer>
                      <v-btn color="blue darken-1" text @click="close"
                        >Cancel</v-btn
                      >
                      <v-btn color="blue darken-1" text @click="save"
                        >Save</v-btn
                      >
                    </v-card-actions> -->
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
import navigate from "../../../components/Nav";
export default {
  name: "manageemp",
  components: {
    navigate
  },
  data() {
    return {
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
        { text: "Email", value: "email" },
        { text: "Phone", value: "phone" },
        { text: "Address", value: "address" },
        { text: "Group", value: "group" },
        { text: "Actions", value: "actions", sortable: false }
      ],
      employees: [],
      editedIndex: -1,
      editedItem: {
        name: "",
        email: "",
        phone: "",
        address: "",
        group: ""
      },
      defaultItem: {
        name: "",
        email: "",
        phone: "",
        address: "",
        group: ""
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
    initialize() {
      //this.employees.push();
    },
    editItem(item) {
      this.editedIndex = this.employees.indexOf(item);
      this.editedItem = Object.assign({}, item);
      this.dialog = true;
    },

    deleteItem(item) {
      const index = this.employees.indexOf(item);
      confirm("Are You Sure To Delete This Item ?") &&
        this.employees.splice(index, 1);
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
        Object.assign(this.employees[this.editedIndex], this.editedItem);
      } else {
        this.employees.push(this.editedItem);
      }
      this.close();
    }
  }
};
</script>
