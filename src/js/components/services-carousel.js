export default class ServicesCarousel {
  constructor() {
    this.cachedElements();
    this.initSwiper();
  }
  cachedElements() {
    this.swiperEl = document.querySelector('.services__carousel .swiper');
    if( !this.swiperEl ) {
      throw new Error('Swiper element not found in Services Section');
    }
  }
  initSwiper() {
    if( typeof Swiper === 'undefined' ) {
      throw new Error('Swiper is not defined');
    }

    new Swiper(this.swiperEl, {
      slidesPerView: 1,
      spaceBetween: 20,
      navigation: {
        nextEl: '.services__carousel .gpw-nav-btn__next',
        prevEl: '.services__carousel .gpw-nav-btn__prev',
      },
      breakpoints: {
        550: {
          slidesPerView: 2,
        },
        850: {
          slidesPerView: 4,
        }
      }
    });
  }
};