<template>
    <v-img  :class="className" :src="imageFileName" @load="onImageLoad()" v-show="imageLoaded" />
    <div class="image-loading" v-if="!imageLoaded && imageFileName">
      <img src="@/assets/images/default/Loading-300-300.gif" alt="">
      <slot></slot>
      <v-skeleton-loader type="image" :width="skeletonWidth" :height="skeletonHeight" />
    </div>
</template>

<script>
export default {
  name: "ImageLoading",
  props: ['imageFileName', 'skeletonWidth', 'skeletonHeight', 'className'],
  data() {
    return {
      imageLoaded: false,
    };
  },
  methods: {
    onImageLoad() {
      this.imageLoaded = true;
    },
    getImageSrc(filename) {
      if (['quiz', 'answer-sheet'].includes(this.$route.name)){
        return `${this.$storeFourBaseUrl}/filepond/quiz/${filename}`
      } else if(['store', 'mycourses','product-detail'].includes(this.$route.name)){
        return `${this.$storeFourBaseUrl}/filepond/product/${filename}`
      }else{
        return filename ?  `${this.$baseImgUrl}/uploads/images/shop/${filename}` :  require('../../../assets/images/classino_default.jpeg')
      }
    },
  },
};
</script>

<style lang="scss" scoped>
.image-loading{
  position: relative;
  display: flex;
  justify-content: center;
  align-items: center;
  img{
    width: 75px;
    &:nth-child(1){
      position: absolute;
    }
  }
  h5{
    color:#085cd7;
    position: absolute;
    top: 65%;
  }
}
</style>
