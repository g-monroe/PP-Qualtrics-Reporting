<?php

define("HOME_URL", "http://rise.hs.iastate.edu/");

define("DASH_URL", "p-p/dashboard/");

define("VERSION", "vdev/");

define("MAIN_DIR", "main/");
define("ASSETS", "app-assets/");
define("ROOT", $_SERVER['DOCUMENT_ROOT']."/p-p/");
define("LIBRARY_DIR", ROOT . ASSETS . MAIN_DIR . VERSION. "library/");
define("HOMEURL", "HOMEURL");
define("PHP_LIBS", ROOT . ASSETS . MAIN_DIR . VERSION . "php/libs/");
/**

 * Library Definitions

 */

define("MODEL_DIR", LIBRARY_DIR . "model/");

define("VIEW_DIR", LIBRARY_DIR . "view/");

define("CONTROLLER_DIR", LIBRARY_DIR . "controller/");

/**

 * Template Engine Definitions

 */

define("TEMPLATE_DIR", LIBRARY_DIR . "template/");

define("TEMPLATE", TEMPLATE_DIR . "template.htm");

define("TEMPLATE_COMPONENTS_DIR", TEMPLATE_DIR . "components/");



define("META", TEMPLATE_COMPONENTS_DIR . "meta.php");

define("LINK", TEMPLATE_COMPONENTS_DIR . "link.php");

define("SCRIPT", TEMPLATE_COMPONENTS_DIR . "script.php");

define("HEADER", TEMPLATE_COMPONENTS_DIR . "header.php");

define("FOOTER", TEMPLATE_COMPONENTS_DIR . "footer.php");

define("SIDEBAR", TEMPLATE_COMPONENTS_DIR . "sidebar.php");

if (defined('CONFIG')){

    if (strpos(CONFIG,"ERRLOG") !== false){

        ini_set('display_errors', 1);

        ini_set('display_startup_errors', 1);

        error_reporting(E_ALL);

    }

    //Unless we absolutely need the database we don't want to declare these private variables.

    if (strpos(CONFIG,"DATABASE") !== false){



        /* SPIDER/DORK detection protection

         * To quit spiders from snooping around the directories and trying to find the database file we can use a password like directory name

         * Spiders or snoopers try to guess folder locations along with un-protected directory listings to help build knowledge about the back-end

         * If they get this knowledge they can easily can permission or even try to crack admin/root login.

         */

        define("DBCON_FOLDER", "randomSecureString");



        /* BRUTEFORCE File creation and protection

         * A password which is secure needs to be longer or as long as 48 characters, using random characters along with uncommon words.

         * This password is important since it will be used to check if a right php file has permission to access the database.

         * More details on this subject are here:

         * https://blog.webernetz.net/password-strengthentropy-characters-vs-words/

         */

        define("DBCON_PASS", "secureRandomPassword");



         /* Database Credentials

          * USERNAME

          * PASSWORD

          * HOST

          * TABLE

          * DROP is removed from the user since it's not needed, its also a common standard for security, a separate user with review of

          * drop should be only able to drop.

          */

         define("DB_USER", "USER");

         define("DB_PASS", "PASS");

         define("DB_HOST", "HOST");

         define("DB_TABLE", "main");

    }

    if (strpos(CONFIG,"MAIL") !== false){

        /* SMTP Credentials

         * Host, Port, Security Type, Username, Password

         */

        define("SMTP_HOST", "mailhub");

        define("SMTP_PORT", "587");

        define("SMTP_SECR", "TLS");

        define("SMTP_AUTH", false);
        define("SMTP_USER", "");

        define("SMTP_PASS", "");

    }

}
