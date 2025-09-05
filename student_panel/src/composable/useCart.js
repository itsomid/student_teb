import {ref, defineEmits, computed} from "vue";
import {useStore} from "vuex";
import {useAlert} from "@/composable/useAlert";
import {useNavigator} from "@/composable/useNavigator";
import RepositoryFactory from "@/repository/RepositoryFactory";
import LocalStorageService from "@/services/LocalStorage.service";
import {useDate} from "@/composable/useDate";
import {useHotjar} from "@/composable/useHotjar";
/**
 * Store repository instance.
 * @type {import('@/repository/Repository').default}
 */
const StoreRepository = RepositoryFactory.get("Store");
const CartRepository = RepositoryFactory.get("Cart");

const { success, error } = useAlert();
const { isDaysPast } = useDate();
const { HOTJAR_EVENTS, sendEvent } = useHotjar();

export function useCart({emits}) {
    const DAYS_SINCE_CART_NOT_PAID = import.meta.env.VITE_APP_DAYS_SINCE_CART_NOT_PAID || 2;
    const store = useStore();
    const { navigateToMyCourses, navigateToStore, navigateToCart } = useNavigator();
    const loading = ref();


   async function buyForFree(product_id){
        try {
            loading.value = true;
            await StoreRepository.buyForFree(product_id);
            success('محصول با موفقیت به درس های شما افزوده شد. شما در حال انتقال به درس های من هستید...');
            navigateToMyCourses();
        }catch {
            error('خطایی در ارتباط با سرور رخ داده');
        }finally {
            loading.value = false;
        }
    }

    async function addToCart(product_id){
        try {
            loading.value = true;
            await StoreRepository.addToCart({product_id: product_id});
            await store.dispatch('cartStore/fetchCartItemsCount', { type: 'increment' });``
            success('محصول با موفقیت به سبد خرید افزوده شد');
            emits('addedToCart', product_id);
        }catch(e) {
            e.error.status === 429 ? error('ظرفیت سبد خرید شما تکمیل شده است!') : error('خطایی در ارتباط با سرور رخ داده');
        }finally {
            loading.value = false;
        }
    }

    async function addToCartOnRedirectAfterLogin(product_id, query = null){
        try {
            loading.value = true;
            const { data: { isFree } } = await StoreRepository.addToCartOnRedirectAfterLogin(product_id);
            await store.dispatch('cartStore/fetchCartItemsCount', { type: 'increment' });
            success(isFree ? 'دوره با موفقیت به درس های شما اضافه شد.' : 'دوره با موفقیت به سبد خرید افزوده شد');
            isFree ? navigateToMyCourses(query): navigateToCart(query);

        }catch(e) {
          if( e.error.status === 400 ) {
              error('محصول مورد نظر قبلا خریداری شده.')
              navigateToMyCourses(query)
          }
          else if( e.error.status === 404 ) error('محصول مورد نظر وجود ندارد.')
          else if( e.error.status === 406 ) error('محصول مورد نظر در سبد خرید وجود دارد.')
          else                              error('خطایی در ارتباط با سرور رخ داده.')
        }finally {
            loading.value = false;
        }
    }
    async function addPackageToCart(payload){
        try {
            loading.value = true;
            await StoreRepository.addPackageToCart(payload);
            await store.dispatch('cartStore/fetchCartItemsCount', { type: 'increment' });
            emits('addedToCart')
            success('محصول با موفقیت به سبد خرید افزوده شد');
        }catch(e) {
            e.error.status === 429 ? error('ظرفیت سبد خرید شما تکمیل شده است!') : error('خطایی در ارتباط با سرور رخ داده');
            return Promise.reject(e);
        }finally {
            loading.value = false;
        }
    }

    async function addPlanZPackageToCart(payload){
        try {
            loading.value = true;
            await StoreRepository.addPlanZPackageToCart(payload);
            await store.dispatch('cartStore/fetchCartItemsCount', { type: 'increment' });
            emits('addedToCart')
            success('محصول با موفقیت به سبد خرید افزوده شد');
        }catch(e) {
            e.error.status === 429 ? error('ظرفیت سبد خرید شما تکمیل شده است!') : error('خطایی در ارتباط با سرور رخ داده');
            return Promise.reject(e);
        }finally {
            loading.value = false;
        }
    }
    async function removeFromCart(product_id){
        try {
            loading.value = true;
            await CartRepository.removeCartItem(product_id);
            await store.dispatch('cartStore/fetchCartItemsCount', { type: 'decrement' });
            const { data: { data } } = await CartRepository.getUserCart();
            await store.dispatch('cartStore/updateCart',data);
            store.getters['cartStore/cartItemsCount'] || navigateToStore();
            success('محصول با موفقیت از سبد خرید حذف شد.');
        }catch(e) {
             error('حذف از سبد خرید انجام نشد.');
        }finally {
            loading.value = false;
        }
    }

    async function trackUnpaidCartStatus() {
        const cartUpdatedAt = localStorage.getItem('cart_updated_at');

        // Check if the cart was updated beyond the specified days
        if (!isDaysPast(cartUpdatedAt, DAYS_SINCE_CART_NOT_PAID)) {
            return; // Exit early if the condition is not met
        }

        // Using computed properties to get user information
        const userID = store.getters['userStore/id'];
        const grade = store.getters['userStore/grade'];

        try {
            const { data: { data: cart } } = await CartRepository.getUserCart();

            // Prepare data for sending to Hotjar
            const eventData = {
                userID,
                orderItems: cart.items,
                grade,
                cartFinalPayable: cart.invoice.payable_price,
            };

            // Send the event to Hotjar
            sendEvent(HOTJAR_EVENTS.NOT_PAYED_ORDER, eventData);

            // Remove cart updated timestamp from local storage
            LocalStorageService.remove('cart_updated_at');
        } catch (error) {
            console.error('Error fetching user cart:', error); // Log the error for debugging
            throw new Error('Failed to check if cart is paid');
        }
    }


    return {
        loading,
        buyForFree,
        addToCart,
        addPackageToCart,
        addPlanZPackageToCart,
        removeFromCart,
        addToCartOnRedirectAfterLogin,
        trackUnpaidCartStatus,
    }
}