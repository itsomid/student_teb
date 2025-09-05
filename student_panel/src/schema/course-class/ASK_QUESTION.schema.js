import {required} from "@/composable/useValidator";

export const SCHEMA = {
    /* Form SCHEMA */
    schema: [
        {
            id: "question_title",
            label: '',
            placeholder: "عنوان سوال خود را اینجا وارد کنید، به هر میزان عنوان خلاصه تر و گویا تر باشد سریعتر توسط استاد پاسخگویی خواهد شد",
            cols: 12,
            xl: 12,
            lg: 12,
            md: 12,
            sm: 12,
            rounded: 'xl',
            type: "text",
        },
        {
            id: "question_text",
            placeholder: "متن کامل سوال خود را فقط اینجا وارد کنید",
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
        question_title: null,
        question_text: null,
    },

    /* VALIDATION SCHEMA */
    validations: {
        question_title: { required},
        question_text: { required},
    },
};
