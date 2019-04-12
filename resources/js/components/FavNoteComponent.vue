<template>
  <div v-bind:class="{ favNote: isFavNote, favAnime: isFavAnime }" @click="onClick">
    <i class="fas fa-heart">
      <span>{{ numOfFav }}</span>
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
      },
      numOfFav: this.num_of_fav,
      isFavNote: this.is_fav,
      isFavAnime: false
    };
  },
  methods: {
    onClick: function() {
      if (this.isFavNote) {
        this.isFavNote = 0;
        this.isFavAnime = false;
        this.numOfFav--;
      } else {
        this.isFavNote = 1;
        this.isFavAnime = true;
        this.numOfFav++;
      }
      this.$http
        .post("/ajax/notes/fav", this.params)
        .then(function() {})
        .catch(function() {});
    }
  }
};
</script>
