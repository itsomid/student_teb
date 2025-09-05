import {GRADE_ITEMS} from "@/constants/educational";

export const SCHEMA = {
    /* Form SCHEMA */
    schema: [
        {
            id: "grades",
            placeholder: "پایه تحصیلی",
            color: 'primary',
            items: GRADE_ITEMS,
            returnObject: true,
            itemTitle: 'name',
            hideSelection: true,
            variant: 'outlined',
            multiple: true,
            chips: false,
            clearable: false,
            hideDetails: true,
            cols: 12,
            xl: 2  ,
            lg: 2,
            md: 4,
            sm: 12,
            rounded: 'lg',
            type: "autocomplete",
        },
        {
            id: "lessons",
            placeholder: "درس",
            itemTitle: 'name',
            hideSelection: true,
            returnObject: true,
            variant: 'outlined',
            color: 'primary',
            multiple: true,
            items: [],
            chips: false,
            clearable: false,
            hideDetails: true,
            cols: 12,
            xl: 2,
            lg: 2,
            md: 4,
            sm: 12,
            rounded: 'lg',
            type: "autocomplete",
        },
        {
            id: "teacher_name",
            label: 'نام استاد',
            placeholder: "نام استاد",
            itemTitle: 'teacher_name',
            variant: 'outlined',
            color: 'primary',
            cols: 12,
            xl: 2,
            lg: 2,
            md: 4,
            sm: 12,
            rounded: 'lg',
            type: "text",
        },
    ],

    /* Form MODEL */
    model: {
        grades: null,
        lessons: null,
        teacher_name: null,
    },

    /* VALIDATION SCHEMA */
    validations: {
        grades: {},
        lessons: {},
        teacher_name:{},
    },
};
