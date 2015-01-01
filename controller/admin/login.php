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
    
//     // check that all fields were filled out
//     if (empty($email) || empty($username) || empty($password)) {
//         // send back to sign up page
//         $signupMessage = "
//             <p class='failure-message'>Please enter all required fields.</p>";
    
//         if (empty($password)) {
//             // focus on password
//             $jsFocusCode = '$("input[name=password]").focus();';
//         }
//         if (empty($username)) {
//             // focus on password
//             $jsFocusCode = '$("input[name=username]").focus();';
//         }
//         if (empty($email)) {
//             // focus on email
//             $jsFocusCode = '$("input[name=email]").focus();';
//         }
//     }

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

        // focus on username
        // clear username field
        $jsFocusCode = '$("input[name=username]").focus();';
        $jsFocusCode .= '$("input[name=username]").val("");';

        $usernameExists = false;
    }
}

$loginOut = include_once 'view/admin/login-html.php';
return $loginOut;
