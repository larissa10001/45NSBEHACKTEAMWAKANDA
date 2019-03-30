//smooth page transitions
$(function(){
  'use strict';
  var options = {
    prefetch: true,
    cacheLength: 2,
    onStart: {
      duration: 250, // Duration of our animation
      render: function ($container) {
        // Add your CSS animation reversing class
        $container.addClass('is-exiting');

        // Restart your animation
        smoothState.restartCSSAnimations();
      }
    },
    onReady: {
      duration: 5,
      render: function ($container, $newContent) {
        // Remove your CSS animation reversing class
        $container.removeClass('is-exiting');

        // Inject the new content
        $container.html($newContent);

      }
    }
  },
  smoothState = $('#main').smoothState(options).data('smoothState');

  $('#main').smoothState({
  onReady: {
    duration: 250,
    // `$container` is a `jQuery Object` of the the current smoothState container
    // `$newContent` is a `jQuery Object` of the HTML that should replace the existing container's HTML.
    render: function ($container, $newContent) {
      // Update the HTML on the page
      $container.html($newContent);
    }
  }
});

function say_hi() {
    var address = document.getElementById('searchInput').value;

    var html = address;
}
