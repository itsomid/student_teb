import {required } from "@/composable/useValidator";

export const SCHEMA = {
    /* Form SCHEMA */
    schema: [
        {
            id: "password",
            label: "رمز عبور",
            placeholder: "رمز عبور خود را وارد کنید.",
            cols: 12,
            xl: 12,
            lg: 12,
            md: 12,
            sm: 12,
            rounded: 'lg',
            variant: 'outlined',
            type: "password",
        },
    ],

    /* Form MODEL */
    model: {
        password: null,
    },

    /* VALIDATION SCHEMA */
    validations: {
        password: { required },
    },
};
