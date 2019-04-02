<template>
  <div @click="onClick">
    <i class="fas fa-heart">
      <span>{{ num_of_fav }}</span>
    </i>
  </div>
</template>
<script>
export default {
  props: {
    note_id: {
      type: Number,
      required: true
    },
    is_fav: {
      type: Number,
      required: true
    },
    num_of_fav: {
      type: Number,
      required: true
    }
  },
  data: function() {
    return {
      params: {
        note_id: this.note_id
      }
    };
  },
  methods: {
    onClick: function() {
      this.$emit("click-fav");
      this.$http
        .post("/ajax/notes/fav", this.params)
        .then(function() {})
        .catch(function() {});
    }
  }
};
</script>
