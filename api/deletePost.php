<?php

function makeMessageJson($message) {
    $messageArray = array(
    	'message' => $message
    );
    $messageJson = json_encode($messageArray);
    return $messageJson;
}

function makeResponseJson($title) {
    $respArray = array(
    	'title' => $title
    );
    $titleJson = json_encode($respArray);
    return $titleJson;
};

/*
 * Send a json response
 */
function sendJsonReponse($responseJson) {
    header("Content-Type: application/json");
    echo $responseJson;
}

// get a list of all the images in the album
if (isset($_GET['postId'])) {

    // get the post id
    $postId = $_GET['postId'];
    
    include_once 'model/table/PostsTable.class.php';
    $postsTable = new PostsTable($db);
    $post = $postsTable->getPostById($postId);

    // check if the post exists
    if ($post) {
        // delete post
        $postsTable->deletePostById($postId);
        
        // decrement category count
        $categoryId = $postsTable->getCategoryIdByPostId($postId);        
        include_once 'model/table/PostCategoriesTable.class.php';
        $postCategoriesTable = new PostCategoriesTable($db);
        $postCategoriesTable->decrementCount($categoryId);
        
        $responseJson = makeResponseJson($post['title']);
        sendJsonReponse($responseJson);
    }
    
    // post does not exist
    else {
        $errorMessageJson = makeMessageJson("post does not exist");
        sendJsonReponse($errorMessageJson);
    }

}

// album-id query param not set
else {
    $errorMessageJson = makeErrorJson("album-id query parameter not set");
    sendJsonReponse($errorMessageJson);
}
