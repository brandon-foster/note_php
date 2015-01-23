<?php
if (!isset($numUsers)) {
    trigger_error('Oops: view/admin/login-html.php needs a $numUsers');
}
// if signup fails, show message and fill in email and username with previously
// submitted values
if (!isset($loginMessage)) {
    $loginMessage = '';
}
if (!isset($username)) {
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
// set default js input focus code
if (!isset($jsFocusCode)) {
    $jsFocusCode = '$("input[name=username]").focus();';
}

// set js focus script
$pageData->addScriptCode($jsFocusCode);

// only show link to sign up if there is no user already in existence in the db
if ($numUsers < 1) {
    $signupLink = "<p>Don't have an account? <a href='admin.php?page=signup'>Sign up</a></p>";
} else {
    $signupLink = '';
}

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
        {$signupLink}
    </div>
</div>";

return $out;
