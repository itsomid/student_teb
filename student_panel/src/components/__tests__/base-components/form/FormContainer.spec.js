import { describe, test ,  expect } from 'vitest'
import { shallowMount , mount } from "@vue/test-utils";
import { createVuetify } from "vuetify"
import FormContainer from "../../../base/form/FormContainer.vue";
 const vuetify = createVuetify()


describe("FormContainer | @/src/components/base-components/form/FormContainer" , ()=>{

    test("render component " , ()=>{
        //Arrange
        const  wrapper = shallowMount(FormContainer , {
                global: {
                    plugins: [vuetify],
                },
            })

        //Assert
        expect(wrapper.exists()).toBeTruthy()
    })

    test(("render content of body slot") , ()=>{

        //Arrange
         const  wrapper =mount(FormContainer , {
            global: {
                plugins: [vuetify],
                stubs: {
                    "v-form": false,
                },
            },
            slots: {
                body: "<div>body</div>",
            },
        });

        //Assert
        expect(wrapper.html()).toContain("<div>body</div>");

       })

    test(("render content of action-inline slot") , ()=>{

        //Arrange
        const  wrapper =mount(FormContainer , {
            global: {
                plugins: [vuetify],
                stubs: {
                    "v-form": false,
                },
            },
            slots: {
                body: "<div>action-inline</div>",
            },
        });

        //Assert
        expect(wrapper.html()).toContain("<div>action-inline</div>");

    })

    test(("render content of action slot") , ()=>{

        //Arrange
        const  wrapper =mount(FormContainer , {
            global: {
                plugins: [vuetify],
                stubs: {
                    "v-form": false,
                },
            },
            slots: {
                body: "<div>action</div>",
            },
        });

        //Assert
        expect(wrapper.html()).toContain("<div>action</div>");

    })
})