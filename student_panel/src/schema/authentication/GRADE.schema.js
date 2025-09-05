import {required} from "@/composable/useValidator";
import {FIELD_OF_STUDY, GRADE_ITEMS} from "@/constants/educational";

export const MINIMUM_GRAD_FOR_FILED_OF_STUDY = 9;
export const SCHEMA = {
    /* Form SCHEMA */
    schema: [
        {
            id: "grade",
            label: "پایه تحصیلی",
            placeholder: "پایه تحصیلی خود را انتخاب کنید.",
            cols: 12,
            xl: 12,
            lg: 12,
            md: 12,
            sm: 12,
            items: GRADE_ITEMS,
            rounded: 'lg',
            variant: 'outlined',
            type: "select",
        },
        {
            id: "field_of_study",
            label: "رشته تحصیلی",
            placeholder: "رشته تحصیلی خود را انتخاب کنید.",
            cols: 12,
            xl: 12,
            lg: 12,
            md: 12,
            sm: 12,
            disabled: true,
            items: FIELD_OF_STUDY,
            rounded: 'lg',
            variant: 'outlined',
            type: "select",
        },
    ],

    /* Form MODEL */
    model: {
        grade: null,
        field_of_study: null,
    },

    /* VALIDATION SCHEMA */
    validations: {
        grade: { required },
        field_of_study: {},
    },
};

