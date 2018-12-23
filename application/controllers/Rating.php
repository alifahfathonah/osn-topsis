<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Rating extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model('Rating_model');
        $this->load->library('form_validation');
    }

    public function index()
    {
        $q = urldecode($this->input->get('q', TRUE));
        $start = intval($this->input->get('start'));
        
        if ($q <> '') {
            $config['base_url'] = base_url() . 'rating/index.html?q=' . urlencode($q);
            $config['first_url'] = base_url() . 'rating/index.html?q=' . urlencode($q);
        } else {
            $config['base_url'] = base_url() . 'rating/index.html';
            $config['first_url'] = base_url() . 'rating/index.html';
        }

        $config['per_page'] = 10;
        $config['page_query_string'] = TRUE;
        $config['total_rows'] = $this->Rating_model->total_rows($q);
        $rating = $this->Rating_model->get_limit_data($config['per_page'], $start, $q);

        $this->load->library('pagination');
        $this->pagination->initialize($config);

        $data = array(
            'rating_data' => $rating,
            'q' => $q,
            'pagination' => $this->pagination->create_links(),
            'total_rows' => $config['total_rows'],
            'start' => $start,
        );
        $this->load->view('rating/rating_list', $data);
    }

    public function read($id) 
    {
        $row = $this->Rating_model->get_by_id($id);
        if ($row) {
            $data = array(
		'id' => $row->id,
		'name' => $row->name,
		'rating' => $row->rating,
		'keterangan' => $row->keterangan,
	    );
            $this->load->view('rating/rating_read', $data);
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('rating'));
        }
    }

    public function create() 
    {
        $data = array(
            'button' => 'Create',
            'action' => site_url('rating/create_action'),
	    'id' => set_value('id'),
	    'name' => set_value('name'),
	    'rating' => set_value('rating'),
	    'keterangan' => set_value('keterangan'),
	);
        $this->load->view('rating/rating_form', $data);
    }
    
    public function create_action() 
    {
        $this->_rules();

        if ($this->form_validation->run() == FALSE) {
            $this->create();
        } else {
            $data = array(
		'name' => $this->input->post('name',TRUE),
		'rating' => $this->input->post('rating',TRUE),
		'keterangan' => $this->input->post('keterangan',TRUE),
	    );

            $this->Rating_model->insert($data);
            $this->session->set_flashdata('message', 'Create Record Success');
            redirect(site_url('rating'));
        }
    }
    
    public function update($id) 
    {
        $row = $this->Rating_model->get_by_id($id);

        if ($row) {
            $data = array(
                'button' => 'Update',
                'action' => site_url('rating/update_action'),
		'id' => set_value('id', $row->id),
		'name' => set_value('name', $row->name),
		'rating' => set_value('rating', $row->rating),
		'keterangan' => set_value('keterangan', $row->keterangan),
	    );
            $this->load->view('rating/rating_form', $data);
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('rating'));
        }
    }
    
    public function update_action() 
    {
        $this->_rules();

        if ($this->form_validation->run() == FALSE) {
            $this->update($this->input->post('id', TRUE));
        } else {
            $data = array(
		'name' => $this->input->post('name',TRUE),
		'rating' => $this->input->post('rating',TRUE),
		'keterangan' => $this->input->post('keterangan',TRUE),
	    );

            $this->Rating_model->update($this->input->post('id', TRUE), $data);
            $this->session->set_flashdata('message', 'Update Record Success');
            redirect(site_url('rating'));
        }
    }
    
    public function delete($id) 
    {
        $row = $this->Rating_model->get_by_id($id);

        if ($row) {
            $this->Rating_model->delete($id);
            $this->session->set_flashdata('message', 'Delete Record Success');
            redirect(site_url('rating'));
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('rating'));
        }
    }

    public function _rules() 
    {
	$this->form_validation->set_rules('name', 'name', 'trim|required');
	$this->form_validation->set_rules('rating', 'rating', 'trim|required|numeric');
	$this->form_validation->set_rules('keterangan', 'keterangan', 'trim|required');

	$this->form_validation->set_rules('id', 'id', 'trim');
	$this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');
    }

    public function excel()
    {
        $this->load->helper('exportexcel');
        $namaFile = "rating.xls";
        $judul = "rating";
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
	xlsWriteLabel($tablehead, $kolomhead++, "Name");
	xlsWriteLabel($tablehead, $kolomhead++, "Rating");
	xlsWriteLabel($tablehead, $kolomhead++, "Keterangan");

	foreach ($this->Rating_model->get_all() as $data) {
            $kolombody = 0;

            //ubah xlsWriteLabel menjadi xlsWriteNumber untuk kolom numeric
            xlsWriteNumber($tablebody, $kolombody++, $nourut);
	    xlsWriteLabel($tablebody, $kolombody++, $data->name);
	    xlsWriteNumber($tablebody, $kolombody++, $data->rating);
	    xlsWriteLabel($tablebody, $kolombody++, $data->keterangan);

	    $tablebody++;
            $nourut++;
        }

        xlsEOF();
        exit();
    }

}

/* End of file Rating.php */
/* Location: ./application/controllers/Rating.php */
/* Please DO NOT modify this information : */
/* Generated by Harviacode Codeigniter CRUD Generator 2018-06-11 22:34:21 */
/* http://harviacode.com */