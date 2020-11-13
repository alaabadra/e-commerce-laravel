<template>
  <div>
    <!-- overlay -->
    <v-overlay :value="overlay">
      <v-progress-circular indeterminate size="64"></v-progress-circular>
    </v-overlay>
    <navigate />
    <!-- <div class="container">
      <div class="row"> -->
    <v-container>
      <v-row>
        <div class="col-sm-9 mx-auto row mt-5">
          <v-alert
            class="col-sm-12 mx-auto white--text font-2 text-center"
            color="black"
          >
            <i class="fas fa-user-tie mr-3"></i> Employees Management
          </v-alert>
          <v-text-field
            class="col-sm-5 mr-auto"
            outlined
            dense
            label="Employee Name"
            v-model="name"
          ></v-text-field>
          <v-text-field
            class="col-sm-5 ml-auto"
            outlined
            dense
            label="Email"
            v-model="email"
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
            label="Password"
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
            v-model="address"
          ></v-text-field>
          <v-text-field
            class="col-sm-5 ml-auto"
            outlined
            dense
            label="Phone"
            v-model="phone"
          ></v-text-field>
          <v-autocomplete
            class="col-sm-5 mr-auto"
            outlined
            dense
            label="Group"
            :items="groups"
            v-model="group"
          ></v-autocomplete>
          <v-text-field
            class="col-sm-5 ml-auto"
            outlined
            dense
            label="National Id"
            v-model="nationalId"
          ></v-text-field>
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
                  @click="saveEmployee"
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
                  to="/manageemp"
                >
                  <v-icon>mdi-reply-all</v-icon>
                </v-btn>
              </template>
              <span>Back</span>
            </v-tooltip>
          </div>
        </div>
      </v-row>
    </v-container>
    <!-- </div>
    </div> -->
  </div>
</template>
<script>
import navigate from "../../../components/EngNavigate";
import db from "../../../database/DB";
export default {
  name: "AddEmp",
  components: {
    navigate
  },
  data() {
    return {
      overlay: false,
      name: null,
      email: null,
      address: null,
      phone: null,
      password: "",
      group: null,
      groups: [],
      nationalId: null,
      confirmPass: "",
      show: false,
      rules: {
        required: value => !!value || "Required.",
        min: v => v.length >= 8 || "Min 8 characters",
        passMatch: () =>
          this.password == this.confirmPass ||
          "Please Check the Password Again!!!"
      }
    };
  },
  methods: {
    //method that saves the data of an employee to the database
    saveEmployee() {
      db.users
        .add({
          name: this.name,
          email: this.email,
          password: this.password,
          address: this.address,
          phone: this.phone,
          group: this.group,
          nationalId: this.nationalId,
          admin: false
        })
        .then(() => {
          (this.name = null),
            (this.email = null),
            (this.address = null),
            (this.phone = null),
            (this.password = ""),
            (this.group = null),
            (this.nationalId = null),
            (this.overlay = true)((this.confirmPass = ""));
        });
    }
  },
  created() {
    db.groups
      .where("type")
      .equals("Employees")
      .or("type")
      .equals("موظفين")
      .each(group => {
        this.groups.push(group.name);
      });
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
