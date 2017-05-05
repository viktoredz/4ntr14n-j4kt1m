<?php
class Bpjs extends CI_Controller {

	var $limit=20;
	var $page=1;

    public function __construct(){
		parent::__construct();
		$this->load->model('bpjs_model');
	}
	
	function index(){
		$this->authentication->verify('admin','show');

		$data = $this->bpjs_model->get_data(); 
		$data['title_group'] = "Admin Panel";
		$data['title_form'] = "BPJS Configuration";
		$data['content'] = $this->parser->parse("admin/config/bpjs",$data,true);

		$this->template->show($data,"home");
	}
		
	function update(){
		$this->authentication->verify('admin','edit');

		if($this->bpjs_model->update_bpjs()){
			die('Save data successful...');
		}else{
			die('Save data failed...');
		}
	}
	
}
