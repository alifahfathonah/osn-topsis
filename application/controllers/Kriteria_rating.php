<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Kriteria_rating extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model('Kriteria_rating_model');
        $this->load->library('form_validation');
    }

    public function index()
    {
        $q = urldecode($this->input->get('q', TRUE));
        $start = intval($this->input->get('start'));
        
        if ($q <> '') {
            $config['base_url'] = base_url() . 'kriteria_rating/index.html?q=' . urlencode($q);
            $config['first_url'] = base_url() . 'kriteria_rating/index.html?q=' . urlencode($q);
        } else {
            $config['base_url'] = base_url() . 'kriteria_rating/index.html';
            $config['first_url'] = base_url() . 'kriteria_rating/index.html';
        }

        $config['per_page'] = 10;
        $config['page_query_string'] = TRUE;
        $config['total_rows'] = $this->Kriteria_rating_model->total_rows($q);
        $kriteria_rating = $this->Kriteria_rating_model->get_limit_data($config['per_page'], $start, $q);

        $this->load->library('pagination');
        $this->pagination->initialize($config);

        $data = array(
            'kriteria_rating_data' => $kriteria_rating,
            'q' => $q,
            'pagination' => $this->pagination->create_links(),
            'total_rows' => $config['total_rows'],
            'start' => $start,
        );
        $this->load->view('kriteria_rating/kriteria_rating_list', $data);
    }

    public function read($id) 
    {
        $row = $this->Kriteria_rating_model->get_by_id($id);
        if ($row) {
            $data = array(
		'id' => $row->id,
		'kriteria_id' => $row->kriteria_id,
		'rating_id' => $row->rating_id,
	    );
            $this->load->view('kriteria_rating/kriteria_rating_read', $data);
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('kriteria_rating'));
        }
    }

    public function create() 
    {
        $data = array(
            'button' => 'Create',
            'action' => site_url('kriteria_rating/create_action'),
	    'id' => set_value('id'),
	    'kriteria_id' => set_value('kriteria_id'),
	    'rating_id' => set_value('rating_id'),
	);
        $this->load->view('kriteria_rating/kriteria_rating_form', $data);
    }
    
    public function create_action() 
    {
        $this->_rules();

        if ($this->form_validation->run() == FALSE) {
            $this->create();
        } else {
            $data = array(
		'kriteria_id' => $this->input->post('kriteria_id',TRUE),
		'rating_id' => $this->input->post('rating_id',TRUE),
	    );

            $this->Kriteria_rating_model->insert($data);
            $this->session->set_flashdata('message', 'Create Record Success');
            redirect(site_url('kriteria_rating'));
        }
    }
    
    public function update($id) 
    {
        $row = $this->Kriteria_rating_model->get_by_id($id);

        if ($row) {
            $data = array(
                'button' => 'Update',
                'action' => site_url('kriteria_rating/update_action'),
		'id' => set_value('id', $row->id),
		'kriteria_id' => set_value('kriteria_id', $row->kriteria_id),
		'rating_id' => set_value('rating_id', $row->rating_id),
	    );
            $this->load->view('kriteria_rating/kriteria_rating_form', $data);
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('kriteria_rating'));
        }
    }
    
    public function update_action() 
    {
        $this->_rules();

        if ($this->form_validation->run() == FALSE) {
            $this->update($this->input->post('id', TRUE));
        } else {
            $data = array(
		'kriteria_id' => $this->input->post('kriteria_id',TRUE),
		'rating_id' => $this->input->post('rating_id',TRUE),
	    );

            $this->Kriteria_rating_model->update($this->input->post('id', TRUE), $data);
            $this->session->set_flashdata('message', 'Update Record Success');
            redirect(site_url('kriteria_rating'));
        }
    }
    
    public function delete($id) 
    {
        $row = $this->Kriteria_rating_model->get_by_id($id);

        if ($row) {
            $this->Kriteria_rating_model->delete($id);
            $this->session->set_flashdata('message', 'Delete Record Success');
            redirect(site_url('kriteria_rating'));
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('kriteria_rating'));
        }
    }

    public function _rules() 
    {
	$this->form_validation->set_rules('kriteria_id', 'kriteria id', 'trim|required');
	$this->form_validation->set_rules('rating_id', 'rating id', 'trim|required');

	$this->form_validation->set_rules('id', 'id', 'trim');
	$this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');
    }

}

/* End of file Kriteria_rating.php */
/* Location: ./application/controllers/Kriteria_rating.php */
/* Please DO NOT modify this information : */
/* Generated by Harviacode Codeigniter CRUD Generator 2018-06-11 23:28:29 */
/* http://harviacode.com */