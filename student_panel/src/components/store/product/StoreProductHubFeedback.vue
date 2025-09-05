<script setup>
  import {useUrl} from "../../../composable/useUrl";

  const props = defineProps({
    comments: {
      type: Array,
      default: ()=> [],
    }
  });

  const { imageUrlBuilder, defaultImageUrlBuilder } = useUrl();
  const avatarSelector = function (avatar) {
    return avatar ? imageUrlBuilder(avatar, 'PRODUCT') : defaultImageUrlBuilder('assets/images/default/avatars/avatar-default.png')
  }
</script>

<template>
  <div>
    <div v-if="comments.length" >
      <p>نظرات ثبت شده درباره این دوره:</p>
      <v-card rounded="xl" variant="text" class="mt-4">
        <v-card-text class="pa-0">
          <V-list variant="text"  rounded="xl" max-width="500" class="pl-4">
            <template v-for="(item,index) in comments" :key="'comments-' + item.comment_id">
              <v-list-item  lines="three" :prepend-avatar="avatarSelector(item.avatar)" >
                <v-list-item-title>{{ item.user_name }}</v-list-item-title>
                <v-list-item-subtitle>
                  <div v-html="item.comment"></div>
                </v-list-item-subtitle>
              </v-list-item>
              <v-divider inset v-if="index < comments.length - 1"/>
            </template>
          </V-list>
        </v-card-text>
      </v-card>
    </div>
    <div v-else class="d-flex flex-column justify-center align-center pa-4">
      <v-img max-width="64" width="64" :src="defaultImageUrlBuilder('assets/images/empty/empty-state-content.png')"/>
      <p class="font-weight-bold">محتوایی برای نمایش نیست</p>
    </div>
  </div>
</template>

<style scoped lang="scss">

</style>