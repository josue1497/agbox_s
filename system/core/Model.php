<?php
/**
 * clase base que gestiona las funcionalidades de los modelos
 */
class Model
{

	/* nombre de la tabla */
	public $table_name;
	/* etiqueta de la tabla */
	public $table_label;
	/* columnas de la tabla */
	public $table_fields = array();
	/* clave primaria de la tabla */
	public $id_field;
	/* texto identificador del registro - texto que aparecera en lo comboBox */
	public $name_fields = array();
	/* claves unicas*/
	public $unike_keys = array();
	/* permisos sobre la tabla - se ajustara segun privilegios del usuario*/
	public $crud_config = array(
		'can_create' => true,
		'can_read' => true,
		'can_update' => true,
		'can_delete' => true
	);

	/**
		  * constructor de la clase por defecto, recibe 
		  * el nombre de la tabla a cargar
		  *
		  * @param type|null $table_name 
		  * @return void
		  */
	public function __construct($table_name = null)
	{
		if ($table_name != null) {
			$this->table_name = $table_name;
		}
		$this->table_label = $table_name;
	}


	/* metodos para agregar una columna */
	public function add_column($column)
	{
		$this->table_fields[] = $column;
	}

	/* metodos para agregar muchas columnas */
	public function add_columns($columns)
	{
		foreach ($columns as $column) {
			$this->add_column($column);
		}
	}

	/*************************************************************/

	/* metodo para inicializar el modelo a partir de la definicion de 
		los campos de la tabla - debe llamarse al final del construct de cada model*/
	public function init()
	{
		if (count($this->table_fields) < 1)
			return false;
		foreach ($this->table_fields as $table_field) {
			if ($table_field->get_primary_key()) {
				$this->id_field = $table_field->get_name();
			}
			if ($table_field->get_name_key()) {
				$this->name_fields[] = $table_field->get_name();
			}
			if ($table_field->get_unike_key()) {
				$this->unike_keys[] = $table_field->get_name();
			}
		}
	}

	/**
		* metodo para buscar registros segun algun atributo(array (column_name => value, ...))
		*/
	public function findByPoperty($properties)
	{
		if (empty($properties)) {
			return null;
		}

		$sql = "Select * From " . $this->table_name . " Where ";
		$keys = array_keys($properties);
		$first = true;
		foreach ($keys as $key) {
			$sql .= ($first == false ? " and " : "") . $key . " = '" . $properties[$key] . "' ";
			$first = false;
		}

		$req = Database::getBdd()->prepare($sql);
		$req->execute();
		return $req->fetch();
	}

	public function get_by_property($properties)
	{
		return $this->findByPoperty($properties);
	}

	/**
		* metodo adaptados para obtener un registro de la entidad por id
		*/
	public function get_by_id($id)
	{
		return $this->findByPoperty(array($this->id_field => $id));
	}
	/**
		* metodo para obtener un registro de una segunda tabla relacionada 
		* a la primera
		*/
	public function get_fk_by_id($id, $fk_obj)
	{
		$m = $this->get_by_id($id);
		return $fk_obj->get_by_id($m[$fk_obj->id_field]);
	}
	/**
		* metodo para obtener un registro de una tercera tabla relacionda 
		* a la segunda
		*/
	public function get_fk2_by_id($id, $fk1_obj, $fk2_obj)
	{
		$m = $this->get_fk_by_id($id, $fk1_obj);
		return $fk2_obj->get_by_id($m[$fk2_obj->id_field]);
	}

	/**
		* metodo para mostrar todos los registros
		* retorna un array(filas) de arrays(columnas)
		*/
	public function showAllRecords()
	{
		$sql = "SELECT * FROM " . $this->table_name . "";
		$req = Database::getBdd()->prepare($sql);
		$req->execute();
		return $req->fetchAll(PDO::FETCH_ASSOC);
	}

	/**
		* metodo para eliminar un registro segun id
		*/
	public function delete($id)
	{
		$sql = "DELETE FROM " . $this->table_name . " WHERE " . $this->id_field . " = ?";
		$req = Database::getBdd()->prepare($sql);
		return $req->execute(array($id));
	}

	/**
		* metodo para obtener array de registros segun id opcional
		*/

	public function get_array_data($id = null)
	{
		$result = array();
		if (!empty($id)) {
			$result[] = $this->get_by_id($id);
		} else {
			$result = $this->showAllRecords();
		}
		return $result;
	}

	/**
		* metodo para obtener registros y mapearlos para combo generico
		*/
	public function get_select_data($id = null)
	{
		$data = $this->get_array_data($id);
		$result = array();
		foreach ($data as $row)
			$result[] = array(
				"id" => $row[$this->id_field],
				"name" => $this->map_name_value($row)
			);
		return $result;
	}

	/* metodo par obtener los valores del registro a mostrar en los select */
	public function map_name_value($row)
	{
		$result = '';
		$first = true;
		foreach ($this->name_fields as $name_field) {
			$result .= (($first == false ? ' - ' : '') . (isset($row[$name_field]) ? $row[$name_field] : ''));
			$first = false;
		}
		return $result;
	}

	/**
		* metodo para verificar si ya existe un registro con los valores unicos especificados
		*/
	public function exist_unike_keys($params)
	{
		if (count($this->unike_keys) < 1) {
			return false;
		}

		$db_params = array();
		foreach ($this->unike_keys as $key) {
			$db_params[$key] = $params[$key];
		}

		$result = $this->findByPoperty($db_params);

		if ($result) {
			echo Component::alert_message('Ya existe un registro con estos datos');
			return true;
		}
		return false;
	}

	/**
		* metodo para insertar un nuevo registro
		*/
	public function create($params)
	{

		echo '<script>console.log("modelo: agregar registro nuevo")</script>';

		if ($this->exist_unike_keys($params)) {
			echo '<script>console.log("modelo: ya existe la clave unica")</script>';

			return false;
		}

		$sqlInsert = "INSERT INTO " . $this->table_name . " (";

		$sqlValues = "VALUES (";
		$db_params = array();
		$first = true;

		foreach ($this->table_fields as $table_field) {
			$name = $table_field->get_name();
			if (!empty($params[$name]) && strlen($params[$name]) > 0 && $table_field->get_column_in_db() == true) {
				$sqlInsert .= ($first == false ? " , " : "") . $name;
				$sqlValues .= ($first == false ? " , " : "") . ":" . $name;
				$db_params[$name] = $params[$name];
				$first = false;
			}
		}

		$sqlInsert .= ") ";
		$sqlValues .= ") ";
		// var_dump($db_params);die;

		try {

			$req = Database::getBdd()->prepare($sqlInsert . $sqlValues);		

			$result = $req->execute($db_params);
		} catch (PDOException $err) {
			echo $err->getMessage();
		}

		return $result;
	}

	/**
		* metodo para actualizar un registro existente
		*/
	public function edit($id, $params)
	{
		$sqlUpdate = "UPDATE " . $this->table_name . " SET ";
		$sqlWhere = " WHERE " . $this->id_field . " = :" . $this->id_field . "";
		$db_params = array();
		$first = true;

		foreach ($this->table_fields as $table_field) {
			$name = $table_field->get_name();
			if (!empty($params[$name]) && strlen($params[$name]) > 0 && $table_field->get_column_in_db() == true) {
				$sqlUpdate .= ($first == false ? " , " : "") . $name . " = :" . $name;
				$db_params[$name] = $params[$name];
				$first = false;
			}
		}

		$db_params[$this->id_field] = $id;
		$req = Database::getBdd()->prepare($sqlUpdate . $sqlWhere);
		return $req->execute($db_params);
	}

	/**
		* metodo generico deberia ser estatic y esta en model
		*/
	public static function save_record($model, $data)
	{
		if (isset($data[$model->id_field])) {
			$result = $model->get_by_id($data[$model->id_field]);
			if ($result) {
				return $model->edit($data[$model->id_field], $data);
			}
		}
		return $model->create($data);
	}
}
 