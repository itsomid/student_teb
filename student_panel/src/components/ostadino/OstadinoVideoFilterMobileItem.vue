<script setup>
import { ref, onBeforeUnmount } from "vue";


const emits = defineEmits([]);
const props = defineProps({
  title: {
    type: String,
    required: true
  },
  items: {
    type: Array,
    required: true
  },
});

const expand = ref(false);
const selectedItems = defineModel();

</script>

<template>
  <!-- Main card container for the cart item -->
  <div>
    <v-card variant="tonal" :color="expand ? 'primary' : ''" @click="expand = !expand" rounded="lg"  flat class="mb-4">
      <div
           class="d-flex flex-row align-center justify-space-between pa-4">

        <!-- Left section containing product image and details -->
        <div class="d-flex flex-row align-center flex-grow-1" :class="{'font-weight-bold' : expand}">
          {{  title }}
        </div>

        <!-- Right section with action buttons (delete, expand) -->
        <div class="d-flex flex-row align-center justify-space-between flex-shrink-1">
          <!-- Button to expand/collapse package details (if the item is a package) -->
          <v-btn  rounded="lg"  flat tile size="small"  @click.stop.prevent="expand = !expand">
            <v-icon :color="expand ? '': ''" :icon="expand ? 'cli:ArrowUp2' : 'cli:ArrowDown2'" type="bold">
            </v-icon>
          </v-btn>
        </div>
      </div>
    </v-card>
    <v-expand-transition mode="out-in">
      <v-card-text v-if="expand" class="bg-surface" >
        <v-list
            v-model:selected="selectedItems"
            select-strategy="leaf"
        >
          <v-list-item
              v-for="item in items"
              :key="item.id"
              :title="item.name"
              :value="item"
              density="compact"
              variant="text"
              rounded="lg"
              class="my-1"
          >
            <template v-slot:append="{ isSelected }">
              <v-list-item-action start>
                <v-checkbox-btn color="primary" :model-value="isSelected"></v-checkbox-btn>
              </v-list-item-action>
            </template>
          </v-list-item>
        </v-list>
      </v-card-text>
    </v-expand-transition>
  </div>
</template>


<style scoped lang="scss">

</style>
