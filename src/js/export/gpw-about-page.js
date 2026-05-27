document.addEventListener( 'DOMContentLoaded', function () {
  // Statistic Section Animation
  const statistic = {
    init() {
      this.cachedDOM();
      this.bindEvents();
    },
    cachedDOM() {
      this.sectionEl = document.querySelector('section.statistic');
      if(!this.sectionEl) {
        console.error('STATISTIC: Section element not found');
        return;
      }
      this.counterEls = this.sectionEl.querySelectorAll('.statistic__number-int');
    },
    bindEvents() {
      this.handleCounters();
    },
    handleCounters() {
      if(this.counterEls.length === 0) {
        console.log('STATISTIC: No counter elements found');
        return;
      }
      const observer = new IntersectionObserver(entries => {
        entries.forEach(entry => {
          if(entry.isIntersecting) {
            if(entry.target.isRunning) return;
            entry.target.isRunning = true;
            this.counterAnimation(entry.target);
          }
        });
      }, { threshold: 0.8 })
      this.counterEls.forEach(counterEl => {
        counterEl.isRunning = false;
        observer.observe(counterEl);
      });
    },
    counterAnimation(counterEl) {
      const targetNumber = parseInt(counterEl.textContent, 10);
      let currentNumber = parseInt(counterEl.dataset.start || '0', 10);
      const step = parseInt(counterEl.dataset.step || '1', 10);
      let interval = setInterval(() => {
        currentNumber += step;
        if(currentNumber >= targetNumber) {
          currentNumber = targetNumber;
          counterEl.isRunning = false;
          clearInterval(interval);
        }
        counterEl.textContent = currentNumber.toLocaleString();
      }, 50);      
    }
  }.init();
  // Why choose us
  const whyChooseUs = {
    init() {
      try {
        this.cacheElements();
        this.initSwiper();
      } catch( error ) {
        console.warn( 'ABOUT PAGE: Why choose us carousel error: ', error );
      }
    },
    cacheElements() {
      this.swiperEl = document.querySelector( '.why-choose-us .swiper' );
      if( !this.swiperEl ) {
        throw new Error( 'Can NOT find swiper element!' );
      }
    },
    initSwiper() {
      if( typeof Swiper === 'undefined' ) {
        throw new Error( 'Swiper library have NOT registered!' );
      }
      new Swiper( this.swiperEl, {
        slidesPerView: 1.2,
        spaceBetween: 10,
        loop: true,
        navigation: {
          prevEl: '.why-choose-us .gpw-nav-btn__prev',
          nextEl: '.why-choose-us .gpw-nav-btn__next',
        },
        pagination: {
          el: '.why-choose-us .gpw-pagination',
          clickable: true,
        },
        breakpoints: {
          550: {
            slidesPerView: 3,
            spaceBetween: 20,
          },
          850: {
            slidesPerView: 4,
            spaceBetween: 20,
          },
        }
      });
    }
  }.init();
  // our solutions carousel
  const ourSolutions = {
    init() {
      try {
        this.cacheElements();
        this.initCarousel();
      } catch( error ) {
        console.warn( 'OUR SOLUTIONS CAROUSEL:', error.message );
      }
    },
    cacheElements() {
      this.sectionEl = document.querySelector('.our-solutions');
      if( !this.sectionEl ) {
        throw new Error('Section our solutions not found');
      }
      this.swiperEl = this.sectionEl.querySelector('.our-solutions__carousel .swiper');
      if( !this.swiperEl ) {
        throw new Error('Swiper element for our solutions not found');
      }
    },
    initCarousel() {
      if( typeof Swiper === 'undefined' ) {
        throw new Error('Swiper library is not loaded');
      }
      this.swiper = new Swiper(this.swiperEl, {
        slidesPerView: 1.5,
        spaceBetween: 20,
        loop: true,
        autoplay: {
          delay: 3000,
        },
        navigation: {
          nextEl: this.sectionEl.querySelector('.gpw-nav-btn__next'),
          prevEl: this.sectionEl.querySelector('.gpw-nav-btn__prev'),
        },
        pagination: {
          el: this.sectionEl.querySelector('.gpw-pagination'),
          clickable: true,
        },
        breakpoints: {
          550: {
            slidesPerView: 2.5,
          },
          850: {
            slidesPerView: 3.5,
          },
          1250: {
            slidesPerView: 4.5,
          }
        }
      });

      // observe to stop autoplay when not visible
      const observer = new IntersectionObserver(entries => {
        entries.forEach(entry => {
          if(entry.isIntersecting) {
            this.swiper.autoplay.start();
          } else {
            this.swiper.autoplay.stop();
          }
        });
      }, { threshold: 0.5 });
      observer.observe(this.sectionEl);
    }
  }.init();
  // case studies
  const caseStudiesSection = {
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
  }.init();
} );