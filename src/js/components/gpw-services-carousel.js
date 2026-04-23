export default class ServicesCarousel {
  constructor() {
    try {
      this.cachedElements();
      this.initSwiper();
    } catch (error) {
      console.warn('SERVICE CAROUSEL ERROR: ', error);
    }
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

    this.swiper = new Swiper(this.swiperEl, {
      slidesPerView: 2,
      spaceBetween: 20,
      navigation: {
        nextEl: '.services__carousel .gpw-nav-btn__next',
        prevEl: '.services__carousel .gpw-nav-btn__prev',
      },
      breakpoints: {
        550: {
          slidesPerView: 3,
        },
        850: {
          slidesPerView: 4,
        }
      }
    });
  }
};