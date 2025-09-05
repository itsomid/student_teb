/**
 * @created        17/06/2023 - 12:21
 * @author         Nariman Palangi
 * @user           ragnarok
 * @organization
 * @project        boilerplate-vue-3
 * @file-name      dark.js
 * @file-dir       src/plugins/vuetify-options
 */

/** @description config dark theme for vuetify */

/**  to set dark/light theme
 *   @constant
 *   @type {boolean}
 *   @default true
 *  **/
const isDark = true
export default {
  dark: isDark,
  colors: {
    white:"#ffffff",
    black: '#1E1E1E',
    background: "#121212",
    surface: '#212121',
    onSurface: '#ffffff',
    primary: '#FFAF20',
    secondary: '#727272',
    'table-active': "#424242",
    btn: "#212121",
    card: '#1A1A1A',
    error: '#EF5350',
    info: '#2196F3',
    success: '#4CAF50',
    warning: '#FFAF20'
  }
}
