<?php
$signupResultSet = isset($signupResult);
if ($signupResultSet === false) {
    trigger_error('Oops: view/admin/signup-success-html.php needs $signupResult.');
}
return "
<h1>Sign Up Success</h1>
<p>
    {$signupResult}
</p>";
