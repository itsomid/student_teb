<script setup>
import {PRODUCT_STATUS} from "@/constants/product";
import {useNavigator} from "@/composable/useNavigator";
import {defineEmits, inject} from "vue";

const emits = defineEmits(['addedToCart']);
const props = defineProps({
  status: {
    type: String,
    required: true,
    validator: (value) => {
      return Object.values(PRODUCT_STATUS).includes(value);
    }
  },
  is_new_panel: {
    type: Boolean,
    default: false
  },
  product_id: {
    type: [String,Number],
    required: true
  },
  bottom: {
    type: Boolean,
    default: false,
  }
})

const { navigateToPlanZPackage, navigateToProduct } = useNavigator();
const newStudentPanel = inject("$newStudentPanel")

const BTN_STATE= {
  [PRODUCT_STATUS.PURCHASED]: {
    text: 'شما این پکیج را ثبت نام کرده اید',
    variant: 'tonal',
    icon: '$mdiBookmark',
    disabled: false,
    doAction:()=> {
      navigateToProduct(props.id)
    }
  },
  [PRODUCT_STATUS.IN_CART] : {
    text: 'ویرایش پکیج',
    variant: 'tonal',
    icon: '$mdiCheck',
    disabled: false,
    doAction: ()=> {
      navigateToPlanZPackage(props.product_id)
    }
  },
  [PRODUCT_STATUS.AVAILABLE] : {
    text: 'ساخت پکیج شخصی',
    variant: 'elevated',
    icon: '$mdiCheck',
    disabled: false,
    doAction: ()=> {
      if(props.is_new_panel) window.location.href = newStudentPanel;
      else navigateToPlanZPackage(props.product_id)
    }
  },
  [PRODUCT_STATUS.NOT_PURCHASABLE] : {
    text: 'ظرفیت این دوره تکمیل شده است',
    variant: 'elevated',
    icon: '$mdiAlert',
    disabled: true,
    doAction: ()=>{},
  }
}


</script>

<template>
  <v-btn
      class="ma-0 pa-0"
      :height="bottom ? 80 : 50"
      color="primary"
      :variant="BTN_STATE[status].variant"
      block
      :rounded="bottom ? '0' : 'lg'"
      size="large"
      elevation="0"
      :disabled="BTN_STATE[status].disabled"
      @click.prevent="BTN_STATE[status].doAction()">
    <v-icon class="border rounded-lg mx-3 product-card-icon product-card-icon_primary btn-store-class" >
      {{
        BTN_STATE[status].icon
      }}
    </v-icon>
    <span>
      {{ BTN_STATE[status].text }}
    </span>
  </v-btn>
</template>

<style scoped lang="scss">

</style>