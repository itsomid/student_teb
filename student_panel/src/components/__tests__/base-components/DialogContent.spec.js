import { describe, it, expect } from 'vitest'
import { createVuetify } from 'vuetify'
const vuetify = createVuetify()
import { mount } from '@vue/test-utils'
import DialogContent from '@/components/base/DialogContent.vue'
describe('DialogContent.vue', () => {
  it('renders properly', () => {
    const wrapper = mount(DialogContent, {
      global: {
        plugins: [vuetify]
      }
    })
    expect(wrapper.exists()).toBeTruthy()
  })

  it('render content of title slot', () => {
    //Arrange
    const wrapper = mount(DialogContent, {
      global: {
        plugins: [vuetify]
      },
      slots: {
        title: '<div>title</div>'
      }
    })
    //Assert
    expect(wrapper.html()).toContain('<div>title</div>')
  })
  it('render content of body slot', () => {
    //Arrange
    const wrapper = mount(DialogContent, {
      global: {
        plugins: [vuetify]
      },
      slots: {
        body: '<div>body</div>'
      }
    })
    //Assert
    expect(wrapper.html()).toContain('<div>body</div>')
  })
  it('render content of action slot', () => {
    //Arrange
    const wrapper = mount(DialogContent, {
      global: {
        plugins: [vuetify]
      },
      slots: {
        action: '<div>action</div>'
      }
    })
    //Assert
    expect(wrapper.html()).toContain('<div>action</div>')
  })
})
