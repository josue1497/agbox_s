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

    public static function set_user_session_data($user_record){
		Session::getNdelete('log_out');
		Session::set('logged_in',true);
		Session::set('user_id',$user_record['id_usuario']);
		Session::set('user_email',$user_record['nombre_usuario']);
		Session::set('role_id',$user_record['id_nivel_usuario']);
    }

    public static function unset_user_session_data(){
		Session::set('log_out',true);
		Session::getNdelete('logged_in');
		Session::getNdelete('user_id');
		Session::getNdelete('role_id');
		Session::getNdelete('user_email');
    }

}
?>