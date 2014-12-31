<?php
// if signup fails, show message and fill in email and username with previously
// submitted values
if (!isset($loginMessage)) {
    $loginMessage = '';
}
if (!isset($username) || !$usernameExists) {
    $username = '';
}

// set title
$pageData->setTitle('Log In');
// set body class
$pageData->setBodyClass('body-log-in');
// add css
$pageData->addCss('res/foundation-icons/foundation-icons.css');
$pageData->addCss('css/admin/pretty-form.css');
// javascript input focus code (added to $pageData before return'ed)
// focus on username by default
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

$out = "
<!-- view/admin/login-html.php depends on css/admin/login.css -->
<div class='row center'>
        <div class='signup-panel'>
            <p class='welcome'>Log In</p>
            {$loginMessage}
            <form action='admin.php' method='POST'>
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
                <input type='submit' name='login' value='Log in' class='button' />
            </form>
            <p>Don't have an account? <a href='admin.php?page=signup'>Sign up</a></p>
        </div>
</div>";

return $out;
