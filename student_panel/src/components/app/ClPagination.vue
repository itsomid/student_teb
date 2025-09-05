<script setup>
  const props = defineProps({
    /**
     * @description Specify the max total visible pagination numbers
     * @type {number}
     * */
    totalVisible: {
      type: Number,
      default: 5
    },

    /**
     * @description The length of the pagination component
     * @type {Number}
     * */
    totalPages: {
      type: Number,
      required: true,
    },

    size: {
      type: String,
      default: 'x-small'
    },
  })
  const page = defineModel({default: 1});
</script>

<template>
  <v-pagination
      v-model="page"
      :length="totalPages"
      :total-visible="totalVisible"
      rounded="lg"
      color="primary"
      :size="size"
  ></v-pagination>
</template>

<style scoped lang="scss">

</style>
