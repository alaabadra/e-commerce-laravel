<template>
  <div></div>
</template>
<script>
export default {
  name: "Sidebar",
  data() {
    return {
      drawer: null,
      mini: false,
      items: [
        { title: "Home", icon: "mdi-view-dashboard" },
        { title: "About", icon: "mdi-forum" }
      ],
      windowWidth: window.innerWidth
    };
  }
};
</script>
