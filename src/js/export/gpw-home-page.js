import GPWTabs from "../components/gpw-tabs";
import Testimonial from "../components/testimonial";
import ServicesCarousel from "../components/services-carousel";
document.addEventListener('DOMContentLoaded', function() {
  new GPWTabs();

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
      this.videoWrapperEl = this.sectionEl.querySelector('.statistic__video');
      this.videoEl = this.videoWrapperEl?.querySelector('video');
      this.videoPlayBtn = this.videoWrapperEl?.querySelector('.statistic__video-btn');
      this.counterEls = this.sectionEl.querySelectorAll('.statistic__number-int');
    },
    bindEvents() {
      this.handleVideoPlay();
      this.handleCounters();
    },
    handleVideoPlay() {
      if(!this.videoWrapperEl) {
        console.log('STATISTIC: Video element not found');
        return;
      }
      this.videoWrapperEl.addEventListener('click', event => {
        const target = event.target;
        if( (target === this.videoPlayBtn || target.closest('button') === this.videoPlayBtn) && this.videoEl.paused ) {
          this.videoEl.play();
          this.videoPlayBtn.classList.add('hidden');
        }
        if( target === this.videoEl && !this.videoEl.paused ) {
          this.videoEl.pause();
          this.videoPlayBtn.classList.remove('hidden');
        }
      });
      // Show play button when video ends
      this.videoEl.addEventListener('ended', () => {
        this.videoPlayBtn.classList.remove('hidden');
      });
    },
    handleCounters() {
      if(this.counterEls.length === 0) {
        console.log('STATISTIC: No counter elements found');
        return;
      }
      const observer = new IntersectionObserver(entries => {
        entries.forEach(entry => {
          if(entry.isIntersecting) {
            this.counterAnimation(entry.target);
            observer.unobserve(entry.target); // Stop observing after animation
          }
        });
      }, { threshold: 0.8 })
      this.counterEls.forEach(counterEl => {
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
          clearInterval(interval);
        }
        counterEl.textContent = currentNumber.toLocaleString();
      }, 50);      
    }
  }.init();

  new Testimonial();

  new ServicesCarousel();

  // Blogs carousel
  const blogsSection = {
    init() {
      try {
        this.cachedDOM();
        this.initSwiper();
      } catch (error) {
        console.error('BLOGS SECTION:', error);
      }
    },
    cachedDOM() {
      this.swiperEl = document.querySelector('.blogs__post-grid .swiper');
      if(!this.swiperEl) {
        throw new Error('Swiper element not found');
      }
    },
    initSwiper() {
      if( typeof Swiper === 'undefined' ) {
        throw new Error('Swiper is not loaded');
      }
      this.swiper = new Swiper(this.swiperEl, {
        slidesPerView: 1,
        spaceBetween: 10,
        scrollbar: {
          el: '.swiper-scrollbar',
          draggable: true,
        },
        breakpoints: {
          550: {
            slidesPerView: 2,
          },
          850: {
            slidesPerView: 3,
            spaceBetween: 20,
          }
        }
      });
    }
  }.init();
});