<?php

include_once 'model/table/PostsTable.class.php';
$postsTable = new PostsTable($db);

include_once 'model/table/PostCategoriesTable.class.php';
$postCategoriesTable = new PostCategoriesTable($db);

// handle edit submission
if (isset($_POST['delete-posts'])) {
	
	if (isset($_POST['postsToDelete'])) {
		$postsToDelete = $_POST['postsToDelete'];
		
		if (count($postsToDelete) != 0) {
			$length = count($postsToDelete);
			$numDeleted = 0;
			for ($i = 0; $i < $length; $i++) {
				$id = $postsToDelete[$i];
				$postsTable->deletePostById($id);
					
				// decrement count for post_categories table
				$categoryId = $postsTable->getCategoryIdByPostId($id);
				$postCategoriesTable->decrementCount($categoryId);
				$numDeleted++;
			}
		
			$postOrPosts = StringFunctions::singularOrPlural("post", $numDeleted);
			$deleteMessage = "<p class='failure-message'>Deleted {$numDeleted} {$postOrPosts}.</p>";
		}
	}
	
	// no posts checked to delete
	else {
		$deleteMessage = "<p class='failure-message'>No posts selected to delete.</p>";
	}
}

// get all quotations    
// provide view with $postRows
$postRows = $postsTable->getPostsListing();

$out = include_once 'view/admin/delete-posts-html.php';
return $out;
