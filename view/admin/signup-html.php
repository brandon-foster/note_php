<?php
$usersTableSet = isset($usersTable);
if ($usersTableSet == false) {
    trigger_error('Oops: view/admin/signup-html.php needs a UsersTable object $userTable.');
}
$signupMessageSet = isset($signupMessage);
$emailSet = isset($email);
$usernameSet = isset($username);
if ($signupMessageSet === false) {
    $signupMessage = '';
}
if ($emailSet === false) {
    $email = '';
}
if ($emailSet === false) {
    $username = '';
}

// set title
$pageData->setTitle('Sign Up');
// set body class
$pageData->setBodyClass('body-sign-up');
// focus on appropriate input field

// $jsCode = "";
// $pageData->addScriptCode();

if (isset($_POST['signup'])) {
    $email = $_POST['email'];
    $username = $_POST['username'];
    $password = $_POST['password'];

    // check if email exists
    $emailExists = $usersTable->emailExists($email);
    if ($emailExists) {
        // send back to sign up page
        $signupMessage = "<p class='signup-message'>Email address <em>{$email}</em> already exists</p>";
        $page = 'signup-html';
    }
    else {
        // so far so good.
        // now, check if username exists
        $usernameExists = $usersTable->usernameExists($username);
        if ($usernameExists) {
            // send back to sign up page
            $signupMessage = "User <em>{$username}</em> already exists";
            $page = 'signup-html';
        }
        else {
            // so far so good.
            // now, create new user
            $usersTable->createUser($username, $password, $email);
            $page = 'signup-success-html';
        }
    }
}

$emailInput = "
    <div class='row collapse'>
        <div class='small-2 columns'>
            <span class='prefix'><i class='fi-mail'></i> <em class='required'></em></span>
        </div>
        <div class='small-10  columns'>
            <input type='text' name='email' value='{$email}' placeholder='email' required />
        </div>
    </div>";

$out = "
<!-- view/admin/login-html.php depends on css/admin/login.css -->
<div class='row center'>
        <div class='signup-panel'>
            <p class='welcome'>Sign Up</p>
            {$signupMessage}
            <form action='admin.php?page=signup' method='POST'>
                {$emailInput}
                <div class='row collapse'>
                    <div class='small-2 columns'>
                        <span class='prefix'><i class='fi-torso'></i> <em class='required'></em></span>
                    </div>
                    <div class='small-10  columns'>
                        <input type='text' name='username' value='{$username}' placeholder='username' required />
                    </div>
                </div>
                <div class='row collapse'>
                    <div class='small-2 columns '>
                        <span class='prefix'><i class='fi-lock'></i> <em class='required'></em></span>
                    </div>
                    <div class='small-10 columns '>
                        <input type='password' name='password' placeholder='password' required />
                    </div>
                </div>
                <input type='submit' name='signup' value='Sign up' class='button' />
            </form>
            <p>Already have an account? <a href='admin.php'>Log in</a></p>
        </div>
</div>";

return $out;
