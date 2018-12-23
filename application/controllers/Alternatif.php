<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Alternatif extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model('Alternatif_model');
        $this->load->library('form_validation');
    }

    public function index()
    {
        $q = urldecode($this->input->get('q', TRUE));
        $start = intval($this->input->get('start'));
        
        if ($q <> '') {
            $config['base_url'] = base_url() . 'alternatif/index.html?q=' . urlencode($q);
            $config['first_url'] = base_url() . 'alternatif/index.html?q=' . urlencode($q);
        } else {
            $config['base_url'] = base_url() . 'alternatif/index.html';
            $config['first_url'] = base_url() . 'alternatif/index.html';
        }

        $config['per_page'] = 10;
        $config['page_query_string'] = TRUE;
        $config['total_rows'] = $this->Alternatif_model->total_rows($q);
        $alternatif = $this->Alternatif_model->get_limit_data($config['per_page'], $start, $q);

        $this->load->library('pagination');
        $this->pagination->initialize($config);

        $data = array(
            'alternatif_data' => $alternatif,
            'q' => $q,
            'pagination' => $this->pagination->create_links(),
            'total_rows' => $config['total_rows'],
            'start' => $start,
        );
        $this->load->view('alternatif/alternatif_list', $data);
    }

    public function read($id) 
    {
        $row = $this->Alternatif_model->get_by_id($id);
        if ($row) {
            $data = array(
		'id' => $row->id,
		'nama' => $row->nama,
		'kelas' => $row->kelas,
		'no_induk' => $row->no_induk,
	    );
            $this->load->view('alternatif/alternatif_read', $data);
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('alternatif'));
        }
    }

    public function create() 
    {
        $data = array(
            'button' => 'Create',
            'action' => site_url('alternatif/create_action'),
	    'id' => set_value('id'),
	    'nama' => set_value('nama'),
	    'kelas' => set_value('kelas'),
	    'no_induk' => set_value('no_induk'),
	);
        $this->load->view('alternatif/alternatif_form', $data);
    }
    
    public function create_action() 
    {
        $this->_rules();

        if ($this->form_validation->run() == FALSE) {
            $this->create();
        } else {
            $data = array(
		'nama' => $this->input->post('nama',TRUE),
		'kelas' => $this->input->post('kelas',TRUE),
		'no_induk' => $this->input->post('no_induk',TRUE),
	    );

            $this->Alternatif_model->insert($data);
            $this->session->set_flashdata('message', 'Create Record Success');
            redirect(site_url('alternatif'));
        }
    }
    
    public function update($id) 
    {
        $row = $this->Alternatif_model->get_by_id($id);

        if ($row) {
            $data = array(
                'button' => 'Update',
                'action' => site_url('alternatif/update_action'),
		'id' => set_value('id', $row->id),
		'nama' => set_value('nama', $row->nama),
		'kelas' => set_value('kelas', $row->kelas),
		'no_induk' => set_value('no_induk', $row->no_induk),
	    );
            $this->load->view('alternatif/alternatif_form', $data);
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('alternatif'));
        }
    }
    
    public function update_action() 
    {
        $this->_rules();

        if ($this->form_validation->run() == FALSE) {
            $this->update($this->input->post('id', TRUE));
        } else {
            $data = array(
		'nama' => $this->input->post('nama',TRUE),
		'kelas' => $this->input->post('kelas',TRUE),
		'no_induk' => $this->input->post('no_induk',TRUE),
	    );

            $this->Alternatif_model->update($this->input->post('id', TRUE), $data);
            $this->session->set_flashdata('message', 'Update Record Success');
            redirect(site_url('alternatif'));
        }
    }
    
    public function delete($id) 
    {
        $row = $this->Alternatif_model->get_by_id($id);

        if ($row) {
            $this->Alternatif_model->delete($id);
            $this->session->set_flashdata('message', 'Delete Record Success');
            redirect(site_url('alternatif'));
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('alternatif'));
        }
    }

    public function _rules() 
    {
	$this->form_validation->set_rules('nama', 'nama', 'trim|required');
	$this->form_validation->set_rules('kelas', 'kelas', 'trim|required');
	$this->form_validation->set_rules('no_induk', 'no induk', 'trim|required');

	$this->form_validation->set_rules('id', 'id', 'trim');
	$this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');
    }

}

/* End of file Alternatif.php */
/* Location: ./application/controllers/Alternatif.php */
/* Please DO NOT modify this information : */
/* Generated by Harviacode Codeigniter CRUD Generator 2018-06-11 22:16:04 */
/* http://harviacode.com */