import { triggerCustomEvent } from '@area17/a17-helpers';

const mask = function(container) {

  function _handleClicks(event) {
    event.preventDefault();
    event.stopPropagation();
    container.blur();
    triggerCustomEvent(document, 'shareMenu:close');
    triggerCustomEvent(document, 'selectDate:close');
    triggerCustomEvent(document, 'fullScreenImage:close');
    triggerCustomEvent(document, 'collectionSearch:close');
    triggerCustomEvent(document, 'collectionFilters:close');
    triggerCustomEvent(document, 'stickySidebar:close');
    triggerCustomEvent(document, 'infoButtonInfo:close');
    triggerCustomEvent(document, 'modal:close');
    triggerCustomEvent(document, 'roadblock:close');
    triggerCustomEvent(document, 'globalSearch:close');
    triggerCustomEvent(document, 'navMobile:close');
    triggerCustomEvent(document, 'dropdown:close');
  }

  function _init() {
    container.addEventListener('touchend', _handleClicks, false);
    container.addEventListener('click', _handleClicks, false);
  }

  this.destroy = function() {
    // Remove specific event handlers
    container.removeEventListener('touchend', _handleClicks);
    container.removeEventListener('click', _handleClicks);

    // Remove properties of this behavior
    A17.Helpers.purgeProperties(this);
  };

  this.init = function() {
    _init();
  };
};

export default mask;
