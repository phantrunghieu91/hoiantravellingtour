export default class Testimonial {
  constructor(selector = 'testimonials') {
    try {
      this.selector = selector;
      this.cachedDOM(selector);
      this.initSwiper();
    } catch( error ) {
      console.error( `TESTIMONIAL: ${error}`);
    }
  }
  cachedDOM( ) {
    this.swiperEl = document.querySelector(`.${this.selector} .swiper`);
    if( !this.swiperEl ) {
      throw Error( 'Can\'t find swiper element!');
    }
  }
  initSwiper() {
    if( typeof Swiper == 'undefined' || !this.swiperEl ) {
      throw Error( 'Can\'t find Swiper module or Swiper element can NOT be found.');
    }
    this.swiper = new Swiper( this.swiperEl, {
      slidesPerView: 1,
      slidesPerGroup: 1,
      spaceBetween: 10,
      grabCursor: true,
      loop: true,
      breakpoints: {
        550: {
          slidesPerView: 2,
          slidesPerGroup: 2,
        }
      },
      pagination: {
        el: `.${this.selector} .gpw-pagination`,
        clickable: true,
      }
    });
  }
}