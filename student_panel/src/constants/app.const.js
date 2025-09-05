/**
 * @created        17/06/2023 - 15:17
 * @author         Nariman Palangi
 * @user           ragnarok
 * @organization
 * @project        boilerplate-vue-3
 * @file name      app.const.js
 * @file dir       src/constants
 */
export const APP_NAME = 'Classino';
export const APP_NAME_FA = 'پنل دانش آموز';
export const APP_DESCRIPTION = 'پنل دانش آموز';

export const ENTRANCE_EXAM_DATE = "2025-04-21";
export const LAST_ENTRANCE_EXAM_DATE = "2024-04-20";
export const ADMIN_PERMISSIONS = [
    /*panel admin permission*/
    'ADMIN',
    'SUPER_USER'
];

export const EXCLUDE_ROUTES = ['auth', 'authentication.auth','login-pass','login-otp','signup.otp', 'signup.state', 'signup.terms'];


export const COOKIES = {
    COOKIE_EXP_MINUTES: 300
}

export const VUE_VERSION = "3.3.4";