<?php
$out = "
<!-- view/admin/login-html.php depends on css/admin/login.css -->
<div class='row center'>
        <div class='signup-panel'>
            <p class='welcome'>Log In</p>
            <form action='admin.php' method='POST'>
                <div class='row collapse'>
                    <div class='small-2 columns'>
                        <span class='prefix'><i class='fi-torso'></i> <em class='required'></em></span>
                    </div>
                    <div class='small-10  columns'>
                        <input type='text' name='username' placeholder='username' required />
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
