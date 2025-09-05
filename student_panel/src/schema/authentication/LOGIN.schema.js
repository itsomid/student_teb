import {required, mobile, numeric} from "@/composable/useValidator";

export const SCHEMA = {
  /* Form SCHEMA */
  schema: [
    {
      id: "mobile",
      label: "شماره تماس",
      placeholder: "شماره تماس خود را وارد کنید.",
      cols: 12,
      xl: 12,
      lg: 12,
      md: 12,
      sm: 12,
      rounded: 'lg',
      variant: 'outlined',
      type: "text",
    },
  ],

  /* Form MODEL */
  model: {
    mobile: null,
  },

  /* VALIDATION SCHEMA */
  validations: {
      mobile: { required, mobile, numeric },
  },
};
