import { describe , it , expect ,
     assert ,
    vi}   from "vitest"
import AppBar from "../../layouts/AppBar.vue";
import {mount} from "@vue/test-utils";
import {createVuetify} from "vuetify";
 const vuetify= createVuetify()
import Vuex from "vuex"
const wrapper = mount(AppBar  , {
    global :{
        plugins :[vuetify],
        stubs :{
            'v-app-bar' :false
        },
    }
})
console.log("wrapper",wrapper.html())
class ResizeObserver {
    observe() {}
    unobserve() {}
}
describe("AppBar" , ()=>{
    window.ResizeObserver = ResizeObserver;
    let state = {
        drawer: true,
    };
    let store;
    store = new Vuex.Store({
        modules: {
            drawer: {
                state,
                getters: {
                    drawer() {
                        return state.drawer;
                    },
                },
                mutations: {
                    mutateDrawer: (state) => {
                        state.drawer = !state.drawer;
                    },
                },
                actions: {
                    toggleDrawer: ({ commit }) => {
                        commit("mutateDrawer");
                    },
                },
                name: "drawer",
                namespaced: true,
            },
        },
    });
     const wrapper = mount(AppBar  , {
        global :{
            plugins :[vuetify],
            stubs :{
                'v-app-bar' :false
            },
         }
    })
      it("render component" , ()=>{
       expect(wrapper.exists()).toBeTruthy()
    })

    it("call toggle function" , async  ()=>{
        assert(2)
        const spy = vi.spyOn(wrapper.vm , "toggle")
        const btn = wrapper.find("#btn-drawer")
        expect(btn.exists()).toBeTruthy();
        await btn.trigger("click")
        expect(spy).toHaveBeenCalledTimes(1)
      })
})
