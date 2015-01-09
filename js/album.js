(function ($){
  var $tiles = $("#tiles"),
      $handler = $("li", $tiles),
      $main = $("#main"),
      $window = $(window),
      $document = $(document),
      options = {
        autoResize: true, // This will auto-update the layout when the browser window is resized.
        container: $main, // Optional, used for some extra CSS styling
        offset: 20, // Optional, the distance between grid items
        itemWidth:280 // Optional, the width of a grid item
      };
//  /**
//   * Reinitializes the wookmark handler after all images have loaded
//   */
//  function applyLayout() {
//    // keep track of which image is being loaded
//    var iteration = 1;
//    // store the number of images in the album
//    //var size = $("#main").attr("data-size");        
//    
//    $tiles.imagesLoaded()
//        .progress( function( instance, image ) {            
//            // only every other iteration
//            if (iteration % 2 === 0) {
//                //var result = image.isLoaded ? "loaded" : "broken";
//
////                var percentage = (iteration / size) * 100;
////                percentage = Math.round(percentage);
////                $("#loading-progress-meter.meter").css("width", percentage + "%");
//
//                $("#tiles li:eq(" + (iteration - 1) + ")").css("display", "block");
//            }
//
//            iteration++;
//        })
//        .done(function( instance ) {
//            // remove the #loading-info-row
////            $("#loading-info-row").remove();
//
//            // Destroy the old handler
//            if ($handler.wookmarkInstance) {
//                $handler.wookmarkInstance.clear();
//            }
//            
//            // Create a new layout handler.
//            $handler = $("li", $tiles);
//            $handler.wookmark(options);
//        });
//  }

//  /**
//   * When scrolled all the way to the bottom, add more tiles
//   */
//  function onScroll() {
//    // Check if we"re within 100 pixels of the bottom edge of the browser window.
//    var winHeight = window.innerHeight ? window.innerHeight : $window.height(), // iphone fix
//        closeToBottom = ($window.scrollTop() + winHeight > $document.height() - 100);
//
//    if (closeToBottom) {
//      // Get the first then items from the grid, clone them, and add them to the bottom of the grid
//      var $items = $("li", $tiles);
//      var $firstTen = $items.slice(0, 10);
//      $tiles.append($firstTen.clone());
//
//      applyLayout();
//    }
//  };
  
  /*
   * helper function for makeTiles()
   */
  function massageAlbumData(album) {
      var albumSize = album.count;
      var albumDate = album.date;
      var albumName = album.name;
      var albumDir = album.directory;
      var images = album.images;
      console.log(albumSize);
      console.log(albumDate);
      console.log(albumName);
      console.log(albumDir);
      
      var tileItemsHtml = '';
      
      for (var i = 0; i < albumSize; i++) {
          var location = 'img/gallery/' + albumDir + '/' + images[i].name;
          console.log(location);
          
          var tile = "\
          		<li>\
                  <a href='" + location + "' class='fancybox' data-fancybox-group='gallery' title='title here'>\
                      <img src='" + location + "' width='282' height='118'>\
                  </a>\
                  <div class='post-info'>\
                      <div class='post-basic-info'>\
                          <h3><a href='#'>Animation films</a></h3>\
                          <span><a href='#'><label> </label>Movies</a></span>\
                          <p>Lorem Ipsum is simply dummy text of the printing & typesetting industry.</p>\
                      </div>\
                \
                  </div>\
                </li>";
          
          // append tile to tiles
          tileItemsHtml += tile;
      }
      
        $('#tiles').html(tileItemsHtml);
      
        $handler = $("li", $tiles);
        $handler.wookmark(options);
        
        console.log(tileItemsHtml);
      
        console.log(album);
//      var images = data.images;
//      
//      for (var i = 0; i < images.length; i++) {
//          console.log(images[i]);
//      }
  }
  
  function makeTiles() {
            
      $.ajax({
          type : 'GET',
          dataType : 'json',
          url : '/index.php',
          data : {
              'api' : 'album-json',
              'album-id' : $('#main').attr('data-album-id')
          }
      }).done(massageAlbumData);
  }

  // Call the layout function for the first time
  //applyLayout();

  // Capture scroll event.
  // $window.bind("scroll.wookmark", onScroll);
  
  makeTiles();
})(jQuery);
