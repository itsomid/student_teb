<script setup>
  import StoreFilters from "@/components/store/products/StoreFilters.vue";
  import {useRoute, useRouter} from "vue-router";
  import {useStore} from "vuex";
  import {computed} from "vue";

  const dialog = defineModel({default: false});
  const router = useRouter();
  const route = useRoute();

  const store = useStore();
  const filters = computed(()=> store.getters['shop/filters']);
  const cancel = ()=> {
    router.push({query: {}})
    dialog.value = false;
  }
  const submit = ()=>{
    dialog.value = false;
  }
</script>

<template>
    <v-dialog
        v-model="dialog"
        transition="dialog-bottom-transition"
        fullscreen
    >
      <template v-slot:activator="{ props: activatorProps }">
        <v-btn
            variant="text"
            color="secondary"
            border
            block
            rounded="lg"
            append-icon="$mdiFilterOutline"
            size="large"
            text="فیلتر‌ها"
            v-bind="activatorProps"
        ></v-btn>
      </template>

      <v-card rounded="0">
        <v-toolbar>


          <v-toolbar-title>فیلترها</v-toolbar-title>

          <v-spacer></v-spacer>

          <v-btn
              icon="$mdiClose"
              @click="cancel"
          ></v-btn>
        </v-toolbar>
        <v-toolbar color="grey-lighten-1 ">
          {{ state }}
        </v-toolbar>
        <v-card-text>
          <StoreFilters />
        </v-card-text>
        <v-card-actions class="pa-0 bg-primary">
          <v-btn class="" rounded="0" height="" tile variant="flat" block color="primary" size="x-large" @click="submit">
            اعمال
          </v-btn>
        </v-card-actions>
      </v-card>
    </v-dialog>
</template>

<style scoped lang="scss">

</style>