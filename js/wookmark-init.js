(function ($) {
    var wookmark;
    var container = '#gallery-container';
    var $container = $(container);
    var $window = $(window);
    var $document = $(document);
    var imageIndex = { val : 0 };
    var globalAlbum = '';
    var noMoreImages = false;
    var albumCount = 0;
    var numImagesLoadedSoFar = 0;
    
    /**
     * When scrolled all the way to the bottom, add more tiles
     */
    var onScroll = function() {
        // Check if we're within 300 pixels of the bottom edge of the broser window.
        var winHeight = window.innerHeight ? window.innerHeight : $window.height(), // iphone fix
        closeToBottom = ($window.scrollTop() + winHeight > $document.height() - window.innerHeight);
        //$('title').html("winHeight: " + winHeight);
        //$('title').html("$window.scrollTop(): " + $window.scrollTop());
        //$('title').html("$document.height(): " + $document.height());

        if (closeToBottom && globalAlbum != '' && !noMoreImages && numImagesLoadedSoFar != albumCount) {
            $('title').html("CLOSE TO BOTTOM");
            var $nextGroupHtml = getGroupOfTiles(imageIndex.val, 5);
            if ($nextGroupHtml.length == 0) {
                noMoreImages = true;
            }
            $container.append($nextGroupHtml);
            
            $container.imagesLoaded(container, function () {
                console.log('imagesLoaded in onScroll');
                //$(image.img).closest('li').removeClass('tile-loading');
                $('#gallery-container li').removeClass('tile-loading');
                wookmark = new Wookmark(container, {
                    offset: 5, // Optional, the distance between grid items
                    outerOffset: 10, // Optional, the distance to the containers border
                    itemWidth: 310 // Optional, the width of a grid item
                });
                wookmark.initItems();
                wookmark.layout(true, function () {
                    // Fade in items after layout
                    setTimeout(function() {
                        $('#gallery-container li').css('opacity', 1);
                    }, 300);
                    setTimeout(function() {
                        $('body').spin('modal');
                    }, 400);
                });
                $('body').spin('modal');
            }).progress(function (instance, image) {
                console.log('progress resize');
            });
        }
    };

    // Capture scroll event.
    $window.bind('scroll.wookmark', onScroll);
    
    var getGroupOfTiles = function(startIndex, stepSize) {
        //var container = '#gallery-container';
        //var $container = $(container);
        var albumDate = globalAlbum.date;
        var albumDir = globalAlbum.directory;
        var images = globalAlbum.images;
        
        var newItemHtml = '';
        var sumNewItemsHtml = '';
        for (var i = 0; i < stepSize && imageIndex.val < albumCount; i++) {
            var location = './img/gallery/' + albumDir + '/' + encodeURIComponent(images[imageIndex.val].name);
            newItemHtml = '\
                <li class="tile-loading">\
                    <a href=' + location + ' class="fancybox" data-fancybox-group="gallery">\
                        <img src="' + location + '"><p>' + albumDate + '</p>\
                    </a>\
                </li>';
            sumNewItemsHtml += newItemHtml;
            imageIndex.val++;
            numImagesLoadedSoFar++;
        }
        
        var $nextGroupHtml = $('<div/>').html(sumNewItemsHtml).contents().css('opacity', 0);
        console.log("numImagesLoadedSoFar: " + numImagesLoadedSoFar);
        return $nextGroupHtml;
    };
    
    // callback for xhr from ajaxTiles()
    var handleAlbumJson = function(album) {
        albumCount = album.count;
        $('body').spin('modal');

        globalAlbum = album;
        
        console.log('in callback handleAlbumJson');

        $initialTiles = getGroupOfTiles(imageIndex.val, 5);
        $container.append($initialTiles);
    
        $container.imagesLoaded(container, function () {
            console.log('imagesLoaded in handleAlbumJson');
            //$(image.img).closest('li').removeClass('tile-loading');
            $('#gallery-container li').removeClass('tile-loading');
            wookmark = new Wookmark(container, {
                offset: 5, // Optional, the distance between grid items
                outerOffset: 10, // Optional, the distance to the containers border
                itemWidth: 310 // Optional, the width of a grid item
            });
            wookmark.initItems();
            wookmark.layout(true, function () {
                // Fade in items after layout
                setTimeout(function() {
                    $('#gallery-container li').css('opacity', 1);
                }, 300);
                setTimeout(function() {
                    $('body').spin('modal');
                }, 400);
            });
        }).progress(function (instance, image) {
            console.log('progress');
        });
        $('body').stop('modal');
    };
    
    var ajaxTiles = function() {
        console.log('in ajaxTiles');
        
        var dataAlbumId = $('#main').attr('data-album-id');
        
        var ajaxOptions = {
            type : 'GET',
            dataType : 'json',
            url : './index.php',
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
