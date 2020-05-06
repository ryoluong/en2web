<template>
  <FormCard
    title="Upload Icon"
    :show-progress="loading"
    :show-content="!loading"
    class="max-width"
  >
    <ValidationObserver v-if="!loading" ref="observer" v-slot="{ passes }">
      <div class="px-4">
        <ValidationProvider v-slot="{ errors }" name="Icon" rules="image">
          <v-file-input
            accept="image/png,image/jpeg,image/gif"
            show-size
            prepend-inner-icon="mdi-camera"
            :error-messages="errors"
            prepend-icon=""
            :disabled="submitting || uploading"
            label="Select Image"
            @change="handleFileUpload"
          />
        </ValidationProvider>
        <div class="preview-container">
          <p v-if="uploading" class="pa-0 ma-auto text-center">
            ファイルをアップロード中です...
          </p>
          <p v-else-if="!previewPath" class="pa-0 ma-auto text-center">
            ここにプレビューが表示されます。
          </p>
          <v-avatar v-else class="ma-auto" size="120">
            <v-img :src="previewPath" />
          </v-avatar>
        </div>
      </div>
      <v-btn
        class="white--text ml-4 mt-6 d-block"
        min-width="100px"
        :loading="submitting"
        :disabled="uploading || !previewPath"
        color="blue-grey"
        large
        @click="passes(submit)"
      >
        Save
      </v-btn>
    </ValidationObserver>
  </FormCard>
</template>
<script>
import FormCard from '@/js/components/FormCard.vue';
import { ValidationObserver, ValidationProvider } from 'vee-validate';
import { mapActions } from 'vuex';
export default {
  components: {
    FormCard,
    ValidationProvider,
    ValidationObserver,
  },
  data: () => ({
    loading: false,
    canSubmit: false,
    uploading: false,
    submitting: false,
    file: null,
    previewPath: null,
  }),
  computed: {
    params() {
      return {
        type: 'avatar',
        file: this.file,
      };
    },
  },
  methods: {
    ...mapActions('user', ['upload', 'saveIcon']),
    async handleFileUpload(e) {
      if (e && e['type'].split('/')[0] === 'image') {
        this.uploading = true;
        this.file = e;
        this.previewPath = await this.upload(this.params);
        this.uploading = false;
      }
    },
    async submit() {
      this.submitting = true;
      const user = await this.saveIcon({ path: this.previewPath });
      if (user) {
        this.$router.push('/mypage');
      }
      this.submitting = false;
    },
  },
};
</script>
<style lang="scss" scoped>
.preview-container {
  height: 150px;
  display: flex;
  align-items: center;
  justify-items: center;
  border: 1px dashed #aaa;
  color: #888;
}
</style>
