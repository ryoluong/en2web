<template>
  <div>
    <div class="form_view">
      <div class="property">
        <p>学科編成</p>
      </div>
      <div class="value">
        <div class="radio_wrapper">
          <label for="show-new-old">
            <input
              id="show-new-old"
              class="radio_button"
              name="selection"
              v-model="showNew"
              type="radio"
              value="1"
              @change="switchNewOld"
            >2017年度以降
          </label>
        </div>
        <div class="radio_wrapper">
          <label for="show-new-false">
            <input
              id="show-new-false"
              class="radio_button"
              name="selection"
              v-model="showNew"
              type="radio"
              value="0"
              @change="switchNewOld"
            >2016年度以前
          </label>
        </div>
      </div>
    </div>
    <div class="form_view">
      <div class="property">
        <p>学部（必須）</p>
      </div>
      <div class="value">
        <select
          id="newDepartments"
          class="input_select switch"
          name="department"
          v-model="department"
        >
          <option v-for="key of Object.keys(departments)" :key="key" :value="key">{{ key }}</option>
        </select>
      </div>
    </div>
    <div class="form_view">
      <div class="property">
        <p>学科（必須）</p>
      </div>
      <div class="value">
        <select id="newMajors" class="input_select switch" name="major" v-model="major">
          <option v-for="key of Object.keys(majors)" :key="key" :value="key">{{ key }}</option>
        </select>
        <input type="hidden" name="department_id" :value="departments[department][major]">
      </div>
    </div>
  </div>
</template>
<script>
export default {
  props: {},
  data() {
    return {
      showNew: 1,
      department: "経済学部",
      major: "経済学科"
    };
  },
  mounted() {
    if (sessionStorage.showNew) {
      this.showNew = sessionStorage.showNew;
    }
    if (sessionStorage.department) {
      this.department = sessionStorage.department;
    }
    if (sessionStorage.major) {
      this.major = sessionStorage.major;
    }
  },
  watch: {
    showNew(newShowNew) {
      sessionStorage.showNew = newShowNew;
    },
    department(newDepartment) {
      sessionStorage.department = newDepartment;
      this.major = Object.keys(this.departments[this.department])[0];
    },
    major(newMajor) {
      sessionStorage.major = newMajor;
    }
  },
  methods: {
    switchNewOld() {
      this.department = "経済学部";
      if (this.showNew == 1) {
        this.major = "経済学科";
      } else {
        this.major = "国際経済学科";
      }
    }
  },
  computed: {
    departments() {
      if (this.showNew == 1) {
        return {
          経済学部: {
            経済学科: 1
          },
          経営学部: {
            経営学科: 2
          },
          教育学部: {
            教育学科: 3
          },
          都市科学部: {
            都市社会共生学科: 4,
            環境リスク共生学科: 4,
            都市基盤学科: 4,
            建築学科: 4
          },
          理工学部: {
            "機械・材料・海洋系学科": 5,
            "化学・生命系学科": 5,
            "数物・電子情報系学科": 5
          }
        };
      } else {
        return {
          経済学部: {
            国際経済学科: 1,
            経済システム学科: 1
          },
          経営学部: {
            経営学科: 2,
            "会計・情報学科": 2,
            経営システム学科: 2,
            国際経営学科: 2
          },
          教育人間科学部: {
            学校教育課程: 3,
            人間文化課程: 4
          },
          理工学部: {
            "機械工学・材料系学科": 5,
            "化学・生命系学科": 5,
            "建築都市・環境系学科": 4,
            "数物・電子情報系学科": 5
          }
        };
      }
    },
    majors() {
      return this.departments[this.department];
    }
  }
};
</script>