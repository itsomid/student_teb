<script setup>
</script>
<template>
  <v-form>
    <v-row>
      <v-col cols="12">
        <slot name="body"></slot>
        <slot name="action-inline"></slot>
      </v-col>
      <v-col cols="12" class="d-flex justify-end">
        <slot name="action"></slot>
      </v-col>
    </v-row>
  </v-form>

</template>

<style scoped>
</style>
