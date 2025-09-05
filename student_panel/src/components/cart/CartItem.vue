<script setup>
import { useUrl } from "@/composable/useUrl";
import { ref, onBeforeUnmount } from "vue";
import { DEFAULT_IMAGE_PATH } from "@/config/filePath.config";
import { useNumberFormatter } from "@/composable/useNumberFormatter";
import CartItemPackageSelection from "@/components/cart/CartItemPackageSelection.vue";
import {useCart} from "@/composable/useCart";
import {useThemeManager} from "@/composable/useThemeManager";
import { useGoogleTagManager } from "@/composable/useGtm";
import CartItemPlanZPackageSelection from "@/components/cart/CartItemPlanZPackageSelection.vue";

const emits = defineEmits([]);
const props = defineProps({
  item: {
    type: Object,
    required: true
  },
  isNonInstallmentProduct: {
    type: Boolean,
    required: true,
    default: false,
  }
});

const { trackRemoveFromCartEvent } = useGoogleTagManager();
const { numberFormatter } = useNumberFormatter();
const { imageUrlBuilder, defaultImageUrlBuilder } = useUrl();
const { removeFromCart, loading } = useCart({emits})
const { isDark } = useThemeManager();
const expand = ref(false);
const showDeleteForm = ref(false);
const confirmDelete = ref(false);


const openDeleteForm = () => {
  showDeleteForm.value = true;
  expand.value = false;
};

const closeDeleteForm = () => {
  showDeleteForm.value = false;
};

const countDown = ref(5);
const interval = ref(null);

const startTimer = () => {
  countDown.value = 5; // reset countdown
  interval.value = setInterval(() => {
    if (countDown.value < 1) {
      clearInterval(interval.value);
      // Handle actual deletion here if needed
      removeFromCart(props.item.product_id);
      // revertDeleteConfirm();
      // closeDeleteForm();
    } else {
      countDown.value -= 1;
    }
  }, 1000);
};

const confirm = () => {
  removeFromCart(props.item.product_id);
  trackRemoveFromCartEvent(props.item);
  // confirmDelete.value = true;
  // startTimer();
};

const revertDeleteConfirm = () => {
  confirmDelete.value = false;
};

const stopTimer = () => {
  clearInterval(interval.value);
  revertDeleteConfirm();
  closeDeleteForm();
};

onBeforeUnmount(() => {
  clearInterval(interval.value);
});
</script>

<template>
  <!-- Main card container for the cart item -->
  <div>
    <v-card :variant="isNonInstallmentProduct ? 'tonal' : 'flat'" :color="isNonInstallmentProduct ? 'warning' : ''" rounded="xl" border flat class="mb-4 overflow-hidden">

      <!-- Main content section of the cart item -->
      <div :class="{ 'cart-item-content_slide-x': showDeleteForm, 'disabled': confirmDelete }"
           class="d-flex flex-row align-center justify-space-between pa-4 cart-item-content">

        <!-- Left section containing product image and details -->
        <div class="d-flex flex-row align-center flex-grow-1">
          <!-- Product image/avatar -->
          <v-avatar
              tile
              rounded="xl"
              size="80"
              :image="item.product_image ? imageUrlBuilder(item.product_image, 'PRODUCT') : defaultImageUrlBuilder(isDark ? DEFAULT_IMAGE_PATH.PRODUCTS_DARK : DEFAULT_IMAGE_PATH.PRODUCTS_LIGHT)"
          />
          <!-- Product details (name, price) -->
          <div class="d-flex flex-column mr-3">
            <div>
              <h2 class="text-body-1 font-weight-bold">{{ item.product_name }}</h2>
            </div>
            <div class="text-body-2">
              <span class="text-secondary">قیمت دوره:</span>
              <!-- If the item has conditions (e.g., discount) -->
              <div v-if="item.full_price_show">
                <!-- Original price with strikethrough and discounted price -->
                <span class="text-error mr-2 text-decoration-line-through text-body-2">{{ numberFormatter(item.full_price_show) }}</span>
                <span class="text-secondary mr-1 ml-2">ریال</span>
                <span class="text-success text-body-2">{{ numberFormatter(item.product_calculated_price) }}</span>
                <span class="text-secondary mr-1 ml-2">ریال</span>
              </div>
              <!-- Otherwise, just show the regular price -->
              <span v-else>
                {{ numberFormatter(item.product_price) }}
                <span class="text-caption">ریال</span>
              </span>
              <div v-if="item.conditions.length" class="">
                <span class="text-secondary">میزان تخفیف:</span>
                {{ numberFormatter(item.product_price - item.product_calculated_price)  }}
                <span class="text-secondary text-caption">ریال</span>
              </div>
            </div>
          </div>
        </div>

        <!-- Right section with action buttons (delete, expand) -->
        <div class="d-flex flex-row align-center justify-space-between flex-shrink-1" style="gap: 8px">
          <!-- Button to open delete confirmation form -->
          <v-btn @click="openDeleteForm" rounded="lg" border flat tile size="small" icon="$mdiTrashCanOutline"></v-btn>
          <!-- Button to expand/collapse package details (if the item is a package) -->
          <v-btn v-if="item.is_package" rounded="lg" border flat tile size="small" :icon="expand ? '$mdiChevronUp' : '$mdiChevronDown'" @click="expand = !expand"></v-btn>
        </div>
      </div>

      <!-- Delete confirmation form (shows if confirmDelete is false) -->
      <div v-if="!confirmDelete"
           class="cart-item-delete-form d-flex flex-row justify-center align-center"
           :class="{ 'active': showDeleteForm, 'disabled': confirmDelete }">
        <!-- Cancel delete button -->
        <v-btn variant="text" border @click="closeDeleteForm">لغو</v-btn>
        <!-- Confirm delete button -->
        <v-btn color="error" class="mx-1" variant="elevated" @click="confirm">حذف</v-btn>
      </div>

      <!-- Alert shown during delete confirmation countdown -->
      <v-alert
          variant="tonal"
          color="info"
          position="absolute"
          type="info"
          width="100%"
          height="100%"
          class="cart-item-confirm-delete text-body-1"
          :class="{ 'active': confirmDelete }"
      >
        <div class="d-flex flex-column flex-md-row justify-center align-center" style="
gap: 3px">
          <!-- Message and option to revert deletion -->
          <div class="text-center">اگه منصرف شدی می‌تونی توی <strong>۵ ثانیه</strong> محصولت رو به سبد برگردونی!</div>
          <div class="text-center" style="gap:3px">
            <!-- Button to stop the timer and revert delete -->
            <v-btn :loading="loading" color="info" variant="outlined" size="large" rounded="lg" class="mx-2 mb-2" @click="stopTimer">برگردون به سبدم</v-btn>
            <!-- Countdown timer chip -->
            <v-chip variant="outlined" rounded="circle" size="large">{{ countDown }}</v-chip>
          </div>
        </div>
      </v-alert>

      <!-- Expandable section for package selection (if the item is a package) -->
      <v-expand-transition mode="in-out" leave-absolute hide-on-leave>
        <div v-if="expand">
          <CartItemPackageSelection v-if="item.is_package" :product-id="item.product_id" />
<!--          <CartItemPlanZPackageSelection v-else-if="item.is_planz_package" :product-id="item.product_id" />-->
        </div>
      </v-expand-transition>
    </v-card>
    <p class="font-weight-bold text-warning text-caption mt-0 mb-6" v-if="isNonInstallmentProduct">
      این دوره قابلیت قسطی شدن نداره، برای ادامه فرایند خرید به صورت قسطی لطفا این دوره رو از سبد خرید حذف کنید
    </p>
  </div>
</template>


<style scoped lang="scss">
.cart-item-content {
  transition: all 0.5s;
}
.cart-item-delete-form {
  position: absolute;
  top: 0;
  right: 0;
  width: 180px;
  height: 100%;
  transform: translateX(180px);
  transition: all 0.5s;
}
.cart-item-content_slide-x {
  transform: translateX(-180px);
}
.cart-item-delete-form.active {
  transform: translateX(0);
}
.cart-item-confirm-delete {
  height: 100%;
  top: 0;
  right: 0;
  width: 100%;
  transition: all 0.5s;
  transform: translateX(calc(100% + 180px));
}
.cart-item-confirm-delete.active {
  transform: translateX(0);
}
.cart-item-content_slide-x.disabled {
  transform: translateX(calc(-100% - 180px));
}
.cart-item-delete-form.disabled {
  transform: translateX(calc(-100%));
}
</style>
