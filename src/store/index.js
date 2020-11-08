import Vue from "vue";
import Vuex from "vuex";

Vue.use(Vuex);

export default new Vuex.Store({
  state: {
    mini: true
  },
  mutations: {
    setMini: state => {
      // state.mini = !state.mini
      alert(state.mini);
    }
  },
  actions: {},
  modules: {}
});
