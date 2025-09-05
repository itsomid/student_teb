import {describe , test,expect} from "vitest";
 import Snackbar from  "/src/components/base-components/Snackbar.vue"
import {shallowMount} from "@vue/test-utils";
import {createVuetify} from "vuetify";
const vuetify = createVuetify()

describe("Snackbar | src/components/base-components/Snackbar.vue" ,()=>{
    test("render component" , ()=>{
      const wrapper = shallowMount(Snackbar)
      expect(wrapper.exists()).toBeTruthy()
    })

    test("test show snackbar" ,()=>{
        const wrapper = shallowMount(Snackbar,{
            data (){
              return {
                  data :{
                      text:"its snackbar"
                  },
              }
            }
        })
        const snackbar =wrapper.find("div")
        expect(snackbar.html()).toBeTruthy()

    })

    test("test hide snackbar" ,()=>{
        const wrapper = shallowMount(Snackbar,{
            data (){
                return {
                    data :{
                        text:null
                    },
                }
            }
        })
        const snackbar =wrapper.find("div")
        expect(snackbar.html()).toBeTruthy()

    })

    test("test message of snackbar" ,()=>{
        const wrapper = shallowMount(Snackbar,{
            data (){
                return {
                    data :{
                        text:"its snackbar"
                    },
                }
            },
            global: {
                plugins: [vuetify],
            },
            shallow: true,
        //     stubs:{
        //    "v-snackbar-stub":"v-snackbar"
        // }
        })
        console.log(wrapper,"wrapper")
         // const snackbar =wrapper.find("v-snackbar-stub")
         // console.log(snackbar.text(),"snackbar")
        // expect(snackbar.text()).toEqual(wrapper.vm.$data.data.text)

    })
})
