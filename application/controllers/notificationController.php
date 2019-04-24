<?php
class notificationController extends Controller{

    public function read_notification(){
        $value=$_POST['notification_id'];
        $req=Model::execute_update("UPDATE notification set `read` ='Y' where id=".$_POST['notification_id']."");
        echo $req;
    }

    public function show_all(){
        $this->init(new Notification());
        $this->render('list');
    }
   
}
?>