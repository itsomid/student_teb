import {defineAsyncComponent, onMounted, shallowRef} from "vue";
import ClLoading from "@/components/base/ClLoading.vue";
import ClError from "@/components/app/ClError.vue";
import DashboardNotificationEducational
    from "@/components/dashboard/notifications/DashboardNotificationEducational.vue";
import DashboardNotificationFinance from "@/components/dashboard/notifications/DashboardNotificationFinance.vue";
import DashboardNotificationSuggestions
    from "@/components/dashboard/notifications/DashboardNotificationSuggestions.vue";
import {useDate} from "@/composable/useDate";
import RepositoryFactory from "@/repository/RepositoryFactory";
import {BANNER_TYPES} from "@/constants/bannerTypes";
export default function useDashboardNotifications() {
    const { isDateAfter } = useDate();
    const  BannerRepository = RepositoryFactory.get("Banner");

    const getAnnouncement = async ()=> {
        try {
            const { data: { data }} = await BannerRepository.getBanner(BANNER_TYPES.ANNOUNCEMENT);
            const showSuggestion = data.some(item => isDateAfter(item.expired_at));
            if(showSuggestion) selection.value = DashboardNotificationSuggestions;
        }catch (e) {
            error(e.error?.message)
        }
    }

    const selection = shallowRef(DashboardNotificationEducational);

    const tabs = [
        {
            id: 'educational',
            text: 'درسی',
            icon: '$mdiBookOpenVariantOutline',
            value: DashboardNotificationEducational
        },
        {
            id: 'suggestions',
            text: 'پیشنهاد‌ها',
            icon: '$mdiStorePlusOutline',
            value: DashboardNotificationSuggestions
        },
        {
            id: 'financial',
            text: 'مالی',
            icon: '$mdiCreditCardOutline',
            value: DashboardNotificationFinance
        }
    ];

    onMounted(()=> getAnnouncement());

    return {
        selection,
        tabs
    };
}
