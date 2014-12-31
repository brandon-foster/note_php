<?php
// unset user's session
unset($_SESSION['user']);
redirect('admin.php?page=login');
