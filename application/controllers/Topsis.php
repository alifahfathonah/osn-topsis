<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Topsis extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model('Topsis_model');
        $this->load->model('Alternatif_model');
        $this->load->model('Kriteria_model');
        $this->load->model('Rating_model');
        $this->load->model('Kriteria_rating_model');
        $this->load->library('form_validation');
    }

    public function index()
    {
        $dtTopsis = array();
        $normalisasi = array();
        $x = array();
        $r = array();
        $kriteria = $this->Kriteria_model->get_all();
        $alternatif =  $this->Alternatif_model->get_all();

        foreach($kriteria as $ktr){
            $x[$ktr->kode] = 0;
        }

        foreach ($alternatif as $alt) {
            $dtTopsis[$alt->id] = $this->Topsis_model->getVallByAltId($alt->id);
            if(!empty($dtTopsis[$alt->id])){
                $arrTopsis[$alt->id] = $this->Topsis_model->getVallByAltId($alt->id);
                $i=0;
                foreach($kriteria as $ktr){
                    $x[$ktr->kode] += pow($arrTopsis[$alt->id][$i]->nilai, 2);
                    $i++;
                }
                $dMax[$alt->id] = 0;
                $dMin[$alt->id] = 0;
            }
            
        }

        $j=0;
        foreach($kriteria as $ktr){
            $x_val[$ktr->kode] = sqrt($x[$ktr->kode]);
            foreach($alternatif as $alt){
                if(!empty($arrTopsis[$alt->id][$j])){
                    $hasilBagi = $arrTopsis[$alt->id][$j]->nilai / $x_val[$ktr->kode];
                    $r[$ktr->kode][$alt->id] = $hasilBagi;
    
                    $kaliBobot = $arrTopsis[$alt->id][$j]->bobot * $r[$ktr->kode][$alt->id];
                    $y[$ktr->kode][$alt->id] = $kaliBobot;
                }
               
            }
            $j++;

            $max[$ktr->kode] = max($y[$ktr->kode]);
            $min[$ktr->kode] = min($y[$ktr->kode]);
        }

        
        $hasil = array();
        foreach ($alternatif as $alt) {
            // d
            foreach ($kriteria as $ktr) {
                if(!empty($y[$ktr->kode][$alt->id])){
                    $dMax[$alt->id] += pow($max[$ktr->kode] - $y[$ktr->kode][$alt->id], 2);
                    $dMin[$alt->id] += pow($min[$ktr->kode] - $y[$ktr->kode][$alt->id], 2);
                } 
                
            }           
        }

        foreach ($alternatif as $alt) {
            if(!empty($dtTopsis[$alt->id])){
                $valDmax[$alt->id] = sqrt($dMax[$alt->id]);
                $valDmin[$alt->id] = sqrt($dMin[$alt->id]);
                
                $val = $valDmin[$alt->id] / ($valDmin[$alt->id] +  $valDmax[$alt->id]);

                $hasil[] = $val." (".$alt->nama." )";

            }
            
        }
        rsort($hasil);


        var_dump($arrTopsis);
        // echo "value x";
        // var_dump($x_val);
        echo "value r";
        var_dump($r);
        echo "value y";
        var_dump($y);
        // echo "value max";
        // var_dump($max);
        // echo "value min";
        // var_dump($min);
        // echo "result D";
        // var_dump($valDmax);
        // var_dump($valDmin);
        // echo "hasil";
        // var_dump($hasil);

        //  var_dump($kriteria);
        var_dump($alternatif);
        // die();
        
        $data = array(
            'kriteria' => $kriteria,
            'alternatif' => $alternatif,
            'topsis_data' => $arrTopsis,
            'x_val' => $x_val,
            'hasil' => $hasil,
            'r' => $r,
            'y' => $y,
            
        );

        
        $this->load->view('topsis/topsis_list', $data);
    }

    public function read($id) 
    {
        $row = $this->Topsis_model->get_by_id($id);
        if ($row) {
                $data = array(
            'id' => $row->id,
            'alternatif_id' => $row->alternatif_id,
            'kriteria_id' => $row->kriteria_id,
            'nilai' => $row->nilai,
            );
            $this->load->view('topsis/topsis_read', $data);
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('topsis'));
        }
    }

    public function create() 
    {
        $alternatif =  $this->Alternatif_model->get_all();
        $kriteria = $this->Kriteria_model->get_all();
        foreach ($kriteria as $value) {
            $kriteria_rating = $this->Kriteria_rating_model->get_by_id_kriteria($value->id);
            foreach($kriteria_rating as $kr){
                $rating = $this->Rating_model->get_by_id($kr->rating_id);
                $rating_val[$value->id]['id'][] = $rating->name;
                $rating_val[$value->id]['name'][] = $rating->name;
                $rating_val[$value->id]['rating'][] = $rating->rating;
                $rating_val[$value->id]['keterangan'][] = $rating->keterangan;
            }
        }
        $data = array(
            'button' => 'Create',
            'action' => site_url('topsis/create_action'),
            'id' => set_value('id'),
            'alternatif_id' => set_value('alternatif_id'),
            'kriteria_id' => set_value('kriteria_id'),
            'nilai' => set_value('nilai'),
            'alternatif' => $alternatif,
            'kriteria' => $kriteria,
            'rating_val' => $rating_val,
        );
        $this->load->view('topsis/topsis_form', $data);
    }
    
    public function create_action() 
    {
        //$this->_rules();
        $kriteria = $this->Kriteria_model->get_all();
        // if ($this->form_validation->run() == FALSE) {
        //     $this->create();
        // } else {
            $alternatifId = $this->input->post('alternatif_id',TRUE);
            $data['alternatif_id'] =  $alternatifId;
            foreach($kriteria as $value){
                $data[$alternatifId][$value->id] =  $this->input->post('kriteria_'.$value->kode,TRUE);
                $data = array(
                    'alternatif_id' => $alternatifId,
                    'kriteria_id' => $value->id,
                    'nilai' => $this->input->post('kriteria_'.$value->kode,TRUE),
                );
                $this->Topsis_model->insert($data);
            }
            $this->session->set_flashdata('message', 'Create Record Success');
            redirect(site_url('topsis'));
        //}
    }
    
    public function update($id) 
    {
        $row = $this->Topsis_model->get_by_id($id);

        if ($row) {
            $data = array(
                'button' => 'Update',
                'action' => site_url('topsis/update_action'),
		'id' => set_value('id', $row->id),
		'alternatif_id' => set_value('alternatif_id', $row->alternatif_id),
		'kriteria_id' => set_value('kriteria_id', $row->kriteria_id),
		'nilai' => set_value('nilai', $row->nilai),
	    );
            $this->load->view('topsis/topsis_form', $data);
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('topsis'));
        }
    }
    
    public function update_action() 
    {
        $this->_rules();

        if ($this->form_validation->run() == FALSE) {
            $this->update($this->input->post('id', TRUE));
        } else {
            $data = array(
		'alternatif_id' => $this->input->post('alternatif_id',TRUE),
		'kriteria_id' => $this->input->post('kriteria_id',TRUE),
		'nilai' => $this->input->post('nilai',TRUE),
	    );

            $this->Topsis_model->update($this->input->post('id', TRUE), $data);
            $this->session->set_flashdata('message', 'Update Record Success');
            redirect(site_url('topsis'));
        }
    }
    
    public function delete($id) 
    {
        $row = $this->Topsis_model->get_by_id($id);

        if ($row) {
            $this->Topsis_model->delete($id);
            $this->session->set_flashdata('message', 'Delete Record Success');
            redirect(site_url('topsis'));
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('topsis'));
        }
    }


    public function _rules() 
    {
	$this->form_validation->set_rules('alternatif_id', 'alternatif id', 'trim|required');
	$this->form_validation->set_rules('kriteria_id', 'kriteria id', 'trim|required');
	$this->form_validation->set_rules('nilai', 'nilai', 'trim|required|numeric');

	$this->form_validation->set_rules('id', 'id', 'trim');
	$this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');
    }

}

/* End of file Topsis.php */
/* Location: ./application/controllers/Topsis.php */
/* Please DO NOT modify this information : */
/* Generated by Harviacode Codeigniter CRUD Generator 2018-06-11 23:28:40 */
/* http://harviacode.com */