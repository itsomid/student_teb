<script setup>
import {PRODUCT_STATUS} from "@/constants/product";
import {useNavigator} from "@/composable/useNavigator";
import {useCart} from "@/composable/useCart";
import {defineEmits,inject} from "vue";

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
    course_id: {
      type: [String,Number],
    },
    bottom: {
      type: Boolean,
      default: false,
    }
  })
const emits = defineEmits(['addedToCart']);
const { loading, buyForFree, addToCart } = useCart({emits});
const { navigateToCourse, navigateToProduct, navigateToCart } = useNavigator();

const newStudentPanel = inject("$newStudentPanel")

const BTN_STATE= {
  [PRODUCT_STATUS.PURCHASED]: {
    text: 'شما این دوره را ثبت نام کرده اید',
    variant: 'tonal',
    icon: '$mdiBookmark',
    iconClass: 'border rounded-lg mx-1 product-card-icon product-card-icon_primary',
    disabled: false,
    doAction:()=> {
      navigateToCourse(props.course_id)
    }
  },
  [PRODUCT_STATUS.IN_CART] : {
    text: 'به سبد خرید افزوده شد',
    variant: 'outlined',
    icon: '$mdiCheck',
    iconClass: 'border rounded-lg mx-1 product-card-icon product-card-icon_primary',
    disabled: false,
    doAction: ()=> {
      navigateToProduct(props.product_id)
    }
  },
  [PRODUCT_STATUS.FREE] : {
    text: 'افزودن به دوره‌های من',
    variant: 'elevated',
    icon: '$mdiPlus',
    iconClass: 'border rounded-lg mx-1 product-card-icon product-card-icon_primary',
    disabled: false,
    doAction: ()=> {
      buyForFree(props.product_id)
    }
  },
  [PRODUCT_STATUS.AVAILABLE] : {
    text: 'افزودن به سبد خرید',
    variant: 'elevated',
    icon: '$mdiCartPlus',
    iconClass: 'mx-3',
    disabled: false,
    doAction: ()=> {
      if(props.is_new_panel) window.location.href = newStudentPanel;
      else {
        addToCart(props.product_id);
        setTimeout(()=>{
          navigateToCart();
        },200);
      }
    }
  },
  [PRODUCT_STATUS.NOT_PURCHASABLE] : {
    text: 'قابل خرید مجزا نیست',
    variant: 'elevated',
    icon: '$mdiAlert',
    iconClass: 'border rounded-lg mx-1 product-card-icon product-card-icon_primary',
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
         :loading="loading"
         :disabled="BTN_STATE[status].disabled || loading"
         @click.prevent="BTN_STATE[status].doAction()">
    <v-icon :class="BTN_STATE[status].iconClass" class="btn-store-class">
      {{
        BTN_STATE[status].icon
      }}
    </v-icon>
    <span class="text-subtitle-2">
      {{ BTN_STATE[status].text }}
    </span>
  </v-btn>
</template>

<style scoped lang="scss">

</style>