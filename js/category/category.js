(function(yourcode) {
    // the global jQuery object is passed as a parameter
    yourcode(window.jQuery, window, document);
}(function($, window, document) {
    // the $ is now locally scoped
    
    // listen for the jQuery ready event on the document
    $(function() {
       // the DOM is ready
        $('#category-posts').on('click', '.delete-post', function(event) {
            // get postId
            var postId = $(this).attr('data-post-id');
            
            var $deleteButton = $(this);
            
            // make ajax call
            deletePostAjax(postId).done(function(data) {
                // delete row enclosing the post and display a nice message
                deleteRow($deleteButton, data);
                
                // update the quantity description
                updateQuantityDescription();
            });
        });
    });
    
    // the rest of the code goes here
    
    // delete the row enclosing the delete button that was clicked, and show and fade the message
    var deleteRow = function($deleteButton, data) {
        var title = data.title;
        
        var $row = $deleteButton.closest('.row');
        var $message = $('<div class="message">post <strong><em>' + title + '<em></strong> deleted</div>').insertBefore($row);
        $row.remove();
        $message.fadeOut(1400);
    };
    
    // update the text on the page that says "There are 99 posts..."
    var updateQuantityDescription = function() {
        var quantity = parseInt($('span#quantity').text(), 10);
        quantity--;
        
        var isOrAre = '';
        var postOrPosts = '';
        if (quantity === 1) {
            isOrAre = 'is';
            postOrPosts = 'post';
        } else {
            isOrAre = 'are';
            postOrPosts = 'posts';
        }
        
        var newQuantityDescription = isOrAre + ' <span id="quantity">' + quantity + '</span> ' + postOrPosts;
        $('span#quantity-description').html(newQuantityDescription);
    };
    
    // send request to delete post with id postId
    var deletePostAjax = function(postId) {
        var ajaxOptions = {
            type : 'GET',
            dataType : 'json',
            // request looks like /index.php?api=deletePost&postId=99
            url : '/index.php',
            data : {
                'api' : 'deletePost',
                'postId' : postId,
            }
        };
        
        return $.ajax(ajaxOptions);
    };

}));