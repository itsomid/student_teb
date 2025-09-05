<script setup>
/**
 * Vue component for a customizable dialog.
 * @typedef {Object} Props
 * @property {String} [title=""] - The title of the dialog.
 * @property {Boolean} [fullScreen=false] - Whether the dialog should occupy the full screen.
 * @property {Boolean} [scrim=true] - Whether to display a scrim behind the dialog.
 * @property {(String|Number)} [maxWidth="100%"] - The maximum width of the dialog.
 * @property {String} [width="500"] - The width of the dialog.
 * @property {String} [attach=""] - The attach property.
 * @property {String} [color=""] - The color of the dialog.
 * @property {Boolean} [blur=false] - Whether to apply a blur effect to the dialog.
 */

/**
 * Vue setup script.
 * @type {import('vue').DefineSetupFunction<Props>}
 */
const props = defineProps({
  title: {
    type: String,
    default: "",
  },
    fullScreen: {
    type: Boolean,
    default: false,
  },
  scrim: {
    type: Boolean,
    default: true,
  },
  maxWidth: {
    type: [String, Number],
    default: '100%',
  },
  width: {
    type: String,
    default: '500',
  },
  attach: {
    type: String,
    default: ""
  },
  color: {
    type: String,
    default: ""
  },
  blur: {
    type: Boolean,
    default: false,
  }
})

const model = defineModel()
</script>

<template>
    <v-dialog
        v-model="model"
        transition="dialog-bottom-transition"
        :fullscreen="fullScreen"
        :scrim="scrim"
        :width="width"
        :max-width="maxWidth"
        :class="{'blur': blur}"
    >
      <v-sheet width="100%" class="pa-3" color="transparent" elevation="0">
        <slot name="default" />
        <v-card v-if="!$slots.default" :color="color" rounded class="rounded-xl" >
          <slot name="heading"></slot>
          <v-card-title v-if="!$slots.heading" class="d-flex justify-space-between align-center">
            <div class="text-h6  ps-2">
              <slot name="title" />
              {{ title }}
            </div>

            <v-btn
                icon
                variant="text"
                @click="model = false"
            >
              <i class="icon-CL_xmark font-weight-bold text-h6"></i>
            </v-btn>
          </v-card-title>

          <v-divider />
          <slot name="content" />
          <slot name="actions" />
        </v-card>
      </v-sheet>
    </v-dialog>
</template>

<style scoped>
.blur {
  -webkit-backdrop-filter: saturate(180%) blur(15px);
  backdrop-filter: saturate(180%) blur(15px);
}

</style>
