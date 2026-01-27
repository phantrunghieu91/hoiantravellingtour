import GPWTabs from "../components/gpw-tabs";
import CareerController from "../controller/career-controller";
document.addEventListener('DOMContentLoaded', () => {
  new GPWTabs();
  new CareerController(ajaxObj);
});