<script setup>

import {useRoute, useRouter} from "vue-router";

const emits = defineEmits(['addedToCart']);
import {useCart} from "@/composable/useCart";
import {computed, ref} from "vue";
import {useNavigator} from "@/composable/useNavigator";
const props = defineProps({
  data: {
    type: Object,
    required: false,
  },
  selected: {
    type: Object,
    default: ()=> {}
  }
});
const route               = useRoute();
const { navigateToCart }  = useNavigator();
const product_id          = computed(()=> route.params.id);
const loading             = ref(false);
const { addPackageToCart } = useCart({emits})
const submit = async ()=>{
  const payload = [];
  if(!isValid) {
    error('شما باید در هر بخش یک درس را انتخاب کنید');
    return;
  }
  for(const key in props.selected){
    payload.push({
      section_id: key,
      product_id: props.selected[key],
    })
  }
  try {
    loading.value = true;
    await addPackageToCart({
      product_id: product_id.value,
      packages: payload,
    })
    await navigateToCart();
  }catch (e) {
    console.log(error);
  }finally {
    loading.value = false;
  }
}

const isValid = computed(()=> props.data && props.data?.sections.length === Object.keys(props.selected).length)
</script>

<template>
  <v-app-bar v-if="data.product_name" height="60" app class="pa-0" location="bottom">
    <v-btn
        class="ma-0 pa-0"
        height="80"
        color="primary"
        block
        variant="elevated"
        rounded="0"
        size="large"
        :disabled="!isValid"
        :loading="loading"
        @click.prevent="submit"
    >
      <v-icon class="rounded-lg mx-3 btn-store-class"  >
        $mdiCartPlus
      </v-icon>
      <span v-if="data.in_cart">
              ویرایش پکیج
          </span>
      <span v-else>
        افزودن به سبد خرید
      </span>
    </v-btn>
  </v-app-bar>
</template>

<style scoped lang="scss">

</style>