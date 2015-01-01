<?php
// handle already logged in user
if (isset($_SESSION['user'])) {
    // send to dashboard
    redirect('admin.php?page=dashboard');
}

// handle form submission
if (isset($_POST['login'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    include_once 'model/table/UsersTable.class.php';
    $usersTable = new UsersTable($db);

    $loginMessage = '';
    // check if username does not exists
    // check that all fields are filled out
    if (strlen($username) === 0 && strlen($password) === 0) {
        // send back to sign up page
        $loginMessage .= "
            <p class='failure-message'>Please enter your username and password.</p>";
    
        if (strlen($password) === 0) {
            // focus on password
            $jsFocusCode = '$("input[name=password]").focus();';
        }
        if (strlen($username) === 0) {
            // focus on username
            $jsFocusCode = '$("input[name=username]").focus();';
        }
    }
    // check if only the username was empty
    else if (strlen($username) === 0) {
        // send back to sign up page
        $loginMessage .= "
            <p class='failure-message'>Please enter your username.</p>";
        // focus on username
        $jsFocusCode = '$("input[name=username]").focus();';
    }
    // now we know the username was not empty, but let's check if it exists
    else if (!$usersTable->usernameExists($username)) {
        $loginMessage = "<p class='failure-message'>Username <em>{$username}</em> does not exist.</p>";
    
        // focus on username
        // clear username field
        $jsFocusCode = '$("input[name=username]").focus();';
        $jsFocusCode .= '$("input[name=username]").val("");';
    }
    // check if only password was empty
    else if (strlen($password) === 0) {
        // send back to sign up page
        $loginMessage .= "
            <p class='failure-message'>Please enter your password.</p>";
        // focus on username
        $jsFocusCode = '$("input[name=password]").focus();';
    }
    // so far so good, username does exists
    else {        
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
        }
    }
}

$loginOut = include_once 'view/admin/login-html.php';
return $loginOut;
