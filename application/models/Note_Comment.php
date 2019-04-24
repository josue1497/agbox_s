<?php
class Note_Comment extends Model{
	public function __construct(){
		
		parent::__construct('note_comment');
		$this->table_label='Comentarios';
		
		$this->add_columns(
			array(
				(new Column('id'))
				->set_label('ID')
				->set_primary_key()
				->set_auto_increment()
				->set_visible_grid(false)
                ->set_visible_form(false),
				
				(new Column('comment'))
                ->set_label('Comentario')
                ->set_type(Column::$COLUMN_TYPE_TEXT)
                ->set_name_key(),
				
				(new Column('date_comment'))
				->set_label('Fecha del Comentario')
				->set_type(Column::$COLUMN_TYPE_DATE)
				->set_visible_grid(false)
				->set_unike_key(),

				(new Column('note_id'))
				->set_label('Nota')
                ->set_type(Column::$COLUMN_TYPE_SELECT)
                ->set_fk_entity(new Note())
                ->set_visible_grid(false),
                
                (new Column('author_id'))
				->set_label('Autor')
                ->set_type(Column::$COLUMN_TYPE_SELECT)
                ->set_fk_entity(new User())
                ->set_visible_grid(false),

			)
		);

		$this->init();
	}

	public static function create_comment($note_id, $user_id, $message){
		$model = new Note_Comment();
		return $model->create(array('note_id'=>$note_id, 'author_id'=>$user_id, 'comment'=>$message));
	}

}
?>