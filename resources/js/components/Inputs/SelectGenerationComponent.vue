<template>
  <select v-model="generation">
    <option v-for="option in options" :value="option.value" :key="option.value">{{ option.text }}</option>
  </select>
</template>
<script>
export default {
  data() {
    return {
      generation: 1
    };
  },
  mounted() {
    if (sessionStorage.generation) {
      this.generation = sessionStorage.generation;
    } else {
      this.generation = this.defaultGeneration;
    }
  },
  watch: {
    generation(newGeneration) {
      sessionStorage.generation = newGeneration;
    }
  },
  computed: {
    defaultGeneration() {
      var year = new Date().getFullYear();
      return year - 2014;
    },
    options() {
      let options = [];
      for (let i = 0; i < 5; i++) {
        let year = new Date().getFullYear();
        let generation = i + year - 2018;
        options.push({ text: generation + "期生", value: generation });
      }
      return options;
    }
  }
};
</script>

