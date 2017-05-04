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
	
	function checkBPJS($code=""){
		$data = $this->bpjs_model->checkBPJS($code); 

		echo json_encode($data);
	}
	
	function insertdata($kode=0){
        $this->form_validation->set_rules('usernamebpjs', 'Username', 'trim|required');
        $this->form_validation->set_rules('passwordbpjs', 'Password', 'trim|required');
        $this->form_validation->set_rules('considbpjs', 'Cons Id', 'trim|required');
        $this->form_validation->set_rules('keybpjs', 'Secret Key', 'trim|required');
        
      	$data = $this->bpjs_model->get_data_bpjs(); 
		$data['title_group'] = "Admin Panel";
		$data['alert_form'] = '';
		$data['title_form'] = "BPJS Configuration";
		$data['kodeklinik'] = $this->bpjs_model->get_data_klinik();
		$data['theme_default_option'] = $this->bpjs_model->get_theme();

        if($this->form_validation->run()== FALSE){
			die($this->parser->parse("admin/config/bpjs",$data));
		}elseif($this->bpjs_model->insert_databpjs($kode)){
			$data['alert_form'] = 'Save data successful...';
			die($this->parser->parse("admin/config/bpjs",$data));
		}else{
			$data['alert_form'] = 'Save data successful...';
			die($this->parser->parse("admin/config/bpjs",$data));
		}
	}
	
	function doupdate(){
		$this->authentication->verify('admin','edit');

		$this->form_validation->set_rules('title', 'Web title', 'trim|required');
		$this->form_validation->set_rules('serverbpjs', 'serverbpjs', 'trim|required');
		 
		if($this->form_validation->run()== FALSE){
			$this->session->set_flashdata('alert_form', validation_errors());
			die($this->general());
		}elseif($this->bpjs_model->update_entry()){
			$this->session->set_flashdata('alert_form', 'Save data successful...');
			die($this->general());
		}else{
			$this->session->set_flashdata('alert_form', 'Save data failed...');
			die($this->general());
		}
	}
	
	function tab($pageIndex){
		$data = array();
		switch ($pageIndex) {
			case 1:
				$this->bpjs();
				break;
			case 2:
				$this->embalase();
				break;
			case 3:
				$this->puskesmas();
				break;
			case 4:
				$this->general();
				break;
		}
	}
	
	function embalase(){
		$this->authentication->verify('admin','show');

		$data['title_group'] = "Admin Panel";
		$data['alert_form']  = '';
		$data['title_form']  = "Embalase Configuration";
		
		$klinik = $this->bpjs_model->get_data_klinik();
		foreach($klinik as $rows):
			$data['embalase']        = $rows->embalase;
			$data['embalase_harga']  = $rows->embalase_harga;
		endforeach; 
		
		die($this->parser->parse("admin/config/embalase",$data,true));
	}
	
	function bpjs(){
		$this->authentication->verify('admin','show');

		$data = $this->bpjs_model->get_data_bpjs(); 
		$data['title_group'] = "Admin Panel";
		$data['alert_form'] = '';
		$data['title_form'] = "BPJS Configuration";
		$data['code']=$this->session->userdata('klinik');
		$data['kodeklinik'] = $this->bpjs_model->get_data_klinik();
		$data['theme_default_option'] = $this->bpjs_model->get_theme();
		die($this->parser->parse("admin/config/bpjs",$data,true));
	}
	
	function general(){
		$this->authentication->verify('admin','show');

		$data = $this->bpjs_model->get_data(); 
		$data['title_group'] = "Admin Panel";
		$data['title_form'] = "Web Configuration";
		$data['title_form_right'] = "BPJS Configuration";
		$data['theme_default_option'] = $this->bpjs_model->get_theme();
		$data['server'] = $this->bpjs_model->get_server_bpjs();
		die($this->parser->parse("admin/config/form",$data,true));
	}
	function puskesmas(){
		$this->authentication->verify('admin','show');

		$data = $this->bpjs_model->get_data_puskesmas(); 
		$data['title_group'] = "Admin Panel";
		$data['title_form'] = "Puskesmas Configuration";
		$data['title_form_right'] = "Puskesmas Configuration";
		$data['theme_default_option'] = $this->bpjs_model->get_theme();
		$data['nm_puskesmas'] = $this->bpjs_model->get_nmpuskesmas();
		die($this->parser->parse("admin/config/puskesmas",$data,true));
	}
	function puskesmas_search(){
		$qr         = $this->input->post('qr');
		$this->db->like('value',$qr);
		$rows = $this->bpjs_model->get_puskesmas(0,10);
		$data = array();
		foreach($rows as $act) {
			$data[] = array(
				'code'		=> $act['code'],
				'value'		=> $act['value'],
				'alamat'	=> $act['alamat'],
			);
		}
		
		$size = sizeof($rows);
		$json = array(
			'content' => $data
		);

		echo json_encode($json);	
	}
}
