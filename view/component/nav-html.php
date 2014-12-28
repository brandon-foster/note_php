<?php
return "
<!-- see /js/nav.js -->
<div id='main-nav-row' class='contain-to-grid fixed'>

    <nav class='top-bar' data-topbar>
        <ul class='title-area'>
            <li class='name'>
                <h1>
                    <a href='/'>Login App</a>
                </h1>
            </li>
            <!-- Remove the class 'menu-icon' to get rid of menu icon. Take out 'Menu' to just have icon alone -->
            <li class='toggle-topbar menu-icon'><a href='#'><span>Menu</span></a></li>
        </ul>

        <section class='top-bar-section'>
            <!-- Left Nav Section -->
            <ul class='left'>
                <li id='link-photos' class='has-dropdown'><a
                    href='/index.php?page=photos'>Photos</a>
                    <ul class='dropdown'>
                        <li id='link-five-days-gratitude'><a
                            href='index.php?page=photos&album=five-days-gratitude'>Five
                                Days of Gratitude</a></li>
                        <li id='link-vt-freshman-fall'><a
                            href='index.php?page=photos&album=vt-freshman-fall'>VT
                                Freshman Fall</a></li>
                        <!-- <li class='has-dropdown'><a href='#'>Second link
                                in dropdown</a>
                            <ul class='dropdown'>
                                <li><a href='#'>aaha yes</a></li>
                                <li class='has-dropdown'><a href='#'>nested
                                        dropdown</a>
                                    <ul class='dropdown'>
                                        <li><a
                                            href='nested-dropdown.php'>nested
                                                inception</a></li>
                                        <li><a href='#'>nested inception
                                                2</a></li>
                                    </ul></li>
                                <li><a href='#'>aaha yes</a></li>
                            </ul></li> -->
                    </ul></li>

                <li id='link-contact'><a href='/index.php?page=contact'>Contact</a></li>

            </ul>

        </section>
    </nav>
</div>
<div class='spacer'></div>";
