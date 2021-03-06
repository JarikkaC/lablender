<?php
 
class ProfileController extends ControllerBase {

   public function beforeExecuteRoute(){ // function ที่ทำงานก่อนเริ่มการทำงานของระบบทั้งระบบ
	  $this->checkAuthen();
   } 
	 	

  public function indexAction(){

  // $email=$this->session->get('memberEmail');
  // $mem=client::findFirst("Email = '$email'");
  $id=$this->session->get('memberID');
  $mem=client::findFirst("client_id = '$id'");
  $this->view->profile=$mem;

  $std=students::findFirst("client_id = '$mem->client_id'");
  $this->view->sentstd=$std;

  $ta=ta::findFirst("client_id = '$mem->client_id'");
  $this->view->sentta=$ta;

  }

  public function editAction(){

    $getclid=$this->request->get('id');
    $editcli=client::findFirst("client_id = '$getclid'");
    $this->view->sentcli=$editcli;

    $editstd=students::findFirst("client_id = '$editcli->client_id'");
    $this->view->sentstd=$editstd;

    $editta=ta::findFirst("client_id = '$editcli->client_id'");
    $this->view->sentta=$editta;

    if($this->request->isPost()){

      $editname=trim($this->request->getPost('name'));
      $editemail=trim($this->request->getPost('email'));
      $editphone=trim($this->request->getPost('phone'));

      $editcli->Name=$editname;
      $editcli->Email=$editemail;
      $editcli->Phone=$editphone;

      $editcli->save();

      if($this->session->has('studentID')){
      $editstd->Student_Name=$editname;

      $editstd->save();

      }

      if($this->session->has('taID')){

      $editta->TA_Name=$editname;
      $editta->save();
      }

      $this->response->redirect('profile');

      }
  }

}
