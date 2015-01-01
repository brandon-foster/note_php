<?php
// handle already logged in user
if (isset($_SESSION['user'])) {
    // send to dashboard
    redirect('admin.php?page=dashboard');
}

if (isset($_POST['signup'])) {
    $email = $_POST['email'];
    $username = $_POST['username'];
    $password = $_POST['password'];

    include_once 'model/table/UsersTable.class.php';
    $usersTable = new UsersTable($db);

    $emailExists = $usersTable->emailExists($email);
    $usernameExists = $usersTable->usernameExists($username);

    $signupMessage = '';
    if ($emailExists && $usernameExists) {
        // send back to sign up page
        $signupMessage .= "
            <p class='failure-message'>Email address <em>{$email}</em> and 
            username <em>{$username}</em> already exist.</p>";

        // clear email field
        $jsFocusCode = '$("input[name=email]").val("");';
        // clear username field
        $jsFocusCode .= '$("input[name=username]").val("");';
        // focus on email field
        $jsFocusCode .= '$("input[name=email]").focus();';
    }
    // check if only the email exists
    else if ($emailExists) {
        // send back to sign up page
        $signupMessage .= "<p class='failure-message'>Email address <em>{$email}</em> already exists.</p>";

        // clear email field
        $jsFocusCode = '$("input[name=email]").focus();';
        // focus on email field
        $jsFocusCode .= '$("input[name=email]").val("");';
    }
    // check if only the username exists
    else if ($usernameExists) {
        // send back to sign up page
        $signupMessage .= "<p class='failure-message'>User <em>{$username}</em> already exists.</p>";

        // focus on username input
        // clear username input
        $jsFocusCode = '$("input[name=username]").focus();';
        $jsFocusCode .= '$("input[name=username]").val("");';
    }
    // check that all fields are filled out
    else if (strlen($email) === 0 || strlen($username) === 0 || strlen($password) === 0) {
        // send back to sign up page
        $signupMessage .= "
            <p class='failure-message'>Please enter all required fields.</p>";
        
        if (strlen($password) === 0) {
            // focus on password
            $jsFocusCode = '$("input[name=password]").focus();';
        }
        if (strlen($username) === 0) {
            // focus on password
            $jsFocusCode = '$("input[name=username]").focus();';
        }
        if (strlen($email) === 0) {
            // focus on email
            $jsFocusCode = '$("input[name=email]").focus();';
        }
    }
    // now, check that the password is reasonable
    else if (strlen($password) < 1) {
        $signupMessage .= "<p class='failure-message'>Password must be at least one character long.</p>";
        $jsFocusCode = '$("input[name=password]").focus();';
    }
    else {
        // so far so good
        // now, create new user
        $successBool = $usersTable->createUser($username, $password, $email);
        if ($successBool) {
            // get the newly created user
            $user = $usersTable->getUserByName($username);
        
            // unset user's hash and salt
            unset($user['hash']);
            unset($user['salt']);
        
            // set the user in the session
            $_SESSION['user'] = $user;
        
            // redirect to dashboard
            redirect('admin.php?page=dashboard');
        }
    }
}

$signupOut = include_once "view/admin/signup-html.php";
return $signupOut;
