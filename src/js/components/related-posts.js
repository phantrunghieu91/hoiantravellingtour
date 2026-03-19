export default class RelatedPosts {
  constructor() {
    try {
      this.initState();
      this.cacheElements();
      this.bindEvents();
    } catch (error) {
      console.warn('RELATED POSTS:', error.message);
    }
  }

  initState() {
    this.state = new Proxy(
      {
        currentCategory: '0',
      },
      {
        set: (target, key, value) => {
          if (key === 'currentCategory') {
            this.indexedNavItems[target[key]].classList.remove('related-posts__nav-item--active');
            this.indexedNavItems[value].classList.add('related-posts__nav-item--active');
            target[key] = value;
            this.filterPostsByCategory();
            return true;
          }
        },
      },
    );
  }

  cacheElements() {
    this.navItems = [...document.querySelectorAll('.related-posts__nav-item')];
    this.postCards = [...document.querySelectorAll('.related-posts .post-card')];
    if (this.navItems.length == 0) {
      throw new Error('No related posts nav items found.');
    }
    if (this.postCards.length == 0) {
      throw new Error('No related posts post cards found.');
    }
    this.indexedNavItems = this.navItems.reduce((acc, navItem) => {
      const categoryId = navItem.dataset.cat || '0';
      acc[categoryId] = navItem;
      return acc;
    }, {});
  }

  bindEvents() {
    this.navItems.forEach(navItem => {
      navItem.addEventListener('click', () => {
        const selectedCat = navItem.dataset.cat || '0';
        if (this.state.currentCategory == selectedCat) return;
        this.state.currentCategory = selectedCat;
      });
    });
  }

  filterPostsByCategory() {
    if (this.postCards.length == 0) {
      throw new Error('POST CONTROLLER: No post cards found to switch category.');
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
        if (visibleCount >= 6) return;
        postCard.setAttribute('aria-hidden', postCatIds.includes(this.state.currentCategory) ? 'false' : 'true');
        visibleCount += postCatIds.includes(this.state.currentCategory) ? 1 : 0;
      });
    }
  }
}
