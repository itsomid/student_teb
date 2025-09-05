<!--
    @created        18/09/2023 - 20:03
    @author         Nariman Palangi
    @user           ragnarok  
    @organization   
    @project        hr-rd
    @file name      BreadCrumb.vue
    @file dir       src/components/base-components
-->
<script setup>
import {computed} from "vue";

const props = defineProps({
  items: {
    type: Array,
    required: true,
  }
});

const items = computed(()=> props.items.map((item,index)=> {
  return {
    title: item.meta.title,
    disabled: (props.items.length - 1) === index,
    to: {name: item.name},
  };
}))
</script>

<template>
  <v-breadcrumbs :items="items">

  </v-breadcrumbs>
</template>

<style scoped>

</style>