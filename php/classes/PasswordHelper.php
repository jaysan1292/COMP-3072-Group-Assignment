<?php
class PasswordHelper {
    static function encryptPassword($plaintext) {
        return hash('sha256', $plaintext);
    }

    static function checkPassword($plaintext, $encrypted) {
        $hash = PasswordHelper::encryptPassword($plaintext);
        return $hash == $encrypted;
    }
}
