<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Kriteria extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model('Kriteria_model');
        $this->load->library('form_validation');
    }

    public function index()
    {
        $q = urldecode($this->input->get('q', TRUE));
        $start = intval($this->input->get('start'));
        
        if ($q <> '') {
            $config['base_url'] = base_url() . 'kriteria/index.html?q=' . urlencode($q);
            $config['first_url'] = base_url() . 'kriteria/index.html?q=' . urlencode($q);
        } else {
            $config['base_url'] = base_url() . 'kriteria/index.html';
            $config['first_url'] = base_url() . 'kriteria/index.html';
        }

        $config['per_page'] = 10;
        $config['page_query_string'] = TRUE;
        $config['total_rows'] = $this->Kriteria_model->total_rows($q);
        $kriteria = $this->Kriteria_model->get_limit_data($config['per_page'], $start, $q);

        $this->load->library('pagination');
        $this->pagination->initialize($config);

        $data = array(
            'kriteria_data' => $kriteria,
            'q' => $q,
            'pagination' => $this->pagination->create_links(),
            'total_rows' => $config['total_rows'],
            'start' => $start,
        );
        $this->load->view('kriteria/kriteria_list', $data);
    }

    public function read($id) 
    {
        $row = $this->Kriteria_model->get_by_id($id);
        if ($row) {
            $data = array(
		'id' => $row->id,
		'kode' => $row->kode,
		'name' => $row->name,
		'bobot' => $row->bobot,
	    );
            $this->load->view('kriteria/kriteria_read', $data);
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('kriteria'));
        }
    }

    public function create() 
    {
        $data = array(
            'button' => 'Create',
            'action' => site_url('kriteria/create_action'),
	    'id' => set_value('id'),
	    'kode' => set_value('kode'),
	    'name' => set_value('name'),
	    'bobot' => set_value('bobot'),
	);
        $this->load->view('kriteria/kriteria_form', $data);
    }
    
    public function create_action() 
    {
        $this->_rules();

        if ($this->form_validation->run() == FALSE) {
            $this->create();
        } else {
            $data = array(
		'kode' => $this->input->post('kode',TRUE),
		'name' => $this->input->post('name',TRUE),
		'bobot' => $this->input->post('bobot',TRUE),
	    );

            $this->Kriteria_model->insert($data);
            $this->session->set_flashdata('message', 'Create Record Success');
            redirect(site_url('kriteria'));
        }
    }
    
    public function update($id) 
    {
        $row = $this->Kriteria_model->get_by_id($id);

        if ($row) {
            $data = array(
                'button' => 'Update',
                'action' => site_url('kriteria/update_action'),
		'id' => set_value('id', $row->id),
		'kode' => set_value('kode', $row->kode),
		'name' => set_value('name', $row->name),
		'bobot' => set_value('bobot', $row->bobot),
	    );
            $this->load->view('kriteria/kriteria_form', $data);
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('kriteria'));
        }
    }
    
    public function update_action() 
    {
        $this->_rules();

        if ($this->form_validation->run() == FALSE) {
            $this->update($this->input->post('id', TRUE));
        } else {
            $data = array(
		'kode' => $this->input->post('kode',TRUE),
		'name' => $this->input->post('name',TRUE),
		'bobot' => $this->input->post('bobot',TRUE),
	    );

            $this->Kriteria_model->update($this->input->post('id', TRUE), $data);
            $this->session->set_flashdata('message', 'Update Record Success');
            redirect(site_url('kriteria'));
        }
    }
    
    public function delete($id) 
    {
        $row = $this->Kriteria_model->get_by_id($id);

        if ($row) {
            $this->Kriteria_model->delete($id);
            $this->session->set_flashdata('message', 'Delete Record Success');
            redirect(site_url('kriteria'));
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('kriteria'));
        }
    }

    public function _rules() 
    {
	$this->form_validation->set_rules('kode', 'kode', 'trim|required');
	$this->form_validation->set_rules('name', 'name', 'trim|required');
	$this->form_validation->set_rules('bobot', 'bobot', 'trim|required|numeric');

	$this->form_validation->set_rules('id', 'id', 'trim');
	$this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');
    }

    public function excel()
    {
        $this->load->helper('exportexcel');
        $namaFile = "kriteria.xls";
        $judul = "kriteria";
        $tablehead = 0;
        $tablebody = 1;
        $nourut = 1;
        //penulisan header
        header("Pragma: public");
        header("Expires: 0");
        header("Cache-Control: must-revalidate, post-check=0,pre-check=0");
        header("Content-Type: application/force-download");
        header("Content-Type: application/octet-stream");
        header("Content-Type: application/download");
        header("Content-Disposition: attachment;filename=" . $namaFile . "");
        header("Content-Transfer-Encoding: binary ");

        xlsBOF();

        $kolomhead = 0;
        xlsWriteLabel($tablehead, $kolomhead++, "No");
	xlsWriteLabel($tablehead, $kolomhead++, "Kode");
	xlsWriteLabel($tablehead, $kolomhead++, "Name");
	xlsWriteLabel($tablehead, $kolomhead++, "Bobot");

	foreach ($this->Kriteria_model->get_all() as $data) {
            $kolombody = 0;

            //ubah xlsWriteLabel menjadi xlsWriteNumber untuk kolom numeric
            xlsWriteNumber($tablebody, $kolombody++, $nourut);
	    xlsWriteLabel($tablebody, $kolombody++, $data->kode);
	    xlsWriteLabel($tablebody, $kolombody++, $data->name);
	    xlsWriteNumber($tablebody, $kolombody++, $data->bobot);

	    $tablebody++;
            $nourut++;
        }

        xlsEOF();
        exit();
    }

}

/* End of file Kriteria.php */
/* Location: ./application/controllers/Kriteria.php */
/* Please DO NOT modify this information : */
/* Generated by Harviacode Codeigniter CRUD Generator 2018-06-11 22:29:27 */
/* http://harviacode.com */