<?php
/**
 * clase para gestionar las sesiones de los usuarios, y los datos de sesion
 */
class Session {
	/**
	 * metodo para comprobar si una clave existe en la sesion actual
	 * 
	 * @param type $key 
	 * @return boolean
	 */
    public static function check($key) {
        $result = FALSE;
        if (isset($_SESSION[$key])) {
            $result = TRUE;
        }
        return $result;
    }
    /**
     * metodo para obtener el valor de una clave en la sesion actual 
     * session(clave => valor)
     * 
     * @param type $key 
     * @return valor o null
     */
    public static function get($key) {
        $result = NULL;
        if (self::check($key)) {
            $result = $_SESSION[$key];
        }
        return $result;
    }
	
	/**
	 * metodo para obtener y eliminar un valor de la sesion actual
	 * 
	 * @param type $key 
	 * @return valor o null
	 */
    public static function getNdelete($key) {
        $result = self::get($key);
        self::delete($key);
        return $result;
    }

    /**
     * metodo para establecer el valor a una clave(nueva o no) en la sesion actual
     * 
     * @param type $key 
     * @param type $value 
     * @return void
     */
    public static function set($key, $value) {
        $_SESSION[$key] = $value;
    }

    /**
     * metodo para eliminar una clave de la sesion actual
     * 
     * @param type $key 
     * @return void
     */
    public static function delete($key) {
        if (self::check($key)) {
            unset($_SESSION[$key]);
        }
    }

	/**
	 * metodo para establecer los datos de un usuario logeado en la sesion actual
	 * 
	 * @param type $user_record 
	 * @return type
	 */
    public static function set_user_session_data($user_record){
		Session::getNdelete('log_out');
		Session::set('logged_in',true);
		Session::set('user_id',$user_record['id']);
        Session::set('user_email',$user_record['mail']);        
        Session::set('username',$user_record['username']);
        Session::set('user_names',$user_record['names']);
        Session::set('user_lastnames',$user_record['lastnames']);
        Session::set('username',$user_record['username']);
        Session::set('user_profile_photo',$user_record['profile_photo']);
        Session::set('role_id',$user_record['user_level_id']);
        Session::set('lan',$user_record['lan']);
    }
	
	/**
	 * metodo para seliminar los datos de el usuario en la sesion actual
	 * 
	 * @return type
	 */
    public static function unset_user_session_data(){
		Session::set('log_out',true);
		Session::delete('logged_in');
		Session::delete('user_id');
		Session::delete('role_id');
		Session::delete('user_email');
		Session::delete('lan');
    }
}
?>