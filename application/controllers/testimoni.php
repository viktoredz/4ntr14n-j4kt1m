<?php
class Testimoni extends CI_Controller {

    public function __construct(){
		parent::__construct();
    $this->load->helper(array('url','html','form'));
    $this->load->model('antrian_model');
		$this->load->model('morganisasi_model');

	}

	function index(){
    $data['title_group'] 	= "Testimonial";
		$data['title_form']  	= "Daftar Testimonial";
    $data['testimoni_up']   = number_format($this->morganisasi_model->get_jml_testimoni('puas'));
    $data['testimoni_down'] = number_format($this->morganisasi_model->get_jml_testimoni('tidak'));

		$v = "antrian/antrian_testimoni";

		$data['content']= $this->parser->parse($v,$data,true);

		$this->template->show($data,"home");
	}

  function fullscreen(){
    $data = array();
    $data['title_form'] = "Testimoni Pasien";
    $data['action']     = "tambah";

    $data['content']= $this->parser->parse('antrian/antrian_testimoni_fullscreen',$data,true);
    $this->template->show($data,"testi");
  }

  function add_testimoni(){
    $data = array();
    $data['title_form'] = "Tambah Testimonial";
    $data['action']     = "tambah";
    die($this->parser->parse('antrian/antrian_testimoni_add', $data));
  }

  function detail_testimoni($id){
    $data = $this->antrian_model->get_testimoni_by_id($id);
    $data['title_form']	= "Detail Testimonial";
    $data['action']   = "update";
		$data['waktu']		= date("d M Y, H:i:s",strtotime($data['waktu']));

    die($this->parser->parse('antrian/antrian_testimoni_detail', $data));
  }

  function submit_testimoni(){
    $content = $this->input->post('content');
    $status = $this->input->post('status');
    $data = array(
      'id' => '',
      'content' => $content,
      'status' => $status,
      'code' => 'P'.$this->session->userdata('puskesmas'),
    );
    $query = $this->antrian_model->add_testimoni($data);
    if($query){
      echo "OK";
    }else{
      echo "ERROR";
    }
  }

  function delete_testimoni($id=""){
		//$this->authentication->verify('antrian','del');

		if($this->antrian_model->delete_testimoni($id)){
			$this->session->set_flashdata('alert', 'Delete data ('.$id.')');
		}else{
			$this->session->set_flashdata('alert', 'Delete data error');
		}
	}

  function json_testimoni(){
    if($_POST) {
      $fil = $this->input->post('filterscount');
      $ord = $this->input->post('sortdatafield');

      for($i=0;$i<$fil;$i++) {
        $field = $this->input->post('filterdatafield'.$i);
        $value = $this->input->post('filtervalue'.$i);

        $this->db->like($field,$value);
      }

      if(!empty($ord)) {
        $this->db->order_by($ord, $this->input->post('sortorder'));
      }
    }


    $this->db->where('cl_testimoni.code', $this->session->userdata('klinik'));
    $rows_all = $this->antrian_model->get_testimoni();

    if($_POST) {
      $fil = $this->input->post('filterscount');
      $ord = $this->input->post('sortdatafield');

      for($i=0;$i<$fil;$i++) {
        $field = $this->input->post('filterdatafield'.$i);
        $value = $this->input->post('filtervalue'.$i);

        $this->db->like($field,$value);
      }

      if(!empty($ord)) {
        $this->db->order_by($ord, $this->input->post('sortorder'));
      }
    }

    $this->db->where('cl_testimoni.code', $this->session->userdata('klinik'));
		$rows = $this->antrian_model->get_testimoni($this->input->post('recordstartindex'), $this->input->post('pagesize'));

		$data = array();
		foreach($rows as $act) {
			$data[] = array(
				'id'	=> $act->id,
				'content'	=> $act->content,
				'status'	=> $act->status,
        'waktu' => date("d M Y H:i:s",strtotime($act->waktu))
			);
		}

		$size = sizeof($rows_all);
		$json = array(
			'TotalRows' => (int) $size,
			'Rows'      => $data
		);

		echo json_encode(array($json));
  }
}
