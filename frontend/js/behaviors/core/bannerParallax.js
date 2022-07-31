const bannerParallax = function(container) {

  let parallaxAmount = 100;
  let active = false;
  let img;

  function _update() {
    if (A17.currentMediaQuery !== 'small' && active) {
      let rect = container.getBoundingClientRect();
      let end = rect.top + rect.height;
      let start = end - rect.height - window.innerHeight;
      if (start < 0 && end > 0) {
        let moveBy = Math.round(parallaxAmount - ((end / (window.innerHeight + rect.height)) * parallaxAmount));
        img.style.transform = 'translate3D(0px, ' + moveBy + 'px, 0px)';
      }
    }
    window.requestAnimationFrame(_update);
  }

  function _init() {
    active = true;
    img = container.querySelector('[data-parallax-img]');
    window.requestAnimationFrame(_update);
  }

  this.destroy = function() {
    // Remove specific event handlers
    active = false;

    // Remove properties of this behavior
    A17.Helpers.purgeProperties(this);
  };

  this.init = function() {
    _init();
  };
};

export default bannerParallax;
