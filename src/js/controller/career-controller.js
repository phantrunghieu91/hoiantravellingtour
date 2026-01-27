export default class CareerController {
  constructor(ajaxObj) {
    if (!ajaxObj) {
      throw new Error('ajaxObj is required to initialize CareerController');
    }
    this.ajaxObj = ajaxObj;
    try {
      this.cacheElements();
      this.initState();
      this.bindEvents();
    } catch (error) {
      console.warn('CAREER CONTROLLER ERROR: ', error);
    }
  }
  initState() {
    this.state = new Proxy(
      {
        isFetching: false,
        currentPage: 1,
        maxPages: this.jobListFooter ? parseInt(this.jobListFooter.querySelector('.job-list__pagination').dataset.maxPages, 10) : 1,
      },
      {
        set: (obj, prop, value) => {
          obj[prop] = value;
          if (prop === 'isFetching') {
            this.submitButton.disabled = value;
          }
          if (prop === 'currentPage') {
            if (value < 1 || value > this.state.maxPages) {
              return true;
            }
            this.fetchJobsByPage(value);
          }
          return true;
        },
      },
    );
  }
  cacheElements() {
    this.searchForm = document.querySelector('.job-list__search-form');
    if (!this.searchForm) {
      throw new Error('Search form not found');
    }
    this.submitButton = this.searchForm.querySelector('.job-search__submit-btn');
    this.messageContainer = this.searchForm.querySelector('.job-search__message');
    if (!this.messageContainer) {
      this.messageContainer = document.createElement('div');
      this.messageContainer.classList.add('job-search__message');
      this.messageContainer.setAttribute('aria-hidden', 'true');
      this.searchForm.prepend(this.messageContainer);
    }
    this.jobListContainer = document.querySelector('.job-list__items');
    this.jobListFooter = document.querySelector('.job-list__footer');
    this.paginationItems = this.jobListFooter ? [...this.jobListFooter.querySelectorAll('.job-list__pagination-item')] : [];
  }
  bindEvents() {
    this.searchForm.addEventListener('submit', this.handleSearchSubmit.bind(this));
    this.bindEventForPagination();
  }
  getFormData() {
    const formData = new FormData(this.searchForm);
    formData.append('action', this.ajaxObj.action);
    formData.append('nonce', this.ajaxObj.nonce);
    return formData;
  }
  async handleSearchSubmit(event) {
    this.state.isFetching = true;
    event.preventDefault();
    const formData = this.getFormData();
    if (!this.validateFormData(formData)) {
      this.state.isFetching = false;
      return;
    }
    const jobData = await this.fetchJobList(formData);
    this.displayMessage(`Found ${jobData.found_jobs} job(s).`, '', 'success');
    this.state.isFetching = false;
    console.log('HandleSearch: ', jobData);
    this.renderJobList(jobData.jobs);
    this.renderPagination(jobData.max_pages);
  }
  async fetchJobList(formData) {
    try {
      const response = await fetch(this.ajaxObj.url, {
        method: 'POST',
        body: formData,
      });
      const resData = await response.json();
      if (!response.ok || resData.success === false) {
        throw new Error(resData.data.code || 'Failed to fetch job list');
      }
      return resData.data;
    } catch (error) {
      this.displayMessage('', error.message || 'UNKNOWN_ERROR');
      this.state.isFetching = false;
      console.error('Error fetching job list:', error.message);
    }
  }
  validateFormData(formData) {
    if (!formData.get('keyword') && !formData.get('job-position') && !formData.get('work-location')) {
      this.displayMessage('Please enter at least one search criterion.');
      return false;
    } else {
      this.displayMessage('');
      return true;
    }
  }
  displayMessage(message, code = '', type = 'error') {
    if (message === '' && code === '') {
      this.messageContainer.className = 'job-search__message';
      this.messageContainer.setAttribute('aria-hidden', 'true');
      this.messageContainer.textContent = '';
      return;
    }
    if (message === '' && code !== '') {
      switch (code) {
        case 'INVALID_NONCE':
          message = 'Security check failed. Please refresh the page and try again.';
          break;
        case 'NO_JOBS_FOUND':
          message = 'No job listings found matching your criteria.';
          type = 'info';
          break;
        default:
          message = 'An unknown error occurred. Please try again later.';
          break;
      }
    }

    this.messageContainer.className = 'job-search__message';
    this.messageContainer.setAttribute('aria-hidden', 'false');
    this.messageContainer.classList.add(`job-search__message--${type}`);
    this.messageContainer.textContent = message;

    // setTimeout(() => {
    //   this.messageContainer.setAttribute('aria-hidden', 'true');
    // }, 5000);
  }
  bindEventForPagination() {
    if (!this.jobListFooter) {
      throw new Error('Job list footer not found!');
    }

    if (this.paginationItems.length === 0) {
      throw new Error('No pagination items found!');
    }
    this.paginationItems.forEach(item => {
      item.addEventListener('click', this.handlePaginationClick.bind(this, item));
    });
  }
  handlePaginationClick(pageItem, event) {
    const pageNumber = pageItem.dataset.page;
    if (pageNumber === 'prev') {
      if (this.state.currentPage > 1) {
        this.state.currentPage -= 1;
      }
    } else if (pageNumber === 'next') {
      this.state.currentPage += 1;
    } else {
      this.state.currentPage = parseInt(pageNumber, 10);
    }
    this.state.isFetching = true;
  }
  async fetchJobsByPage(pageNumber) {
    const formData = this.getFormData();
    formData.append('page', pageNumber);
    const jobData = await this.fetchJobList(formData);
    this.state.isFetching = false;
    this.changeActivePaginationItem();
    console.log('FetchJobsByPage: ', jobData);
    this.renderJobList(jobData.jobs);
  }
  changeActivePaginationItem() {
    console.log(this.state);
    this.paginationItems.forEach(item => {
      const isActive = item.dataset.page == this.state.currentPage;
      item.classList.toggle('job-list__pagination-item--active', isActive);
    });
    this.paginationItems.find(item => item.dataset.page === 'prev').classList.remove('job-list__pagination-item--disabled');
    this.paginationItems.find(item => item.dataset.page === 'next').classList.remove('job-list__pagination-item--disabled');
    if (this.state.currentPage === 1) {
      this.paginationItems.find(item => item.dataset.page === 'prev').classList.add('job-list__pagination-item--disabled');
    } else if (this.state.currentPage === this.state.maxPages) {
      this.paginationItems.find(item => item.dataset.page === 'next').classList.add('job-list__pagination-item--disabled');
    }
  }
  renderJobList(jobs) {
    this.jobListContainer.innerHTML = '';
    if (!jobs || jobs.length === 0) {
      this.displayMessage('', 'NO_JOBS_FOUND', 'info');
      return;
    }
    const fragment = new DocumentFragment();
    jobs.forEach(job => {
      const jobItem = this.getJobItemTemplate();
      const titleEl = jobItem.querySelector('.job-list__item-title a');
      const quantityEl = jobItem.querySelector('.job-list__item-meta.quantity .job-list__item-meta-value');
      const locationEl = jobItem.querySelector('.job-list__item-meta.location .job-list__item-meta-value');
      const deadlineEl = jobItem.querySelector('.job-list__item-meta.deadline .job-list__item-meta-value');
      const viewDetailsBtn = jobItem.querySelector('.job-list__item-view-detail');
      titleEl.textContent = job.title;
      titleEl.href = job.permalink || 'javascript:void(0);';
      quantityEl.textContent = job.quantity;
      if (job.location) {
        locationEl.textContent = job.location;
      } else {
        locationEl.remove();
      }
      if (job.deadline) {
        deadlineEl.textContent = job.deadline;
      } else {
        deadlineEl.remove();
      }
      viewDetailsBtn.href = job.permalink || 'javascript:void(0);';
      fragment.appendChild(jobItem);
    });
    this.jobListContainer.appendChild(fragment);
  }
  renderPagination(maxPages) {
    if (maxPages <= 1) {
      this.jobListFooter?.setAttribute('aria-hidden', 'true');
      return;
    }
    let paginationEl = null;
    if (!this.jobListFooter) {
      paginationEl = this.createFooterWithPagination();
    } else {
      paginationEl = this.jobListFooter.querySelector('.job-list__pagination');
      this.jobListFooter.setAttribute('aria-hidden', 'false');
    }
    const oldMaxPages = this.state.maxPages;
    this.state.maxPages = maxPages;

    // Update data-max-pages attribute if maxPages differs
    let maxPagesDiffers = Math.abs(oldMaxPages - maxPages);
    if (maxPagesDiffers > 0) {
      paginationEl.dataset.maxPages = maxPages;
    }

    // Add or remove pagination item that different from new maxPages to old maxPages ( new = 4, old = 2, add 2 items; new = 2, old = 3, remove 1 item)
    while (maxPagesDiffers > 0) {
      if (oldMaxPages < maxPages) {
        const newPageItem = this.createPaginationItem(oldMaxPages + (maxPages - oldMaxPages) - maxPagesDiffers + 1);
        
        newPageItem.addEventListener('click', this.handlePaginationClick.bind(this, newPageItem));
        paginationEl.insertBefore(newPageItem, paginationEl.querySelector('.job-list__pagination-item[data-page="next"]'));
        maxPagesDiffers -= 1;
      } else {
        const pageToRemove = paginationEl.querySelector(`.job-list__pagination-item[data-page="${oldMaxPages - maxPagesDiffers + 1}"]`);
        if (pageToRemove) {
          paginationEl.removeChild(pageToRemove);
        }
        maxPagesDiffers -= 1;
      }
    }
    this.paginationItems = [...paginationEl.querySelectorAll('.job-list__pagination-item')];
    this.state.currentPage = 1;
    this.changeActivePaginationItem();
  }
  getJobItemTemplate() {
    const template = document.getElementById('job-item-template');
    return template.content.cloneNode(true);
  }
  createFooterWithPagination() {
    this.jobListFooter = document.createElement('footer');
    this.jobListFooter.classList.add('job-list__footer');
    this.jobListFooter.setAttribute('aria-hidden', 'false');
    const ul = document.createElement('ul');
    ul.classList.add('job-list__pagination');
    ul.appendChild(this.createPaginationItem('prev'));
    ul.appendChild(this.createPaginationItem('next'));
    this.jobListFooter.appendChild(ul);
    this.jobListContainer.after(this.jobListFooter);
    return ul;
  }
  createPaginationItem(pageNumber, isActive = false) {
    const li = document.createElement('li');
    li.classList.add('job-list__pagination-item');
    if (isActive) {
      li.classList.add('job-list__pagination-item--active');
    }
    li.setAttribute('data-page', pageNumber);
    const span = document.createElement('span');
    if (pageNumber === 'prev' || pageNumber === 'next') {
      span.classList.add('material-symbols-outlined');
      span.textContent = pageNumber === 'prev' ? 'chevron_left' : 'chevron_right';
    } else {
      span.textContent = pageNumber;
    }
    li.appendChild(span);
    return li;
  }
}
