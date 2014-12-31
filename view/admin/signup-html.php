<?php
$usersTableSet = isset($usersTable);
if ($usersTableSet == false) {
    trigger_error('Oops: view/admin/signup-html.php needs a UsersTable object $userTable.');
}
// if signup fails, show message and fill in email and username with previously
// submitted values
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
// add css
$pageData->addCss('res/foundation-icons/foundation-icons.css');
$pageData->addCss('css/admin/pretty-form.css');
// javascript input focus code (added to $pageData before return'ed)
// focus on email by default
$jsFocusCode = '$("input[name=email]").focus();';

if (isset($_POST['signup'])) {
    $email = $_POST['email'];
    $username = $_POST['username'];
    $password = $_POST['password'];

    // check if email exists
    $emailExists = $usersTable->emailExists($email);
    if ($emailExists) {
        // send back to sign up page
        $signupMessage = "<p class='failure-message'>Email address <em>{$email}</em> already exists</p>";
        
        // set js to focus on cleared email field
        $jsFocusCode .= '$("input[name=email]").val("");';
        
        $page = 'signup-html';
    }
    else {
        // so far so good.
        // now, check if username exists
        $usernameExists = $usersTable->usernameExists($username);
        if ($usernameExists) {
            // send back to sign up page
            $signupMessage = "<p class='failure-message'>User <em>{$username}</em> already exists</p>";

            $jsFocusCode = '$("input[name=username]").focus();';
            $jsFocusCode .= '$("input[name=username]").val("");';
            
            $page = 'signup-html';
        }
        else {
            // so far so good.
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
}

// set js focus script
$pageData->addScriptCode($jsFocusCode);

$emailInput = "
    <div class='row collapse'>
        <div class='small-2 columns'>
            <span class='prefix'><i class='fi-mail'></i> <em class='required'></em></span>
        </div>
        <div class='small-10  columns'>
            <input type='email' name='email' value='{$email}' placeholder='email' required />
        </div>
    </div>";

$out = "
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