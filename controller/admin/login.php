<?php
// handle already logged in user
if (isset($_SESSION['user'])) {
    // send to dashboard
    redirect('admin.php?page=dashboard');
}

$pageData->addCss('res/foundation-icons/foundation-icons.css');
$pageData->addCss('css/admin/login-signup.css');

// javascript input focus code (added to $pageData before include)
$jsFocusCode = '$("input[name=username]").focus();';

// handle form submission
if (isset($_POST['login'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];
    
    include_once 'model/table/UsersTable.class.php';
    $usersTable = new UsersTable($db);
    
    // check if username exists
    if ($usersTable->usernameExists($username)) {
        // so far so good, validate login
        $checkLogin = $usersTable->validateLogin($username, $password);
        if ($checkLogin === true) {
                // get the user who's logging in
                $user = $usersTable->getUserByName($username);

                // unset user's hash and salt
                unset($user['hash']);
                unset($user['salt']);

                // set the user in the session
                $_SESSION['user'] = $user;

                // redirect to dashboard
                redirect('admin.php?page=dashboard');
        } else {
            $loginMessage = "<p class='failure-message'>Oops. Wrong password. Try again.</p>";
            
            // set js to focus on password field
            $jsFocusCode = '$("input[name=password]").focus();';

            $usernameExists = true;
        }
    }
    // username does not exists
    else {
        $loginMessage = "<p class='failure-message'>Username <em>{$username}</em> does not exist.</p>";
        
        // clear username field
        $jsFocusCode .= '$("input[name=username]").val("");';

        $usernameExists = false;
    }
}

// set js focus script
$pageData->addScriptCode($jsFocusCode);

$loginOut = include_once 'view/admin/login-html.php';
return $loginOut;
