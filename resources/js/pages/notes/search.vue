<template>
  <FormCard
    class="max-width"
    title="Search"
    :show-progress="false"
    :show-content="true"
  >
    <div class="px-2 px-sm-4">
      <v-text-field
        v-model="params.keyword"
        label="Free word"
        prepend-icon="mdi-text-search"
        clearable
      />
      <v-autocomplete
        v-model="params.user_id"
        :items="users"
        label="Author"
        item-value="id"
        item-text="name"
        :disabled="submitting"
        :filter="customFilter"
        :menu-props="{ maxHeight: 180 }"
        prepend-icon="mdi-account-edit"
        clearable
      />
      <v-select
        v-model="params.category_id"
        :items="categories"
        label="Category"
        item-value="id"
        item-text="name"
        :disabled="submitting"
        prepend-icon="mdi-folder-outline"
        clearable
      />
      <v-select
        v-model="params.country_id"
        :items="countries"
        label="Country"
        item-value="country_id"
        item-text="name"
        :disabled="submitting"
        prepend-icon="mdi-earth"
        clearable
      />
      <v-select
        v-model="params.tag_id"
        :items="tags"
        label="Tag"
        item-value="id"
        item-text="name"
        :disabled="submitting"
        prepend-icon="mdi-tag"
        clearable
      />
      <v-select
        v-model="params.is_best"
        :items="[{ value: 1, text: 'ベストノートのみ' }]"
        item-value="value"
        item-text="text"
        label="Best Note"
        :disabled="submitting"
        prepend-icon="mdi-star"
        clearable
      />
      <v-btn
        class="white--text ml-1 mt-4 d-block"
        min-width="100px"
        :loading="submitting"
        color="blue-grey"
        large
        @click="search"
      >
        Search
      </v-btn>
    </div>
  </FormCard>
</template>
<script>
import { mapActions, mapMutations } from 'vuex';
import FormCard from '@/js/components/FormCard.vue';
export default {
  components: {
    FormCard,
  },
  data: () => ({
    params: {
      keyword: '',
      country_id: 0,
      category_id: 0,
      tag_id: 0,
      user_id: 0,
      is_best: 0,
    },
    users: [],
    categories: [],
    tags: [],
    countries: [],
    submitting: false,
  }),
  mounted() {
    this.params = this.$store.state.note.params;
  },
  async created() {
    this.categories = await this.getCategories();
    this.tags = await this.getTags();
    this.users = await this.getUsers();
    this.countries = await this.getCountries();
  },
  methods: {
    ...mapActions('user', { getUsers: 'index' }),
    ...mapActions('country', { getCountries: 'index' }),
    ...mapActions('note', {
      getCategories: 'categories',
      getTags: 'tags',
    }),
    ...mapMutations('note', ['setParams']),
    customFilter(item, queryText) {
      const text = item.name.toLowerCase();
      const searchText = queryText.toLowerCase();

      return text.indexOf(searchText) > -1;
    },
    search() {
      const params = this.params;
      this.setParams(params);
      Object.keys(this.params).forEach(v => {
        if (!params[v]) {
          delete params[v];
        }
      });
      this.$router.push({
        name: 'note.index',
        query: params,
      });
    },
  },
};
</script>
