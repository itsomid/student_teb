import {required} from "@/composable/useValidator";

export const SCHEMA = {
    /* Form SCHEMA */
    schema: [
        {
            id: "title",
            label: "عنوان",
            placeholder: "کدام قسمت پنل مشکل داشتید؟",
            cols: 12,
            xl: 12,
            lg: 12,
            md: 12,
            sm: 12,
            rounded: 'xl',
            type: "text",
        },
        {
            id: "message",
            label: "جزییات مشکل",
            placeholder: "جزییات مشکل را بنویسید",
            cols: 12,
            xl: 12,
            lg: 12,
            md: 12,
            sm: 12,
            rounded: 'xl',
            type: "textarea",
        },
    ],

    /* Form MODEL */
    model: {
        title: null,
        message: null,
    },

    /* VALIDATION SCHEMA */
    validations: {
        title: { required},
        message: { required},
    },
};
