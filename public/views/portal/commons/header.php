<?php
echo    '<header>
        <a href="/dashboard"><img src="public/assets/logo-full-portal.svg" alt="logo"></a>
        <div id="search-bar">
            <img src="public/assets/search-icon.svg" alt="Search icon">
            <input placeholder="Type here for search">
        </div>
        <div id="name">
            <a href="/account">';
         if(isset($messages)){
                    echo $messages['username'];
                } else{
                    echo "Unknown user";
                }
    
echo    '<img src="public/assets/account-icon.svg" alt="account icon"></a>
        </div>
        <div id="log-out">
            <a href="/logout">Log out<img src="public/assets/log-out-icon.svg" alt="logout icon"></a>
        </div>
    </header>';

?>
