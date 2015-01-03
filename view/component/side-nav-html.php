<?php
// if (!isset($secondaryNavItems)) {
//     trigger_error('Oops: view/component side-nav-html.php needs a $sideNavItems.');
// }
$out = "
<div class='small-2 columns'>";
$out .= "
    <ul class='side-nav'>
      <li class='active'><a href='#'>Nav Item 1</a></li>
      <li><a href='#'>Nav Item 2</a></li>
      <li><a href='#'>Nav Item 3</a></li>
      <li><a href='#'>Nav Item 4</a></li>
    </ul>";
$out .= "
</div>";
return $out;
