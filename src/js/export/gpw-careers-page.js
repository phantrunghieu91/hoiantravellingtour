import GPWTabs from "../components/gpw-tabs";
import CareerController from "../controller/career-controller";
import RelatedPosts from '../components/related-posts';
document.addEventListener('DOMContentLoaded', () => {
  new GPWTabs();
  new CareerController(ajaxObj);
  new RelatedPosts();
});