<script setup>
import {useUrl} from "@/composable/useUrl";
const { defaultImageUrlBuilder } = useUrl();

const scrollToSection = (id)=>{
  const element = document.getElementById(id);
  if (element) {
    element.scrollIntoView({
      behavior: 'smooth'
    });
  }
}
</script>

<template>
  <div>
    <div class="pwa-wizard-heading d-flex flex-column pa-4 align-center justify-center">
      <div class="w-100 d-flex flex-row justify-start align-center">
        <v-img class="flex-shrink-1 flex-grow-0" width="50" height="50" :src="defaultImageUrlBuilder('assets/images/pwa-wizard/arrow.png')" />
        <span class="text-white font-weight-bold">از اینجا!</span>
      </div>
      <h1 class="text-center text-h5 font-weight-bold text-white mb-10">
        تو ۳ قدم اپلیکیشن کلاسینو رو نصب کن!
      </h1>
    </div>
    <v-card-text class="pa-4">/home/ragnarok/Downloads/IMG_9909 (1).png
      <v-card class="mt-n16" rounded="lg" flat>
        <v-list>
          <v-list-item class="px-2">
            <v-list-item-title class="text-wrap text-body-2">
              ازبالای صفحه، روی آیکون <strong>Share</strong> کلیک کن
            </v-list-item-title>
            <template #append>
              <v-btn size="x-small" color="primary" variant="elevated" readonly icon="$mdiExportVariant" />
            </template>
          </v-list-item>
          <v-divider class="my-4"/>
          <v-list-item class="px-2">
            <v-list-item-title class="text-wrap text-body-2">
              از قسمت پایین منوی باز شده، دکمه‌ی <strong>Add to Home Screen</strong> رو انتخاب کن
            </v-list-item-title>
            <template #append>
              <v-btn size="x-small" color="primary" variant="elevated" readonly icon="$mdiPlusBoxOutline" />
            </template>
          </v-list-item>
          <v-divider class="my-4"/>
          <v-list-item class="px-2">
            <v-list-item-title class="text-wrap text-body-2">
              در قسمت پایین صفحه، روی <strong>Install</strong> کلیک کن
            </v-list-item-title>
            <template #append>
              <v-btn size="x-small" color="primary" variant="elevated" readonly icon="" text="Add" />
            </template>
          </v-list-item>
        </v-list>
      </v-card>
      <section class="mt-8 text-center">
        <h2 class="font-weight-bold text-body-1 text-grey-darken-3">چرا کلاسینو رو نصب کنم؟</h2>

        <p class="text-body-1 text-grey-darken-3 mt-6">
          با نصب کردن اپلیکیشن می‌تونی همیشه و همه‌جا کلاسینو رو روی گوشیت داشته باشی، به همه محتواها دسترسی داشته باشی، از آخرین اخبار مطلع باشی و مهم‌تر از همه، از هیچ درسی جا نمونی!
        </p>


        <v-btn @click="scrollToSection('guide')"  size="x-large" variant="tonal" color="primary" rounded="pill" class=" mt-6 text-subtitle-1 font-weight-bold">
          <v-icon>$mdiImageOutline</v-icon>
          آموزش تصویری نصب اپلیکیشن کلاسینو
        </v-btn>
      </section>
      <section id="guide" class="mt-16 pt-16">
        <h2 class="text-body-1 font-weight-bold text-center">آموزش تصویری نصب اپلیکیشن کلاسینو</h2>
        <h3 class="text-body-1 font-weight-bold text-primary mt-6">قدم اول</h3>
        <p class="mt-1">از منوی بالای صفحه، روی آیکون <strong>Share</strong> کلیک کن</p>
        <v-img class="flex-shrink-1 flex-grow-0 mt-4" width="100%" :src="defaultImageUrlBuilder('assets/images/pwa-wizard/ios/first_step.png')" />

        <h3 class="text-body-1 font-weight-bold text-primary mt-6">قدم دوم</h3>
        <p class="mt-1"> از قسمت پایین منوی باز شده، دکمه‌ی <strong>Add to Home Screen</strong> رو انتخاب کن </p>
        <v-img class="flex-shrink-1 flex-grow-0 mt-4" width="100%" :src="defaultImageUrlBuilder('assets/images/pwa-wizard/ios/second_step.png')" />

        <h3 class="text-body-1 font-weight-bold text-primary mt-6">قدم سوم</h3>
        <p class="mt-1">در قسمت بالای صفحه، روی <strong>Add</strong> کلیک کنکلیک کن </p>
        <v-img class="flex-shrink-1 flex-grow-0 mt-4" width="100%" :src="defaultImageUrlBuilder('assets/images/pwa-wizard/ios/third_step.png')" />

        <h3 class="text-body-1 font-weight-bold text-primary mt-6">تمام شد!</h3>
        <p class="mt-1"> الان دیگه اپلیکیشن کلاسینو رو روی گوشیت داری! </p>
        <v-img class="flex-shrink-1 flex-grow-0 mt-4" width="100%" :src="defaultImageUrlBuilder('assets/images/pwa-wizard/ios/forth_step.png')" />
      </section>
    </v-card-text>
  </div>

</template>

<style scoped lang="scss">
.pwa-wizard-heading {
  width: 100%;
  height: 284px;
  background: linear-gradient(138deg, rgba(102, 26, 255, 0.80) 25%, rgba(0, 111, 255, 0.80) 75%);
}
</style>