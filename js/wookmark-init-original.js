/*
// regular
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
*/

// imagesloaded
(function ($) {
    var handleAlbumJson = function(album) {
        console.log('in callback');
        var albumDate = album.date;
        var albumDir = album.directory;
        var images = album.images;
        
        var container = '#gallery-container';
        var $container = $(container);
        var wookmark;

        for (var i = 0; i < album.images.length; i++) {
            var location = 'img/gallery/' + albumDir + '/' + encodeURIComponent(images[i].name);
            console.log('location: ' + location);
            var newItemHtml = '\
                <li class="tile-loading">\
                    <a href=' + location + ' class="fancybox" data-fancybox-group="gallery" title="title here">\
                        <img src="' + location + '"><p>' + albumDate + '</p>\
                    </a>\
                </li>';
            //var newItemHtml = '<li class="tile-loading"><img src="' + location + '"><p>' + albumDate + '</p></li>';
            $container.append(newItemHtml);
        }
    
        // Initialize Wookmark
        wookmark = new Wookmark(container, {
          offset: 5, // Optional, the distance between grid items
          outerOffset: 10, // Optional, the distance to the containers border
          itemWidth: 210 // Optional, the width of a grid item
        });
    
        $container.imagesLoaded()
        .always(function () {
            console.log('always');
        })
        .progress(function (instance, image) {
            // Update progress bar after each image has loaded and remove loading state
            $(image.img).closest('li').removeClass('tile-loading');
            wookmark.updateOptions();
        });
    };
    
    var ajaxTiles = function() {
        console.log('in ajaxTiles');
        
        var dataAlbumId = $('#main').attr('data-album-id');
        
        var ajaxOptions = {
            type : 'GET',
            dataType : 'json',
            url : '/index.php',
            data : {
                'api' : 'album-json',
                'album-id' : dataAlbumId,
            },
            success : handleAlbumJson,
        };
        
        $.ajax(ajaxOptions);
    };
    
    ajaxTiles();

})(jQuery);
