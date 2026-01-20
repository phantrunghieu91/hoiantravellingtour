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

  // Products
  const productsSection = {
    init() {
      try {
        this.cacheElements();
        this.observeProductsCarousel();
        this.initProductImageCarousel();
      } catch (error) {
        console.warn('PRODUCTS SECTION: ', error.message);
      }
    },
    cacheElements() {
      this.productsCarousel = document.querySelector('.products__carousel > .swiper');
      if( !this.productsCarousel ) {
        throw new Error('Products carousel not found');
      }
      this.productImagesCarousels = [...document.querySelectorAll('.product__images-carousel > .swiper')];
    },
    initProductsCarousel() {
      if( typeof Swiper === 'undefined' ) {
        throw new Error('Swiper is not defined');
      }
      return new Swiper(this.productsCarousel, {
        slidesPerView: 1.4,
        spaceBetween: 20,
        navigation: {
          nextEl:  '.products__carousel > .swiper > .gpw-nav-btn__next',
          prevEl: '.products__carousel > .swiper > .gpw-nav-btn__prev',
        },
        pagination: {
          el: '.products__carousel > .swiper > .gpw-pagination',
          clickable: true,
        }
      });
    },
    observeProductsCarousel() {
      let swiper = null;
      const observer = new ResizeObserver( entries => {
        const entry = entries[0];
        const isLargeScreen = entry.contentRect.width > 550;
        if( !isLargeScreen ) {
          !swiper && (swiper = this.initProductsCarousel());
        } else {
          if( swiper ) {
            swiper.destroy();
            swiper = null;
          }
        }
      });
      observer.observe(this.productsCarousel);
    },
    initProductImageCarousel() {
      if( typeof Swiper === 'undefined' ) {
        throw new Error('Swiper is not defined');
      }
      if( this.productImagesCarousels.length === 0 ) {
        throw new Error('No product images carousels found');
      }
      this.productImagesCarousels.forEach(carousel => {
        new Swiper(carousel, {
          slidesPerView: 1,
          spaceBetween: 10,
          navigation: {
            nextEl: carousel.querySelector('.gpw-nav-btn__next'),
            prevEl: carousel.querySelector('.gpw-nav-btn__prev'),
          },
          pagination: {
            el: carousel.querySelector('.gpw-pagination'),
            clickable: true,
          }
        });
      });
    }
  }.init();

  // Logistics Solutions Tabs
  new GPWTabs();

  // Related Industries Carousel
  const relatedIndustries = {
    init() {
      try {
        this.cacheElements();
        this.initSwiper();
      } catch (error) {
        console.warn('RELATED INDUSTRIES SECTION: ', error.message);
      }
    },
    cacheElements() {
      this.swiperEl = document.querySelector('.related-industries__carousel .swiper');
      if( !this.swiperEl ) {
        throw new Error('Related industries swiper not found');
      }
    },
    initSwiper() {
      if( typeof Swiper === 'undefined' ) {
        throw new Error('Swiper is not defined');
      }
      new Swiper(this.swiperEl, {
        slidesPerView: 1,
        spaceBetween: 20,
        breakpoints: {
          550: {
            slidesPerView: 2,
          },
          850: {
            slidesPerView: 3,
          }
        },
        navigation: {
          nextEl:  '.related-industries__carousel .gpw-nav-btn__next',
          prevEl: '.related-industries__carousel .gpw-nav-btn__prev',
        }
      });
    }
  }.init();
});