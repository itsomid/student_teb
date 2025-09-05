import {mobile,length ,required} from "@/composable/useValidator";

export const SCHEMA = {
  /* Form SCHEMA */
  schema: [
    {
      id: "otp",
      label: "کد یکبار مصرف",
      placeholder: "0",
      cols: 12,
      xl: 12,
      lg: 12,
      md: 12,
      sm: 12,
      rounded: 'lg',
      hideDetails: true,
      variant: 'outlined',
      type: "otp",
    },
  ],

  /* Form MODEL */
  model: {
    otp: "",
  },

  /* VALIDATION SCHEMA */
  validations: {
    otp: { required,length: length(5) },
  },
};
