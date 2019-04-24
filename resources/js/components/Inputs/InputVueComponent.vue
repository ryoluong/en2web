<template>
  <input v-model="value">
</template>
<script>
export default {
  props: {
    component_id: {
      type: String,
      required: false
    }
  },
  data() {
    return {
      value: ""
    };
  },
  mounted() {
    if (eval("sessionStorage." + this.component_id)) {
      eval("this.value = sessionStorage." + this.component_id);
    }
  },
  watch: {
    value(newValue) {
      eval("sessionStorage." + this.component_id + "= newValue");
    }
  }
};
</script>

