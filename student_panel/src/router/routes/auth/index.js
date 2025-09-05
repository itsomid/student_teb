/**
 * @created        15/09/2023 - 19:07
 * @author         Nariman Palangi
 * @user           ragnarok
 * @organization
 * @project        boilerplate-vue-3
 * @file name      authentication.js
 * @file dir       src/router/routes
 */
"use strict";
const DEFAULT_TITLE = '';
import Authentication from "../../../views/authentication/Auth.vue";
export default [
    {
        path: "/auth",
        name: "authentication",
        redirect: { name: "authentication.auth" },
        meta: {
            layout: "auth",
            title: "ورود/عضویت",
            redirectIfLoggedIn: true
        },
        children: [
            {
                path: "",
                name: "authentication.auth",
                component:() => import("../../../views/authentication/Auth.vue"),
                meta: {
                    title: DEFAULT_TITLE + 'ورود/عضویت',
                    redirectIfLoggedIn: true
                },
            },
            {
                path: 'login/pass/:mobile',
                component: ()=>import( "../../../views/authentication/LoginWithPassword.vue") ,
                name: 'login-pass',
                meta: {
                    title: DEFAULT_TITLE + 'ورود با رمز عبور',
                    redirectIfLoggedIn: true
                }
            },
            {
                path: 'login/otp/:mobile/',
                component: ()=>import( "../../../views/authentication/LoginWithOtp.vue") ,
                name: 'login-otp',
                meta: {
                    title: DEFAULT_TITLE + 'ورود با رمز یکبار مصرف',
                    redirectIfLoggedIn: true
                }
            },
            {
                path: 'signup/otp/:mobile/',
                component: ()=> import("../../../views/authentication/SignUpOtp.vue"),
                name: 'signup.otp',
                meta: {
                    title: DEFAULT_TITLE + 'ثبت کد تایید',
                    redirectIfLoggedIn: true
                }
            },
            {
                path: 'signup/state/:mobile/',
                component: ()=> import("../../../views/authentication/SignUp.vue"),
                name: 'signup.state',
                meta: {
                    title: DEFAULT_TITLE + 'ثبت نام',
                    redirectIfLoggedIn: true
                }
            },
            {
                path: 'signup/terms/:mobile/',
                component: ()=> import("../../../views/authentication/SignUpTerms.vue"),
                name: 'signup.terms',
                meta: {
                    title: DEFAULT_TITLE + 'قوانین',
                    redirectIfLoggedIn: true
                }
            },
            // {
            //     path: 'signup/otp/:status/:mobile/',
            //     component: ()=> import("../../views/authentication/SignUpOtp.vue"),
            //     name: 'verify',
            //     meta: {
            //         title: DEFAULT_TITLE + 'ثبت کد تایید',
            //         redirectIfLoggedIn: true
            //     }
            // },
            // {
            //     path: 'signup/:status/:mobile/',
            //     component: ()=> import("../../views/authentication/SignUp.vue"),
            //     name: 'register',
            //     meta: {
            //         title: DEFAULT_TITLE + 'ثبت نام',
            //         redirectIfLoggedIn: true
            //     }
            // },
            // {
            //     path: 'terms/:status/:mobile/',
            //     component: ()=> import(/* webpackChunkName: "auth-terms" */ "../../views/authentication/SignUpTerms.vue"),
            //     name: 'terms',
            //     meta: {
            //         title: DEFAULT_TITLE + 'قوانین',
            //         redirectIfLoggedIn: true
            //     }
            // },
        ],
    },
];
