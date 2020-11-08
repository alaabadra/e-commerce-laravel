<template>
  <div>
    <!-- navbar -->
    <v-app-bar dense dark app color="primary">
      <v-icon
        class="mr-5"
        @click.stop="
          windowWidth > 700 ? (mini = !mini) : (drawer = !drawer), emitMini()
        "
        >mdi-store</v-icon
      >
      <!-- @click.stop="windowWidth > 700 ? (mini = !mini) : (drawer = !drawer)" -->
      <v-toolbar-title>STORE</v-toolbar-title>

      <v-spacer></v-spacer>

      <!-- settings button and dropdown -->
      <v-menu rounded="b-xl" offset-y left :close-on-content-click="false">
        <template v-slot:activator="{ attrs, on }">
          <v-btn class="white--text" v-bind="attrs" v-on="on" icon large>
            <v-icon>mdi-magnify</v-icon>
          </v-btn>
        </template>

        <v-list width="30em" class="p-2">
          <v-combobox placeholder="Search What You Want ..."></v-combobox>
        </v-list>
      </v-menu>

      <v-btn icon>
        <v-badge content="5" value="3" color="green" overlap>
          <v-icon>
            mdi-message-reply
          </v-icon>
        </v-badge>
      </v-btn>
      <v-btn icon>
        <v-badge content="3" value="3" color="green" overlap>
          <v-icon>
            mdi-bell
          </v-icon>
        </v-badge>
      </v-btn>

      <!-- settings button and dropdown -->
      <v-menu rounded="b-xl" offset-y>
        <template v-slot:activator="{ attrs, on }">
          <v-btn class="white--text" v-bind="attrs" v-on="on" icon large>
            <v-icon>mdi-cog</v-icon>
          </v-btn>
        </template>

        <v-list dense width="150px">
          <div
            class="text-center grey--text"
            width="150px"
            style="font-size:.8rem"
          >
            Settings
          </div>
          <v-list-item-group color="primary">
            <v-list-item v-for="item in settingsItems" :key="item.title">
              <v-list-item-icon>
                <v-icon v-text="item.icon"></v-icon>
              </v-list-item-icon>
              <v-list-item-content>
                <v-list-item-title v-text="item.title"></v-list-item-title>
              </v-list-item-content>
            </v-list-item>
          </v-list-item-group>
        </v-list>
      </v-menu>
    </v-app-bar>
    <!--end of navbar -->

    <!--permenant drawer -->

    <v-navigation-drawer
      v-model="drawer"
      dark
      :permanent="windowWidth > 700 ? true : false"
      app
      :mini-variant="windowWidth > 700 ? mini : !mini"
    >
      <v-list-item class="px-2">
        <v-list-item-avatar>
          <v-img src="https://randomuser.me/api/portraits/men/85.jpg"></v-img>
        </v-list-item-avatar>

        <v-list-item-title>John Leider</v-list-item-title>
      </v-list-item>
      <v-divider></v-divider>
      <div v-for="item in DrawerItems" :key="item.title">
        <v-list-group
          :value="false"
          :prepend-icon="item.icon"
          color="white"
          v-if="item.subItems"
        >
          <template v-slot:activator>
            <v-list-item-title>{{ item.title }}</v-list-item-title>
          </template>
          <v-list dense>
            <v-list-item
              v-for="subItem in item.subItems"
              :key="subItem.title"
              link
            >
              <v-list-item-icon>
                <v-icon v-text="subItem.icon"></v-icon>
              </v-list-item-icon>
              <v-list-item-title v-text="subItem.title"></v-list-item-title>
            </v-list-item>
          </v-list>
        </v-list-group>
        <v-list v-else-if="!item.subItems">
          <v-list-item link>
            <v-list-item-icon>
              <v-icon v-text="item.icon"></v-icon>
            </v-list-item-icon>
            <v-list-item-title v-text="item.title"></v-list-item-title>
          </v-list-item>
        </v-list>
      </div>
    </v-navigation-drawer>
    <!-- end of permanent drawer -->
  </div>
</template>
<script>
export default {
  name: "navbar",
  components: {},
  data() {
    return {
      drawer: false,
      mini: true,
      //items in the settings dropdown
      settingsItems: [
        { title: "Search", icon: "mdi-magnify" },
        { title: "Home", icon: "mdi-view-dashboard" },
        { title: "About", icon: "mdi-forum" }
      ],
      windowWidth: window.innerWidth,
      btns: [
        ["Removed", "0"],
        ["Large", "lg"],
        ["Custom", "b-xl"]
      ],
      colors: ["deep-purple accent-4", "error", "teal darken-1"],
      //the navigation buttons in the side-bar
      DrawerItems: [
        {
          title: "Dashboard",
          icon: "mdi-view-dashboard"
        },
        {
          title: "Users",
          icon: "mdi-account-circle"
        },
        {
          title: "Products",
          icon: "mdi-package-variant",
          subItems: [
            {
              title: "New Product",
              icon: "mdi-plus-circle"
            },
            {
              title: "Manage Products",
              icon: "mdi-table-edit"
            }
          ]
        },
        {
          title: "Sales",
          icon: "mdi-currency-usd-circle",
          subItems: [
            {
              title: "Orders",
              icon: "mdi-cart"
            },
            {
              title: "Shipings",
              icon: "mdi-truck"
            }
          ]
        },
        {
          title: "Ads",
          icon: "mdi-bookmark",
          subItems: [
            {
              title: "New Campaign",
              icon: "mdi-bookmark-plus"
            },
            {
              title: "Analystics",
              icon: "mdi-chart-areaspline"
            }
          ]
        }
      ]
    };
  },
  created() {
    //:permanent="windowWidth > 700 ? true : mini == false ? false : true"
    //  :mini-variant="windowWidth > 700 ? mini : !mini"
    this.emitMini();
  },
  methods: {
    emitMini() {
      this.$emit("emitMini", this.mini);
    }
  }
};
</script>
