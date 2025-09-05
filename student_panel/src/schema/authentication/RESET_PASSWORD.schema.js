import {required, minLength, sameAs} from "../../composable/useValidator";


export const SCHEMA = {
  /* Form SCHEMA */
  schema: [
    {
      id: "password",
      label: "رمزعبور",
      placeholder: "رمز عبور  جدید خود را وارد کنید.",
      class: "white-label",
      cols: 12,
      lg: 12,
      md: 12,
      sm: 12,
      rounded: 'xl',
      type: "password",
    },
    {
      id: "confirm",
      label: "تکرار رمز عبور",
      placeholder: "تکرار رمز عبور",
      class: "white-label",
      cols: 12,
      lg: 12,
      md: 12,
      sm: 12,
      rounded: 'xl',
      type: "password",
    },
  ],

  /* Form MODEL */
  model: {
    password: null,
    confirm: null,
  },

  /* VALIDATION SCHEMA */
  validations: {
      password: { required, minLength: minLength(8) },
      confirm: { required},
  },
};
