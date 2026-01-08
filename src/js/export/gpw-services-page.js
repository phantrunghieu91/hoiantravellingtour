import ServicesCarousel from "../components/gpw-services-carousel";
import GPWAccordion from "../components/gpw-accordion";
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
  new ServicesCarousel();
});