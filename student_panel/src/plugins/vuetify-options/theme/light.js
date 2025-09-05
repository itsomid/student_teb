/**
 * @created        17/06/2023 - 12:22
 * @author         Nariman Palangi
 * @user           ragnarok
 * @organization
 * @project        boilerplate-vue-3
 * @file           light.js
 * @file-dir       src/plugins/vuetify-options
 */

/** @description config light theme for vuetify */

/** @constant
 *   @type {boolean}
 *   @default true
 *  **/
const isDark = false;

//###########################################

export default {
  dark: isDark,
  colors: {
    white:"#ffffff",
    black:"#1E1E1E",
    background: '#f9fAfB',
    card: '#f5f5f5',
    surface: '#FFFFFF',
    onSurface: '#45464F',
    primary: '#036af5',
    secondary: '#757575',
    'table-active': "#EEEEEE",
    error: '#E53935',
    info: '#2196F3',
    success: '#4CAF50',
    warning: '#FFAF20'
    // primary: {
    //   base: '#1976D2',          // Base primary color
    //   lighten5: '#BBDEFB',      // Lightest tonal shade
    //   lighten4: '#90CAF9',      // Lighter shade
    //   lighten3: '#64B5F6',      // Light shade
    //   lighten2: '#42A5F5',      // Lighter base shade
    //   lighten1: '#2196F3',      // Slightly lighter than the base
    //   darken1: '#1565C0',       // Darker shade
    //   darken2: '#0D47A1',       // Darker tone
    //   darken3: '#0A3C7A',       // Darkest tonal shade
    // },
    // secondary: {
    //   base: '#FF5722',          // Base secondary color
    //   lighten5: '#FFCCBC',      // Lightest tonal shade
    //   lighten4: '#FFAB91',      // Lighter shade
    //   lighten3: '#FF8A65',      // Light shade
    //   lighten2: '#FF7043',      // Lighter base shade
    //   lighten1: '#FF5722',      // Base shade
    //   darken1: '#E64A19',       // Darker shade
    //   darken2: '#D32F2F',       // Darker tone
    //   darken3: '#C2185B',       // Darkest tonal shade
    // },
  },
  variables: {
    // 'border-color': '#000000',
    // 'border-opacity': 0.12,
    // 'high-emphasis-opacity': 0.87,
    // 'medium-emphasis-opacity': 0.60,
    // 'disabled-opacity': 0.38,
    // 'idle-opacity': 0.04,
    // 'hover-opacity': 0.1,
    // 'focus-opacity': 0.12,
    // 'selected-opacity': 0.08,
    // 'activated-opacity': 0.12,
    // 'pressed-opacity': 0.12,
    // 'dragged-opacity': 0.08,
    // 'theme-kbd': '#212529',
    // 'theme-on-kbd': '#FFFFFF',
    // 'theme-code': '#F5F5F5',
    // 'theme-on-code': '#000000',
  }
}
