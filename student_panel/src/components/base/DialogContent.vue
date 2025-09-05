<template>
  <v-card>
    <v-card-title class="text-body-2 text-lg-body-1">
      <slot name="title" />
    </v-card-title>
    <v-divider />
    <v-card-text>
      <slot name="body" />
    </v-card-text>
    <v-card-actions>
      <slot name="action" />
    </v-card-actions>
  </v-card>
</template>

<script setup>

</script>

<style scoped></style>
