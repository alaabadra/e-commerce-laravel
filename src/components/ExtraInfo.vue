<template>
  <div class="col-sm-12 mx-auto row">
    <v-card
      :class="
        windowWidth > 700 ? 'col-sm-7 mr-auto row' : 'col-sm-12 mx-auto row'
      "
      color="light"
    >
      <v-alert
        class="col-sm-12 text-center"
        style="font-size: 1rem; font-weight: 600"
        dark
      >
        <v-icon class="mr-3">mdi-sale</v-icon>
        Most Selling Products
      </v-alert>
      <v-data-table
        :headers="headers"
        :items="desserts"
        hide-default-header
        hide-default-footer
        class="elevation-1"
      ></v-data-table>
    </v-card>
    <!-- notifications card -->
    <v-card
      :class="
        windowWidth > 700 ? 'col-sm-5 ml-auto row' : 'col-sm-12 mx-auto row'
      "
      color="light"
    >
      <v-alert
        class="col-sm-12 text-center"
        style="font-size: 1rem; font-weight: 600"
        dark
      >
        <v-icon class="mr-3">mdi-bell-ring</v-icon>
        Notifications
      </v-alert>
      <v-list rounded>
        <v-subheader>REPORTS</v-subheader>
        <v-list-item-group v-model="selectedItem" color="primary">
          <v-list-item v-for="(item, i) in notifications" :key="i">
            <v-list-item-icon>
              <v-icon>mdi-bell-ring</v-icon>
            </v-list-item-icon>
            <v-list-item-content>
              <v-list-item-title v-text="item.title"></v-list-item-title>
            </v-list-item-content>
          </v-list-item>
        </v-list-item-group>
      </v-list>
    </v-card>
  </div>
</template>
<script>
export default {
  data() {
    return {
      windowWidth: window.innerWidth,
      selectedItem: 1,
      notifications: [
        {
          title: "Jason Oner"
        },
        {
          title: "Travis Howard"
        },
        {
          title: "Ali Connors"
        },
        {
          title: "Cindy Baker"
        }
      ],
      headers: [
        {
          text: "Dessert (100g serving)",
          align: "start",
          value: "name"
        },
        { text: "Calories", value: "calories" },
        { text: "Fat (g)", value: "fat" },
        { text: "Carbs (g)", value: "carbs" },
        { text: "Protein (g)", value: "protein" },
        { text: "Iron (%)", value: "iron" }
      ],
      desserts: [
        {
          name: "Frozen Yogurt",
          calories: 159,
          fat: 6.0,
          carbs: 24,
          protein: 4.0,
          iron: "1%"
        },
        {
          name: "Ice cream sandwich",
          calories: 237,
          fat: 9.0,
          carbs: 37,
          protein: 4.3,
          iron: "1%"
        },
        {
          name: "Eclair",
          calories: 262,
          fat: 16.0,
          carbs: 23,
          protein: 6.0,
          iron: "7%"
        },
        {
          name: "Cupcake",
          calories: 305,
          fat: 3.7,
          carbs: 67,
          protein: 4.3,
          iron: "8%"
        },
        {
          name: "Gingerbread",
          calories: 356,
          fat: 16.0,
          carbs: 49,
          protein: 3.9,
          iron: "16%"
        },
        {
          name: "Jelly bean",
          calories: 375,
          fat: 0.0,
          carbs: 94,
          protein: 0.0,
          iron: "0%"
        },
        {
          name: "Lollipop",
          calories: 392,
          fat: 0.2,
          carbs: 98,
          protein: 0,
          iron: "2%"
        },
        {
          name: "Honeycomb",
          calories: 408,
          fat: 3.2,
          carbs: 87,
          protein: 6.5,
          iron: "45%"
        },
        {
          name: "Donut",
          calories: 452,
          fat: 25.0,
          carbs: 51,
          protein: 4.9,
          iron: "22%"
        },
        {
          name: "KitKat",
          calories: 518,
          fat: 26.0,
          carbs: 65,
          protein: 7,
          iron: "6%"
        }
      ]
    };
  }
};
</script>
