<?php
/**
 * Created by PhpStorm.
 * User: zhalnin
 * Date: 27/07/14
 * Time: 20:36
 */

namespace dmn\view\utils;
error_reporting( E_ALL & ~E_NOTICE );
//require_once( "imei_service/base/Registry.php" );
use dmn\base\SessionRegistry;


    $enter = SessionRegistry::getSession('auto');
    $login = SessionRegistry::getSession('login');
//echo "<tt><pre>".print_r( $enter , true ) ."</pre></tt>";
    if( intval( $enter ) === 1 ) {
        ?>

        <ul id="login-wrap">
            <li>
                <a id="login-nav" class="login-globalNavLink login-elem" href="#">
                    <span class="nav-link login-elem">
                        <img class="login-avatar" width="26" height="26" title="alezhal" alt="alezhal" data-random="11237289575920228" data-height="26" data-username="alezhal" data-avatarid="1316" src="imei_service/view/files/login/avatar/26_rounded.png">
                        <span class="login-user-name login-username-navLabel">Добро пожаловать, <?php print $login; ?></span>
                    </span>
                </a>
                |
                <a href="?cmd=Logout">Выйти</a>
                <div id="j-satNav-menu" class="clearfix" style="display:none;"></div>
            </li>
        </ul>

    <?php
    } else {
        ?>

        <ul id="login-wrap">
            <li>
                <ul id="login-nav">
                    <li class="welcome-guest">Добро пожаловать, Гость</li>
                    <li class="login">
                        |
                        <a title="Login" href="?cmd=Login">Войти</a>
                    </li>
                </ul>
                <div id="j-satNav-menu" class="clearfix" style="display:none;"></div>
            </li>
        </ul>

    <?php

    }
?>
