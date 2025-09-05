import { describe, test ,  expect } from 'vitest'
import {mount} from "@vue/test-utils";
import FormGenerator from "../../../base/form/FormGenerator.vue";
import {createVuetify} from "vuetify";
const vuetify = createVuetify()

describe("FormGenerator | @/src/components/base-components/form/FormGenerator" , ()=>{


  const schema =[
        {type :"text",
            id:"name",
            xl:"4",
            lg :"4",
            md :"4",
            sm:"12",
            visible:"false",
            label :"نام",
            placeholder :"لطفا نام را وارد کنید",
            clearable :true ,
            suffix :"ریال",
            innerIcon:"account",
            prependIcon:"account",
            disabled :true

        }
        ,{
            type :"password",
            id:"name",
            xl:"4",
            lg :"4",
            md :"4",
            sm:"12",
            visible:"false",
            label :"رمز",
            placeholder :"لطفا رمز را وارد کنید",
            clearable :false
        },
    ];

  test("render component" , ()=>{

      //Arrange
      const wrapper = mount(FormGenerator , {
            global: {
                plugins: [vuetify],
            },
        })

      //Assert
      expect(wrapper.exists()).toBeTruthy()
  })

  test("render body slot" , ()=>{

      //Arrange
      const bodySlotContent  = "<div>body</div>";
      const wrapper  = mount(FormGenerator , {
           slots:{
               body :bodySlotContent
           }
       })

      //Assert
      expect(wrapper.html()).toContain(bodySlotContent)
  })

  test("render all element of schema in template" , ()=>{

        //Arrange
        const wrapper = mount(FormGenerator , {
            global: {
                plugins: [vuetify],
            },
            propsData :{schema},
        })

        //Action
        const items = wrapper.findAll("#form-generator-input")

         //Assert
        expect(items.length).toBe(schema.length)

    })

  test("test binding label",()=>{

      //Arrange

      //Action
      const wrapper = mount(FormGenerator , {
          global: {
              plugins: [vuetify],
          },
          propsData :{schema},
      })
      const labels = wrapper.findAll("label")

      //Assert
      expect(labels[0].html()).toContain(schema[0].label)
  })

  test("test binding placeholder for input",()=>{

        //Arrange
        //Action
        const wrapper = mount(FormGenerator , {
            global: {
                plugins: [vuetify],
            },
            propsData :{schema},
        })
        const inputs = wrapper.findAll("input")

        //Assert
         expect(inputs[0].attributes().placeholder).toEqual(schema[0].placeholder)
    })

  test("test binding clearable for input",()=>{

        //Arrange
        //Action
        const wrapper = mount(FormGenerator , {
            global: {
                plugins: [vuetify],
            },
            propsData :{schema},
        })
        const input = wrapper.find("#form-generator-input")
        let clearable = input.find(".v-field__clearable")

        //Assert
        expect(clearable).toBeTruthy()
    })

  test("test binding suffix for input",()=>{

        //Arrange
        //Action
        const wrapper = mount(FormGenerator , {
            global: {
                plugins: [vuetify],
            },
            propsData :{schema},


        })
        const input = wrapper.find("#form-generator-input")
        let suffix = input.find(".v-text-field__suffix")

        //Assert
        expect(suffix.text()).toEqual(schema[0].suffix)
    })

  test("test binding inner icon for input",()=>{

        //Arrange
        //Action
        const wrapper = mount(FormGenerator , {
            global: {
                plugins: [vuetify],
            },
            propsData :{schema},
        })
        const input = wrapper.find("#form-generator-input")
        let innerIcon = input.find(".v-field__append-inner")

        //Assert
        expect(innerIcon).toBeTruthy()
    })

  test("test binding prepend icon   for input",()=>{

        //Arrange
        //Action
        const wrapper = mount(FormGenerator , {
            global: {
                plugins: [vuetify],
            },
            propsData :{schema},
        })
        const input = wrapper.find("#form-generator-input")
        let prependIcon = input.find(".v-input__prepend")

        //Assert
        expect(prependIcon).toBeTruthy()
    })

  test("test disabled input",()=>{

        //Arrange
        //Action
        const wrapper = mount(FormGenerator , {
            global: {
                plugins: [vuetify],
            },
            propsData :{schema},


        })
        const inputWrapper = wrapper.find("#form-generator-input")
        const input = inputWrapper.find("div")

         //Assert
        expect(input.classes()).contain("v-input--disabled")
     })

  test("test body action" ,()=>{

        //Arrange
        const actionSlotContent  = "<div>action</div>";
        const wrapper  = mount(FormGenerator , {
            slots:{
                body :actionSlotContent
            }
        })

        //Assert
        expect(wrapper.html()).toContain(actionSlotContent)
})


})
