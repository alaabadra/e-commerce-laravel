import Vue from "vue";
import VueRouter from "vue-router";

Vue.use(VueRouter);

const routes = [
  {
    path: "/",
    name: "Home",
    // route level code-splitting
    // this generates a separate chunk (about.[hash].js) for this route
    // which is lazy-loaded when the route is visited.
    component: () =>
      import(/* webpackChunkName: "about" */ "../views/eng/Home.vue")
  },
  {
    path: "/about",
    name: "About",
    // route level code-splitting
    // this generates a separate chunk (about.[hash].js) for this route
    // which is lazy-loaded when the route is visited.
    component: () =>
      import(/* webpackChunkName: "about" */ "../views/About.vue")
  },
  {
    path: "/Admin-Dashboard",
    name: "Admin-Dashboard",
    // route level code-splitting
    // this generates a separate chunk (about.[hash].js) for this route
    // which is lazy-loaded when the route is visited.
    component: () =>
      import(
        /* webpackChunkName: "about" */
        "../views/eng/AdminDashboard.vue"
      )
  },
  {
    path: "/New-Product",
    name: "/New-Product",
    // route level code-splitting
    // this generates a separate chunk (about.[hash].js) for this route
    // which is lazy-loaded when the route is visited.
    component: () =>
      import(
        /* webpackChunkName: "about" */
        "../views/eng/Products/Addproduct.vue"
      )
  },
  {
    path: "/Manage-Product",
    name: "/Manage-Product",
    // route level code-splitting
    // this generates a separate chunk (about.[hash].js) for this route
    // which is lazy-loaded when the route is visited.
    component: () =>
      import(
        /* webpackChunkName: "about" */
        "../views/eng/Products/Manageproduct.vue"
      )
  },
  {
    path: "/Edit-Product/:id",
    name: "/Edit-Product",
    // route level code-splitting
    // this generates a separate chunk (about.[hash].js) for this route
    // which is lazy-loaded when the route is visited.
    component: () =>
      import(
        /* webpackChunkName: "about" */
        "../views/eng/Products/Editproduct.vue"
      )
  },

  {
    path: "/Manage-Categories",
    name: "/Manage-Categories",
    // route level code-splitting
    // this generates a separate chunk (about.[hash].js) for this route
    // which is lazy-loaded when the route is visited.
    component: () =>
      import(
        /* webpackChunkName: "about" */
        "../views/eng/category/Managecategory.vue"
      )
  },
  {
    path: "/Manage-Users",
    name: "/Manage-Users",
    // route level code-splitting
    // this generates a separate chunk (about.[hash].js) for this route
    // which is lazy-loaded when the route is visited.
    component: () =>
      import(
        /* webpackChunkName: "about" */
        "../views/eng/Users/ManageUsers.vue"
      )
  },
  {
    path: "/Manage-Contractors",
    name: "/Manage-Contractors",
    // route level code-splitting
    // this generates a separate chunk (about.[hash].js) for this route
    // which is lazy-loaded when the route is visited.
    component: () =>
      import(
        /* webpackChunkName: "about" */
        "../views/eng/Contractors/ManageContractors.vue"
      )
  },
  {
    path: "/Orders",
    name: "/Orders",
    // route level code-splitting
    // this generates a separate chunk (about.[hash].js) for this route
    // which is lazy-loaded when the route is visited.
    component: () =>
      import(
        /* webpackChunkName: "about" */
        "../views/eng/Sales/Orders.vue"
      )
  },
  {
    path: "/Order/:code",
    name: "/Order",
    // route level code-splitting

    // this generates a separate chunk (about.[hash].js) for this route
    // which is lazy-loaded when the route is visited.
    component: () =>
      import(
        /* webpackChunkName: "about" */
        "../views/eng/Sales/Order.vue"
      )
  },
  {
    path: "/Add-Order",
    name: "/Add-Order",
    // route level code-splitting
    // this generates a separate chunk (about.[hash].js) for this route
    // which is lazy-loaded when the route is visited.
    component: () =>
      import(
        /* webpackChunkName: "about" */
        "../views/eng/Sales/Order.vue"
      )
  },
  {
    path: "/Shipings",
    name: "/Shipings",
    // route level code-splitting
    // this generates a separate chunk (about.[hash].js) for this route
    // which is lazy-loaded when the route is visited.
    component: () =>
      import(
        /* webpackChunkName: "about" */
        "../views/eng/Sales/Shipings.vue"
      )
  },
  {
    path: "/New-Ad",
    name: "/New-Ad",
    // route level code-splitting
    // this generates a separate chunk (about.[hash].js) for this route
    // which is lazy-loaded when the route is visited.
    component: () =>
      import(
        /* webpackChunkName: "about" */
        "../views/eng/Ads/NewAd.vue"
      )
  }
];

const router = new VueRouter({
  mode: "history",
  base: process.env.BASE_URL,
  routes
});

export default router;
