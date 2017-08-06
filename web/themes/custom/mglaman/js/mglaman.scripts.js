;(function(Drupal, $) {
  Drupal.behaviors.articleSocialShare = {
    attach: function(context) {
      $('.social-sharing__link a', context).bind('click', function(e) {
        var $el = $(this);

        var w = 580;
        var h = 470;

        // Fixes dual-screen position                         Most browsers      Firefox
        var dualScreenLeft = window.screenLeft !== undefined ? window.screenLeft : screen.left;
        var dualScreenTop = window.screenTop !== undefined ? window.screenTop : screen.top;

        var width = window.innerWidth ? window.innerWidth : document.documentElement.clientWidth ? document.documentElement.clientWidth : screen.width;
        var height = window.innerHeight ? window.innerHeight : document.documentElement.clientHeight ? document.documentElement.clientHeight : screen.height;

        var left = ((width / 2) - (w / 2)) + dualScreenLeft;
        var top = ((height / 3) - (h / 3)) + dualScreenTop;

        var newWindow = window.open($el.attr('href'), $el.find('span').html(), 'scrollbars=yes, width=' + w + ', height=' + h + ', top=' + top + ', left=' + left);

        // Puts focus on the newWindow
        if (window.focus) {
          newWindow.focus();
        }
        e.preventDefault();
        if (_gaq !== undefined) {
          _gaq.push(['_trackSocial', $el.find('span').html().toLowerCase(), 'share']);
        }
      })
    }
  }
})(Drupal, jQuery);
