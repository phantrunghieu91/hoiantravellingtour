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
} );