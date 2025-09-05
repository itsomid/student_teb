import {required, sameAs} from "@/composable/useValidator";
import {FIELD_OF_STUDY, GRADE_ITEMS} from "@/constants/educational";

export const MINIMUM_GRAD_FOR_FILED_OF_STUDY = 9;
export const SCHEMA = {
    /* Form SCHEMA */
    schema: [
        {
            id: "name_family",
            label: "نام و نام خانوادگی",
            placeholder: "نام و نام خانوادگی",
            cols: 12,
            xl: 12,
            lg: 12,
            md: 12,
            sm: 12,
            innerIcon: '$mdiPencilCircleOutline',
            rounded: 'lg',
            variant: 'outlined',
            type: "text",
        },
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
        {
            id: "terms",
            label: `<span class="text-info">
                        <a href="https://www.classino.com/policy" target="_blank" class="text-decoration-none text-info">
                        شرایط و قوانین
                        </a>
                    </span>
                     کلاسینو را خوانده و با آن موافقم.`,
            cols: 12,
            xl: 12,
            lg: 12,
            md: 12,
            sm: 12,
            falseValue: false,
            trueValue: true,
            // value: false,
            rounded: 'lg',
            variant: 'outlined',
            type: "checkbox",
        },
    ],

    /* Form MODEL */
    model: {
        name_family: null,
        grade: null,
        field_of_study: null,
        terms: null,
    },

    /* VALIDATION SCHEMA */
    validations: {
        name_family: { required },
        grade: { required },
        field_of_study: {},
        terms: { required, sameAsTerms: sameAs(true) },
    },
};

