import ServicesCarousel from "../components/gpw-services-carousel";
import GPWAccordion from "../components/gpw-accordion";
import GPWTabs from '../components/gpw-tabs';
document.addEventListener('DOMContentLoaded', function() {
  const gpwAccordion = new GPWAccordion();
  if( gpwAccordion.accordions.length > 0 ) {
    const expertiseImgs = [...document.querySelectorAll('.expertise__features-img')];
    gpwAccordion.accordions.forEach(accordion => {
      accordion.addEventListener('gpw_accordion:toggle', event => {
        const { button } = event.detail;
        let index = button.getAttribute('aria-controls');
        index = index.split('-').pop();
        expertiseImgs.forEach((img, imgIndex) => {
          if( imgIndex == index ) {
            img.setAttribute('aria-hidden', 'false');
          } else {
            img.setAttribute('aria-hidden', 'true');
          }
        });
      });
    });
  } 
  // suitable industry
  const suitableIndustryCarousel = {
    init() {
      try {
        this.cacheElements();
        this.initSwiper();
      } catch( error ) {
        console.warn( 'SUITABLE INDUSTRY CAROUSEL:', error.message );
      }
    },
    cacheElements() {
      this.swiperEl = document.querySelector('.suitable-industry__carousel .swiper');
      if( !this.swiperEl ) {
        throw new Error('No suitable industry carousel found');
      }
    },
    initSwiper() {
      if( typeof Swiper === 'undefined' ) {
        throw new Error('Swiper is not loaded');
      }
      this.swiper = new Swiper(this.swiperEl, {
        slidesPerView: 1,
        spaceBetween: 20,
        navigation: {
          nextEl: '.suitable-industry__carousel .gpw-nav-btn__next',
          prevEl: '.suitable-industry__carousel .gpw-nav-btn__prev',
        },
        breakpoints: {
          550: {
            slidesPerView: 2,
          },
          850: {
            slidesPerView: 3,
          }
        }
      });
    }
  }.init();

  new GPWTabs();

  new ServicesCarousel();
});