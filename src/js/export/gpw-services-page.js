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

  // other services carousel
  const otherServicesCarousel = {
    init() {
      try {
        this.cacheElements();
        this.initSwiper();
      } catch( error ) {
        console.warn( 'OTHER SERVICES CAROUSEL:', error.message );
      }
    },
    cacheElements() {
      this.swiperEl = document.querySelector('.other-services__carousel .swiper');
      if( !this.swiperEl ) {
        throw new Error('No other services carousel found');
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
          nextEl: '.other-services__carousel .gpw-nav-btn__next',
          prevEl: '.other-services__carousel .gpw-nav-btn__prev',
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

  // related posts
  const relatedPosts = {
    init() {
      try {
        this.initState();
        this.cacheElements();
        this.bindEvents();
      } catch( error ) {
        console.warn( 'RELATED POSTS:', error.message );
      }
    },
    initState() {
      this.state = new Proxy({
        currentCategory: '0', // '0' means all categories
      }, {
        set: (target, key, value) => {
          if (key === 'currentCategory') {
            this.indexedNavItems[target[key]].classList.remove('related-posts__nav-item--active');
            this.indexedNavItems[value].classList.add('related-posts__nav-item--active');
            target[key] = value;
            this.filterPostsByCategory();
            return true;
          }
        }
      });
    },
    cacheElements() {
      this.navItems = [...document.querySelectorAll('.related-posts__nav-item')];
      this.postCards = [...document.querySelectorAll('.related-posts .post-card')];
      if( this.navItems.length == 0 ) {
        throw new Error('No related posts nav items found.');
      }
      if( this.postCards.length == 0 ) {
        throw new Error('No related posts post cards found.');
      }
      this.indexedNavItems = this.navItems.reduce((acc, navItem) => {
        const categoryId = navItem.dataset.cat || '0';
        acc[categoryId] = navItem;
        return acc;
      }, {});
    },
    bindEvents() {
      this.navItems.forEach(navItem => {
        navItem.addEventListener('click', () => {
          const selectedCat = navItem.dataset.cat || '0';
          if( this.state.currentCategory == selectedCat ) return;
          this.state.currentCategory = selectedCat;
        });
      });
    },
    filterPostsByCategory() {
      if (this.postCards.length == 0) {
        throw new Error('POST CONTROLLER: No post cards found to switch category.');
      }
      if (this.state.currentCategory === '0') {
        this.postCards.forEach(postCard => {
          postCard.setAttribute('aria-hidden', 'false');
        });
      } else {
        this.postCards.forEach(postCard => {
          const postCatIds = postCard.dataset.cat ?? '0';
          postCard.setAttribute('aria-hidden', postCatIds.includes(this.state.currentCategory) ? 'false' : 'true');
        });
      }
    }
  }.init();

  new ServicesCarousel();
});