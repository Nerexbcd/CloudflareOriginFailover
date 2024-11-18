<?php

class Permissions {
    public static function setup() {
        $link = connectBD();
        $numUser = $link->query('SELECT COUNT(*) FROM User')->fetch()[0];
        unset($link);
        return $numUser == 0;
    }

    public static function admin() {
        return true;
        return isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true && $_SESSION['userData']['role'] == "admin";
    }

    public static function ownUser($id) {
        return true;
        return isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true && ($_SESSION['userData']['role'] == "admin" || $_SESSION['userData']['id'] == $id);
    }

    public static function user() {
        return true;
        return isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true;
    }

    public static function noLoggedIn() {
        return !isset($_SESSION['loggedin']) && $_SESSION['loggedin'] != true;
    }
}
?>