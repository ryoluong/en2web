<template>
  <div class="max-width">
    <v-list class="py-0">
      <v-list-item
        v-for="item in items"
        :key="item.text"
        ripple
        two-line
        :to="item.to"
      >
        <v-list-item-icon class="my-auto">
          <v-icon size="28" color="#559">
            {{ item.icon }}
          </v-icon>
        </v-list-item-icon>
        <v-list-item-content class="subtitle-1">
          {{ item.text }}
        </v-list-item-content>
      </v-list-item>
    </v-list>
  </div>
</template>
<script>
export default {
  data: () => ({
    items: [
      {
        icon: 'mdi-pencil',
        text: 'プロフィールの編集',
        to: '/settings/profile',
      },
      {
        icon: 'mdi-face',
        text: 'ユーザーアイコンの変更',
        to: '/settings/icon',
      },
      // {
      //   icon: 'mdi-image',
      //   text: 'カバーイメージの変更',
      //   to: '/settings/image',
      // },
    ],
  }),
};
</script>
