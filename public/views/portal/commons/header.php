<?php
echo    '<header>
        <a id="logo" href="/dashboard"><img class="desktop" src="public/assets/logo-full-portal.svg" alt="logo"><img class="mobile" src="public/assets/logo-mobile-portal.svg" alt="logo"></a>
        <div id="search-bar">
            <img src="public/assets/search-icon.svg" alt="Search icon">
            <input placeholder="Type here for search">
        </div>
        <div id="name">
            <a href="/account"><span class="desktop">';
         if(isset($messages)){
                    echo $messages['user']->getUsername();
                } else{
                    echo "Unknown user";
                }
    
echo    '</span><img src="public/assets/account-icon.svg" alt="account icon"></a>
        </div>
        <div id="log-out">
            <a href="/logout"><span class="desktop">Log out</span><img src="public/assets/log-out-icon.svg" alt="logout icon"></a>
        </div>
    </header>';

?>
