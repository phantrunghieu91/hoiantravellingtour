import GPWTabs from "../components/gpw-tabs";
import Testimonial from "../components/testimonial";
import ServicesCarousel from "../components/gpw-services-carousel";
document.addEventListener('DOMContentLoaded', function() {
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
      this.videoDialogEl = this.sectionEl.querySelector('.statistic__video-dialog');
      this.videoEl = this.videoDialogEl?.querySelector('video');
      this.videoPlayBtn = this.sectionEl.querySelector('.statistic__video-btn');
      this.counterEls = this.sectionEl.querySelectorAll('.statistic__number-int');
    },
    bindEvents() {
      this.handleVideoPlay();
      this.handleCounters();
      this.videoPlayBtn?.addEventListener('click', () => {
        this.videoDialogEl.showModal();
        this.toggleOverflowOnHtml();
        setTimeout(() => {
          this.videoEl.play();
        }, 500);
      });
    },
    handleVideoPlay() {
      if(!this.videoDialogEl) {
        console.log('STATISTIC: Video dialog not found');
        return;
      }
      this.videoDialogEl.addEventListener('click', event => {
        const target = event.target;
        if(target === this.videoDialogEl) {
          this.videoEl.pause();
          this.videoDialogEl.close();
          this.toggleOverflowOnHtml(false);
        }
        if( target === this.videoEl ) {
          if( this.videoEl.paused ) {
            this.videoEl.play();
          } else {
            this.videoEl.pause();
          }
        }
      });
      // Show play button when video ends
      this.videoEl.addEventListener('ended', () => {
        this.videoPlayBtn.classList.remove('hidden');
      });
    },
    toggleOverflowOnHtml(hide = true) {
      document.documentElement.style.overflow = hide ? 'hidden' : '';
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

  // Testimonial Section
  new Testimonial();

  new ServicesCarousel();

  // BLOGS
  const blogs = {
    init() {
      try {
        this.initState();
        this.cacheElements();
        this.bindEvents();
      } catch( error ) {
        console.warn( 'BLOGS SECTION:', error.message );
      }
    },
    initState() {
      this.state = new Proxy({
        currentCategory: '0', // '0' means all categories
      }, {
        set: (target, key, value) => {
          if (key === 'currentCategory') {
            this.indexedNavItems[target[key]].classList.remove('blogs__nav-item--active');
            this.indexedNavItems[value].classList.add('blogs__nav-item--active');
            target[key] = value;
            this.filterPostsByCategory();
            return true;
          }
        }
      });
    },
    cacheElements() {
      this.navItems = [...document.querySelectorAll('.blogs__nav-item')];
      this.postCards = [...document.querySelectorAll('.blogs .post-card')];
      if( this.navItems.length == 0 ) {
        throw new Error('No blogs nav items found.');
      }
      if( this.postCards.length == 0 ) {
        throw new Error('No blogs post cards found.');
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
        throw new Error('No post cards found to switch category.');
      }
      if (this.state.currentCategory === '0') {
        this.postCards.forEach((postCard, idx) => {
          postCard.setAttribute('aria-hidden', idx < 6 ? 'false' : 'true');
        });
      } else {
        this.postCards.forEach(postCard => {
          postCard.setAttribute('aria-hidden', 'true');
        });
        let visibleCount = 0;
        this.postCards.forEach(postCard => {
          const postCatIds = postCard.dataset.cat ?? '0';
          if( visibleCount >= 6 ) return;
          postCard.setAttribute('aria-hidden', postCatIds.includes(this.state.currentCategory) ? 'false' : 'true');
          visibleCount += postCatIds.includes(this.state.currentCategory) ? 1 : 0;
        });
      }
    }
  }.init();
});