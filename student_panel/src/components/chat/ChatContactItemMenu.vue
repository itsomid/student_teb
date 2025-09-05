<script setup>
import {computed, ref, watch} from "vue";
    const props = defineProps({
      user_id: {
        type: [String, Number],
        required: true,
      },
      e: Object,
    })


    const emits = defineEmits(['remove']);

    const showMenu = defineModel({default: false});

    const x = ref(0);
    const y = ref(0);
    const absolute = ref(false);

    function removeChat(id){
      emits("remove", id);
    }

    watch(computed(()=> props.e),(value)=> {
      x.value = value.clientX;
      y.value = value.clientY;
    })
</script>

<template>
  <v-menu
      v-model="showMenu"
      scrim
      location="bottom"
      width="250"
      :target="[x,y]"
      offset-y
  >
    <v-list   rounded class="text-start pa-2 rounded-xl">
      <v-list-subheader>
        عملیات
      </v-list-subheader>
      <v-divider class="mb-2"/>
      <v-list-item rounded="xl" density="compact" @click="removeChat(user_id)" prepend-icon="$mdiTrashCanOutline">
          <v-list-item-subtitle class="text--grey">حذف</v-list-item-subtitle>
      </v-list-item>

    </v-list>
  </v-menu>
</template>

<style scoped lang="scss">

</style>