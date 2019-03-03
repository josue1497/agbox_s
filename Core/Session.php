<?php
class Session {
    public static function check($key) {
        $result = FALSE;
        if (isset($_SESSION[$key])) {
            $result = TRUE;
        }
        return $result;
    }
    public static function get($key) {
        $result = NULL;
        if (self::check($key)) {
            $result = $_SESSION[$key];
        }
        return $result;
    }
    public static function getNdelete($key) {
        $result = self::get($key);
        self::delete($key);
        return $result;
    }
    public static function set($key, $value) {
        $_SESSION[$key] = $value;
    }
    public static function delete($key) {
        if (self::check($key)) {
            unset($_SESSION[$key]);
        }
    }
}
?>