<?php

defined('BASEPATH') OR exit('No direct script access allowed');

include APPPATH."libraries/phpqrcode/qrlib.php";

class Koleksi extends CI_Controller{

  function __construct(){
    parent::__construct();
    if($this->session->nama == "" AND $this->session->role == ""){
      redirect(base_url("login"));
    }
    $this->load->model('m_koleksi');
  }

  function index(){
    $data['subheading'] = 'Koleksi';
    $this->load->view('header', $data);
    $data['koleksi'] = $this->m_koleksi->tampil()->result_array();
    $this->load->view('koleksi/koleksi', $data);
    $this->load->view('footer');
  }

  function lihat($no_inventaris){
    $data['subheading'] = 'Koleksi';
    $data['subheadingurl'] = 'koleksi';
    $data['subsubheading'] = $this->m_koleksi->tampil_detail($no_inventaris)->row()->nama_koleksi;
    $this->load->view('header', $data);
    $data['koleksi'] = $this->m_koleksi->tampil_detail($no_inventaris)->row_array();
    $this->load->view('koleksi/detail-koleksi', $data);
    $this->load->view('footer');
  }

  function tambah(){
    $data['subheading'] = 'Koleksi';
    $data['subheadingurl'] = 'koleksi';
    $data['subsubheading'] = 'Tambah Data';
    $this->load->view('header', $data);
    $this->load->view('koleksi/tambah-koleksi');
    $this->load->view('footer');
  }

  function tambah_proses(){
    $this->form_validation->set_rules('nama_koleksi', 'Nama Koleksi', 'required',
    array('required' => '%s tidak boleh kosong'));
    $this->form_validation->set_rules('tanggal_masuk', 'Tanggal Masuk', 'required',
    array('required' => '%s tidak boleh kosong'));
    $this->form_validation->set_rules('jenis', 'Jenis Koleksi', 'required',
    array('required' => '%s tidak boleh kosong'));

    if ($this->form_validation->run() == FALSE){
      $data['subheading'] = 'Koleksi';
      $data['subheadingurl'] = 'koleksi';
      $data['subsubheading'] = 'Tambah Data';
      $data = array(
        'nama_koleksi' => set_value('nama_koleksi', ''),
        'jenis' => set_value('jenis', ''),
        'tanggal_pembuatan' => set_value('tanggal_pembuatan', ''),
        'bentuk' => set_value('bentuk', ''),
        'nilai' => set_value('nilai', ''),
        'bahan' => set_value('bahan', ''),
        'teknik_pembuatan' => set_value('teknik_pembuatan', ''),
        'deskripsi' => set_value('deskripsi', ''),
        'foto' => set_value('foto', ''),
        'tanggal_masuk' => set_value('tanggal_masuk', ''),
        'daerah_asal' => set_value('daerah_asal', ''),
        'banyaknya' => set_value('banyaknya', ''),
        'ukuran' => set_value('ukuran', ''),
        'audio' => set_value('audio', ''),
        'sejarah' => set_value('sejarah', ''),
        'kondisi' => set_value('kondisi', ''),
        'tanggal_pemakaian' => set_value('tanggal_pemakaian', ''),
        'warna' => set_value('warna', '')
      );
      $this->load->view('header', $data);
      $this->load->view('koleksi/tambah-koleksi');
      $this->load->view('footer');
    }
    else{
      $nama_koleksi = $this->input->post('nama_koleksi');
      $jenis = $this->input->post('jenis');
      $tanggal_pembuatan = $this->input->post('tanggal_pembuatan');
      $bentuk = $this->input->post('bentuk');
      $nilai = $this->input->post('nilai');
      $bahan = $this->input->post('bahan');
      $teknik_pembuatan = $this->input->post('teknik_pembuatan');
      $deskripsi = $this->input->post('deskripsi');
      $tanggal_masuk = $this->input->post('tanggal_masuk');
      $daerah_asal = $this->input->post('daerah_asal');
      $banyaknya = $this->input->post('banyaknya');
      $ukuran = $this->input->post('ukuran');
      $sejarah = $this->input->post('sejarah');
      $kondisi = $this->input->post('kondisi');
      $tanggal_pemakaian = $this->input->post('tanggal_pemakaian');
      $warna = $this->input->post('warna');

      if($jenis == 'peralatan'){
        $no_inventaris = "1".substr($this->m_koleksi->cek_no()->row()->no_inventaris, 1)+1;
      }
      else{
        $no_inventaris = "2".substr($this->m_koleksi->cek_no()->row()->no_inventaris, 1)+1;
      }

      $folder= "./uploads/qrcodes/".$no_inventaris.".png";
      QRcode::png($no_inventaris, $folder, 'H', 20, 5);

      $data = array(
        'no_inventaris' => $no_inventaris,
        'nama_koleksi' => $nama_koleksi,
        'jenis' => $jenis,
        'tanggal_pembuatan' => $tanggal_pembuatan,
        'bentuk' => $bentuk,
        'nilai' => $nilai,
        'bahan' => $bahan,
        'teknik_pembuatan' => $teknik_pembuatan,
        'deskripsi' => $deskripsi,
        'tanggal_masuk' => $tanggal_masuk,
        'daerah_asal' => $daerah_asal,
        'banyaknya' => $banyaknya,
        'ukuran' => $ukuran,
        'bentuk' => $bentuk,
        'sejarah' => $sejarah,
        'kondisi' => $kondisi,
        'tanggal_pemakaian' => $tanggal_pemakaian,
        'warna' => $warna,
        'kode_qr' => base_url(substr($folder,2))
      );

      $config['allowed_types'] = 'gif|jpg|png|jpeg|mp3|wav';
      $config['file_name'] = $no_inventaris;
      $config['upload_path'] = "./uploads/files/";

      if(isset($_FILES['foto']) && $_FILES['foto']['size'] != 0){

        $this->load->library('upload', $config);

        if ($this->upload->do_upload('foto')){
          $data['foto'] = $this->upload->data('full_path');
        }
      }

      if(isset($_FILES['audio'])){
        $this->load->library('upload', $config);

        print_r($this->upload->do_upload());

        if ($this->upload->do_upload('audio')){
          $data['audio'] = $this->upload->data('full_path');
        }else{
          echo 'woy';
        }
      }
      else{
        echo 'w';
      }
      print_r($data);
      $this->m_koleksi->tambah($data);
      redirect(base_url('koleksi'));
    }
  }

  function hapus($no_inventaris){
    $this->m_koleksi->hapus($no_inventaris);
    redirect(base_url('koleksi'));
  }

}

?>
