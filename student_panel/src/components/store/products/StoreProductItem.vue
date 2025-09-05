<script setup>
  import {computed, defineEmits, ref} from "vue";
  import {DEFAULT_IMAGE_PATH} from "@/config/filePath.config";
  import {useCart} from "@/composable/useCart";
  import ClImage from "@/components/base/ClImage.vue";
  import StoreProductBtn from "@/components/store/StoreProductBtn.vue";
  import {useRoute, useRouter} from "vue-router";
  import { useGoogleTagManager } from "@/composable/useGtm";


  const emits = defineEmits(['addedToCart'])
  const props = defineProps({
    item: {
      type: Object,
      required: true,
    }
  })
  ;
  const { loading } = useCart({emits});
  const { trackAddToCartEvent,trackSelectItemEvent } = useGoogleTagManager();
  const isSpecialSuggestPrice = computed(()=> !!props.item.off_price || !!props.item.full_price_show);

  const numberConvertor = (number)=> {
    return Intl.NumberFormat('en').format(number)
  }

  const emitUpdateProductStatusToParent = (value) => {
    trackAddToCartEvent(props.item)
    emits('addedToCart',value)
  }
  const route = useRoute();
  const router = useRouter();

  /**
   * Updates the current route's query parameters while saving past queries.
   * Adds or removes a query parameter based on the provided filter and value.
   *
   * @param {string} filter - The query parameter key to be added or removed.
   * @param {string} value - The query parameter value to be set. If falsy, the parameter will be removed.
   */
  const updateQueryParams = (filter, value) => {
    // Log the filter and value for debugging purposes.

    // Make a shallow copy of the current query parameters from the route object.
    const query = Object.assign({}, route.query);

    // If the value is truthy (non-empty), set the query parameter with the provided filter (key).
    // If the value is falsy (empty or null), remove the query parameter by deleting it from the query object.
    value ? query[filter] = value : delete query[filter];

    // Push the updated query parameters to the router. This updates the URL while keeping the past queries intact.
    router.push({ query: { ...query } }).then((res) => {
      // Optional: Perform any additional actions upon successful route update (like logging the result or handling response).
    });
  }

  /**
   * Resets the current route's query parameters by replacing a specific filter with a new value.
   *
   * @param {string} filter - The query parameter key to be set or updated.
   * @param {string} value - The new query parameter value to be set. This will replace the existing value.
   */
  const pushWithQuery = (filter, value) => {
    // Create a new query object and directly set the filter (key) to the provided value.
    // This will reset the query to only include the new value for the specified filter.
    const query = {};
    query[filter] = value;

    // Push the new query parameters to the router, updating the URL.
    router.push({ query: { ...query } }).then((res) => {
      // Optional: Perform any additional actions upon successful route update (e.g., logging).
    });
  }

</script>

<template>
  <div class="h-100">
    <v-hover>
      <template v-slot:default="{ isHovering,props }">
        <v-card
            v-bind="props"
            :elevation="isHovering ? 8 : 1"
            rounded="xl"
            height="100%"
            class="d-flex flex-column"
            variant="elevated"
            :loading="loading"
            @click.prevent="trackSelectItemEvent(item)"
            :to="{ name: 'product', params: { id: item.id }}"
        >
          <!-- ClImage component for displaying product image -->
          <ClImage
              path="PRODUCT"
              :default-image="DEFAULT_IMAGE_PATH.PRODUCTS"
              :alt="item.name"
              :image="item.img_filename"
          />

          <v-card-text>
            <!-- Product name -->
            <p class="text-body-1">
              {{ item.name }}
            </p>

            <!-- Additional details: teacher name, grades, lessons, start date -->
            <div class="d-flex flex-row flex-wrap mt-4" style="gap: 8px">
              <!-- Chips for teacher name, grades, lessons, start date -->
              <template v-if="item.teacher_name && item.product_type_id !== 15">
                <v-chip  @click.prevent="pushWithQuery('professor',item.teacher_id)" active-class="bg-primary" size="small" label variant="tonal">{{ item.teacher_name }}</v-chip>
              </template>
              <template v-if="item.grades.length">
                <v-chip v-for="grade in item.grades" @click.prevent="pushWithQuery('grade',grade.id)" size="small" label variant="tonal">{{ grade.name }}</v-chip>
              </template>
              <template v-if="item.lessons.length && item.product_type_id !== 15" >
                <v-chip v-for="lesson in item.lessons" @click.prevent="pushWithQuery('lesson',lesson.id)" size="small" label variant="tonal" >{{ lesson.name }}</v-chip>
              </template>
              <template v-if="item.start_date">
                <v-chip size="small" label variant="tonal">شروع از {{ item.start_date }}</v-chip>
              </template>
            </div>

            <!-- Price section -->

          </v-card-text>

          <!-- StoreProductBtn component for adding product to cart -->
          <v-card-actions class="px-4 pb-4 pt-0 align-self-start w-100 d-flex flex-column align-start">
            <div class="mt-5">
              <!-- Special price section -->
              <div v-if="isSpecialSuggestPrice" class="d-flex flex-row flex-wrap mt-3 text-caption font-weight-bold">
                <span class="text-secondary">قیمت پیشنهاد ویژه:</span>
                <span class=" text-error mr-2 text-decoration-line-through text-body-2">
                  {{ item.off_price ? numberConvertor(item.original_price) : numberConvertor(item.full_price_show) }}
                </span>
                <span class="text-secondary mr-1 ml-2">
              ریال
                </span>
                <span class="text-success text-body-2">
                {{ item.price === 0 ? 'رایگان' : numberConvertor(item.price) }}
                </span>
                <span v-if="item.price !== 0" class="text-secondary mr-1 ml-2">
              ریال
                </span>
              </div>

              <!-- Regular price section -->
              <div v-else  class="d-flex flex-row flex-wrap mt-3 text-caption font-weight-bold">
                <span class="text-secondary">
                 قیمت:
                </span>
                <span class="mx-2 text-body-2">{{ item.price === 0 ? 'رایگان' : numberConvertor(item.price) }}</span>
                <span v-if="item.price !== 0" class="text-secondary mr-1 ml-2">
              ریال
                </span>
              </div>
            </div>
            <StoreProductBtn
                :is_new_panel="item.name.includes('1405')"
                :product_id="item.id"
                :course_id="item.course_id"
                :status="item.store_status"
                :product_type="item.product_type_id"
                @addedToCart="emitUpdateProductStatusToParent"
            />
          </v-card-actions>
        </v-card>
      </template>
    </v-hover>
  </div>
</template>

<style scoped lang="scss">

</style>