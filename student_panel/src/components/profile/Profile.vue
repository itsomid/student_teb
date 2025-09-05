<script setup>

import ProfileChangePassword from "@/components/profile/ProfileChangePassword.vue";
import ProfileUpdate from "@/components/profile/ProfileUpdate.vue";

import {onMounted, ref} from "vue";
import {useStore} from "vuex";
import ClLoading from "@/components/base/ClLoading.vue";
import ProfileHadsinoStudentGuess from "@/components/profile/ProfileHadsinoStudentGuess.vue";
import ProfileHadsinoStudentReport from "@/components/profile/ProfileHadsinoStudentReport.vue";
const loading = ref(false);
const store = useStore();

const getUser = async ()=> {
  try {
    loading.value = true;
    await store.dispatch('userStore/updateProfile');
  }catch (e) {
    console.log(e);
  }finally {
    loading.value = false;
  }
}

onMounted(()=> {
  getUser();
})
</script>

<template>
 <div>
   <!-- Loading indicator -->
   <ClLoading v-if="loading" />
   <v-row v-else>
     <v-col cols="12" lg="3">
       <ProfileChangePassword />
     </v-col>
     <v-col cols="12" lg="9">
       <ProfileUpdate />

      <v-row class="mt-10">
        <v-col cols="12" lg="6">
          <ProfileHadsinoStudentGuess />
        </v-col>
        <v-col cols="12" lg="6">
          <ProfileHadsinoStudentReport />
        </v-col>
       </v-row>
     </v-col>
   </v-row>
 </div>
</template>

<style scoped lang="scss">

</style>