<script setup>
  import RepositoryFactory from "@/repository/RepositoryFactory";
  import {computed, ref} from "vue";
  import {useDateFormatter} from "../../composable/useDate";
  import {useStore} from "vuex";
  import ClModal from "@/components/app/ClModal.vue";
  import ClImage from "@/components/base/ClImage.vue";
  import {DEFAULT_IMAGE_PATH} from "@/config/filePath.config";


  const store = useStore();

  const isModal = defineModel({default:false});

  const items = computed(()=>store.getters['notificationStore/modalItems']);

  /**
   * Reference for the loading state.
   * @type {import('vue').Ref<boolean>}
   */
  const loading = ref(false);

  /**
   * Instance of the Notification repository.
   * @type {import('@/repository/Repository').default}
   */
  const NotificationRepository = RepositoryFactory.get("Notification");
  const markAsRead = async ()=>{
    try {
      loading.value = true;
      const { data } = await NotificationRepository.markAsReadSpecialNotifications({ids: items.value.map(item=>item._id)});
      isModal.value = false;
    } catch (e) {
      error(e.error?.message);
    } finally {
      loading.value = false;
    }
  }
</script>

<template>
  <template>
    <ClModal :model-value="isModal" v-model="isModal" :blur="true" >
      <v-card>
        <v-toolbar class="px-3">
          اعلان فوری
        </v-toolbar>
        <div class="modal-notifications overflow-auto text-wrap" ref="modalNotification">
          <v-card-text class="p-0  text-wrap">
            <v-card width="100%" max-height="100%" v-for="modal in items" :key="modal._id" flat border rounded="lg" class="mt-3 notification-detail text-start pa-4 px-5" >
              <div class="d-flex flex-row text-wrap">
                <ClImage v-if="modal.product_img" width="48"   :aspect-ratio="1" :default-image="DEFAULT_IMAGE_PATH.PRODUCTS"  path="PRODUCT" :alt="modal.title" :image="modal.product_img" class="rounded" />
                <div class="text-wrap text-h6 font-weight-bold">{{ modal.title }}</div>
              </div>
              <v-divider class="my-3" />
              <p class="notification-text" v-html="modal.message"></p>
              <div class="w-100 d-flex justify-end mt-3">
                <v-chip rounded="xl" size="small" class="datetime justify-end">
                  {{ useDateFormatter(modal.createdAt, 'HOUR_DATE') }}
                </v-chip>
              </div>
            </v-card>
          </v-card-text>
        </div>

        <v-card-actions class="white">
          <v-btn size="large" rounded="xl" color="primary" variant="flat" block
                 :disabled="loading" @click="markAsRead()">
            <span v-if="!loading">متوجه شدم</span>
          </v-btn>
        </v-card-actions>
      </v-card>
    </ClModal>
  </template>
</template>

<style scoped lang="scss">
.modal-notifications {
  max-height: 500px;
}
</style>