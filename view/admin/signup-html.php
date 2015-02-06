<?php
// if signup fails, show message and fill in email and username with previously
// submitted values
if (!isset($signupMessage)) {
    $signupMessage = '';
}
if (!isset($email)) {
    $email = '';
}
if (!isset($username)) {
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
if (!isset($jsFocusCode)) {
    $jsFocusCode = '$("input[name=email]").focus();';
}

// set js focus script
$pageData->addScriptCode($jsFocusCode);

$emailInput = "
    <div class='row collapse'>
        <div class='small-2 medium-1 columns'>
            <span class='prefix'><i class='fi-mail'></i> <em class='required'></em></span>
        </div>
        <div class='small-10 medium-11 columns'>
            <input type='email' name='email' value='{$email}' placeholder='email' required />
        </div>
    </div>";

$out = "
<div class='row center'>
        <div class='signup-panel'>
            <h2 class='welcome'>Sign Up</h2>
            {$signupMessage}
            <form action='admin.php?page=signup' method='POST'>
                {$emailInput}
                <div class='row collapse'>
                    <div class='small-2 medium-1 columns'>
                        <span class='prefix'><i class='fi-torso'></i> <em class='required'></em></span>
                    </div>
                    <div class='small-10 medium-11 columns'>
                        <input type='text' name='username' value='{$username}' placeholder='username' required />
                    </div>
                </div>
                <div class='row collapse'>
                    <div class='small-2 medium-1 columns'>
                        <span class='prefix'><i class='fi-lock'></i> <em class='required'></em></span>
                    </div>
                    <div class='small-10 medium-11 columns '>
                        <input type='password' name='password' placeholder='password' required />
                    </div>
                </div>
                <input type='submit' name='signup' value='Sign up' class='button' />
            </form>
            <p>Already have an account? <a href='admin.php'>Log in</a></p>
        </div>
</div>";

return $out;
