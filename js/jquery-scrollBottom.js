/*!
 * jquery.scrollBottom.js v1.7 - 23 December, 2012
 * By João Gonçalves (http://goncalvesjoao.github.com)
 * Hosted on https://github.com/goncalvesjoao/jquery.scrollBottom
 * Licensed under MIT license.
 */

(function($){
  var methods = {
    init: function(callback, options) {
      return this.each(function() {
        var $this = $(this), data = $this.data('scrollBottom');
        if (data) return $this;

        var settings = { margin_bottom: 0, constant_check: false };
        if (typeof options == "number") {
          settings["margin_bottom"] = options;
        } else {
          settings = $.extend(settings, options);
        }
        settings["reached_bottom"] = false;

        $this.data('scrollBottom', settings);
        $this.bind('scroll.scrollBottom', function() { $this.scrollBottom('check_bottom', false); });
        $this.bind('scroll_reached_bottom', function(event) {
          callback(event);
          event.stopPropagation();
        });
      });
    },
    check_bottom: function(bypass_validation) {
      if (bypass_validation == undefined) bypass_validation = true;
      return this.each(function() {
        var $this = $(this), data = $this.data('scrollBottom');
        if (!data) return $this;

        var scrollHeight = (this == window) ? $(document).height() : this.scrollHeight;
        if ((scrollHeight - $this.scrollTop()) <= ($this.outerHeight() + data.margin_bottom)) {
          if (data.constant_check || bypass_validation || !data.reached_bottom) {
            $this.trigger('scroll_reached_bottom');
            data.reached_bottom = true;
          }
        } else {
          data.reached_bottom = false;
        }
        $this.data('scrollBottom', data);
      });
    },
    destroy: function() {
      return this.each(function() {
        var $this = $(this);
        $this.unbind('scroll_reached_bottom');
        $this.unbind('.scrollBottom');
        $this.removeData('scrollBottom');
      });
    }
  }
  $.fn.scrollBottom = function(method, margin_bottom) {
    if (methods[method]) {
      return methods[method].apply(this, Array.prototype.slice.call(arguments, 1));
    } else if (typeof method == "function") {
      return methods.init.apply(this, arguments);
    } else {
      $.error('Method ' +  method + ' does not exist on jQuery.scrollBottom');
    }
  };
})(jQuery);