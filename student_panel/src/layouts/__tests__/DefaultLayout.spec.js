import {describe , it,expect } from "vitest";
import { mount} from "@vue/test-utils";

import DefaultLayout from "../DefaultLayout.vue"
import {createVuetify} from "vuetify";
const vuetify= createVuetify()

import Drawer from "@/components/layouts/Drawer.vue";
import AppBar from "@/components/layouts/AppBar.vue";

import ResizeObserver from 'resize-observer-polyfill'
window.ResizeObserver = ResizeObserver;

const $route = {
    name: "mock_route",
};
const wrapper  = mount(DefaultLayout , {
    global: {
        plugins: [vuetify],
        stubs:{
            'router-view' : true,
            Drawer : true,
            AppBar : true
        },
        mocks: {
            $route,
        },
    },
})
describe ("DefaultLayout.vue | @/src/layouts" , ()=>{

    it("render DefaultLayout component" , ()=>{
        expect(wrapper.find(".v-application").exists()).toBeTruthy();
    })

    it("render Drawer component in DefaultLayout" , ()=>{
        expect(wrapper.findComponent(Drawer).exists()).toBeTruthy();
    })

    it("render AppBar component in DefaultLayout" , ()=>{
        expect(wrapper.findComponent(AppBar).exists()).toBeTruthy()
    })
})
