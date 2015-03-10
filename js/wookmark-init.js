(function ($){
    var wookmark = new Wookmark('#gallery-container', {
        // Prepare layout options.
        autoResize: true, // This will auto-update the layout when the browser window is resized.
        container: $('#main'), // Optional, used for some extra CSS styling
        offset: 5, // Optional, the distance between grid items
        outerOffset: 10, // Optional, the distance to the containers border
        itemWidth: 210 // Optional, the width of a grid item
    });

    // Capture clicks on grid items.
    $('#container').on('click', 'li', function () {
      // Randomize the height of the clicked item.
      var newHeight = $('img', this).height() + Math.round(Math.random() * 300 + 30);
      $(this).css('height', newHeight+'px');

      // Update the layout.
      wookmark.layout(true);
    });
})(jQuery);
