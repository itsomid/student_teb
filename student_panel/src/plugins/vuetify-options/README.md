# Theme configuration: [theme.js](theme/theme.js)
This document is about how to config your app themes, colors and create your custom theme
## Content

1. [Getting start](#getting-started)
2. [Theme config file](#theme-config-file)
3. [Theme Options](#theme-options)
4. [How to create a custom theme](#how-to-create-a-custom-theme)
5. [Change default `dark` or `light` theme colors](#change-default-dark-or-light-theme-colors)
6. [Material design color pallet](#material-design-color-pallet)
## Getting started

Customize your application’s default text colors, surfaces, and more. Easily modify your theme programmatically in real time.

- [ ] [![N|Solid](../../assets/images/vuetify-logo.svg)](https://vuetifyjs.com/en/features/theme/) [More Detail on Vuetify theme config doc](https://vuetifyjs.com/en/features/theme/)

---

## Theme config file

[theme.js](theme/theme.js)

    file dir: /src/plugins/vuetify-options/theme.js

```javascript
   import dark from "./dark";
   import light from "./light";

   const defaultTheme = 'dark'
   export default {
        defaultTheme: defaultTheme,
        variations: {
        colors: ['primary', 'secondary'],
        lighten: 1,
        darken: 2,
        },
        themes: {
            dark: dark,
            light: light,
        },
    };
    ...
```

---

## [Theme options]()

- defaultTheme -> " select one of existing themes as default theme "
- variation -> " The Vuetify theme system can help you generate any number of variations for the colors in your theme "
- themes -> " imported theme called here as themes object properties"

### defaultTheme

To set the default theme of your application, use the defaultTheme option.

for example:

[theme.js](theme/theme.js)

     file dir: /src/plugins/vuetify-options/theme.js

```javascript
    const defaultTheme = 'dark';
    // or
    const defaultTheme = 'light';
```

### variation

The Vuetify theme system can help you generate any number of variations for the colors in your theme. The following example shows how to generate 1 lighten and 2 darken variants for the primary and secondary colors.

[theme.js](theme/theme.js)

    file dir: /src/plugins/vuetify-options/theme.js

```javascript
variations: {
    colors: ['primary', 'secondary'],
    lighten: 1,
    darken: 2,
},
```

```vue
<template>
  <div class="text-primary-lighten-1">text color</div>

  <div class="text-primary-darken-1">text color</div>

  <div class="text-primary-darken-2">text color</div>
</template>
```

### themes

import custom themes here

     file dir: /src/plugins/vuetify-options/theme.js
```javascript
  //...
  themes: {
    dark: dark,
    light: light,
  },
  //...
```

---

## How to create a custom theme

to create a new custom theme follow below instructions:

1. create a .js file in `/src/plugins/vuetify-options/` directory with any name you want. In this case we create customTheme.js
    
        /src/plugins/vuetify-options/customTheme.js

2. copy this code to customTheme.js and set your own colors

```javascript
//customTheme.js
const isDark = false; // to use dark mode set isDark=true
export default {
  dark: isDark,
  colors: {
    background: '#FFFFFF',
    surface: '#FFFFFF',
    primary: '#2f9e22',
    secondary: '#03DAC6',
    error: '#B00020',
    info: '#2196F3',
    success: '#4CAF50',
    warning: '#FB8C00'
  }
}
```
to define dark mode you should set `isDark` to `true`

you can add any color you want to `color` Object like that:

```javascript
colors: {
    background: '#FFFFFF',
    surface: '#FFFFFF',
    primary: '#2f9e22',
    secondary: '#03DAC6',
    error: '#B00020',
    info: '#2196F3',
    success: '#4CAF50',
    warning: '#FB8C00'
    custom-color: '#FFFFFF' -> add custom color
  }
```

3. add customTheme to `/src/plugins/vuetify-options/theme.js`

```javascript
//...
import customTheme from ./customTheme.js

/** @description import vuetify-options to vuetify instance */
const defaultTheme = 'dark'
export default {
    defaultTheme: defaultTheme,
    /** @see how to configure variation
        @tutorial https://vuetifyjs.com/en/features/theme/#color-variations */
    variations: {
       //...
    },
    themes: {
       //...
       customTheme: customTheme
    },
};
```

4. to use this theme you can set `defaultTheme` to `customTheme` to use this theme as default theme or change dynamicaly in your app
for more detail about dynamic change please read this [article](https://vuetifyjs.com/en/features/theme/#changing-theme)

-------------------------------

## Change default `dark` or `light` theme colors

to change dark theme default colors follow the instruction
1. open [`/src/plugins/vuetify-options/dark.js`](theme/dark.js)
2. change/add any color you want
```javascript
export default {
  dark: isDark,
  colors: {
    background: '#FFFFFF',
    surface: '#FFFFFF',
    primary: '#df0b12',
    'primary-darken-1': '#3700B3',
    secondary: '#03DAC6',
    'secondary-darken-1': '#018786',
    error: '#B00020',
    info: '#2196F3',
    success: '#4CAF50',
    warning: '#FB8C00'
  }
}
```

## Material design color pallet
see  material design color pallet [here](https://vuetifyjs.com/en/styles/colors/#material-colors)