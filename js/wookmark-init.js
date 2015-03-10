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
    var successCallback = function(album) {
        console.log('in callback');
        console.log(album);
        var albumSize = album.count;
        var albumDate = album.date;
        var albumName = album.name;
        var albumDir = album.directory;
        var images = album.images;
        console.log(albumSize);
        console.log(albumDate);
        console.log(albumName);
        console.log(albumDir);
        console.log(images);
        
        
        /******************/
        var loadedImages = 0, // Counter for loaded images
        $progressBar = $('.progress-bar'),
        container = '#gallery-container',
        $container = $(container),
        tileCount = albumSize,
        wookmark;

        for (var i = 0; i < tileCount; i++) {
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
            $progressBar.hide();
          })
          .progress(function (instance, image) {
            // Update progress bar after each image has loaded and remove loading state
            $(image.img).closest('li').removeClass('tile-loading');
            $progressBar.css('width', (++loadedImages / tileCount * 100) + '%');
            wookmark.updateOptions();
          });
    };
    
    var makeTiles = function() {
        console.log('in makeTiles');
        
        var dataAlbumId = $('#main').attr('data-album-id');
        
        var ajaxOptions = {
            type : 'GET',
            dataType : 'json',
            url : '/index.php',
            data : {
                'api' : 'album-json',
                'album-id' : dataAlbumId,
            },
            success : successCallback,
        };
        
        $.ajax(ajaxOptions);
    };
    
    makeTiles();

})(jQuery);