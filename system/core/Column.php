<?php 
	/**
	 * clase que maneja metodos y atrubutos de una columna de un modelo,
	 * desde atributos de base de datos, como atributos para la construccion
	 * dinamica de vistas, entidades relacionadas
	 */
	class Column {
		
		/* atributos propios de la columna*/
		var $column_name;
		var $column_label;
		
		/* tipo de dato de la columna */
		var $column_type;
		
		/* variantes de tipo de dato aceptadas */
		public static $COLUMN_TYPE_TEXT='TEXT';
		public static $COLUMN_TYPE_DATE='DATE';
		public static $COLUMN_TYPE_TEXTAREA='TEXTAREA';
		public static $COLUMN_TYPE_NUMBER='NUMBER';
		public static $COLUMN_TYPE_EMAIL='EMAIL';
		public static $COLUMN_TYPE_PASS='PASSWORD';
		public static $COLUMN_TYPE_SELECT='SELECT';
		public static $COLUMN_TYPE_HIDDEN='HIDDEN';
		public static $COLUMN_TYPE_ICONPICKER='ICONPICKER';
		
		/* visibilidad de la columna en grid y form */
		var $column_visible_form;
		var $column_visible_grid;
		
		/* caracteristicas de indexacion de la columna */
		/* clave unica de la tabla */
		var $column_unike_key;
		/* clave primaria de la tabla*/
		var $column_primary_key;
		/* clave foranea de la tabla, primaria en otra tabla*/
		var $column_foreing_key;
		/* indice auto incrementado */
		var $column_auto_increment;
		/* clave de nombre o descripcion de la tabla(para selects) */
		var $column_name_key;
		
		/* valor/es asignado/s a la columna*/
		var $column_value;
		var $column_values;
		
		/* objeto de modelo, cuando la columna sea fk */
		var $column_fk_entity;
		
		/* propiedad que indica si la columna existe o no en la db*/
		var $column_in_db;
		
		/* atributos auxiliares para construccion de campos - html*/
		var $field_html;
		var $field_help;
		var $table_field_name;
		
		/**
		 * constructor por defecto de la clase
		 *
		 * inicializa los atributos de la columna con valores por defecto
		 *
		 * @param string|null $column_name nombre de la columna en la base de datos
		 * @return void
		 */
		public function __construct($column_name=null){
			if($column_name!=null){
				$this->column_name=$column_name;
				$this->column_label=$column_name;
			}
			$this->column_visible_form=true;
			$this->column_visible_grid=true;
			
			$this->column_unike_key=false;
			$this->column_primary_key=false;
			$this->column_foreing_key=false;
			$this->column_auto_increment=false;
			$this->column_name_key=false;
			$this->column_in_db=true;
			
			$this->field_html='';
			$this->field_help=$column_name;
			$this->table_field_name=$column_name;
		}
		
		/* gets y sets */

		/**
		 * metodo para establecer valor al atributo name, nombre de la columna en la 
		 * base de datos y en los formularios.
		 *
		 * @param string $name 
		 * @return column
		 */
		public function set_name($name){
			$this->column_name=$name;
			if(!$this->label)
				$this->column_label=$name;
			return $this; 			
		}
		/**
		 * metodo para obtener el valor del atributo name
		 *
		 * @return string nombre de la columna en la base de datos
		 */
		public function get_name(){
			return $this->column_name;
		}
		
		/**
		 * metodo para establecer valor al atributo label, etiqueta de la columna en la 
		 * base de datos y en los formularios.
		 *
		 * @param string $label 
		 * @return column
		 */
		public function set_label($label){
			$this->column_label=$label;
			$this->field_help=$label;
			return $this;
		}
		/**
		 * metodo para obtener el valor del atributo label
		 *
		 * @return string etiqueta de la columna en la base de datos
		 */
		public function get_label(){
			return $this->column_label;
		}
		
		/**
		 * Metodo para establecer valor al atributo type, typo de dato 
		 * de la columna en la base de datos y en los formularios. 
		 * 
		 * Debe ser un tipo valido segun los valores especificados en esta clase, 
		 * ya que cada valor tiene un comportamiento predefinido
		 *
		 * @param string $type 
		 * @return column
		 */
		public function set_type($type){
			$this->column_type=$type;
			return $this;
		}
		/**
		 * metodo para comprobar si el valor del atributo type es valido
		 *
		 * @return boolean
		 */
		function is_valid_type(){
			if(!$this->column_type)
				return false;
			$valid_types = array(self::$COLUMN_TYPE_TEXT,
				self::$COLUMN_TYPE_EMAIL,self::$COLUMN_TYPE_HIDDEN,
				self::$COLUMN_TYPE_NUMBER,self::$COLUMN_TYPE_PASS,
				self::$COLUMN_TYPE_SELECT,self::$COLUMN_TYPE_TEXTAREA,
				self::$COLUMN_TYPE_DATE,self::$COLUMN_TYPE_ICONPICKER
			);
			foreach($valid_types as $valid_type)
				if($valid_type == $this->column_type)
					return true;
			return false;
		}
		/**
		 * metodo para obtener el valor del atributo type
		 *
		 * @return string tipo de dato de la columna en la base de datos, 
		 * por defecto texto
		 */
		public function get_type(){
			if(!$this->is_valid_type()){
				return self::$COLUMN_TYPE_TEXT;
			}
			return $this->column_type;
		}
		
		/* visibility */

		/**
		 * metodo para establecer la visibilidad de una columna en los formularios
		 * por defecto esta como true
		 * 
		 * @param boolean $visible 
		 * @return column
		 */
		public function set_visible_form($visible){
			$this->column_visible_form=$visible;
			return $this;
		}
		/**
		 * metodo para obtener la visibilidad de una columna en los formularios
		 *
		 * @return boolean
		 */
		public function get_visible_form(){
			return $this->column_visible_form;
		}
		
		/**
		 * metodo para establecer la visibilidad de una columna en las grillas
		 * por defecto esta como true
		 * 
		 * @param boolean $visible 
		 * @return column
		 */
		public function set_visible_grid($visible){
			$this->column_visible_grid=$visible;
			return $this;
		}
		/**
		 * metodo para obtener la visibilidad de una columna en las grillas
		 *
		 * @return boolean
		 */
		public function get_visible_grid(){
			return $this->column_visible_grid;
		}
		
		/* keys */

		/**
		 * metodo para establecer si una columna es la clave primaria del modelo,
		 * por defecto esta como false
		 *
		 * @param boolean $bool 
		 * @return column
		 */
		public function set_primary_key($bool=true){
			$this->column_primary_key = $bool;
			return $this;
		}
		/**
		 * metodo para obtener si una columna es clave primaria del modelo
		 *
		 * @return boolean
		 */
		public function get_primary_key(){
			return $this->column_primary_key;
		}
		
		/**
		 * Establece que la columna es clave unica en la base de datos.
		 * Autmatiamente previene que se almacenen duplicados de esta columna
		 * 
		 * @param boolean $bool 
		 * @return column
		 */
		public function set_unike_key($bool=true){
			$this->column_unike_key = $bool;
			return $this;
		}
		/**
		 * comprueba si la columna es una clave unica en la tabla
		 *
		 * @return boolean
		 */
		public function get_unike_key(){
			return $this->column_unike_key;
		}
		
		/**
		 * establece si una columna es clave foranea de otro modelo
		 *
		 * @param boolean $bool 
		 * @return column
		 */
		public function set_foreing_key($bool=true){
			$this->column_foreing_key = $bool;
			return $this;
		}
		/**
		 * comprueba si una columna es clave foranea de otro modelo
		 * 
		 * @return boolean
		 */
		public function get_foreing_key(){
			return $this->column_foreing_key;
		}
		
		/**
		 * establece que una columna es autoincremental en base de datos.
		 * 
		 * @param boolean $bool 
		 * @return column
		 */
		public function set_auto_increment($bool=true){
			$this->column_auto_increment=$bool;
			return $this;
		}
		/**
		 * comprueba si una columna es autoincremental en la base de datos
		 * 
		 * @return boolean
		 */
		public function get_auto_increment(){
			return $this->column_auto_increment;
		}
		
		/**
		 * Metodo que indica si una columna es identificador de la tabla/modelo.
		 * 
		 * Este atributo indica si una columna se mostrara como texto en los combobox,
		 * en caso de generacion de listas automaticas de un modelo. Puede haber mas 
		 * de una columna identificadora por modelo.
		 * 
		 * @param boolean $bool 
		 * @return column
		 */
		public function set_name_key($bool=true){
			$this->column_name_key=$bool;
			return $this;
		}
		/**
		 * comprueba si una columna es identificador de la tabla
		 *
		 * @return boolean
		 */
		public function get_name_key(){
			return $this->column_name_key;
		}
		
		/* column values */
		/**
		 * Establece un valor temporal en la columna cuando sea necesario
		 *
		 * @param type $value 
		 * @return column
		 */
		public function set_value($value){
			$this->column_value=$value;
			return $this;
		}
		/**
		 * obtiene el valor temporal de la columna, si existe
		 * 
		 * @return type
		 */
		public function get_value(){
			return $this->column_value;
		}
		
		/**
		 *  Establece un array de valores temporal en la columna cuando sea necesario
		 * 
		 * @param type $values 
		 * @return column
		 */
		public function set_values($values){
			$this->column_values=$values;
			return $this;
		}
		/**
		 * Ebtiene el array de valores temporal de la columna, si existe
		 * 
		 * @return type|array|null
		 */
		public function get_values(){
			return $this->column_values;
		}
		
		/**
		 * Establece que una columna no se almacenara en la base de datos. 
		 * 
		 * @param type|bool $value 
		 * @return column
		 */
		public function set_column_in_db($value=true){
			$this->column_in_db=$value;
			return $this;
		}
		
		/**
		 * Comprueba si una columna debe almacenarse en la base de datos o no. 
		 * Por defecto tiene valor true
		 * 
		 * @return boolean
		 */
		public function get_column_in_db(){
			return $this->column_in_db;
		}
		
		/**
		 * Establece la relacion entre una columna de un modelo, hacia otro modelo. 
		 * A nivel de base de datos, la clave principal debe tener el mismo nombre 
		 * de la foranea. 
		 * 
		 * @param model $entity 
		 * @return column
		 */
		public function set_fk_entity($entity){
			$this->column_fk_entity=$entity;
			$this->set_foreing_key(true);
			return $this;
		}
		/**
		 * Obtiene el modelo con el cual se relaciona la columna foranea.
		 * 
		 * @return type
		 */
		public function get_fk_entity(){
			return $this->column_fk_entity;
		}
		
		/* atributos auxiliares para construccion de campos */
		
		/**
		 * establece valor de texto adicional en campo - onclics,styles,etc
		 * 
		 * @param type|string $value 
		 * @return column
		 */
		public function set_field_html($value=''){
			$this->field_html=$value;
			return $this;
		}
		/**
		 * obtiene el valor del atributo de texto adicional a incrustar 
		 * en campos html
		 * 
		 * @return string
		 */
		public function get_field_html(){
			return $this->field_html;
		}
		
		/**
		 * establece valor de ayudas en campos de formularios html - 
		 * placeholder,tooltips
		 *  
		 * @param string $value
		 * @return column 
		 */
		public function set_field_help($value=''){
			$this->field_help=$value;
			return $this;
		}
		/**
		 * obtiene el valor de atributo de ayudas de camos en formularios
		 * 
		 * @return type|string
		 */
		public function get_field_help(){
			return $this->field_help;
		}
		
		/**
		 * Establece el nombre de la columna de base de datos a la que hace referencia 
		 * el campo del formulario.
		 * 
		 * Necesario para casos como tener nombre distinto a la columna, 
		 * sea por que esta la misma entidad michas veces en la misma vista, o cualquier 
		 * otro escenario por el que no pueda usarse el nombre de la columna de la base 
		 * de datos  en el formulario.
		 * 
		 * @param type|string $value 
		 * @return column
		 */
		public function set_table_field_name($value=''){
			$this->table_field_name = $value;
			return $this;
		}
		/**
		 * obtiene el nombre de la columna de la base de datos a la que hace referencia 
		 * el campo del formulario.
		 * 
		 * @return string
		 */
		public function get_table_field_name(){
			return $this->table_field_name;
		}
	}
?>