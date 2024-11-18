<?php
    function RandomString($length) {
        $keys = array_merge(range('a', 'z'), range('A', 'Z'));
        $key = '';
        for($i=0; $i < $length; $i++) {
            $key .= $keys[array_rand($keys)];
        }
        return $key;
    }

    function RandomPassword($length) {
        $keys = array_merge(range('a', 'z'), range('A', 'Z'), range(0,10));
        $password = '';
        for($i=0; $i < $length; $i++) {
            $password .= $keys[array_rand($keys)];
        }
        return $password;
    }
?>