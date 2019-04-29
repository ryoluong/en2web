<template>
  <div class="attendance-form">
    <p class="mtg-name">
      <i class="fas fa-exclamation"></i>
      出席管理中：{{ active_meeting.name }}
    </p>
    <div class="radio-wrapper">
      <input
        class="input-radio"
        id="attend"
        type="radio"
        name="status"
        v-model="answer"
        value="attend"
      >
      <label class="label-radio" for="attend">出席</label>
      <input class="input-radio" id="late" type="radio" name="status" v-model="answer" value="late">
      <label class="label-radio" for="late">遅刻</label>
      <input
        class="input-radio"
        id="early"
        type="radio"
        name="status"
        v-model="answer"
        value="early"
      >
      <label class="label-radio" for="early">早退</label>
    </div>
    <p class="comment">*欠席の場合は回答不要です。</p>
    <div class="button-wrapper">
      <button class="submit-btn bluebtn" @click="confirm">送信</button>
    </div>
  </div>
</template>
<script>
export default {
  props: {
    active_meeting: {
      type: Object,
      required: true
    }
  },
  data() {
    return {
      answer: "attend",
      answerLabel: {
        attend: "出席",
        early: "早退",
        late: "遅刻"
      }
    };
  },
  computed: {
    params() {
      return { status: this.answer };
    }
  },
  methods: {
    confirm() {
      if (
        window.confirm(
          '"' +
            this.answerLabel[this.answer] +
            '" で回答を送信します。\nよろしいですか？'
        )
      ) {
        this.sendAnswer();
      }
    },
    sendAnswer() {
      this.$http
        .post("/ajax/attend", this.params)
        .then(function() {
          location.href = "/attendance";
        })
        .catch(function() {
          alert("エラーが発生しました。");
        });
    }
  }
};
</script>

