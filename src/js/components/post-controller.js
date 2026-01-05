export default class PostController {
  constructor(ajaxObj) {
    if (!ajaxObj) {
      throw new Error('Ajax object is required to initialize PostController.');
    }
    this.ajaxObj = ajaxObj;
    this.navItemActiveClass = 'posts-grid__nav-item--active';
    this.cachedElements();
    this.initialState({
      page: 1,
      maxPage: this.loadMoreBtn ? parseInt(this.loadMoreBtn.dataset.max) : 1,
      isLoading: false,
      currentCategory: '0',
    });
    this.indexing();
    this.bindEvents();
  }
  cachedElements() {
    this.postGridContainer = document.querySelector('.posts-grid > .section__inner');
    if (!this.postGridContainer) {
      throw new Error('POST CONTROLLER: Post grid container element not found.');
    }
    this.postGrid = this.postGridContainer.querySelector('.posts-grid__grid');
    this.navItems = [...this.postGridContainer.querySelectorAll('.posts-grid__nav-item')];

    this.postCards = [...this.postGridContainer.querySelectorAll('.post-card')];
    this.loadMoreBtn = this.postGridContainer.querySelector('.posts-grid__load-more-btn');
    this.loadingElement = document.createElement('span');
    this.loadingElement.classList.add('material-symbols-outlined', 'posts-grid__loading');
    this.loadingElement.textContent = 'progress_activity';
    this.getPostCardTemplate();
  }
  indexing() {
    const categoryIds = [];
    this.indexedNavItems = this.navItems.reduce((acc, navItem) => {
      const categoryId = navItem.dataset.cat || '0';
      categoryIds.push(categoryId);
      acc[categoryId] = navItem;
      return acc;
    }, {});
    this.indexedPostCardsByCat = this.postCards.reduce((acc, postCard) => {
      return this.handleIndexingPostCardByCat(acc, postCard);
    }, {});
  }
  handleIndexingPostCardByCat(indexedPostCards, postCard) {
    const postCatIds = postCard.dataset.cat ? postCard.dataset.cat.split(',') : ['0'];
    const postCardID = postCard.dataset.id || null;
    postCatIds.forEach(catId => {
      if (!indexedPostCards[catId]) {
        indexedPostCards[catId] = {};
      }
      if (indexedPostCards[catId] && !indexedPostCards[catId][postCardID]) {
        indexedPostCards[catId][postCardID] = postCard;
      }
    });
    return indexedPostCards;
  }
  initialState(initialData = { page: 1, isLoading: false }) {
    this.state = new Proxy(initialData, {
      set: (target, key, value) => {
        if (key === 'isLoading') {
          target[key] = value;
          this.loadingState();
          return true;
        }
        if (key === 'currentCategory') {
          this.indexedNavItems[target[key]].classList.remove(this.navItemActiveClass);
          this.indexedNavItems[value].classList.add(this.navItemActiveClass);
          target[key] = value;
          this.switchActiveCategory();
          return true;
        }
        if( key === 'page' ) {
          target[key] = value;
          if( target[key] >= target['maxPage'] ) {
            this.loadMoreBtn.remove();
          }
          return true;
        }
        target[key] = value;
        return true;
      },
    });
  }
  bindEvents() {
    this.loadMoreBtn?.addEventListener('click', this.handleLoadMore.bind(this));
    this.navItems?.forEach(navItem => {
      const categoryID = navItem.dataset.cat || '0';
      navItem.addEventListener('click', () => {
        if (navItem.classList.contains(this.navItemActiveClass)) {
          return;
        }
        this.state.currentCategory = categoryID;
      });
    });
  }
  async handleLoadMore(event) {
    event.preventDefault();
    if (this.state.isLoading || this.state.page >= this.state.maxPage) {
      return;
    }
    this.state.isLoading = true;
    this.state.page += 1;
    const posts = await this.getPostsData();
    if (posts && posts.length > 0) {
      this.renderLoadMorePosts(posts);
    }
  }
  async getPostsData() {
    try {
      const requestData = new FormData();
      requestData.append('action', this.ajaxObj.action);
      requestData.append('nonce', this.ajaxObj.nonce);
      requestData.append('page', this.state.page);
      requestData.append('category_id', this.loadMoreBtn.dataset.cat || 0);

      const response = await fetch(this.ajaxObj.url, {
        method: 'POST',
        body: requestData,
      });
      if (!response.ok) {
        throw new Error(`HTTP error! status: ${response.status}`);
      }
      const resData = await response.json();
      if (!resData.success) {
        throw new Error('POST CONTROLLER: Failed to fetch posts data.', resData.message);
      }
      return resData.data;
    } catch (error) {
      console.error('POST CONTROLLER: Error loading more posts:', error);
    }
  }
  renderLoadMorePosts(posts) {
    const fragment = document.createDocumentFragment();
    posts.forEach(post => {
      const postElement = this.postCardTemplate.cloneNode(true);
      const postCard = postElement.querySelector('.post-card');
      const postCardCategory = postCard.querySelector('.post-card__category');
      const postCardTitle = postCard.querySelector('.post-card__title a');
      postCard.dataset.cat = post.category_ids;
      postCard.dataset.id = post.id;
      postCardCategory.textContent = post.primary_category.name;
      postCardCategory.href = post.primary_category.permalink;
      postCard.querySelector('.post-card__thumbnail').href = post.permalink;
      const imgElement = postCard.querySelector('.post-card__image');
      imgElement.src = post.featured_image_url;
      imgElement.alt = post.title;
      postCardTitle.href = post.permalink;
      postCardTitle.textContent = post.title;
      postCard.querySelector('.post-card__excerpt').textContent = post.excerpt;
      fragment.appendChild(postElement);

      this.postCards.push(postCard);
      this.handleIndexingPostCardByCat(this.indexedPostCardsByCat, postCard);
    });
    this.postGrid.appendChild(fragment);
    this.state.isLoading = false;
    this.switchActiveCategory();
  }
  loadingState() {
    this.loadMoreBtn.disabled = this.state.isLoading;
    if (this.state.isLoading) {
      this.postGridContainer.insertBefore(this.loadingElement, this.loadMoreBtn);
    } else {
      this.postGridContainer.removeChild(this.loadingElement);
    }
  }
  getPostCardTemplate() {
    const templateElement = document.querySelector('.post-card__template');
    if (!templateElement) {
      throw new Error('POST CONTROLLER: Post card template element not found.');
    }
    this.postCardTemplate = templateElement.content.cloneNode(true);
  }
  switchActiveCategory() {
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
}
