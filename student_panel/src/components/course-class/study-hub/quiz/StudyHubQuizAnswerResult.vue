<script setup>
  import {ref} from "vue";

  const props = defineProps({
    data: {
      type: Object,
      required: true
    }
  })

  const value = ref( [0, 2]);
  const value2 = ref( [0, 12]);
</script>

<template>
  <v-item-group >
    <v-row>
      <v-col
          v-for="(item,key, index) in data"
          :key="'result-item-' + index"
          cols="12"
          lg="3"
          md="4"
      >
        <v-item>
          <v-card
              dark
              width="100%"
              rounded="xl"
              variant="elevated"
              height="100%"
          >
            <v-card-text class="text-center pa-8">
              <div class="d-flex flex-column justify-center align-center text-body-2 font-weight-bold" style="width: 100%">
                <v-icon  size="35" class="my-3">{{ item.icon }}</v-icon>
                <span class="text-body-1"> {{ item.title }} : {{ Math.round(item.value) }}</span>
                <v-progress-circular v-if="['correct_answers','wrong_answers'].includes(key)" class="mt-3" :model-value="item.percent" :rotate="360" :size="100" :width="15" :color="item.color">
                  <template v-slot:default> {{ item.percent.toFixed(0) }} %</template>
                </v-progress-circular>
                <v-progress-circular v-else class="mt-3" :model-value="item.value" :rotate="360" :size="100" :width="15" :color="item.color">
                  <template v-slot:default> {{ Math.round(item.value) }} %</template>
                </v-progress-circular>
              </div>
            </v-card-text>
          </v-card>
        </v-item>
      </v-col>
      <v-col cols="12" lg="3">
        <v-card
            dark
            width="100%"
            height="100%"
            rounded="xl"
            variant="elevated"
        >
          <v-card-text class="text-center pa-8">
            <div class="d-flex flex-column justify-center align-center text-body-2 font-weight-bold" style="width: 100%">
              <v-icon  size="35" class="my-3">$mdiFinance</v-icon>
              <span class="text-body-1"> آنالیز آزمون </span>
              <div>
                <v-hover>
                  <template v-slot:default="{ isHovering, props }">
                <v-progress-circular v-bind="props" class="mt-3" :model-value="data['correct_answers'].percent - data['score'].value" :rotate="(360 * data['score'].value)/100" :size="100" :width="15" color="success">
                  <template v-slot:default>
                    <v-hover>
                      <template v-slot:default="{ isHovering, props }">
                        <v-progress-circular v-bind="props"  :model-value="data['score'].value" :rotate="360" :size="100" :width="15" :color="isHovering ? 'error' : 'info'">

                          <template v-slot:default>
                            <span class="text-success">{{ data['correct_answers'].percent.toFixed(0)}} %</span></template>
                        </v-progress-circular>
                      </template>
                    </v-hover>
                  </template>
                </v-progress-circular>
                  </template>
                </v-hover>
                <div class="mt-3">
                  <v-chip rounded="xl" variant="elevated" size="x-small" class="mx-1 px-2 mt-1" color="info">نتیجه فعلی</v-chip>
                  <v-chip rounded="xl" variant="elevated" size="x-small" class="mx-1 px-2 mt-1" color="success">نتیجه بدون پاسخ غلط</v-chip>
                </div>
              </div>
            </div>
          </v-card-text>

        </v-card>
      </v-col>
    </v-row>
  </v-item-group>
</template>

<style scoped lang="scss">
.stackSpark {
  position: absolute;
  top: 12px;
  left: 15px;
}
</style>