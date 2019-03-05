<?php 
	class Column {
		
		/* atributos propios de la columna*/
		var $column_name;
		var $column_label;
		
		/* tipo de dato de la columna */
		var $column_type;
		
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
		
		/* constructor por defecto */
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
		/* name */
		public function set_name($name){
			$this->column_name=$name;
			if(!$this->label)
				$this->column_label=$name;
			return $this; 			
		}
		public function get_name(){
			return $this->column_name;
		}
		
		/* label */
		public function set_label($label){
			$this->column_label=$label;
			$this->field_help=$label;
			return $this;
		}
		public function get_label(){
			return $this->column_label;
		}
		
		/* type */
		public function set_type($type){
			$this->column_type=$type;
			return $this;
		}
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
		public function get_type(){
			if(!$this->is_valid_type()){
				return self::$COLUMN_TYPE_TEXT;
			}
			return $this->column_type;
		}
		
		/* visibility */
		/* visibility form */
		public function set_visible_form($visible){
			$this->column_visible_form=$visible;
			return $this;
		}
		public function get_visible_form(){
			return $this->column_visible_form;
		}
		
		/* visibility grid */
		public function set_visible_grid($visible){
			$this->column_visible_grid=$visible;
			return $this;
		}
		public function get_visible_grid(){
			return $this->column_visible_grid;
		}
		
		/* keys */
		/* primary */
		public function set_primary_key($bool=true){
			$this->column_primary_key = $bool;
			return $this;
		}
		public function get_primary_key(){
			return $this->column_primary_key;
		}
		
		/* unike */
		public function set_unike_key($bool=true){
			$this->column_unike_key = $bool;
			return $this;
		}
		public function get_unike_key(){
			return $this->column_unike_key;
		}
		
		/* foreing */
		public function set_foreing_key($bool=true){
			$this->column_foreing_key = $bool;
			return $this;
		}
		public function get_foreing_key(){
			return $this->column_foreing_key;
		}
		
		/* auto_increment */
		public function set_auto_increment($bool=true){
			$this->column_auto_increment=$bool;
			return $this;
		}
		public function get_auto_increment(){
			return $this->column_auto_increment;
		}
		
		/* name/description de la tabla */
		public function set_name_key($bool=true){
			$this->column_name_key=$bool;
			return $this;
		}
		public function get_name_key(){
			return $this->column_name_key;
		}
		
		/* column values */
		/* column value */
		public function set_value($value){
			$this->column_value=$value;
			return $this;
		}
		public function get_value(){
			return $this->column_value;
		}
		
		/* column values */
		public function set_values($values){
			$this->column_values=$values;
			return $this;
		}
		public function get_values(){
			return $this->column_values;
		}
		
		/* columna existe en la base de datos*/
		public function set_column_in_db($value=true){
			$this->column_in_db=$value;
			return $this;
		}
		
		public function get_column_in_db(){
			return $this->column_in_db;
		}
		
		/* column entity of foreing key */
		public function set_fk_entity($entity){
			$this->column_fk_entity=$entity;
			$this->set_foreing_key(true);
			return $this;
		}
		public function get_fk_entity(){
			return $this->column_fk_entity;
		}
		
		/* atributos auxiliares para construccion de campos */
		
		/* atributo de texto adicionl en campo - onclics,styles,etc*/
		public function set_field_html($value=''){
			$this->field_html=$value;
			return $this;
		}
		public function get_field_html(){
			return $this->field_html;
		}
		
		/* ayudas en campos - placeholder,tooltips */
		public function set_field_help($value=''){
			$this->field_help=$value;
			return $this;
		}
		public function get_field_help(){
			return $this->field_help;
		}
		
		/* atributo para establecer un nombre distinto a un campo, 
			en caso de muchas instancias del mismo modelo en una misma vista */
		public function set_table_field_name($value=''){
			$this->table_field_name = $value;
			return $this;
		}
		public function get_table_field_name(){
			return $this->table_field_name;
		}
		
	}
?>