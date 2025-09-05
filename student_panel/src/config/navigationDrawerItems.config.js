export const LINKS = [
    {
        to: {name:'dashboard'},
        rules: ['dashboard'],
        icon: "cli:DeskLamp",
        text:"میز مطالعه"
    },
    {
        to: {name:'my-courses'},
        rules:  ['mycourses','course','show-class'],
        icon: "cli:Calendar",
        text:"دوره‌های من"
    },
    {
        to: {name:'store'},
        rules: ['store','cart'],
        icon: "cli:Book1",
        text:"خرید دوره"
    },
    {
        to: {name:'finance'},
        rules: ['finance', 'finance.increase-credit','gift-credit'],
        icon: "cli:Wallet3",
        text:"امور مالی"
    },
]

export const MOBILE_LINKS = [
    {
        to: {name:'profile'},
        rules: ['profile'],
        icon: "$mdiAccountCircleOutline",
        text:"پروفایل"
    },
]