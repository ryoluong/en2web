<template>
  <select v-model="registerYear">
    <option v-for="n in 5" :key="n">{{ n + 2014 }}</option>
  </select>
</template>
<script>
export default {
  data() {
    return {
      registerYear: 2015
    };
  },
  mounted() {
    if (sessionStorage.registerYear) {
      this.registerYear = sessionStorage.registerYear;
    } else {
      this.registerYear = this.nowYear;
    }
  },
  watch: {
    registerYear(newRegisterYear) {
      sessionStorage.setItem("registerYear", this.registerYear);
    }
  },
  computed: {
    nowYear() {
      return new Date().getFullYear();
    }
  }
};
</script>
