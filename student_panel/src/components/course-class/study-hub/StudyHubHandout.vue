<script setup>
import {useUrl} from "@/composable/useUrl";

const props = defineProps({
  handoutLink : [String,Object],
  loading: Boolean,
})

const { defaultImageUrlBuilder } = useUrl();
</script>

<template>
  <v-hover>
    <template v-slot:default="{ isHovering,props }">
      <v-card
          v-bind="props"
          :elevation="isHovering ? 8 : $vuetify.display.smAndDown ? 3 : 0"
          rounded="xl"
          class="d-flex flex-column justify-center align-center flex-grow-1"
       >
        <v-skeleton-loader v-if="loading" min-width="200" type="card" ></v-skeleton-loader>
        <v-card-text v-else class="d-flex flex-column justify-center align-center text-secondary">
          <v-icon size="x-large" color="secondary">$mdiFileDownloadOutline</v-icon>
          <p class="mt-3">دریافت جزوه</p>
          <v-btn
              :disabled="!handoutLink"
              :href="handoutLink"
              class="mt-1"
              variant="text"
              color="primary"
              target="_blank"
              rounded="lg"
          >
            دانلود PDF
            <v-icon>$mdiChevronLeft</v-icon>
          </v-btn>
        </v-card-text>
      </v-card>
    </template>
  </v-hover>
</template>

<style scoped lang="scss">

</style>