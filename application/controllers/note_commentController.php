<?php
/**
 * controlador para el crud de menu
 */
class note_commentController extends Controller{
	/**
	 * metodo accion index que genera la grilla
	 * 
	 * @return void
	 */
    function index(){
		$this->action_index(new Note_Comment(),true);
    }
    
    /**
	 * metodo accion create que genera el form para agregar registros
	 * 
	 * @return void
	 */
    function create(){
        $this->init(new Note_Comment());
        
        if(isset($_POST)&&isset($_POST['comment'])){
            if($this->model->create($_POST)){
                // Notification::create_notification();
            }
        }
    }
    
    /**
	 * metdo accion edit que genra el form para editar registros
	 * 
	 * @return void
	 */
    function edit($id){
		$this->action_edit($id,new Note_Comment(),$_POST,true);
    }

    /**
	 * metodo accion delete que elimina un registro
	 * @return type
	 */
    public function delete($id){
		$this->action_delete($id,new Note_Comment());
    }
    
    /**
	 * metodo accion delete que elimina un registro
	 * @return type
	 */
    public function get_comments(){
        $data=$_POST;

        $query = "select nc.id,nc.comment, concat(u.names,' ',u.lastnames) as 'user_name', date_comment 
        from note_comment nc inner join note n on (n.id=nc.note_id) 
        inner join `user` u on (nc.author_id=u.id)
        where n.id=? order by date_comment desc ";

        $records = Model::get_sql_data($query,array('note_id'=>$data['note_id']));

        $html_result='';
        setlocale(LC_ALL,"es_ES");
        if(count($records)===0){
            $html_result.='<div class="card w-100 my-1">
            <div class="card-body">
               <h4 class="text-seocndary text-center">0 comentarios.</h4>
            </div>
        </div>';
        }else{
        foreach($records as $record){
            $html_result.='<div class="card w-100 my-1">
            <div class="card-body">
                <p class="card-title text-muted"><small>'.strftime ( "%d %b %g %H:%M" , strtotime($record['date_comment'])).'</small> - '.$record['user_name'].'</p>
                <h6 class="card-text">'.$record['comment'].'</h6>
            </div>
        </div>';
        }
    }
        



        echo $html_result;
	}
}
