<script setup>
import {computed, ref} from "vue";
const props = defineProps(["input"])
const showDatePicker = ref(false)

const currentValue = ref(props.input.currentValue)
const items =ref(props.input.value)

const maxColorCount = computed(()=>{return props.input.max <= props.input.value.length})

const isValidate= computed(()=>{
  return !!(currentValue.value.value && currentValue.value.title)
})
function saveItems(){
  if(!isValidate.value)return
  showDatePicker.value=false;
  items.value.push(currentValue.value)
  currentValue.value={value:null ,title:""}
}
function deleteColor(color){
  items.value.splice(color,1)
}

</script>
<template>
  <div class="d-flex justify-center align-start position-relative" >
    <!--title input -->
    <v-text-field
        label="نام رنگ"
        placeholder="لطفا نام رنگ را وارد کنید"
        v-model="currentValue.title"
        :clearable="props.input.clearable"
        :disabled="maxColorCount"
        v-bind="$attrs"
        variant="outlined"
    ></v-text-field>

     <v-divider  class="mx-1" :thickness="2" vertical style="height: 60px !important;"></v-divider>

    <!--hexCode input -->
    <v-text-field
        label="کد رنگ"
        placeholder="لطفا کد رنگ را وارد کنید"
        variant="outlined"
        :clearable="props.input.clearable"
        :disabled="maxColorCount"
        v-bind="$attrs"
        @click="showDatePicker = true"
        v-model="currentValue.value"
    ></v-text-field>

    <v-divider  class="mx-1" :thickness="2" vertical style="height: 60px !important;"></v-divider>

    <!--submit -->
    <v-btn  :disabled="maxColorCount || !isValidate" @click="saveItems()" height="55" class="bg-info">+</v-btn>

    <!--color picker-->
    <v-color-picker  v-show="showDatePicker" position="sticky"
                    v-model="currentValue.value" style="position: absolute;
     top:65px;left:0">
    </v-color-picker>
  </div>

  <!--colors-->
  <div class="d-flex flex-wrap">
    <template v-for="(color,index) in items" :key="index">
      <v-chip class="d-flex justify-space-between   px-3 py-1">
        <v-avatar size="20" :color="color.value" class="ml-3"></v-avatar>
       <span class="ml-12">
         {{color.title}}
       </span>
        <v-icon @click="deleteColor(index)" class="mr-auto">mdi-close</v-icon>
      </v-chip>
    </template>
  </div>
</template>

<style scoped>
</style>
