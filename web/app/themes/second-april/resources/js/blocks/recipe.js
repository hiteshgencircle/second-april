// import Swiper JS
import Swiper from 'swiper';

import {Navigation, Pagination, Autoplay, EffectFade} from 'swiper/modules';
import 'swiper/css/autoplay';
document.addEventListener('DOMContentLoaded', () => {
  console.log("ssss");
  const swiper = new Swiper('.workshops-swiper', {
    modules: [Autoplay],
  direction: 'horizontal',
  loop: true,
  autoplay: {
    delay: 3000,
    disableOnInteraction: false,
  },
  slidesPerView: 1,
  spaceBetween: 46,
  breakpoints: {
    768: {
      slidesPerView: 2,
    },
  },
  dir: 'rtl',
});

function syncHeights() {
  const banner = document.querySelector('.banner-card');
  const sliderArea = document.querySelector('.slider-area');
  // Reset first so natural height can be measured
  banner.style.height = '';
  sliderArea.style.height = '';

  const swiperH = document.querySelector('.workshops-swiper').offsetHeight;
  const bannerH = banner.offsetHeight;
  const maxH = Math.max(swiperH, bannerH);

  banner.style.height = maxH + 'px';
  sliderArea.style.height = maxH + 'px';
}

});
