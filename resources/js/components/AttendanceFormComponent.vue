<template>
  <div class="attendance-form">
    <p class="mtg-name">
      <i class="fas fa-exclamation"></i>
      出席管理中：{{ active_meeting.name }}
    </p>
    <p
      class="answer-status"
      v-if="default_answer != 'none'"
    >{{ "「" + answerLabel[default_answer] + "」で回答されています。" }}</p>
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
      <input
        id="absent"
        type="radio"
        class="input-radio"
        name="status"
        v-model="answer"
        value="absent"
      >
      <label for="absent" class="label-radio">欠席</label>
    </div>
    <div class="button-wrapper">
      <button
        class="submit-btn bluebtn widebtn"
        @click="confirm"
      >{{ default_answer != 'none' ? '回答を更新' : '送信'}}</button>
    </div>
  </div>
</template>
<script>
export default {
  props: {
    active_meeting: {
      type: Object,
      required: true
    },
    default_answer: {
      type: String,
      required: false
    }
  },
  data() {
    return {
      answer: this.default_answer,
      answerLabel: {
        attend: "出席",
        early: "早退",
        late: "遅刻",
        absent: "欠席",
        overseas: "留学中"
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
      if (this.answer != "none") {
        if (
          window.confirm(
            "｢" +
              this.answerLabel[this.answer] +
              (this.default_answer == "none"
                ? "｣ で回答を送信します。\nよろしいですか？"
                : "｣ で回答を更新します。\nよろしいですか？")
          )
        ) {
          this.sendAnswer();
        }
      } else {
        alert("回答を選択してください");
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

