<script setup>
  import {useUrl} from "@/composable/useUrl";
  import {computed, ref, watch} from "vue";
  import {useStore} from "vuex";

  const props = defineProps({
        professors: {
          type: Array,
          required: true,
          default: ()=> [],
        }
      })
  const { imageUrlBuilder,defaultImageUrlBuilder } = useUrl();
  const panel = ref([]);

  const store = useStore();

  watch(()=>store.getters['shop/selectedProfessor'], (value)=> {
   panel.value = [];
   panel.value.push(value);
  }, { immediate: true})
</script>

<template>
  <div>
    <v-expansion-panels v-if="professors.length" rounded="xl" v-model="panel">
      <v-expansion-panel
          v-for="item in professors"
          :key="'professor-' + item"
          :value="item.id"
          :readonly="!Boolean(item?.bio?.length)"
      >
        <v-expansion-panel-title>
          <template v-slot:default="{ expanded }">
            <v-avatar
                color="white"
                class="flex-shrink-1"
                :image="item.img ? imageUrlBuilder(item.img, 'PROFILE') : defaultImageUrlBuilder('assets/images/default/avatars/avatar-default.png')">
            </v-avatar>
            <div class="mx-3">{{  item.name }}</div>
            <v-spacer />
            <span v-if="!expanded && Boolean(item?.bio?.length)" class="text-caption">
              رزومه استاد
            </span>
          </template>
          <template #actions>

          </template>
        </v-expansion-panel-title>
        <v-expansion-panel-text>
          <div class="pa-1" v-html="item.bio">
          </div>
        </v-expansion-panel-text>
      </v-expansion-panel>
    </v-expansion-panels>
    <div v-else class="d-flex flex-column justify-center align-center pa-4">
      <v-img max-width="64" width="64" :src="defaultImageUrlBuilder('assets/images/empty/empty-state-content.png')"/>
      <p class="font-weight-bold">محتوایی برای نمایش نیست</p>
    </div>
  </div>
</template>

<style scoped lang="scss">

</style>