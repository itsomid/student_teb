<script setup>
  import ClImage from "@/components/base/ClImage.vue";
  import {DEFAULT_IMAGE_PATH} from "@/config/filePath.config";
  import {useUrl} from "@/composable/useUrl";

  const props = defineProps(['item']);
  const { imageUrlBuilder, defaultImageUrlBuilder } = useUrl();
</script>

<template>
  <div>
    <div v-if="item.is_banner" class="text-right">
      <div class="mt-4">
        <v-img class="rounded-xl" :src="imageUrlBuilder(item.img_filename,'ANNOUNCEMENT')" :alt="item.title" />
      </div>
      <p class="mt-4 text-subtitle-1 font-weight-bold">
        {{ item.title }}
      </p>

      <v-dialog max-width="650">
        <template v-slot:activator="{ props: activatorProps }">
          <v-btn v-if="item.ext_url" v-bind="activatorProps" block variant="outlined" rounded="lg" color="primary" class="mt-4">
            مشاهده
            <v-icon>$mdiChevronLeft</v-icon>
          </v-btn>
        </template>

        <template v-slot:default="{ isActive }">
          <v-card>
            <v-img width="100%" :src="imageUrlBuilder(item.img_filename,'ANNOUNCEMENT')" :alt="item.description"></v-img>
            <v-card-text class="d-flex justify-start w-100" :class="[$vuetify.display.mobile?'flex-column justify-center':'flex-row']">
              <div>
                <h2 class="font-weight-bold" :class="[$vuetify.display.mobile?'':'mb-5']">
                  {{ item.title }}
                </h2>
                <span v-html="item.subtitle"></span>
              </div>
              <div :class="[$vuetify.display.mobile?'mt-6':'mr-14']" v-html="item.description">
              </div>
            </v-card-text>
            <v-card-actions class="d-flex  mb-5" :class="[$vuetify.display.mobile?'justify-space-around':'justify-center']">
              <v-btn
                  variant="outlined" rounded="lg" color="primary"
                  text="بازگشت"
                  :width="$vuetify.display.mobile? '135px':'200px'"
                  width="200px"
                  @click="isActive.value = false"
              ></v-btn>
              <v-btn
                  variant="flat"
                  color="primary"
                  :width="$vuetify.display.mobile? '135px':'200px'"
                  rounded="lg"
                  text="ادامه"
                  :href="item.ext_url"
                  @click="isActive.value = false"
              ></v-btn>
            </v-card-actions>
          </v-card>
        </template>
      </v-dialog>

    </div>
    <v-sheet
        v-else
        tile
        class="d-flex flex-column mt-4 text-right"
    >
      <h5 class="text-subtitle-1 font-weight-bold">{{ item.title }}</h5>
      <p class="text-subtitle-2">{{ item.description }}</p>
      <v-btn v-if="item.ext_url" :href="item.ext_url" block variant="outlined" rounded="lg" color="primary" class="mt-4">
        مشاهده
        <v-icon>$mdiChevronLeft</v-icon>
      </v-btn>
    </v-sheet>
    <v-divider class="my-6" />
  </div>
</template>

<style scoped lang="scss">

</style>