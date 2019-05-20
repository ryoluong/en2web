<template>
  <div class="note_show_vue">
    <div class="top_photo" :class="{ best_note: isBest }" :style="topPhotoStyle">
      <div class="textbox">
        <div class="title_country_wrapper">
          <h1 class="note_title">{{ note.title }}</h1>
          <div class="note_countries" v-if="countries.length !== 0">
            <a
              v-for="country in countries"
              :key="country.id"
              class="note_country"
              :href="'/countries/' + country.id + '/notes'"
            >{{ '@' + country.name }}&nbsp;</a>
          </div>
        </div>
        <a class="best_icon" href="/notes/best" v-if="note.isBest === 1">Best Note</a>
        <a v-if="isEditable" class="edit" :href="'/notes/' +  note.id + '/edit'">
          <img src="/img/note_edit.png" alt>
        </a>
        <a
          class="note_category"
          :href="'/categories/' + category.id  + '/notes'"
        >{{ category.name }}</a>
      </div>
    </div>
    <div class="author_and_date">
      <a class="note_author" :href="'/users/' + author.id + '/notes'">
        <img
          :src="[ author.avater_path !== null ? author.avater_path : '/img/categories/user.png' ]"
          alt="icon"
        >
        <p>{{ author.name }}</p>
      </a>
      <p class="note_date">{{ note.date }}</p>
    </div>
    <h6>
      <a
        v-for="tag in tags"
        :key="tag.id"
        class="tag"
        :href="'/tags/' + tag.id + '/notes'"
      >#{{ tag.name }}</a>
    </h6>
    <div class="fav-and-share">
      <div class="fav-button-wrapper" v-bind:class="{ favNote: isFav, favAnime: isFavAnime }">
        <p class="text">{{ isFav ? "You\'ve liked!" : 'Like this Note!'}}</p>
        <fav-button
          class="fav-button"
          :is_fav="isFav"
          :num_of_fav="numOfFav"
          :note_id="note.id"
          @click-fav="onClickFav"
          v-bind:class="{ favNote: isFav, favAnime: isFavAnime }"
        ></fav-button>
      </div>
      <div class="line-send-wrapper">
        <img @click="confirm" class="line-send" src="/img/line_send.png" alt="line">
      </div>
    </div>

    <ul v-if="photos.length !== 0" class="photos_wrapper">
      <li v-for="photo in photos" :key="photo.id" class="photo">
        <img :src="photo.path" alt>
      </li>
    </ul>
    <p v-html="note.content" class="content"></p>
    <div class="fav-button-wrapper" v-bind:class="{ favNote: isFav, favAnime: isFavAnime }">
      <p class="text">{{ isFav ? "You\'ve liked!" : 'Like this Note!' }}</p>
      <fav-button
        class="fav-button"
        :is_fav="isFav"
        :num_of_fav="numOfFav"
        :note_id="note.id"
        @click-fav="onClickFav"
      ></fav-button>
    </div>
  </div>
</template>
<script>
export default {
  props: {
    user: {
      type: Object,
      required: true
    },
    note: {
      type: Object,
      required: true
    },
    author: {
      type: Object,
      required: true
    },
    photos: {
      type: Array,
      required: false
    },
    category: {
      type: Object,
      required: true
    },
    countries: {
      type: Array,
      required: true
    },
    tags: {
      type: Array,
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
      isBest: this.note.isBest,
      isFav: this.is_fav,
      numOfFav: this.num_of_fav,
      isFavAnime: false
    };
  },
  methods: {
    onClickFav: function() {
      if (this.isFav) {
        this.isFav = 0;
        this.numOfFav--;
        this.isFavAnime = false;
      } else {
        this.isFav = 1;
        this.numOfFav++;
        this.isFavAnime = true;
      }
    },
    confirm: function() {
      if (window.confirm("【学びの共有】にシェアしますか？")) {
        this.share();
      }
    },
    share: function() {
      this.$http
        .post("/ajax/notes/" + this.note.id + "/share")
        .then(function() {})
        .catch(function() {});
      console.log("it works!");
    }
  },
  computed: {
    topPhotoStyle: function() {
      if (this.photos.length !== 0) {
        return { backgroundImage: "url(" + this.photos[0].path + ")" };
      } else {
        return {
          backgroundImage:
            "url(/img/note_cover_photo/" + this.note.category_id + ".jpg)"
        };
      }
    },
    isEditable: function() {
      return this.user.isAdmin === 1 || this.user.id === this.author.id;
    }
  }
};
</script>
