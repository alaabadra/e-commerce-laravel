<template>
  <div class="mt-5">
    <!-- overlay -->
    <v-overlay :value="overlay">
      <v-progress-circular indeterminate size="64"></v-progress-circular>
    </v-overlay>
    <navigate />
    <div class="container mt-5">
      <div class="row">
        <div class="col-sm-11 mx-auto row mt-5">
          <v-alert
            class="col-sm-12 mx-auto white--text font-2 text-center"
            color="black"
          >
            <i class="fas fa-donate mr-3"></i> Manage Sales
          </v-alert>
          <v-combobox
            class="col-sm-5 mr-auto mt-2"
            outlined
            dense
            label="Client Name"
            :items="clients"
            v-model="clientEmail"
            @change="fetchUserId()"
          ></v-combobox>
          <v-text-field
            class="col-sm-5 ml-auto mt-2"
            v-model="deliveryName"
            label="delivery Name"
            outlined
            dense
          ></v-text-field>

          <v-text-field
            class="col-sm-5 ml-auto mt-2"
            v-model="order_code"
            label="Order Code"
            outlined
            dense
          ></v-text-field>
          <v-text-field
            class="col-sm-5 ml-auto mt-2"
            v-model="date"
            label="Date"
            readonly
            outlined
            dense
          ></v-text-field>
          <v-autocomplete
            class="col-sm-5 mr-auto mt-2"
            outlined
            dense
            label="Payment Method"
            :items="statesPaymentMethod"
            v-model="statusPaymentMethod"
          ></v-autocomplete>
          <v-data-table
            :headers="headers"
            :items="orderItems"
            :hide-default-footer="true"
            sort-by="name"
            class="elevation-1 col-sm-12"
            :items-per-page="20"
          >
            <template v-slot:item.status="{ item }">
              <v-chip :color="getColor(item.status)" dark>{{
                item.status
              }}</v-chip>
            </template>
            <template v-slot:top>
              <v-toolbar flat color="white">
                <v-dialog v-model="dialog" max-width="500px">
                  <template v-slot:activator="{ on, attrs }">
                    <v-btn
                      color="primary"
                      dark
                      class=""
                      v-bind="attrs"
                      v-on="on"
                      icon
                    >
                      <v-icon dark large>mdi-plus-box</v-icon>
                    </v-btn>
                  </template>
                  <v-card>
                    <v-card-title>
                      <v-alert
                        class="col-sm-12 mx-auto white--text font-2 text-center"
                        color="black"
                      >
                        <i class="fas fa-donate mr-3"></i> Manage Sales
                      </v-alert>
                    </v-card-title>

                    <v-card-text>
                      <div class="container">
                        <div class="row">
                          <v-combobox
                            :items="products"
                            v-model="editedItem.product_name"
                            label="Product Name"
                            outlined
                            dense
                            class="col-sm-5 mr-auto"
                          ></v-combobox>

                          <v-combobox
                            class="col-sm-5 ml-auto mt-2"
                            outlined
                            dense
                            label="Category"
                            :items="categories"
                            v-model="category"
                          ></v-combobox>
                          {{ editedItem.product_code }}
                          <v-text-field
                            label="Code"
                            outlined
                            dense
                            class="col-sm-5 mr-auto"
                            v-model="editedItem.product_code"
                            @change="fetchDataProduct(editedItem.product_code)"
                          ></v-text-field>
                          <v-text-field
                            v-model="editedItem.quantity"
                            :label="label"
                            outlined
                            dense
                            class="col-sm-5 ml-auto"
                            @dblclick="changeLabel()"
                            @change="checkQty()"
                          ></v-text-field>
                          <v-text-field
                            v-model="editedItem.store"
                            label="Store"
                            outlined
                            dense
                            class="col-sm-5 mr-auto"
                          ></v-text-field>
                          <v-text-field
                            v-model="editedItem.sellingPrice"
                            label="Price"
                            outlined
                            dense
                            class="col-sm-5 ml-auto"
                            @change="checkPrice()"
                          ></v-text-field>
                          <div class="col-sm-8 mx-auto row">
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
                      </div>
                    </v-card-text>
                  </v-card>
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
          </v-data-table>
          <!-- <div class="col-sm-8 ml-auto" style="height: 0 !important"></div> -->
          <v-text-field
            class="col-sm-2 mr-auto mt-2"
            outlined
            dense
            label="Selling Price"
            v-model="price"
            readonly
            disabled
          ></v-text-field>
          <v-text-field
            class="col-sm-2 mx-auto mt-2"
            outlined
            dense
            label="Discount (%)"
            v-model="discount"
          ></v-text-field>
          <v-text-field
            class="col-sm-2 mx-auto mt-2"
            outlined
            dense
            label="Total Price"
            v-model="tottalPrice"
          ></v-text-field>
          <v-text-field
            class="col-sm-2 mx-auto mt-2"
            outlined
            dense
            label="Amount Paid"
            v-model="paid"
          ></v-text-field>
          <v-text-field
            class="col-sm-2 ml-auto mt-2"
            outlined
            dense
            label="Amount Deserved"
            v-model="deserved"
            readonly
            disabled
          ></v-text-field>
          <div class="col-sm-9 mx-auto row ">
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
                  @click="saveOrder()"
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
                  to="/manageorder"
                >
                  <v-icon>mdi-reply-all</v-icon>
                </v-btn>
              </template>
              <span>Back</span>
            </v-tooltip>
          </div>
          <small class="mr-auto col-sm-4" @click="generateKeys()"
            >code: {{ code }}</small
          >
        </div>
      </div>
    </div>
  </div>
</template>
<script>
import navigate from "../../../components/Nav";
import axios from "axios";
export default {
  name: "Addorder",
  components: {
    navigate
  },
  data() {
    return {
      user_id: null,
      categories: [],
      category: null,
      hidden: true,
      overlay: false,
      paid: 0,
      deserved: 0,
      orderId: null,
      statusPaymentMethod: null,
      date: new Date().toISOString().substr(0, 10),
      code: null,
      clientEmail: null,
      order_code: "",
      clientPhone: null,
      clientAddress: null,
      clientId: null,
      price: 0,
      discount: null,
      tottalPrice: 0,
      quantity: 0,
      dummyQty: 0,
      dummyPrice: 0,
      label: "Qty",
      i: 0,
      labels: ["Main Qty", "Sub Qty"],
      dialog: false,
      delDialog: false,
      deliveryName: "",
      statesPaymentMethod: ["Postpaid", "Cash"],
      clients: [],

      users: [],
      deliveries: [],
      products: [],
      headers: [
        {
          text: "Product Name",
          align: "start",
          sortable: false,
          value: "name"
        },
        { text: "Category", value: "category" },
        { text: "Code", value: "code" },
        { text: "Store", value: "store" },
        { text: "Qty", value: "quantity" },
        { text: "Price", value: "sellingPrice" },
        { text: "Total", value: "itemToattalPrice" },
        { text: "Status", value: "status" },
        { text: "Actions", value: "actions" }
      ],
      orderItems: [],
      editedIndex: -1,
      editedItem: {
        product_name: null,
        product_code: null,
        category: null,
        quantity: 0,
        store: 0,
        status: null,
        sellingPrice: 0,
        itemToattalPrice: 0
      },
      defaultItem: {
        name: null,
        code: null,
        category: null,
        quantity: 0,
        store: 0,
        status: null,
        sellingPrice: 0,
        itemToattalPrice: 0
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
    },
    overlay(val) {
      val &&
        setTimeout(() => {
          this.overlay = false;
        }, 1500);
    }
  },

  created() {
    this.fetchAllUsers();
    this.fetchAllDeliveries();
    this.initialize();
    //checking for the unique code
    this.generateKeys();
    //setting the price automatically
    setInterval(() => {
      if (this.discount != null) {
        this.tottalPrice = Number(
          parseFloat(this.price).toFixed(2) -
            parseFloat(this.discount / 100).toFixed(2) *
              parseFloat(this.price).toFixed(2)
        );
      } else {
        this.discount = null;
      }
    }, 1000);
    //setting the tottal payment process
    setInterval(() => {
      if (this.paid != 0) {
        this.deserved = Number(
          parseFloat(this.tottalPrice).toFixed(2) -
            parseFloat(this.paid).toFixed(2)
        );
      } else if (this.paid == 0) {
        this.deserved = this.tottalPrice;
      }
    }, 1000);
    //getting products data
    //getting the rest of the product automatically by name

    // getting the rest of the product automatically by code

    //getting data sub categories
    axios
      .get("http://127.0.0.1:8000/api/admin/categories/sub-categories")
      .then(res => {
        res.data.dataSubCategories.forEach(cat => {
          this.categories.push(cat.category_name);
        });
      });
  },

  methods: {
    fetchDataProduct(product_code) {
      axios
        .get(
          `http://127.0.0.1:8000/api/admin/products/show-product-data-by-code/${product_code}`
        )
        .then(res => {
          (this.category = res.data.message.category.category_name),
            (this.editItem.product_name = res.data.message.product_name),
            (this.editItem.quantity = res.data.message.product_quantity),
            (this.editItem.price = res.data.message.product_price);
        });
    },
    getColor(status) {
      if (status == "منتهية" || status == "Not Available") return "red";
      else if (status == "متواجدة" || status == "Available") return "green";
      else if (status == "تحت الطلب" || status == "On Demand") return "amber";
    },
    initialize() {
      if (this.$route.params.id) {
        this.orderItems = [];
      }
      //getting clients data
    },
    fetchAllSubCategories() {
      axios
        .get("http://127.0.0.1:8000/api/admin/categories/sub-subcategories")
        .then(res => {
          res.data.message.forEach(client => {
            this.clients.push(client.name);
          });
        });
    },
    fetchAllUsers() {
      axios.get("http://127.0.0.1:8000/api/admin/users/all-users").then(res => {
        this.users = res.data.message;
        res.data.message.forEach(client => {
          this.clients.push(client.email);
        });
      });
    },
    //fetch users id
    fetchUserId() {
      this.users.forEach(user => {
        if (user.email == this.clientEmail) {
          this.user_id = user.id;
        }
      });
    },
    fetchAllDeliveries() {
      axios
        .get("http://127.0.0.1:8000/api/admin/deliveries/all-deliveries")
        .then(res => {
          res.data.message.forEach(delivery => {
            this.deliveries.push(delivery.deliver_name);
          });
        });
    },
    editItem(item) {
      this.editedIndex = this.orderItems.indexOf(item);
      this.editedItem = Object.assign({}, item);
      this.dialog = true;
      this.dummyQty = this.editedItem.quantity;
      this.dummyPrice = this.editedItem.sellingPrice;
    },

    deleteItem(item) {
      const index = this.orderItems.indexOf(item);
      confirm("Are You To Delete This Item?") &&
        this.orderItems.splice(index, 1);
      this.price = Number(
        parseFloat(this.price).toFixed(2) -
          parseFloat(item.quantity).toFixed(2) *
            parseFloat(item.sellingPrice).toFixed(2)
      );
    },

    close() {
      this.dialog = false;
      this.$nextTick(() => {
        this.editedItem = Object.assign({}, this.defaultItem);
        this.editedIndex = -1;
        this.dummyQty = 0;
        this.dummyPrice = 0;
      });
    },

    save() {
      if (this.editedIndex > -1) {
        Object.assign(this.orderItems[this.editedIndex], this.editedItem);
      } else {
        this.orderItems.push(this.editedItem);
      }
      this.getPrice();
      this.close();
    },
    //method to save rder data and items
    saveOrder() {
      //   this.overlay = true;
      this.overlay = true;
      axios
        .post("http://127.0.0.1:8000/api/admin/orders/store", {
          delivery_id: this.deliveryName,
          product_id: this.product_id,
          order_seller: this.order_seller,
          user_id: this.user_id,
          order_price: this.order_price,
          order_code: this.order_code,
          order_payment_method: this.statusPaymentMethod,
          order_status: this.order_status
        })
        .then();
    },

    //method to change the label of an item
    changeLabel() {
      if (this.i < 2) {
        this.label = this.labels[this.i];
        this.i = this.i + 1;
      } else {
        this.i = 0;
        this.label = "Main Qty";
      }
    },
    //method to generate keys
    generateKeys() {
      this.code = Math.floor(Math.random() * 1000000000);
    },
    //method to generate the price
    getPrice() {
      if (this.price == 0) {
        this.price =
          Number(parseFloat(this.editedItem.sellingPrice).toFixed(2)) *
          Number(parseFloat(this.editedItem.quantity).toFixed(2));
      } else {
        this.price =
          Number(parseFloat(this.price).toFixed(2)) +
          Number(parseFloat(this.editedItem.sellingPrice).toFixed(2)) *
            Number(parseFloat(this.editedItem.quantity).toFixed(2));
      }
      this.getTottalPrice(this.editedItem);
    },
    //method to check if the quantity is changed
    checkQty() {
      if (this.dummyQty != this.editedItem.quantity) {
        this.price =
          Number(parseFloat(this.price)).toFixed(2) -
          Number(parseFloat(this.dummyQty).toFixed(2)) *
            Number(parseFloat(this.editedItem.sellingPrice).toFixed(2));
        this.getTottalPrice(this.editedItem);
      }
    },
    //method to check the change in th price
    checkPrice() {
      if (this.dummyPrice != this.editedItem.sellingPrice) {
        this.price =
          Number(parseFloat(this.price)).toFixed(2) -
          Number(parseFloat(this.editedItem.quantity).toFixed(2)) *
            Number(parseFloat(this.dummyPrice).toFixed(2));
        this.getTottalPrice(this.editedItem);
      }
    },
    //method to get the tottal pricr for certain rows
    getTottalPrice(item) {
      item.itemToattalPrice =
        Number(parseFloat(item.quantity).toFixed(2)) *
        Number(parseFloat(item.sellingPrice).toFixed(2));
    }
  }
};
</script>
