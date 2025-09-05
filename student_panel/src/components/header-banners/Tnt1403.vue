<template>
  <div class="header-banner tnt-1403"
       style="cursor: pointer;">
    <div class="right-logo">
      <img alt="right" src="@/assets/images/header-banner/Tnt1403/rightD.svg">
    </div>
    <div class="container">
      <div class="banner-content eshteraki-1403-content">
        <div class="eshteraki-details">
          <p> شروع ثبت‌نام دوره های تدریس، نکته و تست</p>
          <div class="wave-sec">
            <p class="army">
              <span>(TNT)</span>
              <span>(TNT)</span>
            </p>
            <p class="classino">
              <span>کلاسینو</span>
              <span>کلاسینو</span>
            </p>
          </div>

          <!--          <p>کلاسینو</p>-->
          <!--            <span class="neonText-LightPink">(TNT)</span>-->
        </div>
        <div class="ctas">
          <a class="cta-btn-eshteraki primary" href="https://landing.classino.com/TNT_1403">
            توضیحات بیشتر
          </a>
          <a class="cta-btn-eshteraki" href="https://student.classino.com/redirectAfterLogin/buy/25054">
            رایگان تجربه کن
          </a>
        </div>
      </div>
    </div>
    <div class="left-logo">
      <img alt="left" src="@/assets/images/header-banner/Tnt1403/leftD.svg">
    </div>
  </div>
</template>

<script>
export default {
  name: "Tnt1403"
}
</script>

<style lang="scss">
@import '../../../node_modules/vuetify/lib/styles/main.sass';
.wave-sec{
  display: flex;
  justify-content: space-around;
  width: 210px;
  height: 30px;
  @media #{map-get($display-breakpoints, 'md-and-down')} {
    margin-top: .8rem;
  }
  span {
    color: #fff;
    font-size: 1.3em;
    position: absolute;
    @media #{map-get($display-breakpoints, 'lg-and-down')} {
      font-size: 1.7rem;
    }
  }
  .classino{
    display: flex;
    align-items: center;
    justify-content: center;
    span:nth-child(1) {
      color: transparent;
      -webkit-text-stroke: 2px #03a9f4;
    }

    span:nth-child(2) {
      color: #FFF;
      animation: wave 5s ease-in-out infinite;
    }
  }
  .army {
    display: flex;
    align-items: center;
    justify-content: center;
    //font-family: "Poppins", sans-serif;

    span:nth-child(1) {
      color: transparent;
      -webkit-text-stroke: 2px #FFAF20;
    }
    span:nth-child(2) {
      color: #FFAF20;
      animation: wave 2s ease-in-out infinite;
    }
  }
}


.tnt-1403 {
  width: 100%;
  display: flex !important;
  flex-direction: row;
  justify-content: space-around;
  position: relative;
  align-items: center;
  background: url("@/assets/images/header-banner/Tnt1403/backD.jpg") no-repeat center;
  background-size: cover;

  .container {
    padding: 0;
    height: 100%;
    width: 100%;
    display: flex;
    justify-content: center;
  }

  .right-logo {
    margin-right: 60px;
    //position: absolute;
    //right:0;
    //overflow: hidden;
    transform: scaleX(-1);

    img {
      max-width: 150px;
      @media #{map-get($display-breakpoints, 'lg-and-down')} {
        max-width: 75px;
      }
    }

    @media #{map-get($display-breakpoints, 'lg-and-down')} {
      //rotate: 270deg;
      //display: none;
      transform: rotate(90deg);
      margin-right: 0;
      position: absolute;
      right: 0;
    }


  }

  .left-logo {
    margin-left: 60px;
    img {
      max-width: 150px;
      @media #{map-get($display-breakpoints, 'lg-and-down')} {
        max-width: 75px;
      }
    }

    @media #{map-get($display-breakpoints, 'lg-and-down')} {
      transform: rotate(90deg);
      margin-left: 0;
      position: absolute;
      left: 0;
    }
  }

  .banner-content {
    width: 100%;
    display: flex;
    flex-direction: row;
    justify-content: space-between;
    align-items: center;
    @media #{map-get($display-breakpoints, 'lg-and-down')} {
      justify-content: center;
    }
    @media #{map-get($display-breakpoints, 'md-and-down')} {
      flex-direction: column;
    }

    .eshteraki-details {
      display: flex;
      flex-direction: row;
      align-items: center;
      text-align: center;
      justify-content: center;
      p{
        margin-bottom: 0;
      }
      font-size: 24px;
      color: #FFF;
      font-weight: 800;
      @media #{map-get($display-breakpoints, 'md-and-down')} {
        font-size: 15px;
        flex-direction: column;
      }
      @media #{map-get($display-breakpoints, 'lg')} {
        font-size: 18px;
      }
      @media #{map-get($display-breakpoints, 'md')} {
        font-size: 18px;
      }

    }

    .ctas {
      width: 35%;
      display: flex;
      flex-direction: row;
      justify-content: space-evenly;
      @media #{map-get($display-breakpoints, 'md-and-down')} {
        width: 80%;
        display: flex;
        flex-direction: row;
        justify-content: center;
      }

      .cta-btn-eshteraki {
        font-size: 14px;
        font-weight: 800;
        color: #000;
        text-align: center;
        padding: 10px 0;
        margin: 3px 0;
        border: 2px solid #000;
        background: #ffffff;
        border-radius: 40.5px;
        width: 40%;
        @media #{map-get($display-breakpoints, 'lg-and-down')} {
          padding: 7px 0;
          width: 40%;
          margin: 5px 5px 0;
        }

        &:hover {
          text-decoration: none;
          transition: 0.2s ease-out;
          box-shadow: 0 5px 11px 0 rgb(0 0 0 / 18%), 0 4px 15px 0 rgb(0 0 0 / 15%);
        }

      }

      .primary {
        border: 2px solid #000;
        background: #FFAF20;
      }
    }


  }
}
@keyframes wave {
  0%,
  100% {
    clip-path: polygon(
            0% 45%,
            16% 44%,
            33% 50%,
            54% 60%,
            70% 61%,
            84% 59%,
            100% 52%,
            100% 100%,
            0% 100%
    );
  }

  50% {
    clip-path: polygon(
            0% 60%,
            15% 65%,
            34% 66%,
            51% 62%,
            67% 50%,
            84% 45%,
            100% 46%,
            100% 100%,
            0% 100%
    );
  }
}
</style>
