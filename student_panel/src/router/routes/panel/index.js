"use strict";

import {useStore} from "vuex";
import {NAVBAR_ACTION_BACK, NAVBAR_ACTIONS} from "@/constants/navbarActions.const";

const DEFAULT_TITLE = '';
export default [
    {
        path: '/newpanel',
        redirect: { name: 'dashboard' },
        meta: {
            layout: "default",
        },
        children: [
            {
                path: 'dashboard',
                component: ()=> import("../../../views/DashboardView.vue"),
                name: 'dashboard',
                meta: {
                    title: DEFAULT_TITLE + 'میز مطالعه',
                    redirectIfLoggedIn: false,
                }
            },
            {
                path: 'ostadino',
                component: ()=> import("../../../views/OstadinoView.vue"),
                name: 'ostadino',
                meta: {
                    title: DEFAULT_TITLE + 'استادینو',
                    redirectIfLoggedIn: false,
                }
            },
            {
                path: 'ostadino-detail/:professorId',
                component: ()=> import("../../../views/OstadinoTeacherDetailView.vue"),
                name: 'ostadino.detail',
                meta: {
                    title: DEFAULT_TITLE + 'استادینو',
                    redirectIfLoggedIn: false,
                }
            },
            {
                path: 'ostadino-set-rate',
                component: ()=> import("../../../views/OstadinoSetRateRedirectAfterLogin.vue"),
                name: 'ostadino.set-rate',
                meta: {
                    title: DEFAULT_TITLE + 'استادینو',
                    redirectIfLoggedIn: false,
                }
            },
            {
                path: 'book-fair',
                component: ()=> import("../../../views/BookFairRedirectAfterLogin.vue"),
                name: 'book-fair',
                meta: {
                    title: DEFAULT_TITLE + 'نمایشگاه',
                    redirectIfLoggedIn: false,
                }
            },
            {
                path: 'my-courses',
                component: ()=> import("../../../views/MyCoursesView.vue"),
                name: 'my-courses',
                meta: {
                    title: DEFAULT_TITLE + 'دوره های من',
                    redirectIfLoggedIn: false,
                }
            },
            {
                path: 'courses/:id',
                component: ()=> import("../../../views/CourseView.vue"),
                name: 'course',
                meta: {
                    title: DEFAULT_TITLE + 'دوره',
                    redirectIfLoggedIn: false,
                    actions: {
                        CART : NAVBAR_ACTIONS.CART,
                        BACK : NAVBAR_ACTION_BACK.BACK
                    }
                }
            },
            {
                path: 'course/activity/:course_id',
                component: ()=> import("../../../views/CourseActivityView.vue"),
                name: 'course.activity',
                meta: {
                    title: DEFAULT_TITLE + 'وضعیت تحصیلی',
                    redirectIfLoggedIn: false,
                    actions: {
                        BACK : NAVBAR_ACTION_BACK.BACK
                    }
                }
            },
            {
                path: 'class',
                name: 'class',
                meta: {
                    title: DEFAULT_TITLE + 'کلاس',
                    redirectIfLoggedIn: false,
                },
                redirect: { name: 'show-class'},
                children: [
                    {
                        path: 'show/:id',
                        component: ()=> import("../../../views/ClassView.vue"),
                        name: 'show-class',
                        meta: {
                            title: DEFAULT_TITLE + 'کلاس',
                            redirectIfLoggedIn: false,
                            actions: {
                                BACK : NAVBAR_ACTION_BACK.BACK
                            }
                        }
                    },
                    {
                        path: 'recorded-class/:video_quality/:class_id',
                        component: ()=> import('../../../views/ClassRecordedView.vue'),
                        name: 'recorded-class',
                        meta: {
                            title: DEFAULT_TITLE + 'نمایش کلاس',
                            redirectIfLoggedIn: false,
                            actions: {
                                BACK : NAVBAR_ACTION_BACK.BACK
                            }
                        }
                    },
                ]
            },
            {
                path: 'class/question-answer/:course_id/:class_id',
                component: ()=> import("../../../views/ClassQuestionAndAnswerView.vue"),
                name: 'question-answer',
                meta: {
                    title: DEFAULT_TITLE + 'پرسش و پاسخ',
                    redirectIfLoggedIn: false,
                    actions: {
                        BACK : NAVBAR_ACTION_BACK.BACK
                    }
                }
            },
            {
                path: 'class/homework/:class_id',
                component: ()=> import("../../../views/ClassHomeworkView.vue"),
                name: 'homework',
                meta: {
                    title: DEFAULT_TITLE + 'ارسال تکلیف',
                    redirectIfLoggedIn: false,
                    actions: {
                        BACK : NAVBAR_ACTION_BACK.BACK
                    }
                }
            },
            {
                path: 'class/report/:class_id',
                component: ()=> import("../../../views/ClassReportView.vue"),
                name: 'report',
                meta: {
                    title: DEFAULT_TITLE + 'ارسال کارنامه',
                    redirectIfLoggedIn: false,
                    actions: {
                        BACK : NAVBAR_ACTION_BACK.BACK
                    }
                }
            },
            {
                path: 'class/quiz/:quiz_id',
                component: ()=> import("../../../views/ClassQuizView.vue"),
                name: 'quiz',
                meta: {
                    title: DEFAULT_TITLE + 'آزمون',
                    redirectIfLoggedIn: false,
                    actions: {
                        BACK : NAVBAR_ACTION_BACK.BACK
                    }
                }
            },
            {
                path: '/class/join-cc/:class_id',
                component: ()=> import("../../../views/JoinCCOnRedirectAfterLoginView.vue"),
                name: 'joinCC',
                meta:{
                    title: DEFAULT_TITLE,
                    redirectIfLoggedIn: false
                }
            },
            {
                path: 'class/answer-sheet/:quiz_id',
                component: ()=> import("../../../views/ClassQuizAnswerView.vue"),
                name: 'answer-sheet',
                meta: {
                    title: DEFAULT_TITLE + 'پاسخنامه',
                    redirectIfLoggedIn: false,
                    actions: {
                        BACK : NAVBAR_ACTION_BACK.BACK
                    }
                }
            },
            {
                path: 'store',
                name: 'store',
                redirect: { name: 'store.main'},
                meta: {
                    title: DEFAULT_TITLE + 'خرید دوره',
                    redirectIfLoggedIn: false,
                },
                children: [
                    {
                        path: '',
                        component: ()=> import("../../../views/StoreView.vue"),
                        name: 'store.main',
                        meta: {
                            title: DEFAULT_TITLE + 'خرید دوره',
                            redirectIfLoggedIn: false,
                        },
                    },
                    {
                        path: 'product/:id',
                        component: ()=> import("../../../views/ProductView.vue"),
                        name: 'product',
                        meta: {
                            title: DEFAULT_TITLE + 'درباره محصول',
                            redirectIfLoggedIn: false,
                            actions: {
                                CART : NAVBAR_ACTIONS.CART,
                                BACK : NAVBAR_ACTION_BACK.BACK
                            }
                        }
                    },
                ]
            },
            {
                path: 'finance',
                name: 'finance',
                meta: {
                    title: DEFAULT_TITLE + 'امور مالی',
                    redirectIfLoggedIn: false,
                },
                beforeEnter(to, from, next) {
                    const store = useStore();
                    store.dispatch('userStore/updateProfile').then(res => next())
                },
                redirect: { name: 'finance.main'},
                children: [
                    {
                        path: '',
                        component: ()=> import("../../../views/FinanceView.vue"),
                        name: 'finance.main',
                        meta: {
                            title: DEFAULT_TITLE + 'امور مالی',
                            redirectIfLoggedIn: false,
                        },
                        beforeEnter(to, from, next) {
                            const store = useStore();
                            store.dispatch('userStore/updateProfile').then(res => next())
                        },
                    },
                    // {
                    //     path: 'increase-credit/:amount?',
                    //     component: ()=> import(/* webpackChunkName: "dashboard-finance" */ "../../../views/FinanceIncreaseCreditView.vue"),
                    //     name: 'finance.increase-credit',
                    //     meta: {
                    //         title: DEFAULT_TITLE + 'افزایش اعتبار',
                    //         redirectIfLoggedIn: false,
                    //         actions: {
                    //             BACK : NAVBAR_ACTION_BACK.BACK
                    //         }
                    //     }
                    // },
                ]
            },
            {
                path: 'cart',
                component: ()=> import('../../../views/CartView.vue'),
                name: 'cart',
                meta: {
                    title: DEFAULT_TITLE + 'سبد خرید',
                    redirectIfLoggedIn: false,
                    actions: {
                        BACK : NAVBAR_ACTION_BACK.BACK
                    }
                },
            },
            {
                path: '/add-to-cart/:product_id',
                component: ()=> import("../../../views/AddToCartOnRedirectAfterLoginView.vue"),
                name: 'addToCartOnRedirectAfterLogin',
                meta: {
                    title: DEFAULT_TITLE,
                    redirectIfLoggedIn: false
                }
            },
            {
                path: 'shop/packages/:id',
                component: ()=> import("../../../views/PackageView.vue"),
                name: 'package',
                meta: {
                    title: DEFAULT_TITLE + 'پکیج ها',
                    redirectIfLoggedIn: false,
                    actions: {
                        CART : NAVBAR_ACTIONS.CART,
                        BACK : NAVBAR_ACTION_BACK.BACK
                    }
                }
            },
            {
                path: 'shop/product/:id',
                component: ()=> import("../../../views/ProductView.vue"),
                name: 'product',
                meta: {
                    title: DEFAULT_TITLE + 'درباره محصول',
                    redirectIfLoggedIn: false,
                    actions: {
                        CART : NAVBAR_ACTIONS.CART,
                        BACK : NAVBAR_ACTION_BACK.BACK
                    }
                }
            },
            {
                path: 'shop/packages-planz/:id',
                component: ()=> import("../../../views/PackagePlanZView.vue"),
                name: 'package.planz',
                meta: {
                    title: DEFAULT_TITLE + 'پکیج ها Plan Z',
                    redirectIfLoggedIn: false,
                    actions: {
                        CART : NAVBAR_ACTIONS.CART,
                        BACK : NAVBAR_ACTION_BACK.BACK
                    }
                }
            },
            {
                path: 'chat/:user_id?',
                component: ()=> import( "../../../views/ChatView.vue"),
                name: 'chat',
                meta: {
                    title: DEFAULT_TITLE + 'گفتگو',
                    redirectIfLoggedIn: false,
                    actions: {
                        BACK : NAVBAR_ACTION_BACK.BACK
                    }
                }
            },
            {
                path: 'notifications',
                name: 'notifications',
                component: ()=> import("../../../views/NotificationsView.vue"),
                meta: {
                    title: DEFAULT_TITLE + 'اعلان ها',
                    redirectIfLoggedIn: false
                }
            },
            {
                path: 'payment-receipt',
                component: ()=> import("../../../views/PaymentView.vue"),
                name: 'payment',
                meta: {
                    title: DEFAULT_TITLE + 'رسید خرید',
                    redirectIfLoggedIn: false,
                }
            },
            {
                path: '/profile',
                component: ()=> import("../../../views/ProfileView.vue"),
                name: 'profile',
                meta: {
                    title: DEFAULT_TITLE + 'پروفایل',
                    redirectIfLoggedIn: false,
                    actions: {
                        NOTIFICATIONS: NAVBAR_ACTIONS.NOTIFICATIONS,
                        BACK : NAVBAR_ACTION_BACK.BACK
                    }
                }
            },
        ]
    },
];
