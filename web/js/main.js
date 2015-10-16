/*!
 * Bootstrap v3.3.5 (http://getbootstrap.com)
 * Copyright 2011-2015 Twitter, Inc.
 * Licensed under MIT (https://github.com/twbs/bootstrap/blob/master/LICENSE)
 */

/*!
 * Generated using the Bootstrap Customizer (http://getbootstrap.com/customize/?id=916affa2954b1f7627c6)
 * Config saved to config.json and https://gist.github.com/916affa2954b1f7627c6
 */
if (typeof jQuery === 'undefined') {
  throw new Error('Bootstrap\'s JavaScript requires jQuery')
}
+function ($) {
  'use strict';
  var version = $.fn.jquery.split(' ')[0].split('.')
  if ((version[0] < 2 && version[1] < 9) || (version[0] == 1 && version[1] == 9 && version[2] < 1)) {
    throw new Error('Bootstrap\'s JavaScript requires jQuery version 1.9.1 or higher')
  }
}(jQuery);

/* ========================================================================
 * Bootstrap: alert.js v3.3.5
 * http://getbootstrap.com/javascript/#alerts
 * ========================================================================
 * Copyright 2011-2015 Twitter, Inc.
 * Licensed under MIT (https://github.com/twbs/bootstrap/blob/master/LICENSE)
 * ======================================================================== */


+function ($) {
  'use strict';

  // ALERT CLASS DEFINITION
  // ======================

  var dismiss = '[data-dismiss="alert"]'
  var Alert   = function (el) {
    $(el).on('click', dismiss, this.close)
  }

  Alert.VERSION = '3.3.5'

  Alert.TRANSITION_DURATION = 150

  Alert.prototype.close = function (e) {
    var $this    = $(this)
    var selector = $this.attr('data-target')

    if (!selector) {
      selector = $this.attr('href')
      selector = selector && selector.replace(/.*(?=#[^\s]*$)/, '') // strip for ie7
    }

    var $parent = $(selector)

    if (e) e.preventDefault()

    if (!$parent.length) {
      $parent = $this.closest('.alert')
    }

    $parent.trigger(e = $.Event('close.bs.alert'))

    if (e.isDefaultPrevented()) return

    $parent.removeClass('in')

    function removeElement() {
      // detach from parent, fire event then clean up data
      $parent.detach().trigger('closed.bs.alert').remove()
    }

    $.support.transition && $parent.hasClass('fade') ?
      $parent
        .one('bsTransitionEnd', removeElement)
        .emulateTransitionEnd(Alert.TRANSITION_DURATION) :
      removeElement()
  }


  // ALERT PLUGIN DEFINITION
  // =======================

  function Plugin(option) {
    return this.each(function () {
      var $this = $(this)
      var data  = $this.data('bs.alert')

      if (!data) $this.data('bs.alert', (data = new Alert(this)))
      if (typeof option == 'string') data[option].call($this)
    })
  }

  var old = $.fn.alert

  $.fn.alert             = Plugin
  $.fn.alert.Constructor = Alert


  // ALERT NO CONFLICT
  // =================

  $.fn.alert.noConflict = function () {
    $.fn.alert = old
    return this
  }


  // ALERT DATA-API
  // ==============

  $(document).on('click.bs.alert.data-api', dismiss, Alert.prototype.close)

}(jQuery);

/* ========================================================================
 * Bootstrap: button.js v3.3.5
 * http://getbootstrap.com/javascript/#buttons
 * ========================================================================
 * Copyright 2011-2015 Twitter, Inc.
 * Licensed under MIT (https://github.com/twbs/bootstrap/blob/master/LICENSE)
 * ======================================================================== */


+function ($) {
  'use strict';

  // BUTTON PUBLIC CLASS DEFINITION
  // ==============================

  var Button = function (element, options) {
    this.$element  = $(element)
    this.options   = $.extend({}, Button.DEFAULTS, options)
    this.isLoading = false
  }

  Button.VERSION  = '3.3.5'

  Button.DEFAULTS = {
    loadingText: 'loading...'
  }

  Button.prototype.setState = function (state) {
    var d    = 'disabled'
    var $el  = this.$element
    var val  = $el.is('input') ? 'val' : 'html'
    var data = $el.data()

    state += 'Text'

    if (data.resetText == null) $el.data('resetText', $el[val]())

    // push to event loop to allow forms to submit
    setTimeout($.proxy(function () {
      $el[val](data[state] == null ? this.options[state] : data[state])

      if (state == 'loadingText') {
        this.isLoading = true
        $el.addClass(d).attr(d, d)
      } else if (this.isLoading) {
        this.isLoading = false
        $el.removeClass(d).removeAttr(d)
      }
    }, this), 0)
  }

  Button.prototype.toggle = function () {
    var changed = true
    var $parent = this.$element.closest('[data-toggle="buttons"]')

    if ($parent.length) {
      var $input = this.$element.find('input')
      if ($input.prop('type') == 'radio') {
        if ($input.prop('checked')) changed = false
        $parent.find('.active').removeClass('active')
        this.$element.addClass('active')
      } else if ($input.prop('type') == 'checkbox') {
        if (($input.prop('checked')) !== this.$element.hasClass('active')) changed = false
        this.$element.toggleClass('active')
      }
      $input.prop('checked', this.$element.hasClass('active'))
      if (changed) $input.trigger('change')
    } else {
      this.$element.attr('aria-pressed', !this.$element.hasClass('active'))
      this.$element.toggleClass('active')
    }
  }


  // BUTTON PLUGIN DEFINITION
  // ========================

  function Plugin(option) {
    return this.each(function () {
      var $this   = $(this)
      var data    = $this.data('bs.button')
      var options = typeof option == 'object' && option

      if (!data) $this.data('bs.button', (data = new Button(this, options)))

      if (option == 'toggle') data.toggle()
      else if (option) data.setState(option)
    })
  }

  var old = $.fn.button

  $.fn.button             = Plugin
  $.fn.button.Constructor = Button


  // BUTTON NO CONFLICT
  // ==================

  $.fn.button.noConflict = function () {
    $.fn.button = old
    return this
  }


  // BUTTON DATA-API
  // ===============

  $(document)
    .on('click.bs.button.data-api', '[data-toggle^="button"]', function (e) {
      var $btn = $(e.target)
      if (!$btn.hasClass('btn')) $btn = $btn.closest('.btn')
      Plugin.call($btn, 'toggle')
      if (!($(e.target).is('input[type="radio"]') || $(e.target).is('input[type="checkbox"]'))) e.preventDefault()
    })
    .on('focus.bs.button.data-api blur.bs.button.data-api', '[data-toggle^="button"]', function (e) {
      $(e.target).closest('.btn').toggleClass('focus', /^focus(in)?$/.test(e.type))
    })

}(jQuery);

/* ========================================================================
 * Bootstrap: carousel.js v3.3.5
 * http://getbootstrap.com/javascript/#carousel
 * ========================================================================
 * Copyright 2011-2015 Twitter, Inc.
 * Licensed under MIT (https://github.com/twbs/bootstrap/blob/master/LICENSE)
 * ======================================================================== */


+function ($) {
  'use strict';

  // CAROUSEL CLASS DEFINITION
  // =========================

  var Carousel = function (element, options) {
    this.$element    = $(element)
    this.$indicators = this.$element.find('.carousel-indicators')
    this.options     = options
    this.paused      = null
    this.sliding     = null
    this.interval    = null
    this.$active     = null
    this.$items      = null

    this.options.keyboard && this.$element.on('keydown.bs.carousel', $.proxy(this.keydown, this))

    this.options.pause == 'hover' && !('ontouchstart' in document.documentElement) && this.$element
      .on('mouseenter.bs.carousel', $.proxy(this.pause, this))
      .on('mouseleave.bs.carousel', $.proxy(this.cycle, this))
  }

  Carousel.VERSION  = '3.3.5'

  Carousel.TRANSITION_DURATION = 600

  Carousel.DEFAULTS = {
    interval: 5000,
    pause: 'hover',
    wrap: true,
    keyboard: true
  }

  Carousel.prototype.keydown = function (e) {
    if (/input|textarea/i.test(e.target.tagName)) return
    switch (e.which) {
      case 37: this.prev(); break
      case 39: this.next(); break
      default: return
    }

    e.preventDefault()
  }

  Carousel.prototype.cycle = function (e) {
    e || (this.paused = false)

    this.interval && clearInterval(this.interval)

    this.options.interval
      && !this.paused
      && (this.interval = setInterval($.proxy(this.next, this), this.options.interval))

    return this
  }

  Carousel.prototype.getItemIndex = function (item) {
    this.$items = item.parent().children('.item')
    return this.$items.index(item || this.$active)
  }

  Carousel.prototype.getItemForDirection = function (direction, active) {
    var activeIndex = this.getItemIndex(active)
    var willWrap = (direction == 'prev' && activeIndex === 0)
                || (direction == 'next' && activeIndex == (this.$items.length - 1))
    if (willWrap && !this.options.wrap) return active
    var delta = direction == 'prev' ? -1 : 1
    var itemIndex = (activeIndex + delta) % this.$items.length
    return this.$items.eq(itemIndex)
  }

  Carousel.prototype.to = function (pos) {
    var that        = this
    var activeIndex = this.getItemIndex(this.$active = this.$element.find('.item.active'))

    if (pos > (this.$items.length - 1) || pos < 0) return

    if (this.sliding)       return this.$element.one('slid.bs.carousel', function () { that.to(pos) }) // yes, "slid"
    if (activeIndex == pos) return this.pause().cycle()

    return this.slide(pos > activeIndex ? 'next' : 'prev', this.$items.eq(pos))
  }

  Carousel.prototype.pause = function (e) {
    e || (this.paused = true)

    if (this.$element.find('.next, .prev').length && $.support.transition) {
      this.$element.trigger($.support.transition.end)
      this.cycle(true)
    }

    this.interval = clearInterval(this.interval)

    return this
  }

  Carousel.prototype.next = function () {
    if (this.sliding) return
    return this.slide('next')
  }

  Carousel.prototype.prev = function () {
    if (this.sliding) return
    return this.slide('prev')
  }

  Carousel.prototype.slide = function (type, next) {
    var $active   = this.$element.find('.item.active')
    var $next     = next || this.getItemForDirection(type, $active)
    var isCycling = this.interval
    var direction = type == 'next' ? 'left' : 'right'
    var that      = this

    if ($next.hasClass('active')) return (this.sliding = false)

    var relatedTarget = $next[0]
    var slideEvent = $.Event('slide.bs.carousel', {
      relatedTarget: relatedTarget,
      direction: direction
    })
    this.$element.trigger(slideEvent)
    if (slideEvent.isDefaultPrevented()) return

    this.sliding = true

    isCycling && this.pause()

    if (this.$indicators.length) {
      this.$indicators.find('.active').removeClass('active')
      var $nextIndicator = $(this.$indicators.children()[this.getItemIndex($next)])
      $nextIndicator && $nextIndicator.addClass('active')
    }

    var slidEvent = $.Event('slid.bs.carousel', { relatedTarget: relatedTarget, direction: direction }) // yes, "slid"
    if ($.support.transition && this.$element.hasClass('slide')) {
      $next.addClass(type)
      $next[0].offsetWidth // force reflow
      $active.addClass(direction)
      $next.addClass(direction)
      $active
        .one('bsTransitionEnd', function () {
          $next.removeClass([type, direction].join(' ')).addClass('active')
          $active.removeClass(['active', direction].join(' '))
          that.sliding = false
          setTimeout(function () {
            that.$element.trigger(slidEvent)
          }, 0)
        })
        .emulateTransitionEnd(Carousel.TRANSITION_DURATION)
    } else {
      $active.removeClass('active')
      $next.addClass('active')
      this.sliding = false
      this.$element.trigger(slidEvent)
    }

    isCycling && this.cycle()

    return this
  }


  // CAROUSEL PLUGIN DEFINITION
  // ==========================

  function Plugin(option) {
    return this.each(function () {
      var $this   = $(this)
      var data    = $this.data('bs.carousel')
      var options = $.extend({}, Carousel.DEFAULTS, $this.data(), typeof option == 'object' && option)
      var action  = typeof option == 'string' ? option : options.slide

      if (!data) $this.data('bs.carousel', (data = new Carousel(this, options)))
      if (typeof option == 'number') data.to(option)
      else if (action) data[action]()
      else if (options.interval) data.pause().cycle()
    })
  }

  var old = $.fn.carousel

  $.fn.carousel             = Plugin
  $.fn.carousel.Constructor = Carousel


  // CAROUSEL NO CONFLICT
  // ====================

  $.fn.carousel.noConflict = function () {
    $.fn.carousel = old
    return this
  }


  // CAROUSEL DATA-API
  // =================

  var clickHandler = function (e) {
    var href
    var $this   = $(this)
    var $target = $($this.attr('data-target') || (href = $this.attr('href')) && href.replace(/.*(?=#[^\s]+$)/, '')) // strip for ie7
    if (!$target.hasClass('carousel')) return
    var options = $.extend({}, $target.data(), $this.data())
    var slideIndex = $this.attr('data-slide-to')
    if (slideIndex) options.interval = false

    Plugin.call($target, options)

    if (slideIndex) {
      $target.data('bs.carousel').to(slideIndex)
    }

    e.preventDefault()
  }

  $(document)
    .on('click.bs.carousel.data-api', '[data-slide]', clickHandler)
    .on('click.bs.carousel.data-api', '[data-slide-to]', clickHandler)

  $(window).on('load', function () {
    $('[data-ride="carousel"]').each(function () {
      var $carousel = $(this)
      Plugin.call($carousel, $carousel.data())
    })
  })

}(jQuery);

/* ========================================================================
 * Bootstrap: dropdown.js v3.3.5
 * http://getbootstrap.com/javascript/#dropdowns
 * ========================================================================
 * Copyright 2011-2015 Twitter, Inc.
 * Licensed under MIT (https://github.com/twbs/bootstrap/blob/master/LICENSE)
 * ======================================================================== */


+function ($) {
  'use strict';

  // DROPDOWN CLASS DEFINITION
  // =========================

  var backdrop = '.dropdown-backdrop'
  var toggle   = '[data-toggle="dropdown"]'
  var Dropdown = function (element) {
    $(element).on('click.bs.dropdown', this.toggle)
  }

  Dropdown.VERSION = '3.3.5'

  function getParent($this) {
    var selector = $this.attr('data-target')

    if (!selector) {
      selector = $this.attr('href')
      selector = selector && /#[A-Za-z]/.test(selector) && selector.replace(/.*(?=#[^\s]*$)/, '') // strip for ie7
    }

    var $parent = selector && $(selector)

    return $parent && $parent.length ? $parent : $this.parent()
  }

  function clearMenus(e) {
    if (e && e.which === 3) return
    $(backdrop).remove()
    $(toggle).each(function () {
      var $this         = $(this)
      var $parent       = getParent($this)
      var relatedTarget = { relatedTarget: this }

      if (!$parent.hasClass('open')) return

      if (e && e.type == 'click' && /input|textarea/i.test(e.target.tagName) && $.contains($parent[0], e.target)) return

      $parent.trigger(e = $.Event('hide.bs.dropdown', relatedTarget))

      if (e.isDefaultPrevented()) return

      $this.attr('aria-expanded', 'false')
      $parent.removeClass('open').trigger('hidden.bs.dropdown', relatedTarget)
    })
  }

  Dropdown.prototype.toggle = function (e) {
    var $this = $(this)

    if ($this.is('.disabled, :disabled')) return

    var $parent  = getParent($this)
    var isActive = $parent.hasClass('open')

    clearMenus()

    if (!isActive) {
      if ('ontouchstart' in document.documentElement && !$parent.closest('.navbar-nav').length) {
        // if mobile we use a backdrop because click events don't delegate
        $(document.createElement('div'))
          .addClass('dropdown-backdrop')
          .insertAfter($(this))
          .on('click', clearMenus)
      }

      var relatedTarget = { relatedTarget: this }
      $parent.trigger(e = $.Event('show.bs.dropdown', relatedTarget))

      if (e.isDefaultPrevented()) return

      $this
        .trigger('focus')
        .attr('aria-expanded', 'true')

      $parent
        .toggleClass('open')
        .trigger('shown.bs.dropdown', relatedTarget)
    }

    return false
  }

  Dropdown.prototype.keydown = function (e) {
    if (!/(38|40|27|32)/.test(e.which) || /input|textarea/i.test(e.target.tagName)) return

    var $this = $(this)

    e.preventDefault()
    e.stopPropagation()

    if ($this.is('.disabled, :disabled')) return

    var $parent  = getParent($this)
    var isActive = $parent.hasClass('open')

    if (!isActive && e.which != 27 || isActive && e.which == 27) {
      if (e.which == 27) $parent.find(toggle).trigger('focus')
      return $this.trigger('click')
    }

    var desc = ' li:not(.disabled):visible a'
    var $items = $parent.find('.dropdown-menu' + desc)

    if (!$items.length) return

    var index = $items.index(e.target)

    if (e.which == 38 && index > 0)                 index--         // up
    if (e.which == 40 && index < $items.length - 1) index++         // down
    if (!~index)                                    index = 0

    $items.eq(index).trigger('focus')
  }


  // DROPDOWN PLUGIN DEFINITION
  // ==========================

  function Plugin(option) {
    return this.each(function () {
      var $this = $(this)
      var data  = $this.data('bs.dropdown')

      if (!data) $this.data('bs.dropdown', (data = new Dropdown(this)))
      if (typeof option == 'string') data[option].call($this)
    })
  }

  var old = $.fn.dropdown

  $.fn.dropdown             = Plugin
  $.fn.dropdown.Constructor = Dropdown


  // DROPDOWN NO CONFLICT
  // ====================

  $.fn.dropdown.noConflict = function () {
    $.fn.dropdown = old
    return this
  }


  // APPLY TO STANDARD DROPDOWN ELEMENTS
  // ===================================

  $(document)
    .on('click.bs.dropdown.data-api', clearMenus)
    .on('click.bs.dropdown.data-api', '.dropdown form', function (e) { e.stopPropagation() })
    .on('click.bs.dropdown.data-api', toggle, Dropdown.prototype.toggle)
    .on('keydown.bs.dropdown.data-api', toggle, Dropdown.prototype.keydown)
    .on('keydown.bs.dropdown.data-api', '.dropdown-menu', Dropdown.prototype.keydown)

}(jQuery);

/* ========================================================================
 * Bootstrap: modal.js v3.3.5
 * http://getbootstrap.com/javascript/#modals
 * ========================================================================
 * Copyright 2011-2015 Twitter, Inc.
 * Licensed under MIT (https://github.com/twbs/bootstrap/blob/master/LICENSE)
 * ======================================================================== */


+function ($) {
  'use strict';

  // MODAL CLASS DEFINITION
  // ======================

  var Modal = function (element, options) {
    this.options             = options
    this.$body               = $(document.body)
    this.$element            = $(element)
    this.$dialog             = this.$element.find('.modal-dialog')
    this.$backdrop           = null
    this.isShown             = null
    this.originalBodyPad     = null
    this.scrollbarWidth      = 0
    this.ignoreBackdropClick = false

    if (this.options.remote) {
      this.$element
        .find('.modal-content')
        .load(this.options.remote, $.proxy(function () {
          this.$element.trigger('loaded.bs.modal')
        }, this))
    }
  }

  Modal.VERSION  = '3.3.5'

  Modal.TRANSITION_DURATION = 300
  Modal.BACKDROP_TRANSITION_DURATION = 150

  Modal.DEFAULTS = {
    backdrop: true,
    keyboard: true,
    show: true
  }

  Modal.prototype.toggle = function (_relatedTarget) {
    return this.isShown ? this.hide() : this.show(_relatedTarget)
  }

  Modal.prototype.show = function (_relatedTarget) {
    var that = this
    var e    = $.Event('show.bs.modal', { relatedTarget: _relatedTarget })

    this.$element.trigger(e)

    if (this.isShown || e.isDefaultPrevented()) return

    this.isShown = true

    this.checkScrollbar()
    this.setScrollbar()
    this.$body.addClass('modal-open')

    this.escape()
    this.resize()

    this.$element.on('click.dismiss.bs.modal', '[data-dismiss="modal"]', $.proxy(this.hide, this))

    this.$dialog.on('mousedown.dismiss.bs.modal', function () {
      that.$element.one('mouseup.dismiss.bs.modal', function (e) {
        if ($(e.target).is(that.$element)) that.ignoreBackdropClick = true
      })
    })

    this.backdrop(function () {
      var transition = $.support.transition && that.$element.hasClass('fade')

      if (!that.$element.parent().length) {
        that.$element.appendTo(that.$body) // don't move modals dom position
      }

      that.$element
        .show()
        .scrollTop(0)

      that.adjustDialog()

      if (transition) {
        that.$element[0].offsetWidth // force reflow
      }

      that.$element.addClass('in')

      that.enforceFocus()

      var e = $.Event('shown.bs.modal', { relatedTarget: _relatedTarget })

      transition ?
        that.$dialog // wait for modal to slide in
          .one('bsTransitionEnd', function () {
            that.$element.trigger('focus').trigger(e)
          })
          .emulateTransitionEnd(Modal.TRANSITION_DURATION) :
        that.$element.trigger('focus').trigger(e)
    })
  }

  Modal.prototype.hide = function (e) {
    if (e) e.preventDefault()

    e = $.Event('hide.bs.modal')

    this.$element.trigger(e)

    if (!this.isShown || e.isDefaultPrevented()) return

    this.isShown = false

    this.escape()
    this.resize()

    $(document).off('focusin.bs.modal')

    this.$element
      .removeClass('in')
      .off('click.dismiss.bs.modal')
      .off('mouseup.dismiss.bs.modal')

    this.$dialog.off('mousedown.dismiss.bs.modal')

    $.support.transition && this.$element.hasClass('fade') ?
      this.$element
        .one('bsTransitionEnd', $.proxy(this.hideModal, this))
        .emulateTransitionEnd(Modal.TRANSITION_DURATION) :
      this.hideModal()
  }

  Modal.prototype.enforceFocus = function () {
    $(document)
      .off('focusin.bs.modal') // guard against infinite focus loop
      .on('focusin.bs.modal', $.proxy(function (e) {
        if (this.$element[0] !== e.target && !this.$element.has(e.target).length) {
          this.$element.trigger('focus')
        }
      }, this))
  }

  Modal.prototype.escape = function () {
    if (this.isShown && this.options.keyboard) {
      this.$element.on('keydown.dismiss.bs.modal', $.proxy(function (e) {
        e.which == 27 && this.hide()
      }, this))
    } else if (!this.isShown) {
      this.$element.off('keydown.dismiss.bs.modal')
    }
  }

  Modal.prototype.resize = function () {
    if (this.isShown) {
      $(window).on('resize.bs.modal', $.proxy(this.handleUpdate, this))
    } else {
      $(window).off('resize.bs.modal')
    }
  }

  Modal.prototype.hideModal = function () {
    var that = this
    this.$element.hide()
    this.backdrop(function () {
      that.$body.removeClass('modal-open')
      that.resetAdjustments()
      that.resetScrollbar()
      that.$element.trigger('hidden.bs.modal')
    })
  }

  Modal.prototype.removeBackdrop = function () {
    this.$backdrop && this.$backdrop.remove()
    this.$backdrop = null
  }

  Modal.prototype.backdrop = function (callback) {
    var that = this
    var animate = this.$element.hasClass('fade') ? 'fade' : ''

    if (this.isShown && this.options.backdrop) {
      var doAnimate = $.support.transition && animate

      this.$backdrop = $(document.createElement('div'))
        .addClass('modal-backdrop ' + animate)
        .appendTo(this.$body)

      this.$element.on('click.dismiss.bs.modal', $.proxy(function (e) {
        if (this.ignoreBackdropClick) {
          this.ignoreBackdropClick = false
          return
        }
        if (e.target !== e.currentTarget) return
        this.options.backdrop == 'static'
          ? this.$element[0].focus()
          : this.hide()
      }, this))

      if (doAnimate) this.$backdrop[0].offsetWidth // force reflow

      this.$backdrop.addClass('in')

      if (!callback) return

      doAnimate ?
        this.$backdrop
          .one('bsTransitionEnd', callback)
          .emulateTransitionEnd(Modal.BACKDROP_TRANSITION_DURATION) :
        callback()

    } else if (!this.isShown && this.$backdrop) {
      this.$backdrop.removeClass('in')

      var callbackRemove = function () {
        that.removeBackdrop()
        callback && callback()
      }
      $.support.transition && this.$element.hasClass('fade') ?
        this.$backdrop
          .one('bsTransitionEnd', callbackRemove)
          .emulateTransitionEnd(Modal.BACKDROP_TRANSITION_DURATION) :
        callbackRemove()

    } else if (callback) {
      callback()
    }
  }

  // these following methods are used to handle overflowing modals

  Modal.prototype.handleUpdate = function () {
    this.adjustDialog()
  }

  Modal.prototype.adjustDialog = function () {
    var modalIsOverflowing = this.$element[0].scrollHeight > document.documentElement.clientHeight

    this.$element.css({
      paddingLeft:  !this.bodyIsOverflowing && modalIsOverflowing ? this.scrollbarWidth : '',
      paddingRight: this.bodyIsOverflowing && !modalIsOverflowing ? this.scrollbarWidth : ''
    })
  }

  Modal.prototype.resetAdjustments = function () {
    this.$element.css({
      paddingLeft: '',
      paddingRight: ''
    })
  }

  Modal.prototype.checkScrollbar = function () {
    var fullWindowWidth = window.innerWidth
    if (!fullWindowWidth) { // workaround for missing window.innerWidth in IE8
      var documentElementRect = document.documentElement.getBoundingClientRect()
      fullWindowWidth = documentElementRect.right - Math.abs(documentElementRect.left)
    }
    this.bodyIsOverflowing = document.body.clientWidth < fullWindowWidth
    this.scrollbarWidth = this.measureScrollbar()
  }

  Modal.prototype.setScrollbar = function () {
    var bodyPad = parseInt((this.$body.css('padding-right') || 0), 10)
    this.originalBodyPad = document.body.style.paddingRight || ''
    if (this.bodyIsOverflowing) this.$body.css('padding-right', bodyPad + this.scrollbarWidth)
  }

  Modal.prototype.resetScrollbar = function () {
    this.$body.css('padding-right', this.originalBodyPad)
  }

  Modal.prototype.measureScrollbar = function () { // thx walsh
    var scrollDiv = document.createElement('div')
    scrollDiv.className = 'modal-scrollbar-measure'
    this.$body.append(scrollDiv)
    var scrollbarWidth = scrollDiv.offsetWidth - scrollDiv.clientWidth
    this.$body[0].removeChild(scrollDiv)
    return scrollbarWidth
  }


  // MODAL PLUGIN DEFINITION
  // =======================

  function Plugin(option, _relatedTarget) {
    return this.each(function () {
      var $this   = $(this)
      var data    = $this.data('bs.modal')
      var options = $.extend({}, Modal.DEFAULTS, $this.data(), typeof option == 'object' && option)

      if (!data) $this.data('bs.modal', (data = new Modal(this, options)))
      if (typeof option == 'string') data[option](_relatedTarget)
      else if (options.show) data.show(_relatedTarget)
    })
  }

  var old = $.fn.modal

  $.fn.modal             = Plugin
  $.fn.modal.Constructor = Modal


  // MODAL NO CONFLICT
  // =================

  $.fn.modal.noConflict = function () {
    $.fn.modal = old
    return this
  }


  // MODAL DATA-API
  // ==============

  $(document).on('click.bs.modal.data-api', '[data-toggle="modal"]', function (e) {
    var $this   = $(this)
    var href    = $this.attr('href')
    var $target = $($this.attr('data-target') || (href && href.replace(/.*(?=#[^\s]+$)/, ''))) // strip for ie7
    var option  = $target.data('bs.modal') ? 'toggle' : $.extend({ remote: !/#/.test(href) && href }, $target.data(), $this.data())

    if ($this.is('a')) e.preventDefault()

    $target.one('show.bs.modal', function (showEvent) {
      if (showEvent.isDefaultPrevented()) return // only register focus restorer if modal will actually get shown
      $target.one('hidden.bs.modal', function () {
        $this.is(':visible') && $this.trigger('focus')
      })
    })
    Plugin.call($target, option, this)
  })

}(jQuery);

/* ========================================================================
 * Bootstrap: tooltip.js v3.3.5
 * http://getbootstrap.com/javascript/#tooltip
 * Inspired by the original jQuery.tipsy by Jason Frame
 * ========================================================================
 * Copyright 2011-2015 Twitter, Inc.
 * Licensed under MIT (https://github.com/twbs/bootstrap/blob/master/LICENSE)
 * ======================================================================== */


+function ($) {
  'use strict';

  // TOOLTIP PUBLIC CLASS DEFINITION
  // ===============================

  var Tooltip = function (element, options) {
    this.type       = null
    this.options    = null
    this.enabled    = null
    this.timeout    = null
    this.hoverState = null
    this.$element   = null
    this.inState    = null

    this.init('tooltip', element, options)
  }

  Tooltip.VERSION  = '3.3.5'

  Tooltip.TRANSITION_DURATION = 150

  Tooltip.DEFAULTS = {
    animation: true,
    placement: 'top',
    selector: false,
    template: '<div class="tooltip" role="tooltip"><div class="tooltip-arrow"></div><div class="tooltip-inner"></div></div>',
    trigger: 'hover focus',
    title: '',
    delay: 0,
    html: false,
    container: false,
    viewport: {
      selector: 'body',
      padding: 0
    }
  }

  Tooltip.prototype.init = function (type, element, options) {
    this.enabled   = true
    this.type      = type
    this.$element  = $(element)
    this.options   = this.getOptions(options)
    this.$viewport = this.options.viewport && $($.isFunction(this.options.viewport) ? this.options.viewport.call(this, this.$element) : (this.options.viewport.selector || this.options.viewport))
    this.inState   = { click: false, hover: false, focus: false }

    if (this.$element[0] instanceof document.constructor && !this.options.selector) {
      throw new Error('`selector` option must be specified when initializing ' + this.type + ' on the window.document object!')
    }

    var triggers = this.options.trigger.split(' ')

    for (var i = triggers.length; i--;) {
      var trigger = triggers[i]

      if (trigger == 'click') {
        this.$element.on('click.' + this.type, this.options.selector, $.proxy(this.toggle, this))
      } else if (trigger != 'manual') {
        var eventIn  = trigger == 'hover' ? 'mouseenter' : 'focusin'
        var eventOut = trigger == 'hover' ? 'mouseleave' : 'focusout'

        this.$element.on(eventIn  + '.' + this.type, this.options.selector, $.proxy(this.enter, this))
        this.$element.on(eventOut + '.' + this.type, this.options.selector, $.proxy(this.leave, this))
      }
    }

    this.options.selector ?
      (this._options = $.extend({}, this.options, { trigger: 'manual', selector: '' })) :
      this.fixTitle()
  }

  Tooltip.prototype.getDefaults = function () {
    return Tooltip.DEFAULTS
  }

  Tooltip.prototype.getOptions = function (options) {
    options = $.extend({}, this.getDefaults(), this.$element.data(), options)

    if (options.delay && typeof options.delay == 'number') {
      options.delay = {
        show: options.delay,
        hide: options.delay
      }
    }

    return options
  }

  Tooltip.prototype.getDelegateOptions = function () {
    var options  = {}
    var defaults = this.getDefaults()

    this._options && $.each(this._options, function (key, value) {
      if (defaults[key] != value) options[key] = value
    })

    return options
  }

  Tooltip.prototype.enter = function (obj) {
    var self = obj instanceof this.constructor ?
      obj : $(obj.currentTarget).data('bs.' + this.type)

    if (!self) {
      self = new this.constructor(obj.currentTarget, this.getDelegateOptions())
      $(obj.currentTarget).data('bs.' + this.type, self)
    }

    if (obj instanceof $.Event) {
      self.inState[obj.type == 'focusin' ? 'focus' : 'hover'] = true
    }

    if (self.tip().hasClass('in') || self.hoverState == 'in') {
      self.hoverState = 'in'
      return
    }

    clearTimeout(self.timeout)

    self.hoverState = 'in'

    if (!self.options.delay || !self.options.delay.show) return self.show()

    self.timeout = setTimeout(function () {
      if (self.hoverState == 'in') self.show()
    }, self.options.delay.show)
  }

  Tooltip.prototype.isInStateTrue = function () {
    for (var key in this.inState) {
      if (this.inState[key]) return true
    }

    return false
  }

  Tooltip.prototype.leave = function (obj) {
    var self = obj instanceof this.constructor ?
      obj : $(obj.currentTarget).data('bs.' + this.type)

    if (!self) {
      self = new this.constructor(obj.currentTarget, this.getDelegateOptions())
      $(obj.currentTarget).data('bs.' + this.type, self)
    }

    if (obj instanceof $.Event) {
      self.inState[obj.type == 'focusout' ? 'focus' : 'hover'] = false
    }

    if (self.isInStateTrue()) return

    clearTimeout(self.timeout)

    self.hoverState = 'out'

    if (!self.options.delay || !self.options.delay.hide) return self.hide()

    self.timeout = setTimeout(function () {
      if (self.hoverState == 'out') self.hide()
    }, self.options.delay.hide)
  }

  Tooltip.prototype.show = function () {
    var e = $.Event('show.bs.' + this.type)

    if (this.hasContent() && this.enabled) {
      this.$element.trigger(e)

      var inDom = $.contains(this.$element[0].ownerDocument.documentElement, this.$element[0])
      if (e.isDefaultPrevented() || !inDom) return
      var that = this

      var $tip = this.tip()

      var tipId = this.getUID(this.type)

      this.setContent()
      $tip.attr('id', tipId)
      this.$element.attr('aria-describedby', tipId)

      if (this.options.animation) $tip.addClass('fade')

      var placement = typeof this.options.placement == 'function' ?
        this.options.placement.call(this, $tip[0], this.$element[0]) :
        this.options.placement

      var autoToken = /\s?auto?\s?/i
      var autoPlace = autoToken.test(placement)
      if (autoPlace) placement = placement.replace(autoToken, '') || 'top'

      $tip
        .detach()
        .css({ top: 0, left: 0, display: 'block' })
        .addClass(placement)
        .data('bs.' + this.type, this)

      this.options.container ? $tip.appendTo(this.options.container) : $tip.insertAfter(this.$element)
      this.$element.trigger('inserted.bs.' + this.type)

      var pos          = this.getPosition()
      var actualWidth  = $tip[0].offsetWidth
      var actualHeight = $tip[0].offsetHeight

      if (autoPlace) {
        var orgPlacement = placement
        var viewportDim = this.getPosition(this.$viewport)

        placement = placement == 'bottom' && pos.bottom + actualHeight > viewportDim.bottom ? 'top'    :
                    placement == 'top'    && pos.top    - actualHeight < viewportDim.top    ? 'bottom' :
                    placement == 'right'  && pos.right  + actualWidth  > viewportDim.width  ? 'left'   :
                    placement == 'left'   && pos.left   - actualWidth  < viewportDim.left   ? 'right'  :
                    placement

        $tip
          .removeClass(orgPlacement)
          .addClass(placement)
      }

      var calculatedOffset = this.getCalculatedOffset(placement, pos, actualWidth, actualHeight)

      this.applyPlacement(calculatedOffset, placement)

      var complete = function () {
        var prevHoverState = that.hoverState
        that.$element.trigger('shown.bs.' + that.type)
        that.hoverState = null

        if (prevHoverState == 'out') that.leave(that)
      }

      $.support.transition && this.$tip.hasClass('fade') ?
        $tip
          .one('bsTransitionEnd', complete)
          .emulateTransitionEnd(Tooltip.TRANSITION_DURATION) :
        complete()
    }
  }

  Tooltip.prototype.applyPlacement = function (offset, placement) {
    var $tip   = this.tip()
    var width  = $tip[0].offsetWidth
    var height = $tip[0].offsetHeight

    // manually read margins because getBoundingClientRect includes difference
    var marginTop = parseInt($tip.css('margin-top'), 10)
    var marginLeft = parseInt($tip.css('margin-left'), 10)

    // we must check for NaN for ie 8/9
    if (isNaN(marginTop))  marginTop  = 0
    if (isNaN(marginLeft)) marginLeft = 0

    offset.top  += marginTop
    offset.left += marginLeft

    // $.fn.offset doesn't round pixel values
    // so we use setOffset directly with our own function B-0
    $.offset.setOffset($tip[0], $.extend({
      using: function (props) {
        $tip.css({
          top: Math.round(props.top),
          left: Math.round(props.left)
        })
      }
    }, offset), 0)

    $tip.addClass('in')

    // check to see if placing tip in new offset caused the tip to resize itself
    var actualWidth  = $tip[0].offsetWidth
    var actualHeight = $tip[0].offsetHeight

    if (placement == 'top' && actualHeight != height) {
      offset.top = offset.top + height - actualHeight
    }

    var delta = this.getViewportAdjustedDelta(placement, offset, actualWidth, actualHeight)

    if (delta.left) offset.left += delta.left
    else offset.top += delta.top

    var isVertical          = /top|bottom/.test(placement)
    var arrowDelta          = isVertical ? delta.left * 2 - width + actualWidth : delta.top * 2 - height + actualHeight
    var arrowOffsetPosition = isVertical ? 'offsetWidth' : 'offsetHeight'

    $tip.offset(offset)
    this.replaceArrow(arrowDelta, $tip[0][arrowOffsetPosition], isVertical)
  }

  Tooltip.prototype.replaceArrow = function (delta, dimension, isVertical) {
    this.arrow()
      .css(isVertical ? 'left' : 'top', 50 * (1 - delta / dimension) + '%')
      .css(isVertical ? 'top' : 'left', '')
  }

  Tooltip.prototype.setContent = function () {
    var $tip  = this.tip()
    var title = this.getTitle()

    $tip.find('.tooltip-inner')[this.options.html ? 'html' : 'text'](title)
    $tip.removeClass('fade in top bottom left right')
  }

  Tooltip.prototype.hide = function (callback) {
    var that = this
    var $tip = $(this.$tip)
    var e    = $.Event('hide.bs.' + this.type)

    function complete() {
      if (that.hoverState != 'in') $tip.detach()
      that.$element
        .removeAttr('aria-describedby')
        .trigger('hidden.bs.' + that.type)
      callback && callback()
    }

    this.$element.trigger(e)

    if (e.isDefaultPrevented()) return

    $tip.removeClass('in')

    $.support.transition && $tip.hasClass('fade') ?
      $tip
        .one('bsTransitionEnd', complete)
        .emulateTransitionEnd(Tooltip.TRANSITION_DURATION) :
      complete()

    this.hoverState = null

    return this
  }

  Tooltip.prototype.fixTitle = function () {
    var $e = this.$element
    if ($e.attr('title') || typeof $e.attr('data-original-title') != 'string') {
      $e.attr('data-original-title', $e.attr('title') || '').attr('title', '')
    }
  }

  Tooltip.prototype.hasContent = function () {
    return this.getTitle()
  }

  Tooltip.prototype.getPosition = function ($element) {
    $element   = $element || this.$element

    var el     = $element[0]
    var isBody = el.tagName == 'BODY'

    var elRect    = el.getBoundingClientRect()
    if (elRect.width == null) {
      // width and height are missing in IE8, so compute them manually; see https://github.com/twbs/bootstrap/issues/14093
      elRect = $.extend({}, elRect, { width: elRect.right - elRect.left, height: elRect.bottom - elRect.top })
    }
    var elOffset  = isBody ? { top: 0, left: 0 } : $element.offset()
    var scroll    = { scroll: isBody ? document.documentElement.scrollTop || document.body.scrollTop : $element.scrollTop() }
    var outerDims = isBody ? { width: $(window).width(), height: $(window).height() } : null

    return $.extend({}, elRect, scroll, outerDims, elOffset)
  }

  Tooltip.prototype.getCalculatedOffset = function (placement, pos, actualWidth, actualHeight) {
    return placement == 'bottom' ? { top: pos.top + pos.height,   left: pos.left + pos.width / 2 - actualWidth / 2 } :
           placement == 'top'    ? { top: pos.top - actualHeight, left: pos.left + pos.width / 2 - actualWidth / 2 } :
           placement == 'left'   ? { top: pos.top + pos.height / 2 - actualHeight / 2, left: pos.left - actualWidth } :
        /* placement == 'right' */ { top: pos.top + pos.height / 2 - actualHeight / 2, left: pos.left + pos.width }

  }

  Tooltip.prototype.getViewportAdjustedDelta = function (placement, pos, actualWidth, actualHeight) {
    var delta = { top: 0, left: 0 }
    if (!this.$viewport) return delta

    var viewportPadding = this.options.viewport && this.options.viewport.padding || 0
    var viewportDimensions = this.getPosition(this.$viewport)

    if (/right|left/.test(placement)) {
      var topEdgeOffset    = pos.top - viewportPadding - viewportDimensions.scroll
      var bottomEdgeOffset = pos.top + viewportPadding - viewportDimensions.scroll + actualHeight
      if (topEdgeOffset < viewportDimensions.top) { // top overflow
        delta.top = viewportDimensions.top - topEdgeOffset
      } else if (bottomEdgeOffset > viewportDimensions.top + viewportDimensions.height) { // bottom overflow
        delta.top = viewportDimensions.top + viewportDimensions.height - bottomEdgeOffset
      }
    } else {
      var leftEdgeOffset  = pos.left - viewportPadding
      var rightEdgeOffset = pos.left + viewportPadding + actualWidth
      if (leftEdgeOffset < viewportDimensions.left) { // left overflow
        delta.left = viewportDimensions.left - leftEdgeOffset
      } else if (rightEdgeOffset > viewportDimensions.right) { // right overflow
        delta.left = viewportDimensions.left + viewportDimensions.width - rightEdgeOffset
      }
    }

    return delta
  }

  Tooltip.prototype.getTitle = function () {
    var title
    var $e = this.$element
    var o  = this.options

    title = $e.attr('data-original-title')
      || (typeof o.title == 'function' ? o.title.call($e[0]) :  o.title)

    return title
  }

  Tooltip.prototype.getUID = function (prefix) {
    do prefix += ~~(Math.random() * 1000000)
    while (document.getElementById(prefix))
    return prefix
  }

  Tooltip.prototype.tip = function () {
    if (!this.$tip) {
      this.$tip = $(this.options.template)
      if (this.$tip.length != 1) {
        throw new Error(this.type + ' `template` option must consist of exactly 1 top-level element!')
      }
    }
    return this.$tip
  }

  Tooltip.prototype.arrow = function () {
    return (this.$arrow = this.$arrow || this.tip().find('.tooltip-arrow'))
  }

  Tooltip.prototype.enable = function () {
    this.enabled = true
  }

  Tooltip.prototype.disable = function () {
    this.enabled = false
  }

  Tooltip.prototype.toggleEnabled = function () {
    this.enabled = !this.enabled
  }

  Tooltip.prototype.toggle = function (e) {
    var self = this
    if (e) {
      self = $(e.currentTarget).data('bs.' + this.type)
      if (!self) {
        self = new this.constructor(e.currentTarget, this.getDelegateOptions())
        $(e.currentTarget).data('bs.' + this.type, self)
      }
    }

    if (e) {
      self.inState.click = !self.inState.click
      if (self.isInStateTrue()) self.enter(self)
      else self.leave(self)
    } else {
      self.tip().hasClass('in') ? self.leave(self) : self.enter(self)
    }
  }

  Tooltip.prototype.destroy = function () {
    var that = this
    clearTimeout(this.timeout)
    this.hide(function () {
      that.$element.off('.' + that.type).removeData('bs.' + that.type)
      if (that.$tip) {
        that.$tip.detach()
      }
      that.$tip = null
      that.$arrow = null
      that.$viewport = null
    })
  }


  // TOOLTIP PLUGIN DEFINITION
  // =========================

  function Plugin(option) {
    return this.each(function () {
      var $this   = $(this)
      var data    = $this.data('bs.tooltip')
      var options = typeof option == 'object' && option

      if (!data && /destroy|hide/.test(option)) return
      if (!data) $this.data('bs.tooltip', (data = new Tooltip(this, options)))
      if (typeof option == 'string') data[option]()
    })
  }

  var old = $.fn.tooltip

  $.fn.tooltip             = Plugin
  $.fn.tooltip.Constructor = Tooltip


  // TOOLTIP NO CONFLICT
  // ===================

  $.fn.tooltip.noConflict = function () {
    $.fn.tooltip = old
    return this
  }

}(jQuery);

/* ========================================================================
 * Bootstrap: popover.js v3.3.5
 * http://getbootstrap.com/javascript/#popovers
 * ========================================================================
 * Copyright 2011-2015 Twitter, Inc.
 * Licensed under MIT (https://github.com/twbs/bootstrap/blob/master/LICENSE)
 * ======================================================================== */


+function ($) {
  'use strict';

  // POPOVER PUBLIC CLASS DEFINITION
  // ===============================

  var Popover = function (element, options) {
    this.init('popover', element, options)
  }

  if (!$.fn.tooltip) throw new Error('Popover requires tooltip.js')

  Popover.VERSION  = '3.3.5'

  Popover.DEFAULTS = $.extend({}, $.fn.tooltip.Constructor.DEFAULTS, {
    placement: 'right',
    trigger: 'click',
    content: '',
    template: '<div class="popover" role="tooltip"><div class="arrow"></div><h3 class="popover-title"></h3><div class="popover-content"></div></div>'
  })


  // NOTE: POPOVER EXTENDS tooltip.js
  // ================================

  Popover.prototype = $.extend({}, $.fn.tooltip.Constructor.prototype)

  Popover.prototype.constructor = Popover

  Popover.prototype.getDefaults = function () {
    return Popover.DEFAULTS
  }

  Popover.prototype.setContent = function () {
    var $tip    = this.tip()
    var title   = this.getTitle()
    var content = this.getContent()

    $tip.find('.popover-title')[this.options.html ? 'html' : 'text'](title)
    $tip.find('.popover-content').children().detach().end()[ // we use append for html objects to maintain js events
      this.options.html ? (typeof content == 'string' ? 'html' : 'append') : 'text'
    ](content)

    $tip.removeClass('fade top bottom left right in')

    // IE8 doesn't accept hiding via the `:empty` pseudo selector, we have to do
    // this manually by checking the contents.
    if (!$tip.find('.popover-title').html()) $tip.find('.popover-title').hide()
  }

  Popover.prototype.hasContent = function () {
    return this.getTitle() || this.getContent()
  }

  Popover.prototype.getContent = function () {
    var $e = this.$element
    var o  = this.options

    return $e.attr('data-content')
      || (typeof o.content == 'function' ?
            o.content.call($e[0]) :
            o.content)
  }

  Popover.prototype.arrow = function () {
    return (this.$arrow = this.$arrow || this.tip().find('.arrow'))
  }


  // POPOVER PLUGIN DEFINITION
  // =========================

  function Plugin(option) {
    return this.each(function () {
      var $this   = $(this)
      var data    = $this.data('bs.popover')
      var options = typeof option == 'object' && option

      if (!data && /destroy|hide/.test(option)) return
      if (!data) $this.data('bs.popover', (data = new Popover(this, options)))
      if (typeof option == 'string') data[option]()
    })
  }

  var old = $.fn.popover

  $.fn.popover             = Plugin
  $.fn.popover.Constructor = Popover


  // POPOVER NO CONFLICT
  // ===================

  $.fn.popover.noConflict = function () {
    $.fn.popover = old
    return this
  }

}(jQuery);

/* ========================================================================
 * Bootstrap: tab.js v3.3.5
 * http://getbootstrap.com/javascript/#tabs
 * ========================================================================
 * Copyright 2011-2015 Twitter, Inc.
 * Licensed under MIT (https://github.com/twbs/bootstrap/blob/master/LICENSE)
 * ======================================================================== */


+function ($) {
  'use strict';

  // TAB CLASS DEFINITION
  // ====================

  var Tab = function (element) {
    // jscs:disable requireDollarBeforejQueryAssignment
    this.element = $(element)
    // jscs:enable requireDollarBeforejQueryAssignment
  }

  Tab.VERSION = '3.3.5'

  Tab.TRANSITION_DURATION = 150

  Tab.prototype.show = function () {
    var $this    = this.element
    var $ul      = $this.closest('ul:not(.dropdown-menu)')
    var selector = $this.data('target')

    if (!selector) {
      selector = $this.attr('href')
      selector = selector && selector.replace(/.*(?=#[^\s]*$)/, '') // strip for ie7
    }

    if ($this.parent('li').hasClass('active')) return

    var $previous = $ul.find('.active:last a')
    var hideEvent = $.Event('hide.bs.tab', {
      relatedTarget: $this[0]
    })
    var showEvent = $.Event('show.bs.tab', {
      relatedTarget: $previous[0]
    })

    $previous.trigger(hideEvent)
    $this.trigger(showEvent)

    if (showEvent.isDefaultPrevented() || hideEvent.isDefaultPrevented()) return

    var $target = $(selector)

    this.activate($this.closest('li'), $ul)
    this.activate($target, $target.parent(), function () {
      $previous.trigger({
        type: 'hidden.bs.tab',
        relatedTarget: $this[0]
      })
      $this.trigger({
        type: 'shown.bs.tab',
        relatedTarget: $previous[0]
      })
    })
  }

  Tab.prototype.activate = function (element, container, callback) {
    var $active    = container.find('> .active')
    var transition = callback
      && $.support.transition
      && ($active.length && $active.hasClass('fade') || !!container.find('> .fade').length)

    function next() {
      $active
        .removeClass('active')
        .find('> .dropdown-menu > .active')
          .removeClass('active')
        .end()
        .find('[data-toggle="tab"]')
          .attr('aria-expanded', false)

      element
        .addClass('active')
        .find('[data-toggle="tab"]')
          .attr('aria-expanded', true)

      if (transition) {
        element[0].offsetWidth // reflow for transition
        element.addClass('in')
      } else {
        element.removeClass('fade')
      }

      if (element.parent('.dropdown-menu').length) {
        element
          .closest('li.dropdown')
            .addClass('active')
          .end()
          .find('[data-toggle="tab"]')
            .attr('aria-expanded', true)
      }

      callback && callback()
    }

    $active.length && transition ?
      $active
        .one('bsTransitionEnd', next)
        .emulateTransitionEnd(Tab.TRANSITION_DURATION) :
      next()

    $active.removeClass('in')
  }


  // TAB PLUGIN DEFINITION
  // =====================

  function Plugin(option) {
    return this.each(function () {
      var $this = $(this)
      var data  = $this.data('bs.tab')

      if (!data) $this.data('bs.tab', (data = new Tab(this)))
      if (typeof option == 'string') data[option]()
    })
  }

  var old = $.fn.tab

  $.fn.tab             = Plugin
  $.fn.tab.Constructor = Tab


  // TAB NO CONFLICT
  // ===============

  $.fn.tab.noConflict = function () {
    $.fn.tab = old
    return this
  }


  // TAB DATA-API
  // ============

  var clickHandler = function (e) {
    e.preventDefault()
    Plugin.call($(this), 'show')
  }

  $(document)
    .on('click.bs.tab.data-api', '[data-toggle="tab"]', clickHandler)
    .on('click.bs.tab.data-api', '[data-toggle="pill"]', clickHandler)

}(jQuery);

/* ========================================================================
 * Bootstrap: affix.js v3.3.5
 * http://getbootstrap.com/javascript/#affix
 * ========================================================================
 * Copyright 2011-2015 Twitter, Inc.
 * Licensed under MIT (https://github.com/twbs/bootstrap/blob/master/LICENSE)
 * ======================================================================== */


+function ($) {
  'use strict';

  // AFFIX CLASS DEFINITION
  // ======================

  var Affix = function (element, options) {
    this.options = $.extend({}, Affix.DEFAULTS, options)

    this.$target = $(this.options.target)
      .on('scroll.bs.affix.data-api', $.proxy(this.checkPosition, this))
      .on('click.bs.affix.data-api',  $.proxy(this.checkPositionWithEventLoop, this))

    this.$element     = $(element)
    this.affixed      = null
    this.unpin        = null
    this.pinnedOffset = null

    this.checkPosition()
  }

  Affix.VERSION  = '3.3.5'

  Affix.RESET    = 'affix affix-top affix-bottom'

  Affix.DEFAULTS = {
    offset: 0,
    target: window
  }

  Affix.prototype.getState = function (scrollHeight, height, offsetTop, offsetBottom) {
    var scrollTop    = this.$target.scrollTop()
    var position     = this.$element.offset()
    var targetHeight = this.$target.height()

    if (offsetTop != null && this.affixed == 'top') return scrollTop < offsetTop ? 'top' : false

    if (this.affixed == 'bottom') {
      if (offsetTop != null) return (scrollTop + this.unpin <= position.top) ? false : 'bottom'
      return (scrollTop + targetHeight <= scrollHeight - offsetBottom) ? false : 'bottom'
    }

    var initializing   = this.affixed == null
    var colliderTop    = initializing ? scrollTop : position.top
    var colliderHeight = initializing ? targetHeight : height

    if (offsetTop != null && scrollTop <= offsetTop) return 'top'
    if (offsetBottom != null && (colliderTop + colliderHeight >= scrollHeight - offsetBottom)) return 'bottom'

    return false
  }

  Affix.prototype.getPinnedOffset = function () {
    if (this.pinnedOffset) return this.pinnedOffset
    this.$element.removeClass(Affix.RESET).addClass('affix')
    var scrollTop = this.$target.scrollTop()
    var position  = this.$element.offset()
    return (this.pinnedOffset = position.top - scrollTop)
  }

  Affix.prototype.checkPositionWithEventLoop = function () {
    setTimeout($.proxy(this.checkPosition, this), 1)
  }

  Affix.prototype.checkPosition = function () {
    if (!this.$element.is(':visible')) return

    var height       = this.$element.height()
    var offset       = this.options.offset
    var offsetTop    = offset.top
    var offsetBottom = offset.bottom
    var scrollHeight = Math.max($(document).height(), $(document.body).height())

    if (typeof offset != 'object')         offsetBottom = offsetTop = offset
    if (typeof offsetTop == 'function')    offsetTop    = offset.top(this.$element)
    if (typeof offsetBottom == 'function') offsetBottom = offset.bottom(this.$element)

    var affix = this.getState(scrollHeight, height, offsetTop, offsetBottom)

    if (this.affixed != affix) {
      if (this.unpin != null) this.$element.css('top', '')

      var affixType = 'affix' + (affix ? '-' + affix : '')
      var e         = $.Event(affixType + '.bs.affix')

      this.$element.trigger(e)

      if (e.isDefaultPrevented()) return

      this.affixed = affix
      this.unpin = affix == 'bottom' ? this.getPinnedOffset() : null

      this.$element
        .removeClass(Affix.RESET)
        .addClass(affixType)
        .trigger(affixType.replace('affix', 'affixed') + '.bs.affix')
    }

    if (affix == 'bottom') {
      this.$element.offset({
        top: scrollHeight - height - offsetBottom
      })
    }
  }


  // AFFIX PLUGIN DEFINITION
  // =======================

  function Plugin(option) {
    return this.each(function () {
      var $this   = $(this)
      var data    = $this.data('bs.affix')
      var options = typeof option == 'object' && option

      if (!data) $this.data('bs.affix', (data = new Affix(this, options)))
      if (typeof option == 'string') data[option]()
    })
  }

  var old = $.fn.affix

  $.fn.affix             = Plugin
  $.fn.affix.Constructor = Affix


  // AFFIX NO CONFLICT
  // =================

  $.fn.affix.noConflict = function () {
    $.fn.affix = old
    return this
  }


  // AFFIX DATA-API
  // ==============

  $(window).on('load', function () {
    $('[data-spy="affix"]').each(function () {
      var $spy = $(this)
      var data = $spy.data()

      data.offset = data.offset || {}

      if (data.offsetBottom != null) data.offset.bottom = data.offsetBottom
      if (data.offsetTop    != null) data.offset.top    = data.offsetTop

      Plugin.call($spy, data)
    })
  })

}(jQuery);

/* ========================================================================
 * Bootstrap: collapse.js v3.3.5
 * http://getbootstrap.com/javascript/#collapse
 * ========================================================================
 * Copyright 2011-2015 Twitter, Inc.
 * Licensed under MIT (https://github.com/twbs/bootstrap/blob/master/LICENSE)
 * ======================================================================== */


+function ($) {
  'use strict';

  // COLLAPSE PUBLIC CLASS DEFINITION
  // ================================

  var Collapse = function (element, options) {
    this.$element      = $(element)
    this.options       = $.extend({}, Collapse.DEFAULTS, options)
    this.$trigger      = $('[data-toggle="collapse"][href="#' + element.id + '"],' +
                           '[data-toggle="collapse"][data-target="#' + element.id + '"]')
    this.transitioning = null

    if (this.options.parent) {
      this.$parent = this.getParent()
    } else {
      this.addAriaAndCollapsedClass(this.$element, this.$trigger)
    }

    if (this.options.toggle) this.toggle()
  }

  Collapse.VERSION  = '3.3.5'

  Collapse.TRANSITION_DURATION = 350

  Collapse.DEFAULTS = {
    toggle: true
  }

  Collapse.prototype.dimension = function () {
    var hasWidth = this.$element.hasClass('width')
    return hasWidth ? 'width' : 'height'
  }

  Collapse.prototype.show = function () {
    if (this.transitioning || this.$element.hasClass('in')) return

    var activesData
    var actives = this.$parent && this.$parent.children('.panel').children('.in, .collapsing')

    if (actives && actives.length) {
      activesData = actives.data('bs.collapse')
      if (activesData && activesData.transitioning) return
    }

    var startEvent = $.Event('show.bs.collapse')
    this.$element.trigger(startEvent)
    if (startEvent.isDefaultPrevented()) return

    if (actives && actives.length) {
      Plugin.call(actives, 'hide')
      activesData || actives.data('bs.collapse', null)
    }

    var dimension = this.dimension()

    this.$element
      .removeClass('collapse')
      .addClass('collapsing')[dimension](0)
      .attr('aria-expanded', true)

    this.$trigger
      .removeClass('collapsed')
      .attr('aria-expanded', true)

    this.transitioning = 1

    var complete = function () {
      this.$element
        .removeClass('collapsing')
        .addClass('collapse in')[dimension]('')
      this.transitioning = 0
      this.$element
        .trigger('shown.bs.collapse')
    }

    if (!$.support.transition) return complete.call(this)

    var scrollSize = $.camelCase(['scroll', dimension].join('-'))

    this.$element
      .one('bsTransitionEnd', $.proxy(complete, this))
      .emulateTransitionEnd(Collapse.TRANSITION_DURATION)[dimension](this.$element[0][scrollSize])
  }

  Collapse.prototype.hide = function () {
    if (this.transitioning || !this.$element.hasClass('in')) return

    var startEvent = $.Event('hide.bs.collapse')
    this.$element.trigger(startEvent)
    if (startEvent.isDefaultPrevented()) return

    var dimension = this.dimension()

    this.$element[dimension](this.$element[dimension]())[0].offsetHeight

    this.$element
      .addClass('collapsing')
      .removeClass('collapse in')
      .attr('aria-expanded', false)

    this.$trigger
      .addClass('collapsed')
      .attr('aria-expanded', false)

    this.transitioning = 1

    var complete = function () {
      this.transitioning = 0
      this.$element
        .removeClass('collapsing')
        .addClass('collapse')
        .trigger('hidden.bs.collapse')
    }

    if (!$.support.transition) return complete.call(this)

    this.$element
      [dimension](0)
      .one('bsTransitionEnd', $.proxy(complete, this))
      .emulateTransitionEnd(Collapse.TRANSITION_DURATION)
  }

  Collapse.prototype.toggle = function () {
    this[this.$element.hasClass('in') ? 'hide' : 'show']()
  }

  Collapse.prototype.getParent = function () {
    return $(this.options.parent)
      .find('[data-toggle="collapse"][data-parent="' + this.options.parent + '"]')
      .each($.proxy(function (i, element) {
        var $element = $(element)
        this.addAriaAndCollapsedClass(getTargetFromTrigger($element), $element)
      }, this))
      .end()
  }

  Collapse.prototype.addAriaAndCollapsedClass = function ($element, $trigger) {
    var isOpen = $element.hasClass('in')

    $element.attr('aria-expanded', isOpen)
    $trigger
      .toggleClass('collapsed', !isOpen)
      .attr('aria-expanded', isOpen)
  }

  function getTargetFromTrigger($trigger) {
    var href
    var target = $trigger.attr('data-target')
      || (href = $trigger.attr('href')) && href.replace(/.*(?=#[^\s]+$)/, '') // strip for ie7

    return $(target)
  }


  // COLLAPSE PLUGIN DEFINITION
  // ==========================

  function Plugin(option) {
    return this.each(function () {
      var $this   = $(this)
      var data    = $this.data('bs.collapse')
      var options = $.extend({}, Collapse.DEFAULTS, $this.data(), typeof option == 'object' && option)

      if (!data && options.toggle && /show|hide/.test(option)) options.toggle = false
      if (!data) $this.data('bs.collapse', (data = new Collapse(this, options)))
      if (typeof option == 'string') data[option]()
    })
  }

  var old = $.fn.collapse

  $.fn.collapse             = Plugin
  $.fn.collapse.Constructor = Collapse


  // COLLAPSE NO CONFLICT
  // ====================

  $.fn.collapse.noConflict = function () {
    $.fn.collapse = old
    return this
  }


  // COLLAPSE DATA-API
  // =================

  $(document).on('click.bs.collapse.data-api', '[data-toggle="collapse"]', function (e) {
    var $this   = $(this)

    if (!$this.attr('data-target')) e.preventDefault()

    var $target = getTargetFromTrigger($this)
    var data    = $target.data('bs.collapse')
    var option  = data ? 'toggle' : $this.data()

    Plugin.call($target, option)
  })

}(jQuery);

/* ========================================================================
 * Bootstrap: scrollspy.js v3.3.5
 * http://getbootstrap.com/javascript/#scrollspy
 * ========================================================================
 * Copyright 2011-2015 Twitter, Inc.
 * Licensed under MIT (https://github.com/twbs/bootstrap/blob/master/LICENSE)
 * ======================================================================== */


+function ($) {
  'use strict';

  // SCROLLSPY CLASS DEFINITION
  // ==========================

  function ScrollSpy(element, options) {
    this.$body          = $(document.body)
    this.$scrollElement = $(element).is(document.body) ? $(window) : $(element)
    this.options        = $.extend({}, ScrollSpy.DEFAULTS, options)
    this.selector       = (this.options.target || '') + ' .nav li > a'
    this.offsets        = []
    this.targets        = []
    this.activeTarget   = null
    this.scrollHeight   = 0

    this.$scrollElement.on('scroll.bs.scrollspy', $.proxy(this.process, this))
    this.refresh()
    this.process()
  }

  ScrollSpy.VERSION  = '3.3.5'

  ScrollSpy.DEFAULTS = {
    offset: 10
  }

  ScrollSpy.prototype.getScrollHeight = function () {
    return this.$scrollElement[0].scrollHeight || Math.max(this.$body[0].scrollHeight, document.documentElement.scrollHeight)
  }

  ScrollSpy.prototype.refresh = function () {
    var that          = this
    var offsetMethod  = 'offset'
    var offsetBase    = 0

    this.offsets      = []
    this.targets      = []
    this.scrollHeight = this.getScrollHeight()

    if (!$.isWindow(this.$scrollElement[0])) {
      offsetMethod = 'position'
      offsetBase   = this.$scrollElement.scrollTop()
    }

    this.$body
      .find(this.selector)
      .map(function () {
        var $el   = $(this)
        var href  = $el.data('target') || $el.attr('href')
        var $href = /^#./.test(href) && $(href)

        return ($href
          && $href.length
          && $href.is(':visible')
          && [[$href[offsetMethod]().top + offsetBase, href]]) || null
      })
      .sort(function (a, b) { return a[0] - b[0] })
      .each(function () {
        that.offsets.push(this[0])
        that.targets.push(this[1])
      })
  }

  ScrollSpy.prototype.process = function () {
    var scrollTop    = this.$scrollElement.scrollTop() + this.options.offset
    var scrollHeight = this.getScrollHeight()
    var maxScroll    = this.options.offset + scrollHeight - this.$scrollElement.height()
    var offsets      = this.offsets
    var targets      = this.targets
    var activeTarget = this.activeTarget
    var i

    if (this.scrollHeight != scrollHeight) {
      this.refresh()
    }

    if (scrollTop >= maxScroll) {
      return activeTarget != (i = targets[targets.length - 1]) && this.activate(i)
    }

    if (activeTarget && scrollTop < offsets[0]) {
      this.activeTarget = null
      return this.clear()
    }

    for (i = offsets.length; i--;) {
      activeTarget != targets[i]
        && scrollTop >= offsets[i]
        && (offsets[i + 1] === undefined || scrollTop < offsets[i + 1])
        && this.activate(targets[i])
    }
  }

  ScrollSpy.prototype.activate = function (target) {
    this.activeTarget = target

    this.clear()

    var selector = this.selector +
      '[data-target="' + target + '"],' +
      this.selector + '[href="' + target + '"]'

    var active = $(selector)
      .parents('li')
      .addClass('active')

    if (active.parent('.dropdown-menu').length) {
      active = active
        .closest('li.dropdown')
        .addClass('active')
    }

    active.trigger('activate.bs.scrollspy')
  }

  ScrollSpy.prototype.clear = function () {
    $(this.selector)
      .parentsUntil(this.options.target, '.active')
      .removeClass('active')
  }


  // SCROLLSPY PLUGIN DEFINITION
  // ===========================

  function Plugin(option) {
    return this.each(function () {
      var $this   = $(this)
      var data    = $this.data('bs.scrollspy')
      var options = typeof option == 'object' && option

      if (!data) $this.data('bs.scrollspy', (data = new ScrollSpy(this, options)))
      if (typeof option == 'string') data[option]()
    })
  }

  var old = $.fn.scrollspy

  $.fn.scrollspy             = Plugin
  $.fn.scrollspy.Constructor = ScrollSpy


  // SCROLLSPY NO CONFLICT
  // =====================

  $.fn.scrollspy.noConflict = function () {
    $.fn.scrollspy = old
    return this
  }


  // SCROLLSPY DATA-API
  // ==================

  $(window).on('load.bs.scrollspy.data-api', function () {
    $('[data-spy="scroll"]').each(function () {
      var $spy = $(this)
      Plugin.call($spy, $spy.data())
    })
  })

}(jQuery);

/* ========================================================================
 * Bootstrap: transition.js v3.3.5
 * http://getbootstrap.com/javascript/#transitions
 * ========================================================================
 * Copyright 2011-2015 Twitter, Inc.
 * Licensed under MIT (https://github.com/twbs/bootstrap/blob/master/LICENSE)
 * ======================================================================== */


+function ($) {
  'use strict';

  // CSS TRANSITION SUPPORT (Shoutout: http://www.modernizr.com/)
  // ============================================================

  function transitionEnd() {
    var el = document.createElement('bootstrap')

    var transEndEventNames = {
      WebkitTransition : 'webkitTransitionEnd',
      MozTransition    : 'transitionend',
      OTransition      : 'oTransitionEnd otransitionend',
      transition       : 'transitionend'
    }

    for (var name in transEndEventNames) {
      if (el.style[name] !== undefined) {
        return { end: transEndEventNames[name] }
      }
    }

    return false // explicit for ie8 (  ._.)
  }

  // http://blog.alexmaccaw.com/css-transitions
  $.fn.emulateTransitionEnd = function (duration) {
    var called = false
    var $el = this
    $(this).one('bsTransitionEnd', function () { called = true })
    var callback = function () { if (!called) $($el).trigger($.support.transition.end) }
    setTimeout(callback, duration)
    return this
  }

  $(function () {
    $.support.transition = transitionEnd()

    if (!$.support.transition) return

    $.event.special.bsTransitionEnd = {
      bindType: $.support.transition.end,
      delegateType: $.support.transition.end,
      handle: function (e) {
        if ($(e.target).is(this)) return e.handleObj.handler.apply(this, arguments)
      }
    }
  })

}(jQuery);

/*! WysiBB v1.5.1 2014-03-26 
    Author: Vadim Dobroskok
 */
"undefined"==typeof WBBLANG&&(WBBLANG={}),WBBLANG.en=CURLANG={bold:"Bold",italic:"Italic",underline:"Underline",strike:"Strike",link:"Link",img:"Insert image",sup:"Superscript",sub:"Subscript",justifyleft:"Align left",justifycenter:"Align center",justifyright:"Align right",table:"Insert table",bullist:"• Unordered list",numlist:"1. Ordered list",quote:"Quote",offtop:"Offtop",code:"Code",spoiler:"Spoiler",fontcolor:"Font color",fontsize:"Font size",fontfamily:"Font family",fs_verysmall:"Very small",fs_small:"Small",fs_normal:"Normal",fs_big:"Big",fs_verybig:"Very big",smilebox:"Insert emoticon",video:"Insert YouTube",removeFormat:"Remove Format",modal_link_title:"Insert link",modal_link_text:"Display text",modal_link_url:"URL",modal_email_text:"Display email",modal_email_url:"Email",modal_link_tab1:"Insert URL",modal_img_title:"Insert image",modal_img_tab1:"Insert URL",modal_img_tab2:"Upload image",modal_imgsrc_text:"Enter image URL",modal_img_btn:"Choose file",add_attach:"Add Attachment",modal_video_text:"Enter the URL of the video",close:"Close",save:"Save",cancel:"Cancel",remove:"Delete",validation_err:"The entered data is invalid",error_onupload:"Error during file upload",fileupload_text1:"Drop file here",fileupload_text2:"or",loading:"Loading",auto:"Auto",views:"Views",downloads:"Downloads",sm1:"Smile",sm2:"Laughter",sm3:"Wink",sm4:"Thank you",sm5:"Scold",sm6:"Shock",sm7:"Angry",sm8:"Pain",sm9:"Sick"},wbbdebug=!0,function(a){"use strict";a.wysibb=function(b,c){a(b).data("wbb",this),c&&c.deflang&&"undefined"!=typeof WBBLANG[c.deflang]&&(CURLANG=WBBLANG[c.deflang]),c&&c.lang&&"undefined"!=typeof WBBLANG[c.lang]&&(CURLANG=WBBLANG[c.lang]),this.txtArea=b,this.$txtArea=a(b);this.$txtArea.attr("id")||this.setUID(this.txtArea);this.options={bbmode:!1,onlyBBmode:!1,themeName:"default",bodyClass:"",lang:"ru",tabInsert:!0,imgupload:!1,img_uploadurl:"/iupload.php",img_maxwidth:800,img_maxheight:800,hotkeys:!0,showHotkeys:!0,autoresize:!0,resize_maxheight:800,loadPageStyles:!0,traceTextarea:!0,smileConversion:!0,buttons:"bold,italic,underline,strike,sup,sub,|,img,video,link,|,bullist,numlist,|,fontcolor,fontsize,fontfamily,|,justifyleft,justifycenter,justifyright,|,quote,code,table,removeFormat",allButtons:{bold:{title:CURLANG.bold,buttonHTML:'<span class="fonticon ve-tlb-bold1"></span>',excmd:"bold",hotkey:"ctrl+b",transform:{"<b>{SELTEXT}</b>":"[b]{SELTEXT}[/b]","<strong>{SELTEXT}</strong>":"[b]{SELTEXT}[/b]"}},italic:{title:CURLANG.italic,buttonHTML:'<span class="fonticon ve-tlb-italic1"></span>',excmd:"italic",hotkey:"ctrl+i",transform:{"<i>{SELTEXT}</i>":"[i]{SELTEXT}[/i]","<em>{SELTEXT}</em>":"[i]{SELTEXT}[/i]"}},underline:{title:CURLANG.underline,buttonHTML:'<span class="fonticon ve-tlb-underline1"></span>',excmd:"underline",hotkey:"ctrl+u",transform:{"<u>{SELTEXT}</u>":"[u]{SELTEXT}[/u]"}},strike:{title:CURLANG.strike,buttonHTML:'<span class="fonticon fi-stroke1 ve-tlb-strike1"></span>',excmd:"strikeThrough",transform:{"<strike>{SELTEXT}</strike>":"[s]{SELTEXT}[/s]","<s>{SELTEXT}</s>":"[s]{SELTEXT}[/s]"}},sup:{title:CURLANG.sup,buttonHTML:'<span class="fonticon ve-tlb-sup1"></span>',excmd:"superscript",transform:{"<sup>{SELTEXT}</sup>":"[sup]{SELTEXT}[/sup]"}},sub:{title:CURLANG.sub,buttonHTML:'<span class="fonticon ve-tlb-sub1"></span>',excmd:"subscript",transform:{"<sub>{SELTEXT}</sub>":"[sub]{SELTEXT}[/sub]"}},link:{title:CURLANG.link,buttonHTML:'<span class="fonticon ve-tlb-link1"></span>',hotkey:"ctrl+shift+2",modal:{title:CURLANG.modal_link_title,width:"500px",tabs:[{input:[{param:"SELTEXT",title:CURLANG.modal_link_text,type:"div"},{param:"URL",title:CURLANG.modal_link_url,validation:"^http(s)?://"}]}]},transform:{'<a href="{URL}">{SELTEXT}</a>':"[url={URL}]{SELTEXT}[/url]",'<a href="{URL}">{URL}</a>':"[url]{URL}[/url]"}},img:{title:CURLANG.img,buttonHTML:'<span class="fonticon ve-tlb-img1"></span>',hotkey:"ctrl+shift+1",addWrap:!0,modal:{title:CURLANG.modal_img_title,width:"600px",tabs:[{title:CURLANG.modal_img_tab1,input:[{param:"SRC",title:CURLANG.modal_imgsrc_text,validation:"^http(s)?://.*?.(jpg|png|gif|jpeg)$"}]}],onLoad:this.imgLoadModal},transform:{'<img src="{SRC}" />':"[img]{SRC}[/img]",'<img src="{SRC}" width="{WIDTH}" height="{HEIGHT}"/>':"[img width={WIDTH},height={HEIGHT}]{SRC}[/img]"}},bullist:{title:CURLANG.bullist,buttonHTML:'<span class="fonticon ve-tlb-list1"></span>',excmd:"insertUnorderedList",transform:{"<ul>{SELTEXT}</ul>":"[list]{SELTEXT}[/list]","<li>{SELTEXT}</li>":"[*]{SELTEXT}[/*]"}},numlist:{title:CURLANG.numlist,buttonHTML:'<span class="fonticon ve-tlb-numlist1"></span>',excmd:"insertOrderedList",transform:{"<ol>{SELTEXT}</ol>":"[list=1]{SELTEXT}[/list]","<li>{SELTEXT}</li>":"[*]{SELTEXT}[/*]"}},quote:{title:CURLANG.quote,buttonHTML:'<span class="fonticon ve-tlb-quote1"></span>',hotkey:"ctrl+shift+3",transform:{"<blockquote>{SELTEXT}</blockquote>":"[quote]{SELTEXT}[/quote]"}},code:{title:CURLANG.code,buttonText:"[code]",hotkey:"ctrl+shift+4",onlyClearText:!0,transform:{"<code>{SELTEXT}</code>":"[code]{SELTEXT}[/code]"}},offtop:{title:CURLANG.offtop,buttonText:"offtop",transform:{'<span style="font-size:10px;color:#ccc">{SELTEXT}</span>':"[offtop]{SELTEXT}[/offtop]"}},fontcolor:{type:"colorpicker",title:CURLANG.fontcolor,excmd:"foreColor",valueBBname:"color",subInsert:!0,colors:"#000000,#444444,#666666,#999999,#b6b6b6,#cccccc,#d8d8d8,#efefef,#f4f4f4,#ffffff,-, 							 #ff0000,#980000,#ff7700,#ffff00,#00ff00,#00ffff,#1e84cc,#0000ff,#9900ff,#ff00ff,-, 							 #f4cccc,#dbb0a7,#fce5cd,#fff2cc,#d9ead3,#d0e0e3,#c9daf8,#cfe2f3,#d9d2e9,#ead1dc, 							 #ea9999,#dd7e6b,#f9cb9c,#ffe599,#b6d7a8,#a2c4c9,#a4c2f4,#9fc5e8,#b4a7d6,#d5a6bd, 							 #e06666,#cc4125,#f6b26b,#ffd966,#93c47d,#76a5af,#6d9eeb,#6fa8dc,#8e7cc3,#c27ba0, 							 #cc0000,#a61c00,#e69138,#f1c232,#6aa84f,#45818e,#3c78d8,#3d85c6,#674ea7,#a64d79, 							 #900000,#85200C,#B45F06,#BF9000,#38761D,#134F5C,#1155Cc,#0B5394,#351C75,#741B47, 							 #660000,#5B0F00,#783F04,#7F6000,#274E13,#0C343D,#1C4587,#073763,#20124D,#4C1130",transform:{'<font color="{COLOR}">{SELTEXT}</font>':"[color={COLOR}]{SELTEXT}[/color]"}},table:{type:"table",title:CURLANG.table,cols:10,rows:10,cellwidth:20,transform:{"<td>{SELTEXT}</td>":"[td]{SELTEXT}[/td]","<tr>{SELTEXT}</tr>":"[tr]{SELTEXT}[/tr]",'<table class="wbb-table">{SELTEXT}</table>':"[table]{SELTEXT}[/table]"},skipRules:!0},fontsize:{type:"select",title:CURLANG.fontsize,options:"fs_verysmall,fs_small,fs_normal,fs_big,fs_verybig"},fontfamily:{type:"select",title:CURLANG.fontfamily,excmd:"fontName",valueBBname:"font",options:[{title:"Arial",exvalue:"Arial"},{title:"Comic Sans MS",exvalue:"Comic Sans MS"},{title:"Courier New",exvalue:"Courier New"},{title:"Georgia",exvalue:"Georgia"},{title:"Lucida Sans Unicode",exvalue:"Lucida Sans Unicode"},{title:"Tahoma",exvalue:"Tahoma"},{title:"Times New Roman",exvalue:"Times New Roman"},{title:"Trebuchet MS",exvalue:"Trebuchet MS"},{title:"Verdana",exvalue:"Verdana"}],transform:{'<font face="{FONT}">{SELTEXT}</font>':"[font={FONT}]{SELTEXT}[/font]"}},smilebox:{type:"smilebox",title:CURLANG.smilebox,buttonHTML:'<span class="fonticon ve-tlb-smilebox1"></span>'},justifyleft:{title:CURLANG.justifyleft,buttonHTML:'<span class="fonticon ve-tlb-textleft1"></span>',groupkey:"align",transform:{'<p style="text-align:left">{SELTEXT}</p>':"[left]{SELTEXT}[/left]"}},justifyright:{title:CURLANG.justifyright,buttonHTML:'<span class="fonticon ve-tlb-textright1"></span>',groupkey:"align",transform:{'<p style="text-align:right">{SELTEXT}</p>':"[right]{SELTEXT}[/right]"}},justifycenter:{title:CURLANG.justifycenter,buttonHTML:'<span class="fonticon ve-tlb-textcenter1"></span>',groupkey:"align",transform:{'<p style="text-align:center">{SELTEXT}</p>':"[center]{SELTEXT}[/center]"}},video:{title:CURLANG.video,buttonHTML:'<span class="fonticon ve-tlb-video1"></span>',modal:{title:CURLANG.video,width:"600px",tabs:[{title:CURLANG.video,input:[{param:"SRC",title:CURLANG.modal_video_text}]}],onSubmit:function(a){var b=this.$modal.find('input[name="SRC"]').val();b&&(b=b.replace(/^\s+/,"").replace(/\s+$/,""));var c;if(c=b.match(-1!=b.indexOf("youtu.be")?/^http[s]*:\/\/youtu\.be\/([a-z0-9_-]+)/i:/^http[s]*:\/\/www\.youtube\.com\/watch\?.*?v=([a-z0-9_-]+)/i),c&&2==c.length){var d=c[1];this.insertAtCursor(this.getCodeByCommand(a,{src:d}))}return this.closeModal(),this.updateUI(),!1}},transform:{'<iframe src="http://www.youtube.com/embed/{SRC}" width="640" height="480" frameborder="0"></iframe>':"[video]{SRC}[/video]"}},fs_verysmall:{title:CURLANG.fs_verysmall,buttonText:"fs1",excmd:"fontSize",exvalue:"1",transform:{'<font size="1">{SELTEXT}</font>':"[size=50]{SELTEXT}[/size]"}},fs_small:{title:CURLANG.fs_small,buttonText:"fs2",excmd:"fontSize",exvalue:"2",transform:{'<font size="2">{SELTEXT}</font>':"[size=85]{SELTEXT}[/size]"}},fs_normal:{title:CURLANG.fs_normal,buttonText:"fs3",excmd:"fontSize",exvalue:"3",transform:{'<font size="3">{SELTEXT}</font>':"[size=100]{SELTEXT}[/size]"}},fs_big:{title:CURLANG.fs_big,buttonText:"fs4",excmd:"fontSize",exvalue:"4",transform:{'<font size="4">{SELTEXT}</font>':"[size=150]{SELTEXT}[/size]"}},fs_verybig:{title:CURLANG.fs_verybig,buttonText:"fs5",excmd:"fontSize",exvalue:"6",transform:{'<font size="6">{SELTEXT}</font>':"[size=200]{SELTEXT}[/size]"}},removeformat:{title:CURLANG.removeFormat,buttonHTML:'<span class="fonticon ve-tlb-removeformat1"></span>',excmd:"removeFormat"}},systr:{"<br/>":"\n",'<span class="wbbtab">{SELTEXT}</span>':"   {SELTEXT}"},customRules:{td:[["[td]{SELTEXT}[/td]",{seltext:{rgx:!1,attr:!1,sel:!1}}]],tr:[["[tr]{SELTEXT}[/tr]",{seltext:{rgx:!1,attr:!1,sel:!1}}]],table:[["[table]{SELTEXT}[/table]",{seltext:{rgx:!1,attr:!1,sel:!1}}]]},smileList:[],attrWrap:["src","color","href"]},this.inited=this.options.onlyBBmode,this.options.themePrefix||a("link").each(a.proxy(function(b,c){var d=a(c).get(0).href.match(/(.*\/)(.*)\/wbbtheme\.css.*$/);null!==d&&(this.options.themeName=d[2],this.options.themePrefix=d[1])},this)),"undefined"!=typeof WBBPRESET&&(WBBPRESET.allButtons&&a.each(WBBPRESET.allButtons,a.proxy(function(a,b){b.transform&&this.options.allButtons[a]&&delete this.options.allButtons[a].transform},this)),a.extend(!0,this.options,WBBPRESET)),c&&c.allButtons&&a.each(c.allButtons,a.proxy(function(a,b){b.transform&&this.options.allButtons[a]&&delete this.options.allButtons[a].transform},this)),a.extend(!0,this.options,c),this.init()},a.wysibb.prototype={lastid:1,init:function(){a.log("Init",this),this.isMobile=function(a){/android|avantgo|bada\/|blackberry|blazer|compal|elaine|fennec|hiptop|iemobile|ip(hone|od)|iris|kindle|lge |maemo|meego.+mobile|midp|mmp|netfront|opera m(ob|in)i|palm( os)?|phone|p(ixi|re)\/|plucker|pocket|psp|series(4|6)0|symbian|treo|up\.(browser|link)|vodafone|wap|windows (ce|phone)|xda|xiino/i.test(a)}(navigator.userAgent||navigator.vendor||window.opera),this.options.onlyBBmode===!0&&(this.options.bbmode=!0),this.controllers=[],this.options.buttons=this.options.buttons.toLowerCase(),this.options.buttons=this.options.buttons.split(","),this.options.allButtons._systr={},this.options.allButtons._systr.transform=this.options.systr,this.smileFind(),this.initTransforms(),this.build(),this.initModal(),this.options.hotkeys!==!0||this.isMobile||this.initHotkeys(),this.options.smileList&&this.options.smileList.length>0&&this.options.smileList.sort(function(a,b){return b.bbcode.length-a.bbcode.length}),this.$txtArea.parents("form").bind("submit",a.proxy(function(){return this.sync(),!0},this)),this.$txtArea.parents("form").find("input[id*='preview'],input[id*='submit'],input[class*='preview'],input[class*='submit'],input[name*='preview'],input[name*='submit']").bind("mousedown",a.proxy(function(){this.sync(),setTimeout(a.proxy(function(){this.options.bbmode===!1&&this.$txtArea.removeAttr("wbbsync").val("")},this),1e3)},this)),this.options.initCallback&&this.options.initCallback.call(this),a.log(this)},initTransforms:function(){a.log("Create rules for transform HTML=>BB");var b=this.options;b.rules||(b.rules={}),b.groups||(b.groups={});var c=b.buttons.slice();c.push("_systr");for(var d=0;d<c.length;d++){var e=b.allButtons[c[d]];if(e){if(e.en=!0,e.simplebbcode&&a.isArray(e.simplebbcode)&&2==e.simplebbcode.length&&(e.bbcode=e.html=e.simplebbcode[0]+"{SELTEXT}"+e.simplebbcode[1],e.transform&&delete e.transform,e.modal&&delete e.modal),"select"==e.type&&"string"==typeof e.options){var f=e.options.split(",");a.each(f,function(b,d){-1==a.inArray(d,c)&&c.push(d)})}if(e.transform&&e.skipRules!==!0){var g=a.extend({},e.transform);for(var h in g){var i=h,j=g[h];if(e.bbSelector||(e.bbSelector=[]),-1==a.inArray(j,e.bbSelector)&&e.bbSelector.push(j),this.options.onlyBBmode===!1){h=this.wrapAttrs(h);var k=a(document.createElement("DIV")).append(a(this.elFromString(h,document))),l=this.filterByNode(k.children());if("div"==l||"undefined"!=typeof b.rules[l]){a.log("create unique selector: "+l),this.setUID(k.children()),l=this.filterByNode(k.children()),a.log("New rootSelector: "+l);var m=k.html();m=this.unwrapAttrs(m);var n=this.unwrapAttrs(h);e.transform[m]=j,delete e.transform[n],h=m,i=m}e.excmd||(e.rootSelector||(e.rootSelector=[]),e.rootSelector.push(l)),"undefined"==typeof b.rules[l]&&(b.rules[l]=[]);var o={};if(h.match(/\{\S+?\}/)){k.find("*").each(a.proxy(function(b,c){var d=this.getAttributeList(c);a.each(d,a.proxy(function(b,d){var e=a(c).attr(d);"_"==d.substr(0,1)&&(d=d.substr(1));var f=e.match(/\{\S+?\}/g);if(f)for(var g=0;g<f.length;g++){var h=f[g].substr(1,f[g].length-2);h=h.replace(this.getValidationRGX(h),"");var i=this.relFilterByNode(c,l),j=e!=f[g]?this.getRegexpReplace(e,f[g]):!1;o[h.toLowerCase()]={sel:i?a.trim(i):!1,attr:d,rgx:j}}},this));var e=[];a(c).is("iframe")||a(c).contents().filter(function(){return 3===this.nodeType}).each(a.proxy(function(b,d){var f=d.textContent||d.data;if("undefined"==typeof f)return!0;var g=f.match(/\{\S+?\}/g);if(g)for(var h=0;h<g.length;h++){var i=g[h].substr(1,g[h].length-2);i=i.replace(this.getValidationRGX(i),"");var j=this.relFilterByNode(c,l),k=f!=g[h]?this.getRegexpReplace(f,g[h]):!1,m=j?a.trim(j):!1;if(a.inArray(m,e)>-1||a(d).parent().contents().size()>1){var n=a("<span>").html("{"+i+"}");this.setUID(n,"wbb");var p=f.indexOf(i)+i.length+1,q=f.substr(p,f.length-p);d.data=f.substr(0,f.indexOf(i)-1),a(d).after(this.elFromString(q,document)).after(n),m=(m?m+" ":"")+this.filterByNode(n),k=!1}o[i.toLowerCase()]={sel:m,attr:!1,rgx:k},e[e.length]=m}},this)),e=null},this));var p=k.html();p=this.unwrapAttrs(p),i!=p&&(delete e.transform[i],e.transform[p]=j,h=p)}b.rules[l].push([j,o]),e.onlyClearText===!0&&(this.cleartext||(this.cleartext={}),this.cleartext[l]=c[d]),e.groupkey&&(b.groups[e.groupkey]||(b.groups[e.groupkey]=[]),b.groups[e.groupkey].push(l))}}e.rootSelector&&this.sortArray(e.rootSelector,-1);var q=a.map(e.transform,function(a,b){return b}).sort(function(a,b){return(b[0]||"").length-(a[0]||"").length});e.bbcode=e.transform[q[0]],e.html=q[0]}}}this.options.btnlist=c,a.extend(b.rules,this.options.customRules),b.srules={},this.options.smileList&&a.each(b.smileList,a.proxy(function(c,d){var e=a(this.strf(d.img,b)),f=this.filterByNode(e);b.srules[f]=[d.bbcode,d.img]},this));for(var r in b.rules)this.options.rules[r].sort(function(a,b){return b[0].length-a[0].length});this.rsellist=[];for(var r in this.options.rules)this.rsellist.push(r);this.sortArray(this.rsellist,-1)},build:function(){if(a.log("Build editor"),this.$editor=a("<div>").addClass("wysibb"),this.isMobile&&this.$editor.addClass("wysibb-mobile"),this.options.direction&&this.$editor.css("direction",this.options.direction),this.$editor.insertAfter(this.txtArea).append(this.txtArea),this.startHeight=this.$txtArea.outerHeight(),this.$txtArea.addClass("wysibb-texarea"),this.buildToolbar(),this.$txtArea.wrap('<div class="wysibb-text">'),this.options.onlyBBmode===!1){var b=this.options.minheight||this.$txtArea.outerHeight(),c=(this.options.resize_maxheight,this.options.autoresize===!0?this.options.resize_maxheight:b);if(this.$body=a(this.strf('<div class="wysibb-text-editor" style="max-height:{maxheight}px;min-height:{height}px"></div>',{maxheight:c,height:b})).insertAfter(this.$txtArea),this.body=this.$body[0],this.$txtArea.hide(),b>32&&this.$toolbar.css("max-height",b),a.log("WysiBB loaded"),this.$body.addClass("wysibb-body").addClass(this.options.bodyClass),this.options.direction&&this.$body.css("direction",this.options.direction),"contentEditable"in this.body){this.body.contentEditable=!0;try{document.execCommand("StyleWithCSS",!1,!1),this.$body.append("<span></span>")}catch(d){}}else this.options.onlyBBmode=this.options.bbmode=!0;this.txtArea.value.length>0&&this.txtAreaInitContent(),this.$body.bind("keydown",a.proxy(function(b){return 86==b.which&&(1==b.ctrlKey||1==b.metaKey)||45==b.which&&(1==b.shiftKey||1==b.metaKey)?(this.$pasteBlock||(this.saveRange(),this.$pasteBlock=a(this.elFromString('<div style="opacity:0;" contenteditable="true">﻿</div>')),this.$pasteBlock.appendTo(this.body),setTimeout(a.proxy(function(){this.clearPaste(this.$pasteBlock);var b="<span>"+this.$pasteBlock.html()+"</span>";this.$body.attr("contentEditable","true"),this.$pasteBlock.blur().remove(),this.body.focus(),this.cleartext&&(a.log("Check if paste to clearText Block"),this.isInClearTextBlock()&&(b=this.toBB(b).replace(/\n/g,"<br/>").replace(/\s{3}/g,'<span class="wbbtab"></span>'))),b=b.replace(/\t/g,'<span class="wbbtab"></span>'),this.selectRange(this.lastRange),this.insertAtCursor(b,!1),this.lastRange=!1,this.$pasteBlock=!1},this),1),this.selectNode(this.$pasteBlock[0])),!0):void 0},this)),this.$body.bind("keydown",a.proxy(function(a){if(13==a.which){var b=this.isContain(this.getSelectNode(),"li");b||(a.preventDefault&&a.preventDefault(),this.checkForLastBR(this.getSelectNode()),this.insertAtCursor("<br/>",!1))}},this)),this.options.tabInsert===!0&&this.$body.bind("keydown",a.proxy(this.pressTab,this)),this.$body.bind("mouseup keyup",a.proxy(this.updateUI,this)),this.$body.bind("mousedown",a.proxy(function(a){this.clearLastRange(),this.checkForLastBR(a.target)},this)),this.options.traceTextarea===!0&&(a(document).bind("mousedown",a.proxy(this.traceTextareaEvent,this)),this.$txtArea.val("")),this.options.hotkeys===!0&&this.$body.bind("keydown",a.proxy(this.presskey,this)),this.options.smileConversion===!0&&this.$body.bind("keyup",a.proxy(this.smileConversion,this)),this.inited=!0,this.options.autoresize===!0&&(this.$bresize=a(this.elFromString('<div class="bottom-resize-line"></div>')).appendTo(this.$editor).wdrag({scope:this,axisY:!0,height:b})),this.imgListeners()}this.$txtArea.bind("mouseup keyup",a.proxy(function(){clearTimeout(this.uitimer),this.uitimer=setTimeout(a.proxy(this.updateUI,this),100)},this)),this.options.hotkeys===!0&&a(document).bind("keydown",a.proxy(this.presskey,this))},buildToolbar:function(){if(this.options.toolbar===!1)return!1;this.$toolbar=a("<div>").addClass("wysibb-toolbar").prependTo(this.$editor);var b;a.each(this.options.buttons,a.proxy(function(c,d){var e=this.options.allButtons[d];(0==c||"|"==d||"-"==d)&&("-"==d&&this.$toolbar.append("<div>"),b=a('<div class="wysibb-toolbar-container">').appendTo(this.$toolbar)),e&&("colorpicker"==e.type?this.buildColorpicker(b,d,e):"table"==e.type?this.buildTablepicker(b,d,e):"select"==e.type?this.buildSelect(b,d,e):"smilebox"==e.type?this.buildSmilebox(b,d,e):this.buildButton(b,d,e))},this)),this.$toolbar.find(".btn-tooltip").hover(function(){a(this).parent().css("overflow","hidden")},function(){a(this).parent().css("overflow","visible")});var c=a(document.createElement("div")).addClass("wysibb-toolbar-container modeSwitch").html('<div class="wysibb-toolbar-btn mswitch" unselectable="on"><span class="btn-inner modesw" unselectable="on">[bbcode]</span></div>').appendTo(this.$toolbar);1==this.options.bbmode&&c.children(".wysibb-toolbar-btn").addClass("on"),this.options.onlyBBmode===!1&&c.children(".wysibb-toolbar-btn").click(a.proxy(function(b){a(b.currentTarget).toggleClass("on"),this.modeSwitch()},this))},buildButton:function(b,c,d){"object"!=typeof b&&(b=this.$toolbar);var e=d.buttonHTML?a(this.strf(d.buttonHTML,this.options)).addClass("btn-inner"):this.strf('<span class="btn-inner btn-text">{text}</span>',{text:d.buttonText.replace(/</g,"&lt;")}),f=this.options.hotkeys===!0&&this.options.showHotkeys===!0&&d.hotkey?' <span class="tthotkey">['+d.hotkey+"]</span>":"",g=a('<div class="wysibb-toolbar-btn wbb-'+c+'">').appendTo(b).append(e).append(this.strf('<span class="btn-tooltip">{title}<ins/>{hotkey}</span>',{title:d.title,hotkey:f}));this.controllers.push(g),g.bind("queryState",a.proxy(function(b){this.queryState(c)?a(b.currentTarget).addClass("on"):a(b.currentTarget).removeClass("on")},this)),g.mousedown(a.proxy(function(b){b.preventDefault(),this.execCommand(c,d.exvalue||!1),a(b.currentTarget).trigger("queryState")},this))},buildColorpicker:function(b,c,d){var e=a('<div class="wysibb-toolbar-btn wbb-dropdown wbb-cp">').appendTo(b).append('<div class="ve-tlb-colorpick"><span class="fonticon"></span><span class="cp-line"></span></div><ins class="fonticon ar"></ins>').append(this.strf('<span class="btn-tooltip">{title}<ins/></span>',{title:d.title})),f=e.find(".cp-line"),g=a('<div class="wbb-list">').appendTo(e);g.append('<div class="nc">'+CURLANG.auto+"</div>");for(var h=d.colors?d.colors.split(","):[],i=0;i<h.length;i++)h[i]=a.trim(h[i]),g.append("-"==h[i]?'<span class="pl"></span>':this.strf('<div class="sc" style="background:{color}" title="{color}"></div>',{color:h[i]}));var j=a(document.body).css("color");this.controllers.push(e),e.bind("queryState",a.proxy(function(){f.css("background-color",j);var a=this.queryState(c,!0);a&&(f.css("background-color",this.options.bbmode?a.color:a),e.find(".ve-tlb-colorpick span.fonticon").css("color",this.options.bbmode?a.color:a))},this)),e.mousedown(a.proxy(function(a){a.preventDefault(),this.dropdownclick(".wbb-cp",".wbb-list",a)},this)),e.find(".sc").mousedown(a.proxy(function(b){b.preventDefault(),this.selectLastRange();var d=a(b.currentTarget).attr("title");this.execCommand(c,d),e.trigger("queryState")},this)),e.find(".nc").mousedown(a.proxy(function(a){a.preventDefault(),this.selectLastRange(),this.execCommand(c,j),e.trigger("queryState")},this)),e.mousedown(function(a){a.preventDefault&&a.preventDefault()})},buildTablepicker:function(b,c,d){var e=a('<div class="wysibb-toolbar-btn wbb-dropdown wbb-tbl">').appendTo(b).append('<span class="btn-inner fonticon ve-tlb-table1"></span><ins class="fonticon ar"></ins>').append(this.strf('<span class="btn-tooltip">{title}<ins/></span>',{title:d.title})),f=a('<div class="wbb-list">').appendTo(e),g=a("<div>").css({position:"relative","box-sizing":"border-box"}).appendTo(f),h=d.rows||10,i=d.cols||10,j=h*i;g.css("height",h*d.cellwidth+2+"px");for(var k=1;i>=k;k++)for(var l=1;h>=l;l++){var m='<div class="tbl-sel" style="width:'+100*k/i+"%;height:"+100*l/h+"%;z-index:"+--j+'" title="'+l+","+k+'"></div>';g.append(m)}e.find(".tbl-sel").mousedown(a.proxy(function(b){b.preventDefault();for(var c=a(b.currentTarget).attr("title"),d=c.split(","),e=this.options.bbmode?"[table]":'<table class="wbb-table" cellspacing="5" cellpadding="0">',f=1;f<=d[0];f++){e+=this.options.bbmode?" [tr]\n":"<tr>";for(var g=1;g<=d[1];g++)e+=this.options.bbmode?"  [td][/td]\n":"<td>﻿</td>";e+=this.options.bbmode?"[/tr]\n":"</tr>"}e+=this.options.bbmode?"[/table]":"</table>",this.insertAtCursor(e)},this)),e.mousedown(a.proxy(function(a){a.preventDefault(),this.dropdownclick(".wbb-tbl",".wbb-list",a)},this))},buildSelect:function(b,c,d){for(var e=a('<div class="wysibb-toolbar-btn wbb-select wbb-'+c+'">').appendTo(b).append(this.strf('<span class="val">{title}</span><ins class="fonticon sar"></ins>',d)).append(this.strf('<span class="btn-tooltip">{title}<ins/></span>',{title:d.title})),f=a('<div class="wbb-list">').appendTo(e),g=e.find("span.val"),h=a.isArray(d.options)?d.options:d.options.split(","),i=this.isMobile?a("<select>").addClass("wbb-selectbox"):"",j=0;j<h.length;j++){var k=h[j];if("string"==typeof k){var l=this.options.allButtons[k];l&&(l.html?a("<span>").addClass("option").attr("oid",k).attr("cmdvalue",l.exvalue).appendTo(f).append(this.strf(l.html,{seltext:l.title})):f.append(this.strf('<span class="option" oid="'+k+'" cmdvalue="'+l.exvalue+'">{title}</span>',l)),this.isMobile&&i.append(a("<option>").attr("oid",k).attr("cmdvalue",l.exvalue).append(l.title)))}else{var m={seltext:k.title};m[d.valueBBname]=k.exvalue,a("<span>").addClass("option").attr("oid",c).attr("cmdvalue",k.exvalue).appendTo(f).append(this.strf(d.html,m)),this.isMobile&&i.append(a("<option>").attr("oid",c).attr("cmdvalue",k.exvalue).append(k.exvalue))}}this.isMobile&&(i.appendTo(b),this.controllers.push(i),i.bind("queryState",a.proxy(function(){i.find("option").each(a.proxy(function(b,c){var d=a(c),e=this.queryState(d.attr("oid"),!0),f=d.attr("cmdvalue");return f&&e==d.attr("cmdvalue")||!f&&e?(d.prop("selected",!0),!1):void 0},this))},this)),i.change(a.proxy(function(b){b.preventDefault();var c=a(b.currentTarget).find(":selected"),d=c.attr("oid"),e=c.attr("cmdvalue"),f=this.options.allButtons[d];this.execCommand(d,f.exvalue||e||!1),a(b.currentTarget).trigger("queryState")},this))),this.controllers.push(e),e.bind("queryState",a.proxy(function(){g.text(d.title),e.find(".option.selected").removeClass("selected"),e.find(".option").each(a.proxy(function(b,c){var d=a(c),e=this.queryState(d.attr("oid"),!0),f=d.attr("cmdvalue");return f&&e==d.attr("cmdvalue")||!f&&e?(g.text(d.text()),d.addClass("selected"),!1):void 0},this))},this)),e.mousedown(a.proxy(function(a){a.preventDefault(),this.dropdownclick(".wbb-select",".wbb-list",a)},this)),e.find(".option").mousedown(a.proxy(function(b){b.preventDefault();var c=a(b.currentTarget).attr("oid"),d=a(b.currentTarget).attr("cmdvalue"),e=this.options.allButtons[c];this.execCommand(c,e.exvalue||d||!1),a(b.currentTarget).trigger("queryState")},this))},buildSmilebox:function(b,c,d){if(this.options.smileList&&this.options.smileList.length>0){var e=a(this.strf(d.buttonHTML,d)).addClass("btn-inner"),f=a('<div class="wysibb-toolbar-btn wbb-smilebox wbb-'+c+'">').appendTo(b).append(e).append(this.strf('<span class="btn-tooltip">{title}<ins/></span>',{title:d.title})),g=a('<div class="wbb-list">').appendTo(f);a.isArray(this.options.smileList)&&a.each(this.options.smileList,a.proxy(function(b,c){a("<span>").addClass("smile").appendTo(g).append(a(this.strf(c.img,this.options)).attr("title",c.title))},this)),f.mousedown(a.proxy(function(a){a.preventDefault(),this.dropdownclick(".wbb-smilebox",".wbb-list",a)},this)),f.find(".smile").mousedown(a.proxy(function(b){b.preventDefault(),this.insertAtCursor(this.options.bbmode?this.toBB(a(b.currentTarget).html()):a(a(b.currentTarget).html()))},this))}},updateUI:function(b){(!b||b.which>=8&&b.which<=46||b.which>90||"mouseup"==b.type)&&a.each(this.controllers,a.proxy(function(a,b){b.trigger("queryState")},this)),this.disNonActiveButtons()},initModal:function(){this.$modal=a("#wbbmodal"),0==this.$modal.size()&&(a.log("Init modal"),this.$modal=a("<div>").attr("id","wbbmodal").prependTo(document.body).html('<div class="wbbm"><div class="wbbm-title"><span class="wbbm-title-text"></span><span class="wbbclose" title="'+CURLANG.close+'">×</span></div><div class="wbbm-content"></div><div class="wbbm-bottom"><button id="wbbm-submit" class="wbb-button">'+CURLANG.save+'</button><button id="wbbm-cancel" class="wbb-cancel-button">'+CURLANG.cancel+'</button><button id="wbbm-remove" class="wbb-remove-button">'+CURLANG.remove+"</button></div></div>").hide(),this.$modal.find("#wbbm-cancel,.wbbclose").click(a.proxy(this.closeModal,this)),this.$modal.bind("click",a.proxy(function(b){0==a(b.target).parents(".wbbm").size()&&this.closeModal()},this)),a(document).bind("keydown",a.proxy(this.escModal,this)))},initHotkeys:function(){a.log("initHotkeys"),this.hotkeys=[];var b="0123456789       abcdefghijklmnopqrstuvwxyz";a.each(this.options.allButtons,a.proxy(function(c,d){if(d.hotkey){var e=d.hotkey.split("+");if(e&&e.length>=2){var f=0,g=e.pop();a.each(e,function(b,c){switch(a.trim(c.toLowerCase())){case"ctrl":f+=1;break;case"shift":f+=4;break;case"alt":f+=7}}),f>0&&(this.hotkeys["m"+f]||(this.hotkeys["m"+f]=[]),this.hotkeys["m"+f]["k"+(b.indexOf(g)+48)]=c)}}},this))},presskey:function(a){if(1==a.ctrlKey||1==a.shiftKey||1==a.altKey){var b=(1==a.ctrlKey?1:0)+(1==a.shiftKey?4:0)+(1==a.altKey?7:0);if(this.hotkeys["m"+b]&&this.hotkeys["m"+b]["k"+a.which])return this.execCommand(this.hotkeys["m"+b]["k"+a.which],!1),a.preventDefault(),!1}},execCommand:function(b,c){a.log("execCommand: "+b);var d=this.options.allButtons[b];if(d.en!==!0)return!1;var e=this.queryState(b,c),f=this.isInClearTextBlock();if(!f||f==b){if(d.excmd)if(this.options.bbmode)if(a.log("Native command in bbmode: "+b),e&&1!=d.subInsert)this.wbbRemoveCallback(b,c);else{var g={};d.valueBBname&&c&&(g[d.valueBBname]=c),this.insertAtCursor(this.getBBCodeByCommand(b,g))}else this.execNativeCommand(d.excmd,c||!1);else d.cmd?d.cmd.call(this,b,c,e):this.wbbExecCommand.call(this,b,c,e);this.updateUI()}},queryState:function(b,c){var d=this.options.allButtons[b];if(d.en!==!0)return!1;if(this.options.bbmode){if(d.bbSelector)for(var e=0;e<d.bbSelector.length;e++){var f=this.isBBContain(d.bbSelector[e]);if(f)return this.getParams(f,d.bbSelector[e],f[1])}return!1}if(!d.excmd){if(a.isArray(d.rootSelector))for(var e=0;e<d.rootSelector.length;e++){var g=this.isContain(this.getSelectNode(),d.rootSelector[e]);if(g)return this.getParams(g,d.rootSelector[e])}return!1}if(c)try{var h=(document.queryCommandValue(d.excmd)+"").replace(/\'/g,"");return"foreColor"==d.excmd&&(h=this.rgbToHex(h)),h}catch(i){return!1}else try{return"bold"!=d.excmd&&"italic"!=d.excmd&&"underline"!=d.excmd&&"strikeThrough"!=d.excmd||!a(this.getSelectNode()).is("img")?"underline"==d.excmd&&a(this.getSelectNode()).closest("a").size()>0?!1:document.queryCommandState(d.excmd):!1}catch(i){return!1}},wbbExecCommand:function(b,c,d){a.log("wbbExecCommand");var e=this.options.allButtons[b];if(e)if(e.modal)a.isFunction(e.modal)?e.modal.call(this,b,e.modal,d):this.showModal.call(this,b,e.modal,d);else if(d&&1!=e.subInsert)this.wbbRemoveCallback(b);else{if(e.groupkey){var f=this.options.groups[e.groupkey];if(f){var g=this.getSelectNode();a.each(f,a.proxy(function(b,c){var d=this.isContain(g,c);if(d){var e=a("<span>").html(d.innerHTML),f=this.setUID(e);return a(d).replaceWith(e),this.selectNode(this.$editor.find("#"+f)[0]),!1}},this))}}this.wbbInsertCallback(b,c)}},wbbInsertCallback:function(b,c){"object"!=typeof c&&(c={}),a.log("wbbInsertCallback: "+b);var d=this.getCodeByCommand(b,c);if(this.insertAtCursor(d),this.seltextID&&-1!=d.indexOf(this.seltextID)){var e=this.$body.find("#"+this.seltextID)[0];this.selectNode(e),a(e).removeAttr("id"),this.seltextID=!1}},wbbRemoveCallback:function(b,c){a.log("wbbRemoveCallback: "+b);var d=this.options.allButtons[b];if(this.options.bbmode){var e=(this.getCursorPosBB(),0);a.each(d.bbSelector,a.proxy(function(b,d){var f=d.match(/\{[\s\S]+?\}/g);a.each(f,function(a,b){return"{seltext}"==b.toLowerCase()?(e=a,!1):void 0});var g=this.isBBContain(d);return g?(this.txtArea.value=this.txtArea.value.substr(0,g[1])+this.txtArea.value.substr(g[1],this.txtArea.value.length-g[1]).replace(g[0][0],c===!0?"":g[0][e+1]),this.setCursorPosBB(g[1]),!1):void 0},this))}else{var f=this.getSelectNode();a.each(d.rootSelector,a.proxy(function(e,g){var h=this.isContain(f,g);if(!h)return!0;var i=a(h),j=this.options.rules[g][0][1];if(i.is("span[wbb]")||!i.is("span,font")){if(c!==!0&&j&&j.seltext)if(j&&j.seltext&&j.seltext.sel){var k=i.find(j.seltext.sel).html();d.onlyClearText===!0&&(k=this.getHTML(k,!0,!0),k=k.replace(/\&#123;/g,"{").replace(/\&#125;/g,"}")),i.replaceWith(k)}else{var k=i.html();d.onlyClearText===!0&&(k=this.getHTML(k,!0),k=k.replace(/\&lt;/g,"<").replace(/\&gt;/g,">").replace(/\&#123;/g,"{").replace(/\&#125;/g,"}")),i.replaceWith(k)}else this.setCursorByEl(i),i.remove();
return!1}{var l=this.getRange(),m=this.getSelectText();this.getSelectNode()}m=""==m?"﻿":this.clearFromSubInsert(m,b);var n=this.elFromString(m),o=window.getSelection?l.cloneRange():this.body.createTextRange(),p=window.getSelection?l.cloneRange():this.body.createTextRange();if(window.getSelection){this.insertAtCursor('<span id="wbbdivide"></span>');var q=i.find("span#wbbdivide").get(0);o.setStart(h.firstChild,0),o.setEndBefore(q),p.setStartAfter(q),p.setEndAfter(h.lastChild)}else o.moveToElementText(h),p.moveToElementText(h),o.setEndPoint("EndToStart",l),p.setEndPoint("StartToEnd",l);var r=this.getSelectText(!1,o),s=this.getSelectText(!1,p);if(""!=s){var t=i.clone().html(s);i.after(t)}return c!==!0&&i.after(n),window.getSelection?(i.html(r),c!==!0&&this.selectNode(n)):i.replaceWith(r),!1},this))}},execNativeCommand:function(b,c){if(this.body.focus(),"insertHTML"!=b||window.getSelection)if("insertHTML"==b){var d=this.getSelection(),e=this.elFromString(c),f=this.lastRange?this.lastRange:this.getRange();f.deleteContents(),f.insertNode(e),f.collapse(!1),d.removeAllRanges(),d.addRange(f)}else"undefined"==typeof c&&(c=!1),this.lastRange&&(a.log("Last range select"),this.selectLastRange()),document.execCommand(b,!1,c);else{var g=this.lastRange?this.lastRange:document.selection.createRange();g.pasteHTML(c);var h=a("<div>").html(c).text(),i=h.indexOf("﻿");i>-1&&(g.moveStart("character",-1*(h.length-i)),g.select()),this.lastRange=!1}},getCodeByCommand:function(a,b){return this.options.bbmode?this.getBBCodeByCommand(a,b):this.getHTMLByCommand(a,b)},getBBCodeByCommand:function(b,c){if(!this.options.allButtons[b])return"";"undefined"==typeof c&&(c={}),c=this.keysToLower(c),c.seltext||(c.seltext=this.getSelectText(!0));var d=this.options.allButtons[b].bbcode;d=d.replace(/\{(.*?)(\[.*?\])*\}/g,function(a,b,d){if(d){var e;if(d&&(e=new RegExp(d+"+","i")),"undefined"!=typeof c[b.toLowerCase()]&&null===c[b.toLowerCase()].toString().match(e))return""}return"undefined"==typeof c[b.toLowerCase()]?"":c[b.toLowerCase()]});var e=null,f=0;if(this.options.allButtons[b].transform){var g=[];a.each(this.options.allButtons[b].transform,function(a,b){g.push(b)}),g=this.sortArray(g,-1),a.each(g,function(a,b){var d=!0,g=0,h={};b=b.replace(/\{(.*?)(\[.*?\])*\}/g,function(a,b,e){var f;return b=b.toLowerCase(),e&&(f=new RegExp(e+"+","i")),("undefined"==typeof c[b.toLowerCase()]||e&&null===c[b.toLowerCase()].toString().match(f))&&(d=!1),"undefined"==typeof c[b]||h[b]||(h[b]=1,g++),"undefined"==typeof c[b.toLowerCase()]?"":c[b.toLowerCase()]}),d&&g>f&&(e=b,f=g)})}return e||d},getHTMLByCommand:function(b,c){if(!this.options.allButtons[b])return"";c=this.keysToLower(c),"undefined"==typeof c&&(c={}),c.seltext||(c.seltext=this.getSelectText(!1),""==c.seltext?c.seltext="﻿":(c.seltext=this.clearFromSubInsert(c.seltext,b),this.options.allButtons[b].onlyClearText===!0&&(c.seltext=this.toBB(c.seltext).replace(/\</g,"&lt;").replace(/\n/g,"<br/>").replace(/\s{3}/g,'<span class="wbbtab"></span>'))));var d="";this.seltextID="wbbid_"+ ++this.lastid,"link"!=b&&"img"!=b?c.seltext='<span id="'+this.seltextID+'">'+c.seltext+"</span>":d='<span id="'+this.seltextID+'">﻿</span>';var e=this.options.allButtons[b].html;e=e.replace(/\{(.*?)(\[.*?\])*\}/g,function(a,b,d){if(d){var e=new RegExp(d+"+","i");if("undefined"!=typeof c[b.toLowerCase()]&&null===c[b.toLowerCase()].toString().match(e))return""}return"undefined"==typeof c[b.toLowerCase()]?"":c[b.toLowerCase()]});var f=null,g=0;if(this.options.allButtons[b].transform){var h=[];a.each(this.options.allButtons[b].transform,function(a){h.push(a)}),h=this.sortArray(h,-1),a.each(h,function(a,b){var d=!0,e=0,h={};b=b.replace(/\{(.*?)(\[.*?\])*\}/g,function(a,b,f){var g;return b=b.toLowerCase(),f&&(g=new RegExp(f+"+","i")),("undefined"==typeof c[b]||f&&null===c[b].toString().match(g))&&(d=!1),"undefined"==typeof c[b]||h[b]||(h[b]=1,e++),"undefined"==typeof c[b]?"":c[b]}),d&&e>g&&(f=b,g=e)})}return(f||e)+d},getSelection:function(){return window.getSelection?window.getSelection():document.selection?(this.options.bbmode,document.selection.createRange()):void 0},getSelectText:function(b,c){if(b){if(this.txtArea.focus(),"selectionStart"in this.txtArea){var d=this.txtArea.selectionEnd-this.txtArea.selectionStart;return this.txtArea.value.substr(this.txtArea.selectionStart,d)}var e=document.selection.createRange();return e.text}return this.body.focus(),c||(c=this.getRange()),window.getSelection?c?a("<div>").append(c.cloneContents()).html():"":c.htmlText},getRange:function(){if(!window.getSelection)return this.options.bbmode===!0,document.selection.createRange();var a=this.getSelection();if(a.getRangeAt&&a.rangeCount>0)return a.getRangeAt(0);if(a.anchorNode){var b=(this.options.bbmode,document.createRange());return b.setStart(a.anchorNode,a.anchorOffset),b.setEnd(a.focusNode,a.focusOffset),b}},insertAtCursor:function(b,c){if("string"!=typeof b&&(b=a("<div>").append(b).html()),this.options.bbmode&&"undefined"==typeof c||c===!0){var d=b.replace(/.*(\[\/\S+?\])$/,"$1"),e=this.getCursorPosBB()+(-1!=b.indexOf(d)&&b.match(/\[.*\]/)?b.indexOf(d):b.length);document.selection?(this.txtArea.focus(),this.getSelection().text=b):(this.txtArea.selectionStart||"0"==this.txtArea.selectionStart)&&(this.txtArea.value=this.txtArea.value.substring(0,this.txtArea.selectionStart)+b+this.txtArea.value.substring(this.txtArea.selectionEnd,this.txtArea.value.length)),0>e&&(e=0),this.setCursorPosBB(e)}else{this.execNativeCommand("insertHTML",b);var f=this.getSelectNode();a(f).closest("table,tr,td")||this.splitPrevNext(f)}},getSelectNode:function(b){if(this.body.focus(),b||(b=this.getRange()),!b)return this.$body;var c=window.getSelection?b.commonAncestorContainer:b.parentElement();return a(c).is(".imgWrap")&&(c=a(c).children("img")[0]),c},getCursorPosBB:function(){var a=0;if("selectionStart"in this.txtArea)a=this.txtArea.selectionStart;else{this.txtArea.focus();var b=this.getRange(),c=document.body.createTextRange();c.moveToElementText(this.txtArea),c.setEndPoint("EndToStart",b),a=c.text.length}return a},setCursorPosBB:function(a){if(this.options.bbmode)if(window.getSelection)this.txtArea.selectionStart=a,this.txtArea.selectionEnd=a;else{var b=this.txtArea.createTextRange();b.collapse(!0),b.move("character",a),b.select()}},selectNode:function(a,b){if(b||(b=this.getRange()),b)if(window.getSelection){var c=this.getSelection();b.selectNodeContents(a),c.removeAllRanges(),c.addRange(b)}else b.moveToElementText(a),b.select()},selectRange:function(a){if(a)if(window.getSelection){var b=this.getSelection();b.removeAllRanges(),b.addRange(a)}else a.select()},cloneRange:function(a){return a?window.getSelection?a.cloneRange():a.duplicate():void 0},getRangeClone:function(){return this.cloneRange(this.getRange())},saveRange:function(){this.setBodyFocus(),this.lastRange=this.getRangeClone()},selectLastRange:function(){this.lastRange&&(this.body.focus(),this.selectRange(this.lastRange),this.lastRange=!1)},setBodyFocus:function(){a.log("Set focus to WysiBB editor"),this.options.bbmode?this.$txtArea.is(":focus")||this.$txtArea.focus():this.$body.is(":focus")||this.$body.focus()},clearLastRange:function(){this.lastRange=!1},filterByNode:function(b){var c=a(b),d=c.get(0).tagName.toLowerCase(),e=d,f=this.getAttributeList(c.get(0));a.each(f,a.proxy(function(b,d){var f=c.attr(d);if("_"==d.substr(0,1)&&(d=d.substr(1,d.length)),f&&!f.match(/\{.*?\}/))if("style"==d){var f=c.attr(d),g=f.split(";");a.each(g,function(b,c){c&&c.length>0&&(e+="["+d+'*="'+a.trim(c)+'"]')})}else e+="["+d+'="'+f+'"]';else if(f&&"style"==d){var h=f.substr(0,f.indexOf("{"));if(h&&""!=h){var f=f.substr(0,f.indexOf("{")),g=f.split(";");a.each(g,function(a,b){e+="["+d+'*="'+b+'"]'})}}else e+="["+d+"]"},this));var g=c.parent().children(e).index(c);return g>0&&(e+=":eq("+c.index()+")"),e},relFilterByNode:function(b,c){var d="";for(a.each(this.options.attrWrap,function(a,b){c=c.replace("["+b,"[_"+b)});b&&"BODY"!=b.tagName&&!a(b).is(c);)d=this.filterByNode(b)+" "+d,b&&(b=b.parentNode);return d},getRegexpReplace:function(a,b){return a=a.replace(/(\(|\)|\[|\]|\.|\*|\?|\:|\\)/g,"\\$1").replace(/\s+/g,"\\s+").replace(b.replace(/(\(|\)|\[|\]|\.|\*|\?|\:|\\)/g,"\\$1"),"(.+)").replace(/\{\S+?\}/g,".*")},getBBCode:function(){return this.options.rules?this.options.bbmode?this.$txtArea.val():(this.clearEmpty(),this.removeLastBodyBR(),this.toBB(this.$body.html())):this.$txtArea.val()},toBB:function(b){if(!b)return"";var c="string"==typeof b?a("<span>").html(b):a(b);c.find("div,blockquote,p").each(function(){3!=this.nodeType&&this.lastChild&&"BR"==this.lastChild.tagName&&a(this.lastChild).remove()}),c.is("div,blockquote,p")&&3!=c[0].nodeType&&c[0].lastChild&&"BR"==c[0].lastChild.tagName&&a(c[0].lastChild).remove(),c.find("ul > br, table > br, tr > br").remove();var d="";return a.each(this.options.srules,a.proxy(function(a,b){c.find(a).replaceWith(b[0])},this)),c.contents().each(a.proxy(function(b,c){var e=a(c);if(3===c.nodeType)d+=c.data.replace(/\n+/,"").replace(/\t/g,"   ");else{for(var f=0;f<this.rsellist.length;f++){var g=this.rsellist[f];if(e&&e.is(g))for(var h=this.options.rules[g],b=0;b<h.length;b++){var i=h[b][0],j=h[b][1],k=!1,l=!1,m=!1;if(e.is("br")||(i=i.replace(/\n/g,"<br>")),i=i.replace(/\{(.*?)(\[.*?\])*\}/g,a.proxy(function(b,d){var f=j[d.toLowerCase()];"undefined"==typeof f&&(a.log("Param: {"+d+"} not found in HTML representation."),k=!0);var g=f.sel?a(c).find(f.sel):a(c);if(f.attr&&!g.attr(f.attr))return k=!0,d;var h=f.attr?g.attr(f.attr):g.html();if("undefined"==typeof h||null==h)return k=!0,d;var i=f.rgx;i&&"style"==f.attr&&";"!=i.substr(i.length-1,1)&&(i+=";"),"style"==f.attr&&h&&";"!=h.substr(h.length-1,1)&&(h+=";");var n=i?new RegExp(i,""):!1;if(n)if(h.match(n)){var o=h.match(n);o&&2==o.length&&(h=o[1])}else h="";if(f.attr&&k===!1)if("style"==f.attr){l=!0;var p="",q=f.rgx.replace(/^\.\*\?/,"").replace(/\.\*$/,"").replace(/;$/,"");a(g.attr("style").split(";")).each(function(a,b){b&&""!=b&&(b.match(q)||(p+=b+";"))}),""==p?g.removeAttr("style"):g.attr("style",p)}else f.rgx===!1&&(l=!0,m=!0,g.removeAttr(f.attr));return e.is("table,tr,td,font")&&(l=!0),h||""},this)),!k){if(e.is("img,br,hr")){d+=i,e=null;break}if(!l||e.attr("notkeep")){e.is("iframe")?d+=i:(e.empty().html(i),d+=this.toBB(e),e=null);break}e.is("table,tr,td")?(i=this.fixTableTransform(i),d+=this.toBB(a("<span>").html(i)),e=null):e.empty().html("<span>"+i+"</span>")}}}if(!e||e.is("iframe,img"))return!0;d+=this.toBB(e)}},this)),d.replace(/\uFEFF/g,""),d},getHTML:function(b,c,d){if(!this.options.bbmode&&!c)return this.$body.html();d||(b=b.replace(/</g,"&lt;").replace(/\{/g,"&#123;").replace(/\}/g,"&#125;")),b=b.replace(/\[code\]([\s\S]*?)\[\/code\]/g,function(a){return a=a.substr("[code]".length,a.length-"[code]".length-"[/code]".length).replace(/\[/g,"&#91;").replace(/\]/g,"&#93;"),"[code]"+a+"[/code]"}),a.each(this.options.btnlist,a.proxy(function(c,d){if("|"!=d&&"-"!=d){if(!this.options.allButtons[d]||!this.options.allButtons[d].transform)return!0;a.each(this.options.allButtons[d].transform,a.proxy(function(c,d){c=c.replace(/\n/g,"");var e=[];d=d.replace(/(\(|\)|\[|\]|\.|\*|\?|\:|\\|\\)/g,"\\$1"),d=d.replace(/\{(.*?)(\\\[.*?\\\])*\}/gi,a.proxy(function(a,b,c){return e.push(b),c?(c=c.replace(/\\/g,""),"("+c+"*?)"):"([\\s\\S]*?)"},this));for(var f;null!=(f=new RegExp(d,"mgi").exec(b));)if(f){var g={};a.each(e,a.proxy(function(a,b){g[b]=f[a+1]},this));var h=c;h=h.replace(/\{(.*?)(\[.*?\])\}/g,"{$1}"),h=this.strf(h,g),b=b.replace(f[0],h)}},this))}},this)),a.each(this.options.systr,function(a,c){c=c.replace(/(\(|\)|\[|\]|\.|\*|\?|\:|\\|\\)/g,"\\$1").replace(" ","\\s"),b=b.replace(new RegExp(c,"g"),a)});var e=a(this.elFromString("<div>"+b+"</div>"));return this.getHTMLSmiles(e),e.html()},getHTMLSmiles:function(b){a(b).contents().filter(function(){return 3==this.nodeType}).each(a.proxy(this.smileRPL,this))},smileRPL:function(b,c){var d=c.data;a.each(this.options.smileList,a.proxy(function(b,e){var f=d.indexOf(e.bbcode);if(-1!=f){var g=d.substring(f+e.bbcode.length,d.length),h=document.createTextNode(g);return c.data=d=c.data.substr(0,f),a(c).after(h).after(this.strf(e.img,this.options)),this.getHTMLSmiles(c.parentNode),!1}this.getHTMLSmiles(c)},this))},setUID:function(b,c){var d="wbbid_"+ ++this.lastid;return b&&a(b).attr(c||"id",d),d},keysToLower:function(b){return a.each(b,function(a,c){a!=a.toLowerCase()&&(delete b[a],b[a.toLowerCase()]=c)}),b},strf:function(b,c){return c=this.keysToLower(a.extend({},c)),b.replace(/\{([\w\.]*)\}/g,function(b,d){d=d.toLowerCase();var e=d.split("."),f=c[e.shift().toLowerCase()];return a.each(e,function(){f=f[this]}),null===f||void 0===f?"":f})},elFromString:function(b){if(-1!=b.indexOf("<")&&-1!=b.indexOf(">")){var c=document.createElement("SPAN");return a(c).html(b),this.setUID(c,"wbb"),a(c).contents().size()>1?c:c.firstChild}return document.createTextNode(b)},isContain:function(b,c){for(;b&&!a(b).hasClass("wysibb");){if(a(b).is(c))return b;if(!b)return null;b=b.parentNode}},isBBContain:function(a){for(var b,c=this.getCursorPosBB(),d=this.prepareRGX(a),e=new RegExp(d,"g"),f=0;null!=(b=e.exec(this.txtArea.value));){var g=this.txtArea.value.indexOf(b[0],f);if(c>g&&c<g+b[0].length)return[b,g];f=g+1}},prepareRGX:function(a){return a.replace(/(\[|\]|\)|\(|\.|\*|\?|\:|\||\\)/g,"\\$1").replace(/\{.*?\}/g,"([\\s\\S]*?)")},checkForLastBR:function(b){b||(c=this.body),3==b.nodeType&&(b=b.parentNode);var c=a(b);if(c.is("span[id*='wbbid']")&&(c=c.parent()),this.options.bbmode===!1&&c.is("div,blockquote,code")&&c.contents().size()>0){var d=c[0].lastChild;(!d||d&&"BR"!=d.tagName)&&c.append("<br/>")}this.$body.contents().size()>0&&"BR"!=this.body.lastChild.tagName&&this.$body.append("<br/>")},getAttributeList:function(b){var c=[];return a.each(b.attributes,function(a,b){b.specified&&c.push(b.name)}),c},clearFromSubInsert:function(b,c){if(this.options.allButtons[c]&&this.options.allButtons[c].rootSelector){var d=a("<div>").html(b);return a.each(this.options.allButtons[c].rootSelector,a.proxy(function(b,c){var e=!1;"undefined"!=typeof this.options.rules[c][0][1].seltext&&(e=this.options.rules[c][0][1].seltext.sel);var f=!0;return d.find("*").each(function(){a(this).is(c)&&(a(this).replaceWith(e&&e.sel?a(this).find(e.sel.toLowerCase()).html():a(this).html()),f=!1)}),f},this)),d.html()}return b},splitPrevNext:function(b){3==b.nodeType&&(b=b.parentNode);var c=this.filterByNode(b).replace(/\:eq.*$/g,"");a(b.nextSibling).is(c)&&(a(b).append(a(b.nextSibling).html()),a(b.nextSibling).remove()),a(b.previousSibling).is(c)&&(a(b).prepend(a(b.previousSibling).html()),a(b.previousSibling).remove())},modeSwitch:function(){this.options.bbmode?(this.$body.html(this.getHTML(this.$txtArea.val())),this.$txtArea.hide().removeAttr("wbbsync").val(""),this.$body.css("min-height",this.$txtArea.height()).show().focus()):(this.$txtArea.val(this.getBBCode()).css("min-height",this.$body.height()),this.$body.hide(),this.$txtArea.show().focus()),this.options.bbmode=!this.options.bbmode},clearEmpty:function(){function b(){return a(this).is("span,font,a,b,i,u,s")?a(this).hasClass("wbbtab")||0!=a.trim(a(this).html()).length?a(this).children().size()>0&&(a(this).children().filter(b).remove(),0==a(this).html().length&&"BODY"!=this.tagName)?!0:void 0:!0:!1}this.$body.children().filter(b).remove()},dropdownclick:function(b,c,d){var e=a(d.currentTarget).closest(b);e.hasClass("dis")||(e.attr("wbbshow")?(e.removeAttr("wbbshow"),a(document).unbind("mousedown",this.dropdownhandler),document&&a(document).unbind("mousedown",this.dropdownhandler),this.lastRange=!1):(this.saveRange(),this.$editor.find("*[wbbshow]").each(function(b,c){a(c).removeClass("on").find(a(c).attr("wbbshow")).hide().end().removeAttr("wbbshow")}),e.attr("wbbshow",c),a(document.body).bind("mousedown",a.proxy(function(a){this.dropdownhandler(e,b,c,a)},this)),this.$body&&this.$body.bind("mousedown",a.proxy(function(a){this.dropdownhandler(e,b,c,a)},this))),e.find(c).toggle(),e.toggleClass("on"))},dropdownhandler:function(b,c,d,e){0==a(e.target).parents(c).size()&&(b.removeClass("on").find(d).hide(),a(document).unbind("mousedown",this.dropdownhandler),this.$body&&this.$body.unbind("mousedown",this.dropdownhandler))},rgbToHex:function(a){if("#"==a.substr(0,1))return a;if(-1==a.indexOf("rgb")){var b=parseInt(a);return b=(255&b)<<16|65280&b|(16711680&b)>>>16,"#"+b.toString(16)}var c=/(.*?)rgb\((\d+),\s*(\d+),\s*(\d+)\)/.exec(a);return"#"+this.dec2hex(parseInt(c[2]))+this.dec2hex(parseInt(c[3]))+this.dec2hex(parseInt(c[4]))},dec2hex:function(a){return a>15?a.toString(16):"0"+a.toString(16)},sync:function(){this.options.bbmode?this.$body.html(this.getHTML(this.txtArea.value,!0)):this.$txtArea.attr("wbbsync",1).val(this.getBBCode())},clearPaste:function(b){var c=a(b);a.each(this.options.rules,a.proxy(function(b,d){var e=c.find(b).attr("wbbkeep",1);if(e.size()>0){var f=d[0][1];a.each(f,function(a,b){b.sel&&e.find(b.sel).attr("wbbkeep",1)})}},this)),c.find("*[wbbkeep!='1']").each(a.proxy(function(b,c){var d=a(c);!d.is("div,p")||0!=d.children().size()&&"BR"==c.lastChild.tagName||d.after("<br/>")},this)),c.find("*[wbbkeep]").removeAttr("wbbkeep").removeAttr("style"),a.log(c.html()),c.html(this.getHTML(this.toBB(c),!0)),a.log(c.html())},sortArray:function(a,b){return a.sort(function(a,c){return(a.length-c.length)*(b||1)}),a},smileFind:function(){if(this.options.smilefind){var b=a(this.options.smilefind).find("img[alt]");b.size()>0&&(this.options.smileList=[],b.each(a.proxy(function(b,c){var d=a(c);this.options.smileList.push({title:d.attr("title"),bbcode:d.attr("alt"),img:d.removeAttr("alt").removeAttr("title")[0].outerHTML})},this)))}},destroy:function(){this.$editor.replaceWith(this.$txtArea),this.$txtArea.removeClass("wysibb-texarea").show(),this.$modal.remove(),this.$txtArea.data("wbb",null)},pressTab:function(a){a&&9==a.which&&(a.preventDefault&&a.preventDefault(),this.options.bbmode?this.insertAtCursor("   ",!1):this.insertAtCursor('<span class="wbbtab">﻿</span>',!1))},removeLastBodyBR:function(){this.body.lastChild&&3!=this.body.lastChild.nodeType&&"BR"==this.body.lastChild.tagName&&(this.body.removeChild(this.body.lastChild),this.removeLastBodyBR())},traceTextareaEvent:function(b){0==a(b.target).closest("div.wysibb").size()&&(a(document.activeElement).is("div.wysibb-body")&&this.saveRange(),setTimeout(a.proxy(function(){var c=this.$txtArea.val();this.options.bbmode!==!1||""==c||0!=a(b.target).closest("div.wysibb").size()||this.$txtArea.attr("wbbsync")||(this.selectLastRange(),this.insertAtCursor(this.getHTML(c,!0)),this.$txtArea.val("")),a(document.activeElement).is("div.wysibb-body")&&(this.lastRange=!1)},this),100))},txtAreaInitContent:function(){this.$body.html(this.getHTML(this.txtArea.value,!0))},getValidationRGX:function(a){return a.match(/\[\S+\]/)?a.replace(/.*(\\*\[\S+\]).*/,"$1"):""},smileConversion:function(){if(this.options.smileList&&this.options.smileList.length>0){var b=this.getSelectNode();if(3==b.nodeType){var c=b.data;c.length>=2&&!this.isInClearTextBlock(b)&&0==a(b).parents("a").size()&&a.each(this.options.srules,a.proxy(function(d,e){var f=e[0],g=c.indexOf(f);if(-1!=g){var h=c.substring(g+f.length,c.length),i=document.createTextNode(h),j=document.createElement("SPAN");return b.data=b.data.substr(0,g),a(b).after(i).after(j).after(this.strf(e[1],this.options)),this.selectNode(j),!1}},this))}}},isInClearTextBlock:function(){if(this.cleartext){var b=!1;return a.each(this.cleartext,a.proxy(function(a,c){return this.queryState(c)?(b=c,!1):void 0},this)),b}return!1},wrapAttrs:function(b){return a.each(this.options.attrWrap,function(a,c){b=b.replace(c+'="',"_"+c+'="')}),b},unwrapAttrs:function(b){return a.each(this.options.attrWrap,function(a,c){b=b.replace("_"+c+'="',c+'="')}),b},disNonActiveButtons:function(){this.isInClearTextBlock()?this.$toolbar.find(".wysibb-toolbar-btn:not(.on,.mswitch)").addClass("dis"):this.$toolbar.find(".wysibb-toolbar-btn.dis").removeClass("dis")},setCursorByEl:function(b){var c=document.createTextNode("﻿");a(b).after(c),this.selectNode(c)},imgListeners:function(){a(document).on("mousedown",a.proxy(this.imgEventHandler,this))},imgEventHandler:function(b){var c=a(b.target);this.hasWrapedImage&&(0==c.closest(".wbb-img,#wbbmodal").size()||c.hasClass("wbb-cancel-button"))&&(this.$body.find(".imgWrap ").each(function(){a.log("Removed imgWrap block"),a(this).replaceWith(a(this).find("img"))}),this.hasWrapedImage=!1,this.updateUI()),c.is("img")&&c.closest(".wysibb-body").size()>0&&(c.wrap("<span class='imgWrap'></span>"),this.hasWrapedImage=c,this.$body.focus(),this.selectNode(c.parent()[0]))},showModal:function(b,c,d){a.log("showModal: "+b),this.saveRange();var e=this.$modal.find(".wbbm-content").html(""),f=this.$modal.find(".wbbm").removeClass("hastabs");if(this.$modal.find("span.wbbm-title-text").html(c.title),c.tabs&&c.tabs.length>1){f.addClass("hastabs");var g=a('<div class="wbbm-tablist">').appendTo(e).append("<ul>").children("ul");a.each(c.tabs,a.proxy(function(a,b){0==a&&(b.on="on"),g.append(this.strf("<li class=\"{on}\" onClick=\"$(this).parent().find('.on').removeClass('on');$(this).addClass('on');$(this).parents('.wbbm-content').find('.tab-cont').hide();$(this).parents('.wbbm-content').find('.tab"+a+"').show()\">{title}</li>",b))},this))}c.width&&f.css("width",c.width);var h=a('<div class="wbbm-cont">').appendTo(e);d?f.find("#wbbm-remove").show():f.find("#wbbm-remove").hide(),a.each(c.tabs,a.proxy(function(b,c){var e=a("<div>").addClass("tab-cont tab"+b).attr("tid",b).appendTo(h);b>0&&e.hide(),c.html?e.html(this.strf(c.html,this.options)):a.each(c.input,a.proxy(function(b,c){c.value=d[c.param.toLowerCase()],"seltext"!=c.param.toLowerCase()||c.value&&""!=c.value||(c.value=this.getSelectText(this.options.bbmode)),c.value&&0==c.value.indexOf("<span id='wbbid")&&a(c.value).is("span[id*='wbbid']")&&(c.value=a(c.value).html()),e.append(c.type&&"div"==c.type?this.strf('<div class="wbbm-inp-row"><label>{title}</label><div class="inp-text div-modal-text" contenteditable="true" name="{param}">{value}</div></div>',c):this.strf('<div class="wbbm-inp-row"><label>{title}</label><input class="inp-text modal-text" type="text" name="{param}" value="{value}"/></div>',c))},this))},this)),a.isFunction(c.onLoad)&&c.onLoad.call(this,b,c,d),f.find("#wbbm-submit").click(a.proxy(function(){if(a.isFunction(c.onSubmit)){var e=c.onSubmit.call(this,b,c,d);if(e===!1)return}var f={},g=!0;this.$modal.find(".wbbm-inperr").remove(),this.$modal.find(".wbbm-brdred").removeClass("wbbm-brdred"),a.each(this.$modal.find(".tab-cont:visible .inp-text"),a.proxy(function(b,d){var e=a(d).parents(".tab-cont").attr("tid"),h=a(d).attr("name").toLowerCase(),i="";i=a(d).is("input,textrea,select")?a(d).val():a(d).html();var j=c.tabs[e].input[b].validation;"undefined"!=typeof j&&(i.match(new RegExp(j,"i"))||(g=!1,a(d).after('<span class="wbbm-inperr">'+CURLANG.validation_err+"</span>").addClass("wbbm-brdred"))),f[h]=i},this)),g&&(a.log("Last range: "+this.lastRange),this.selectLastRange(),d&&this.wbbRemoveCallback(b,!0),this.wbbInsertCallback(b,f),this.closeModal(),this.updateUI())},this)),f.find("#wbbm-remove").click(a.proxy(function(){this.selectLastRange(),this.wbbRemoveCallback(b),this.closeModal(),this.updateUI()},this)),a(document.body).css("overflow","hidden"),a("body").height()>a(window).height()&&a(document.body).css("padding-right","18px"),this.$modal.show(),this.isMobile?f.css("margin-top","10px"):f.css("margin-top",(a(window).height()-f.outerHeight())/3+"px"),setTimeout(a.proxy(function(){this.$modal.find(".inp-text:visible")[0].focus()},this),10)},escModal:function(a){27==a.which&&this.closeModal()},closeModal:function(){return a(document.body).css("overflow","auto").css("padding-right","0").unbind("keyup",this.escModal),this.$modal.find("#wbbm-submit,#wbbm-remove").unbind("click"),this.$modal.hide(),this.lastRange=!1,this},getParams:function(b,c,d){var e={};if(this.options.bbmode){var f=c.match(/\{[\s\S]+?\}/g);c=this.prepareRGX(c);var g=new RegExp(c,"g"),h=this.txtArea.value;d>0&&(h=h.substr(d,h.length-d));var i=g.exec(h);i&&a.each(f,function(a,b){e[b.replace(/\{|\}/g,"").replace(/"/g,"'").toLowerCase()]=i[a+1]})}else{var j=this.options.rules[c][0][1];a.each(j,a.proxy(function(c,d){var f="",g=d.sel!==!1?f=a(b).find(d.sel):a(b);if(f=d.attr!==!1?g.attr(d.attr):g.html()){if(d.rgx!==!1){var h=f.match(new RegExp(d.rgx));h&&2==h.length&&(f=h[1])}e[c]=f.replace(/"/g,"'")}},this))}return e},imgLoadModal:function(){a.log("imgLoadModal"),this.options.imgupload===!0?(this.$modal.find("#imguploader").dragfileupload({url:this.strf(this.options.img_uploadurl,this.options),extraParams:{maxwidth:this.options.img_maxwidth,maxheight:this.options.img_maxheight},themePrefix:this.options.themePrefix,themeName:this.options.themeName,success:a.proxy(function(a){this.$txtArea.insertImage(a.image_link,a.thumb_link),this.closeModal(),this.updateUI()},this)}),this.$modal.find("#fileupl").bind("change",function(){a("#fupform").submit()}),this.$modal.find("#fupform").bind("submit",a.proxy(function(b){a(b.target).parents("#imguploader").hide().after('<div class="loader"><img src="'+this.options.themePrefix+"/"+this.options.themeName+'/img/loader.gif" /><br/><span>'+CURLANG.loading+"</span></div>").parent().css("text-align","center")},this))):(this.$modal.find(".hastabs").removeClass("hastabs"),this.$modal.find("#imguploader").parents(".tab-cont").remove(),this.$modal.find(".wbbm-tablist").remove())},imgSubmitModal:function(){a.log("imgSubmitModal")},printObjectInIE:function(b){try{a.log(JSON.stringify(b))}catch(c){}},checkFilter:function(b,c){a.log("node: "+a(b).get(0).outerHTML+" filter: "+c+" res: "+a(b).is(c.toLowerCase()))},debug:function(b){if(this.options.debug===!0){var c=(new Date).getTime();"undefined"!=typeof console?console.log(c-this.startTime+" ms: "+b):a("#exlog").append("<p>"+(c-this.startTime)+" ms: "+b+"</p>"),this.startTime=c}},isChrome:function(){return window.chrome?!0:!1},fixTableTransform:function(b){return b?-1==a.inArray("table",this.options.buttons)?b.replace(/\<(\/*?(table|tr|td|tbody))[^>]*\>/gi,""):b.replace(/\<(\/*?(table|tr|td))[^>]*\>/gi,"[$1]".toLowerCase()).replace(/\<\/*tbody[^>]*\>/gi,""):""}},a.log=function(b){"undefined"!=typeof wbbdebug&&wbbdebug===!0&&("undefined"!=typeof console?console.log(b):a("#exlog").append("<p>"+b+"</p>"))},a.fn.wysibb=function(b){return this.each(function(){var c=a(this).data("wbb");c||new a.wysibb(this,b)})},a.fn.wdrag=function(b){b.scope||(b.scope=this);var c,d={x:0,y:0,height:0};b.scope.drag_mousedown=function(e){e.preventDefault(),d={x:e.pageX,y:e.pageY,height:b.height,sheight:b.scope.$body.height()},c=!0,a(document).bind("mousemove",a.proxy(b.scope.drag_mousemove,this)),a(this).addClass("drag")},b.scope.drag_mouseup=function(d){c===!0&&(d.preventDefault(),a(document).unbind("mousemove",b.scope.drag_mousemove),a(this).removeClass("drag"),c=!1)},b.scope.drag_mousemove=function(a){a.preventDefault();var c=0,e=0;if(b.axisX&&(c=a.pageX-d.x),b.axisY&&(e=a.pageY-d.y),0!=e){var f=d.sheight+e;f>d.height&&f<=b.scope.options.resize_maxheight&&(1==b.scope.options.bbmode?b.scope.$txtArea.css(b.scope.options.autoresize===!0?"min-height":"height",f+"px"):b.scope.$body.css(b.scope.options.autoresize===!0?"min-height":"height",f+"px"))}},a(this).bind("mousedown",b.scope.drag_mousedown),a(document).bind("mouseup",a.proxy(b.scope.drag_mouseup,this))},a.fn.getDoc=function(){return this.data("wbb").doc},a.fn.getSelectText=function(a){return this.data("wbb").getSelectText(a)},a.fn.bbcode=function(a){return"undefined"!=typeof a?(this.data("wbb").options.bbmode?this.data("wbb").$txtArea.val(a):this.data("wbb").$body.html(this.data("wbb").getHTML(a)),this):this.data("wbb").getBBCode()},a.fn.htmlcode=function(a){return this.data("wbb").options.onlyBBMode||this.data("wbb").inited!==!0?void 0:"undefined"!=typeof a?(this.data("wbb").$body.html(a),this):this.data("wbb").getHTML(this.data("wbb").$txtArea.val())},a.fn.getBBCode=function(){return this.data("wbb").getBBCode()},a.fn.getHTML=function(){var a=this.data("wbb");return a.getHTML(a.$txtArea.val())},a.fn.getHTMLByCommand=function(a,b){return this.data("wbb").getHTMLByCommand(a,b)},a.fn.getBBCodeByCommand=function(a,b){return this.data("wbb").getBBCodeByCommand(a,b)},a.fn.insertAtCursor=function(a,b){return this.data("wbb").insertAtCursor(a,b),this.data("wbb")},a.fn.execCommand=function(a,b){return this.data("wbb").execCommand(a,b),this.data("wbb")},a.fn.insertImage=function(a,b){var c=this.data("wbb"),d=b?c.getCodeByCommand("link",{url:a,seltext:c.getCodeByCommand("img",{src:b})}):c.getCodeByCommand("img",{src:a});return this.insertAtCursor(d),c},a.fn.sync=function(){return this.data("wbb").sync(),this.data("wbb")},a.fn.destroy=function(){this.data("wbb").destroy()},a.fn.queryState=function(a){return this.data("wbb").queryState(a)}}(jQuery),function(a){"use strict";function b(b,c){this.$block=a(b),this.opt=a.extend({url:!1,success:!1,extraParams:!1,fileParam:"img",validation:".(jpg|png|gif|jpeg)$",t1:CURLANG.fileupload_text1,t2:CURLANG.fileupload_text2},c)}a.fn.dragfileupload=function(a){return this.each(function(){var c=new b(this,a);c.init()})},b.prototype={init:function(){if(null!=window.FormData){this.$block.addClass("drag"),this.$block.prepend('<div class="p2">'+this.opt.t2+"</div>"),this.$block.prepend('<div class="p">'+this.opt.t1+"</div>"),this.$block.bind("dragover",function(){return a(this).addClass("dragover"),!1}),this.$block.bind("dragleave",function(){return a(this).removeClass("dragover"),!1});var b=a.proxy(function(a){var b=parseInt(a.loaded/a.total*100,10);this.$loader.children("span").text(CURLANG.loading+": "+b+"%")},this),c=jQuery.ajaxSettings.xhr();c.upload&&c.upload.addEventListener("progress",b,!1),this.$block[0].ondrop=a.proxy(function(b){b.preventDefault(),this.$block.removeClass("dragover");var d=b.dataTransfer.files[0];if(this.opt.validation&&!d.name.match(new RegExp(this.opt.validation)))return this.error(CURLANG.validation_err),!1;var e=new FormData;e.append(this.opt.fileParam,d),this.opt.extraParams&&a.each(this.opt.extraParams,function(a,b){e.append(a,b)}),this.$loader=a('<div class="loader"><img src="'+this.opt.themePrefix+"/"+this.opt.themeName+'/img/loader.gif" /><br/><span>'+CURLANG.loading+"</span></div>"),this.$block.html(this.$loader),a.ajax({type:"POST",url:this.opt.url,data:e,processData:!1,contentType:!1,xhr:function(){return c},dataType:"json",success:a.proxy(function(a){a&&1==a.status?this.opt.success(a):this.error(a.msg||CURLANG.error_onupload)},this),error:a.proxy(function(){this.error(CURLANG.error_onupload)},this)})},this)}},error:function(a){this.$block.find(".upl-error").remove().end().append('<span class="upl-error">'+a+"</span>").addClass("wbbm-brdred")}}}(jQuery);
$(function() {
	window.DOMObservers = window.DOMObservers || {};
	
	window.async = {
		enable: true,
		getData: function($container, url, method, data) {
			var async = this;
			
			if ($container !== undefined) {
				$.ajax({
					url: url,
					data: data,
					method: method,
					beforeSend: function() {
						async.enable = false;
						if ((load = $container.attr("data-load")) !== undefined) {
							$container.append(load);
						}
					},
					success: function(data) {
						async.enable = true;
						$container.html(data);
						async.initAsync($container);
					},
					error: function() {
						async.enable = true;
						if ((fail = $container.attr("data-fail")) !== undefined) {
							$container.html(fail);
						}
					}
				});
			}
		},
		initAsync: function($container) {
			var async = this;
			var isContainerDefined = ($container === undefined);
			var $asyncData = (isContainerDefined) ? ($(".async-data")) : ($container.find(".async-data"));
			var $asyncLink = (isContainerDefined) ? ($("a.async-link")) : ($container.find("a.async-link"));
			var $asyncForm = (isContainerDefined) ? ($("form.async-form")) : ($container.find("form.async-form"));
			
			$asyncData.each(function() {
				async.initAsyncData($(this));
			});		
			$asyncLink.each(function() {
				var $link = $(this);
				var $target = $container;
				var $target = (target !== undefined) ? ($(target)) : ($container);
				
				async.initAsyncLink($target, $link);
			});
			$asyncForm.each(function() {
				var $form = $(this);
				var target = $link.attr("data-target");
				var $target = (target !== undefined) ? ($(target)) : ($container);
				
				async.initAsyncForm($target, $form);
			});
			
			for (var DOMObserver in window.DOMObservers) {
				window.DOMObservers[DOMObserver].init();
			}
		},
		initAsyncData: function($container) {
			var async = this;
			var wait = $container.attr("data-wait");
			
			if (wait === undefined) {
				async.getData($container, $container.attr("data-url"), "GET", {});
			}
		},
		initAsyncLink: function($container, $link) {
			var async = this;
			
			$link.click(function(event) {
				event.preventDefault();
				
				if (async.enable) {
					async.getData($container, $link.attr("href"), "GET", {});
				}
			});
		},
		initAsyncForm: function($container, $form) {
			var async = this;
			
			$form.submit(function(event) {
				event.preventDefault();
				
				if (async.enable) {
					async.getData($container, $form.attr("action"), $form.attr("method"), $form.serialize());
				}
			});
		},
		loadAsyncData: function($container) {
			var async = this;
			
			async.getData($container, $container.attr("data-url"), "GET", {});
		}
	};
	window.async.initAsync();
});
$(function() {
	$(".popup-background").click(function(event) {
		$(".openable").removeClass("opened");
		$(this).removeClass("opened");
		event.preventDefault();
	});
	
	$(".openable .open").click(function(event) {
		$this = $(this).parents(".openable");
		
		if (!$this.hasClass("opened")) {
			$this.addClass("opened");
			
			$background = $(".popup-background");
			if (!$background.hasClass("opened")) {
				$background.addClass("opened");
			}
			
			$(".openable").css("z-index", $background.css("z-index") - 1);
			$this.css("z-index", $background.css("z-index") + 1);
			event.preventDefault();
		}
	});
	
	$(".openable .close").click(function(event){
		$(".openable").removeClass("opened");
		$(".popup-background").removeClass("opened");
		event.preventDefault();
	});
});
$(function() {
	window.DOMObservers = window.DOMObservers || {};
	
	window.DOMObservers.readMore = {
		init: function() {
			$("a.read-more-link:not(.read-more-link-init)").each(function() {
				$this = $(this);
				
				$this.addClass("read-more-link-init");
				$this.click(function(event) {
					$($(this).attr("read-more-target")).toggleClass("read-more-opened");
					event.preventDefault();
				});
			});
		}
	};
});