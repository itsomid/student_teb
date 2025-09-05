/**
 * Array containing different types of notifications.
 * @type {Array<{ title: string, value: string }>}
 * @description Each object in the array represents a notification type.
 * @property {string} title - The title of the notification type.
 * @property {string} value - The value associated with the notification type.
 *                            This value can be used for filtering notifications.
 */
export const NOTIFICATION_TYPES = [
    {
        title: "همه اعلان ها",
        value: "",
    },
    {
        title: "  اعلان های مقطع تحصیلی",
        value: "grade",
    },
    {
        title: "  اعلان های خصوصی",
        value: "user",
    },
    {
        title: "  اعلان های دوره",
        value: "product",
    }
]