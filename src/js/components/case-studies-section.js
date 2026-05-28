export default {
  init() {
    try {
      this.cacheElements();
      this.initSwiper();
    } catch (error) {
      console.warn('CASE STUDIES SECTION: ', error.message);
    }
  },
  cacheElements() {
    this.sectionEl = document.querySelector('.case-studies');
    if( !this.sectionEl ) {
      throw new Error('Case studies section not found');
    }
    this.swiperEl = this.sectionEl.querySelector('.swiper');
    if( !this.swiperEl ) {
      throw new Error('Case studies swiper not found');
    }
  },
  initSwiper() {
    if( typeof Swiper === 'undefined' ) {
      throw new Error('Swiper is not defined');
    }
    new Swiper(this.swiperEl, {
      slidesPerView: 1,
      spaceBetween: 0,
      navigation: {
        nextEl:  this.sectionEl.querySelector('.gpw-nav-btn__next'),
        prevEl: this.sectionEl.querySelector('.gpw-nav-btn__prev'),
      },
      breakpoints: {
        850: {
          slidesPerView: 3.5,
        }
      }
    });
  }
}