<template>
  <div>
    <!-- navbar -->
    <v-app-bar dense dark app color="primary" class="nav">
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
      <v-btn icon @click.stop="sDrawer = !sDrawer">
        <v-icon>mdi-magnify</v-icon>
      </v-btn>

      <v-btn icon>
        <v-badge content="5" value="3" color="green" overlap>
          <v-icon>
            mdi-message-reply
          </v-icon>
        </v-badge>
      </v-btn>
      <v-btn
        v-show="windowWidth > 700 ? false : true"
        icon
        @click="settingsDrawer = !settingsDrawer"
      >
        <v-icon>mdi-cog</v-icon>
      </v-btn>
    </v-app-bar>
    <!--end of navbar -->

    <!-- search drawers -->
    <v-navigation-drawer
      v-model="sDrawer"
      app
      right
      temporary
      hide-overlay
      height="60px"
      style="overflow: hidden !important;"
      dark
      class="w-100"
    >
      <v-list nav dense>
        <v-list-item>
          <v-combobox
            dense
            rounded
            placeholder="Search What You Want.."
            prepend-inner-icon="mdi-magnify"
            solo
            filled
          ></v-combobox>
        </v-list-item>
      </v-list>
    </v-navigation-drawer>

    <!-- end of search drawers -->

    <!--navigation drawer -->

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
          no-action
          dense
        >
          <template v-slot:activator>
            <v-list-item-title
              style="font-size: .8rem !important; font-weight:500 !important"
              >{{ item.title }}</v-list-item-title
            >
          </template>
          <v-list dense>
            <v-list-item
              v-for="subItem in item.subItems"
              :key="subItem.title"
              :to="subItem.href"
              link
            >
              <v-list-item-icon>
                <v-icon v-text="subItem.icon"></v-icon>
              </v-list-item-icon>
              <v-list-item-title v-text="subItem.title"></v-list-item-title>
            </v-list-item>
          </v-list>
        </v-list-group>
        <!-- list items with single item -->
        <v-list v-else-if="!item.subItems" no-action dense>
          <v-list-item link :to="item.href">
            <v-list-item-icon>
              <v-icon v-text="item.icon"></v-icon>
            </v-list-item-icon>
            <v-list-item-title v-text="item.title"></v-list-item-title>
          </v-list-item>
        </v-list>
      </div>
    </v-navigation-drawer>
    <!-- end of navigation drawer -->

    <!-- button to trigger settings drawer -->

    <v-btn
      @click.stop="settingsDrawer = !settingsDrawer"
      color="primary"
      fab
      dark
      small
      right
      tile
      class="settingsBtn"
      v-show="windowWidth > 700 ? true : false"
    >
      <v-icon>mdi-cog</v-icon>
    </v-btn>

    <!-- settings drawer -->
    <v-navigation-drawer
      v-model="settingsDrawer"
      temporary
      right
      app
      hide-overlay
    >
      <v-list-item class="px-2">
        <v-list-item-icon>
          <v-icon>mdi-cog</v-icon>
        </v-list-item-icon>

        <v-list-item-content>
          <v-list-item-title>Settings</v-list-item-title>
        </v-list-item-content>
      </v-list-item>

      <v-divider></v-divider>

      <v-list dense>
        <v-list-item v-for="item in settingsItems" :key="item.title" link>
          <v-list-item-icon>
            <v-icon>{{ item.icon }}</v-icon>
          </v-list-item-icon>

          <v-list-item-content>
            <v-list-item-title>{{ item.title }}</v-list-item-title>
          </v-list-item-content>
        </v-list-item>
      </v-list>
    </v-navigation-drawer>
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
      sDrawer: false,
      settingsDrawer: false,
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
          icon: "mdi-view-dashboard",
          href: "/Admin-Dashboard"
        },
        {
          title: "Users",
          icon: "mdi-account-circle",
          href: "/Manage-Users"
        },
        {
          title: "Categories",
          icon: "mdi-clipboard-text",
          href: "/Manage-Categories"
        },
        {
          title: "Products",
          icon: "mdi-package-variant",
          subItems: [
            {
              title: "New Product",
              icon: "mdi-plus-circle",
              href: "/New-Product"
            },
            {
              title: "Manage Products",
              icon: "mdi-table-edit",
              href: "/Manage-Product"
            }
          ]
        },
        {
          title: "Contractors",
          icon: "mdi-handshake",
          href: "/Manage-Contractors"
        },
        {
          title: "Sales",
          icon: "mdi-currency-usd-circle",
          subItems: [
            {
              title: "Orders",
              icon: "mdi-cart",
              href: "/Orders"
            },
            {
              title: "Shipings",
              icon: "mdi-truck",
              href: "/Shipings"
            }
          ]
        },
        {
          title: "Ads",
          icon: "mdi-bookmark",
          subItems: [
            {
              title: "New Campaign",
              icon: "mdi-bookmark-plus",
              href: "/New-Ad"
            },
            {
              title: "Analystics",
              icon: "mdi-chart-areaspline",
              href: ""
            }
          ]
        }
        // {
        //   title: "Reports",
        //   icon: "mdi-clipboard-text",
        //   href: "",
        // },
      ]
    };
  },
  created() {},
  methods: {
    emitMini() {
      this.$emit("emitMini", this.mini);
    }
  }
};
</script>
<style>
a:hover {
  text-decoration: none !important;
}

@media (min-width: 1000px) {
  .settingsBtn {
    top: 300px !important;
    left: 97% !important;
    position: fixed !important;
    z-index: 2;
  }
}
.settingsBtn {
  top: 300px !important;
  left: 96% !important;
  position: fixed !important;
  z-index: 2;
}
</style>
