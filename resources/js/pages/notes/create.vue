<template>
  <form>
    <v-card
      class="mx-2 mx-lg-auto mt-3 mt-lg-6 mb-6"
      style="max-width:1100px;margin:auto;"
    >
      <v-card-subtitle class="blue-grey subtitle-1 white--text">
        Create a New Note
      </v-card-subtitle>
      <v-progress-linear
        v-if="loading || submitting"
        indeterminate
        color="blue-grey darken-1"
      />
      <ValidationObserver v-if="!loading" ref="observer" v-slot="{ passes }">
        <div class="pt-2 pt-lg-3 pb-6">
          <div class="d-flex flex-wrap justify-space-between">
            <div class="px-2 px-sm-4" style="width:100%;max-width:400px;">
              <ValidationProvider
                v-slot="{ errors }"
                name="Title"
                rules="required"
              >
                <v-text-field
                  v-model="title"
                  class="mb-2"
                  :error="errors.length !== 0"
                  :disabled="submitting"
                  label="Title"
                  required
                />
              </ValidationProvider>
              <ValidationProvider
                v-slot="{ errors }"
                name="Author"
                rules="required"
              >
                <v-autocomplete
                  v-model="userId"
                  :items="users"
                  :error="errors.length !== 0"
                  :disabled="submitting"
                  item-value="id"
                  item-text="name"
                  :filter="customFilter"
                  label="Author"
                  required
                />
              </ValidationProvider>
              <ValidationProvider
                v-slot="{ errors }"
                name="Date"
                rules="required"
              >
                <v-menu
                  ref="menu"
                  v-model="menu"
                  :close-on-content-click="false"
                  :return-value.sync="date"
                  transition="scale-transition"
                  offset-y
                  min-width="290px"
                >
                  <template v-slot:activator="{ on }">
                    <v-text-field
                      v-model="date"
                      :disabled="submitting"
                      :error="errors.length !== 0"
                      label="Date"
                      readonly
                      required
                      v-on="on"
                    />
                  </template>
                  <v-date-picker v-model="date" no-title scrollable>
                    <v-spacer />
                    <v-btn text color="primary" @click="menu = false">
                      Cancel
                    </v-btn>
                    <v-btn text color="primary" @click="$refs.menu.save(date)">
                      OK
                    </v-btn>
                  </v-date-picker>
                </v-menu>
              </ValidationProvider>
              <ValidationProvider
                v-slot="{ errors }"
                name="Category"
                rules="required"
              >
                <v-select
                  v-model="categoryId"
                  :items="categories"
                  label="Category"
                  item-value="id"
                  item-text="name"
                  :disabled="submitting"
                  :error="errors.length !== 0"
                />
              </ValidationProvider>
              <v-combobox
                v-model="selectedCountries"
                class="mb-4"
                :items="countryNames"
                label="Countries"
                hint="*任意 リストにない国は直接入力してください。"
                :disabled="submitting"
                multiple
                persistent-hint
              >
                <template v-slot:selection="data">
                  <v-chip
                    :key="JSON.stringify(data.item)"
                    v-bind="data.attrs"
                    :input-value="data.selected"
                    :disabled="data.disabled"
                    @click:close="data.parent.selectItem(data.item)"
                  >
                    <v-avatar class="accent white--text" left>
                      <img
                        :src="`/img/flags/${getEnglishName(data.item)}.png`"
                      />
                    </v-avatar>
                    {{ data.item }}
                  </v-chip>
                </template>
              </v-combobox>
              <v-combobox
                v-model="selectedTags"
                class="mb-4"
                :items="tagNames"
                :disabled="submitting"
                label="Tags"
                multiple
                chips
                hint="*任意 リストにないタグも自由に入力できます。"
                persistent-hint
              />
              <v-file-input
                accept="image/png,image/jpeg,image/gif"
                show-size
                prepend-inner-icon="mdi-camera"
                :disabled="submitting"
                prepend-icon=""
                counter
                multiple
                label="Photos"
                @change="handleFilesUpload"
              />
            </div>
            <div class="flex-grow-1 px-2 px-sm-4">
              <ValidationProvider
                v-slot="{ errors }"
                name="Content"
                rules="required"
              >
                <v-textarea
                  v-model="content"
                  class="mt-3 mt-lg-5"
                  height="500px"
                  :disabled="submitting"
                  outlined
                  :error="errors.length !== 0"
                  label="Content"
                />
              </ValidationProvider>
            </div>
          </div>
          <div class="mt-2 mb-8" style="width:100%;" v-if="files.length > 0">
            <p class="body-2 mx-2 mb-3 mx-sm-4 grey--text text--darken-1">
              プレビュー（プレビューでは画像の向きが正しく表示されないことがあります。）
            </p>
            <div class="d-flex mx-2 mx-sm-4" style="overflow-x:scroll;">
              <div v-for="(file, i) in files" :key="i">
                <v-img
                  :src="generateFileUrl(file)"
                  width="200"
                  height="113"
                  class="d-block mr-4 flex-grow-0"
                  cover
                />
              </div>
            </div>
          </div>
          <v-switch
            v-model="isBest"
            :disabled="submitting"
            class="ml-4 mt-1 mt-sm-6"
            label="ベストノートに指定する"
            type="checkbox"
          />
          <v-btn
            class="white--text ml-4 mt-2 mt-sm-4"
            min-width="100px"
            :loading="submitting"
            color="blue-grey"
            large
            @click="passes(submit)"
          >
            Save
          </v-btn>
        </div>
      </ValidationObserver>
    </v-card>
  </form>
</template>
<script>
import { ValidationObserver, ValidationProvider } from 'vee-validate';
import { mapActions } from 'vuex';
export default {
  components: {
    ValidationProvider,
    ValidationObserver,
  },
  data: () => ({
    title: '',
    userId: null,
    menu: false,
    date: new Date().toISOString().substr(0, 10),
    selectedCountries: [],
    countries: [],
    selectedTags: [],
    tags: [],
    categoryId: null,
    categories: [],
    isBest: false,
    users: [],
    loading: true,
    submitting: false,
    content: '',
    files: [],
    previews: [],
  }),
  computed: {
    countryNames() {
      return this.countries.map(c => c.name);
    },
    tagNames() {
      return this.tags.map(t => t.name);
    },
    params() {
      return {
        title: this.title,
        user_id: this.userId,
        date: this.date,
        category_id: this.categoryId,
        countries: this.selectedCountries,
        tags: this.selectedTags,
        isBest: this.isBest ? 1 : 0,
        content: this.content,
        files: this.files,
      };
    },
  },
  async created() {
    if (this.$store.state.auth.user) {
      this.userId = this.$store.state.auth.user.id;
    }
    this.users = await this.getUsers();
    this.categories = await this.getCategories();
    this.tags = await this.getTags();
    this.countries = await this.getCountries();
    this.loading = false;
  },
  methods: {
    ...mapActions('user', { getUsers: 'index' }),
    ...mapActions('country', { getCountries: 'index' }),
    ...mapActions('note', {
      createNote: 'create',
      getCategories: 'categories',
      getTags: 'tags',
    }),
    async submit() {
      this.submitting = true;
      this.$refs.observer.validate();
      const note = await this.createNote(this.params);
      if (note) {
        this.$router.push(`/notes/${note.id}`);
      }
      this.submitting = false;
    },
    customFilter(item, queryText) {
      const text = item.name.toLowerCase();
      const searchText = queryText.toLowerCase();

      return text.indexOf(searchText) > -1;
    },
    getEnglishName(jpName) {
      let res = 'no_name';
      for (let i = 0; i < this.countries.length; i++) {
        if (this.countries[i].name === jpName) {
          res = this.countries[i].english_name;
          break;
        }
      }
      return res;
    },
    generateFileUrl(file) {
      return window.URL.createObjectURL(file);
    },
    handleFilesUpload(e) {
      this.files = e;
    },
  },
};
</script>
