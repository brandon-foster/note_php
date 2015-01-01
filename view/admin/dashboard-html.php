<?php
$userSet = isset($user);
if ($user === false) {
    trigger_error('Oops: view/admin/dashboard-html.php needs $user.');
}

// set title
$pageData->setTitle('dashboard');
// set body class
$pageData->setBodyClass('body-dashboard');
// add css
$pageData->addCss('res/foundation-icons/foundation-icons.css');
$pageData->addCss('css/admin/pretty-form.css');
// javascript input focus code (added to $pageData before return'ed)
// focus on username by default
$jsFocusCode = '$("input[name=username]").focus();';

// handle image upload submission
if (isset($_POST['userimage'])) {
    
}

$pageData->addScriptCode($jsFocusCode);

$out = "
<div class='row center'>
    <div class='signup-panel'>
        <p class='welcome'>Upload Photo</p>
        <form action='admin.php?page=dashboard' method='POST' enctype='multipart/form-data'>
            <div class='row collapse'>
                <div class='small-12  columns'>
                    <input type='file' name='userimage' required />
                </div>
            </div>
            <!--<div class='row collapse'>
                <div class='small-2 columns '>
                    <span class='prefix'><i class='fi-lock'></i> <em class='required'></em></span>
                </div>
                <div class='small-10 columns '>
                    <input type='password' name='password' placeholder='password' required />
                </div>
            </div>-->
            <input type='submit' name='upload' value='Upload' class='button' />
        </form>
    </div>
</div>";

return $out;
