<script setup>
import {computed, onMounted, ref} from "vue";
  import RepositoryFactory from "@/repository/RepositoryFactory";
  import {useAlert} from "@/composable/useAlert";
import {useStore} from "vuex";

  const store               = useStore();
  const { success, error }  = useAlert();
  const loading             = ref(false);
  const CartRepository      = RepositoryFactory.get("Cart");
  const discountForm        = ref(null);
  const discount            = ref("");
  const discountRules       = ref([
    v => !!v || 'کد تخفیف وارد نشده است.',
  ])
  const addedDiscount       = computed(()=> store.getters['cartStore/discount']);


  const updateCart = async ()=> {
    const {data: { data }} = await CartRepository.getUserCart();
    await store.dispatch('cartStore/updateCart', data);
  }

  const addDiscount = async ()=> {
    const { valid } = await discountForm.value.validate();
    if(!valid) return;
    try {
      loading.value = true;
      const { data } = await CartRepository.addDiscount({coupon: discount.value});
      success(data.message)
      await updateCart();

    }catch (e) {
      if (e.error.status === 409 || e.error.status === 406) {
        error(e.error.message);
      } else {
        error('کد تخفیف معتبر نمی باشد.');
      }
    }finally {
      loading.value = false;
    }
  }

  const removeDiscount = async ()=> {
    try {
      loading.value = true;
      const { data } = await CartRepository.removeDiscount({coupon: discount.value});
      success(data.message)
      await updateCart();
      discountForm.value.reset();
      discountForm.value.resetValidation();
    }catch (e) {
      if (e.error.status === 409 || e.error.status === 406) {
        error(e.error.message);
      } else {
        error('کد تخفیف معتبر نمی باشد.');
      }
    }finally {
      loading.value = false;
    }
  }

  const discountAction = ()=> {
    addedDiscount.value ? removeDiscount() : addDiscount();
  }
  onMounted(()=> {
    discount.value = store.getters['cartStore/discount'];
  })
</script>

<template>
  <v-form ref="discountForm">
    <label for="discount">کد تخفیف</label>
    <v-text-field
        id="discount"
        v-model="discount"
        :loading="loading"
        variant="outlined"
        rounded="lg"
        placeholder="کد تخفیف خود را وارد کنید"
        color="primary"
        :readonly="!!addedDiscount"
        class="mb-4"
    >
      <template #append-inner>
        <v-btn @click.prevent="discountAction" color="primary" variant="tonal">
          <span v-if="!addedDiscount">اعمال کد</span>
          <span v-else>حذف کد</span>
        </v-btn>
      </template>
    </v-text-field>
  </v-form>
</template>

<style scoped lang="scss">

</style>