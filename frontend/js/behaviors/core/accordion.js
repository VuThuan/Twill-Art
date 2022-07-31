import { triggerCustomEvent, setFocusOnTarget, forEach, getOffset } from '@area17/a17-helpers';
import { googleTagManagerDataFromLink } from '../../functions/core';

const accordion = function(container) {

  function _findAncestor(el, cls) {
    while ((el = el.parentElement) && !el.classList.contains(cls));
    return el;
  }

  function _focusNextElement(activeElement) {
    if (activeElement) {
      activeElement.blur();
      let activeElementPanelParent = _findAncestor(activeElement,'o-accordion__panel');
      let activeElementPanelParentTabIndexSet = false;
      if (activeElementPanelParent && !activeElementPanelParent.getAttribute('tabindex')) {
        activeElementPanelParent.setAttribute('tabindex','0');
        activeElementPanelParentTabIndexSet = true;
      }
      let focussableElements = [];
      forEach(document.querySelectorAll('a:not([disabled]), button:not([disabled]), input[type=text]:not([disabled]), [tabindex]:not([disabled]):not([tabindex="-1"])'), function(index, el) {
        let push = true;
        if (el.offsetWidth <= 0 || el.offsetWidth <= 0 || el.getAttribute('aria-hidden') === 'true') {
          push = false;
        }
        let parentPanel = _findAncestor(el,'o-accordion__panel');
        if (parentPanel && parentPanel.getAttribute('aria-hidden') === 'true') {
          push = false;
        }
        if (el === activeElementPanelParent) {
          push = true;
        }
        if (push) {
          focussableElements.push(el);
        }
      });
      if (activeElementPanelParentTabIndexSet) {
        activeElementPanelParent.removeAttribute('tabindex');
      }
      if (focussableElements.length > 0) {
        let index = focussableElements.indexOf(activeElementPanelParent);
        if(index > -1) {
          let nextElement = focussableElements[index + 1] || focussableElements[0];
          nextElement.focus();
        }
      }
    }
  }

  function _getHeightAndSet(target) {
    let targetHeight = target.firstElementChild.offsetHeight;
    target.style.height = targetHeight + 'px';
  }

  function _unsetAfterAnimation() {
    this.removeAttribute('style');
    this.removeEventListener('transitionend', _unsetAfterAnimation);
    triggerCustomEvent(document, 'page:updated');
  }

  function _toggle(event) {
    if (event.target.classList.contains('o-accordion__trigger') || event.target.parentNode.classList.contains('o-accordion__trigger')) {
      event.preventDefault();
      event.stopPropagation();
      //
      let trigger = event.target.classList.contains('o-accordion__trigger') ? event.target : event.target.parentNode;
      let target = trigger.parentElement.nextElementSibling || trigger.nextElementSibling;
      let validTarget = (target.classList.contains('o-accordion__panel'));
      //
      if (trigger.classList.contains('s-inactive')) {
        return;
      }
      //
      if (validTarget) {
        trigger.blur();
        if (trigger.getAttribute('aria-expanded') === 'true') {
          // Close
          _getHeightAndSet(target);
          trigger.setAttribute('aria-expanded', 'false');
          target.setAttribute('aria-hidden', 'true');
          let thrash = target.offsetHeight;
          target.style.height = 0;
          target.style.overflow = 'hidden';
        } else {
          // Open
          target.style.height = 0;
          target.style.overflow = 'hidden';
          trigger.setAttribute('aria-expanded', 'true');
          target.setAttribute('aria-hidden', 'false');
          setTimeout(function(){ setTimeout(function(){ setFocusOnTarget(target); }, 0) }, 0)
          _getHeightAndSet(target);
          // If the form has some google tag manager props, tell GTM
          let googleTagManagerObject = googleTagManagerDataFromLink(trigger);
          if (googleTagManagerObject) {
            triggerCustomEvent(document, 'gtm:push', googleTagManagerObject);
          }
        }
        target.addEventListener('transitionend', _unsetAfterAnimation, false);
      }
    }
  }

  function _handleClicks(event) {
    _toggle(event);
  }

  function _handleKeyPress(event) {
    if (event.keyCode === 13 || event.keyCode === 8) {
      _toggle(event);
    }
  }

  function _handleFocus(event) {
    try {
      container.querySelector('.o-accordion__trigger.s-focus').classList.remove('s-focus');
    } catch(err) {
    }
    if (event.keyCode === 9 && container.contains(document.activeElement)) {
      if (document.activeElement.classList.contains('o-accordion__trigger')) {
        document.activeElement.classList.add('s-focus');
      }
      let parentPanel = _findAncestor(document.activeElement,'o-accordion__panel');
      if (parentPanel && parentPanel.getAttribute('aria-hidden') === 'true') {
        _focusNextElement(document.activeElement);
      }
    }
  }

  function _checkHashOnLoad() {
    if (window.location.hash && window.location.hash !== '#') {
      let hashTarget = document.getElementById(window.location.hash.replace(/#/ig,''));
      if (container.contains(hashTarget)) {
        let scrollTarget = Math.round(getOffset(hashTarget).top);
        window.scrollTo(0, scrollTarget);
        hashTarget.click();
      }
    }
  }

  function _init() {
    container.addEventListener('click', _handleClicks, false);
    container.addEventListener('keyup', _handleKeyPress, false);
    window.addEventListener('keyup', _handleFocus, false);
    _checkHashOnLoad();
  }

  this.destroy = function() {
    // Remove specific event handlers
    container.removeEventListener('click', _handleClicks);
    container.removeEventListener('keyup', _handleKeyPress);
    window.removeEventListener('keyup', _handleFocus);

    // Remove properties of this behavior
    A17.Helpers.purgeProperties(this);
  };

  this.init = function() {
    _init();
  };
};

export default accordion;
