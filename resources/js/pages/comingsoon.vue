<template></template>
<script>
export default {
  mounted() {
    this.$store.dispatch('snackbar/show', {
      message: '現在準備中です。',
      type: 'accent',
    });
    this.$router.go(-1);
  },
};
</script>
