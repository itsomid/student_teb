import {required, email} from "../../composable/useValidator";

export const SCHEMA = {
  /* Form SCHEMA */
  schema: [
    {
      id: "email",
      label: "email",
      placeholder: "مثال: email@example.com",
      class: "white-label",
      cols: 12,
      lg: 12,
      md: 12,
      sm: 12,
      type: "text",
    },
  ],

  /* Form MODEL */
  model: {
    email: null,
  },

  /* VALIDATION SCHEMA */
  validations: {
      email: { required, email },
  },
};
