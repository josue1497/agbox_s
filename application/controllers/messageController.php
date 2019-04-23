<?php
class messageController extends Controller{

    public function read_message(){
        $value=$_POST['message_id'];
        $req=Model::execute_update("UPDATE `message` set `read` ='Y' where id=".$value."");
        echo $req;
    }
   
}
?>