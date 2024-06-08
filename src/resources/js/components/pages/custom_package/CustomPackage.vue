<template>
  <div>
    <div class="col-md-8">
      <button class="btn btn-primary text-white btn-block" type="button" style="margin-bottom: 20px" @click="addSection">ساختن Secction جدید
        <i class="fa fa-plus"></i>
      </button>
    </div>
    <package-section-manager v-for="(sect, i) in sections" :section="sect" :key="sect.id" @changeSec="changeSec" @removeSection="removeSection"></package-section-manager>

    <input type="hidden" v-for="input in sections" :value="JSON.stringify(input)" name="sections[]">
  </div>
</template>

<script>
import PackageSectionManager from './PackageSectionManager.vue'

export default {
  name: "CustomPackage",
  components:{
      PackageSectionManager
  },
  mounted() {
    if(this.sections_prop.length > 0){
      this.sections = JSON.parse(this.sections_prop);
    }else {
      this.addSection();
    }
  },
  props: {
    sections_prop: {
      type: String,
      default: ''
    }
  },
  data(){
    return {
      sections: []
    }
  },
  methods: {
    addSection() {
      let id = 1;
      if(this.sections.length > 0){
         id = this.sections[this.sections.length-1].id + 1;
      }

      this.sections.push({
        id: id,
        title: '',
        courses: []
      })
    },
    changeSec(newData){
      let index = this.sections.findIndex(section => section.id == newData.id);
      this.sections[index] = newData;
    },
    removeSection(data){
      console.log(data);
      let index = this.sections.findIndex(section => section.id == data.id);
      this.sections.splice(index, 1);
    }
  }
}
</script>

<style scoped>

</style>
