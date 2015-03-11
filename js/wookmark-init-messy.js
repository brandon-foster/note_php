(function ($) {
    // Instantiate wookmark after all images have been loaded
    var wookmark;
    var container = '#gallery-container';
    var $container = $(container);
    var $window = $(window);
    var $document = $(document);
    var imageIndex = { val : 0 };
    var globalAlbum = '';

    /**
     * When scrolled all the way to the bottom, add more tiles
     */
    var onScroll = function() {
        // Check if we're within 100 pixels of the bottom edge of the broser window.
        var winHeight = window.innerHeight ? window.innerHeight : $window.height(), // iphone fix
        closeToBottom = ($window.scrollTop() + winHeight > $document.height() - 300);

        if (closeToBottom) {
            // Get the first ten items from the grid, clone them, and add them to the bottom of the grid
            /*var $items = $('li', $container),
            $firstTen = $items.slice(0, 10).clone().css('opacity', 0);
            $container.append($firstTen);*/
            var $nextGroupHtml = getGroupOfTiles(imageIndex.val, 5);
            $container.append($nextGroupHtml);
            
            $container.imagesLoaded(container, function () {
                console.log('imagesLoaded');
                //$('li').removeClass('tile-loading');

                //wookmark.updateOptions();
            }).progress(function (instance, image) {
                $(image.img).closest('li').removeClass('tile-loading');
                wookmark.updateOptions();
            });
            
            wookmark = new Wookmark(container, {
                offset: 5, // Optional, the distance between grid items
                outerOffset: 10, // Optional, the distance to the containers border
                itemWidth: 210 // Optional, the width of a grid item
            });
            wookmark.initItems();
            wookmark.layout(true, function () {
                // Fade in items after layout
                setTimeout(function() {
                    $('#gallery-container li').css('opacity', 1);
                }, 300);
            });
            
            /*imagesLoaded(container, function () {
                console.log('imagesLoaded');
                wookmark = new Wookmark(container, {
                    offset: 5, // Optional, the distance between grid items
                    outerOffset: 10, // Optional, the distance to the containers border
                    itemWidth: 210 // Optional, the width of a grid item
                });
                
                $('li').removeClass('tile-loading');
                wookmark.updateOptions();
            });*/
            /*
            wookmark.initItems();
            wookmark.layout(true, function () {
                // Fade in items after layout
                setTimeout(function() {
                    $nextGroupHtml.css('opacity', 1);
                }, 300);
            });
            */
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
        for (var i = 0; i < stepSize && imageIndex.val < globalAlbum.images.length; i++) {
            var location = 'img/gallery/' + albumDir + '/' + encodeURIComponent(images[imageIndex.val].name);
            newItemHtml = '\
                <li class="tile-loading">\
                    <a href=' + location + ' class="fancybox" data-fancybox-group="gallery" title="title here">\
                        <img src="' + location + '"><p>' + albumDate + '</p>\
                    </a>\
                </li>';
            sumNewItemsHtml += newItemHtml;
            imageIndex.val++;
            //$container.append(newItemHtml);
        }
        
        /*
        $container.imagesLoaded()
        .always(function () {
            console.log('always');
        })
        .progress(function (instance, image) {
            $(image.img).closest('li').removeClass('tile-loading');
            wookmark.updateOptions();
        });
        */
        var $nextGroupHtml = $('<div/>').html(sumNewItemsHtml).contents().css('opacity', 0);

        return $nextGroupHtml;
    };
    
    // callback for xhr from ajaxTiles()
    var handleAlbumJson = function(album) {
        globalAlbum = album;
        
        console.log('in callback');

        $initialTiles = getGroupOfTiles(imageIndex.val, 10);
        $container.append($initialTiles);
    
        $container.imagesLoaded(container, function () {
            console.log('imagesLoaded');
            //$('li').removeClass('tile-loading');

            //wookmark.updateOptions();
        }).progress(function (instance, image) {
            $(image.img).closest('li').removeClass('tile-loading');
            wookmark = new Wookmark(container, {
                offset: 5, // Optional, the distance between grid items
                outerOffset: 10, // Optional, the distance to the containers border
                itemWidth: 210 // Optional, the width of a grid item
            });
            wookmark.initItems();
            wookmark.layout(true, function () {
                // Fade in items after layout
                setTimeout(function() {
                    $('#gallery-container li').css('opacity', 1);
                }, 300);
            });
        });
        /*.done(function() {
            $('li').removeClass('tile-loading');
            wookmark.updateOptions();
        });*/
        
        /*// Initialize Wookmark
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
            $(image.img).closest('li').removeClass('tile-loading');
            wookmark.updateOptions();
        });*/
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
