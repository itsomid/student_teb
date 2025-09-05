<script setup>
const uploadHints = [
  {
    text:   "توجه کنید فرمت عکس فقط (jpg,png,jpeg) باشد.",
    icon: "$mdiImageOutline"
  },
  {
    text:       " حداکثر ۲۰ عکس میتوانید آپلود کنید.",
    icon: "$mdiImageMultipleOutline",
  },
  {
    text:    " محدودیت حجم برای فایل تصاویر وجود ندارد",
    icon: "$mdiImageSizeSelectLarge"
  }
]
</script>

<template>
  <v-item-group selected-class="bg-primary">
    <v-container>
      <v-row>
        <v-col
            v-for="(hint, index) in uploadHints"
            :key="'upload-report-hint-' + index"
            cols="12"
            md="4"
        >
          <v-item>
            <v-hover>
              <template v-slot:default="{ isHovering,props }">
                <v-card
                    v-bind="props"
                    class="d-flex flex-column justify-center align-center"
                    dark
                    rounded="xl"
                    :variant="isHovering ? 'tonal' :'text'"
                    :color="isHovering ? 'primary' : 'secondary'"
                >
                  <v-card-text class="text-center pa-8">
                    <div class="d-flex flex-column justify-center align-center text-body-2 font-weight-bold">
                      <v-icon  size="35" class="my-3">{{ hint.icon }}</v-icon>
                     <span > {{ hint.text }}</span>
                    </div>
                  </v-card-text>
                </v-card>
              </template>
            </v-hover>
          </v-item>
        </v-col>
      </v-row>
    </v-container>
  </v-item-group>
</template>

<style scoped lang="scss">

</style>