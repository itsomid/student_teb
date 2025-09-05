<script setup>
  import {useRoute} from "vue-router";
  import {onMounted} from "vue";
  import {useNavigator} from "@/composable/useNavigator";
  import {useReagent} from "@/composable/useReagent";

  const route = useRoute();
  const { setReagentCode } = useReagent();
  const { navigateToAuth  } = useNavigator();

  onMounted(()=>{
    setReagentCode(route.params.reagent_code);
    window.location.href = `${import.meta.env.VITE_APP_NEW_STUDENT_PANEL_BASE_URL}/auth?referral=${route.params.reagent_code}`;
    // navigateToAuth();
  })
</script>

<template>
  <div></div>
</template>

<style scoped lang="scss">

</style>