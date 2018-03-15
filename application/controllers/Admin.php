<?php
defined('BASEPATH') OR exit('No direct script access allowed');

Class Admin extends CI_Controller{
	function __construct(){
		parent:: __construct();
		$this->load->model('admin_m', 'm');
	}

	function index(){
		$this->load->view('layout/header');
		$this->load->view('admin/index');
		$this->load->view('layout/footer');
	}

	public function showAllProduct(){
		$result = $this->m->showAllProduct();
		echo json_encode($result);
	}

	public function addProduct(){
		$result = $this->m->addProduct();
		$msg['success'] = false;
		$msg['type'] = 'add';
		if($result){
			$msg['success'] = true;
		}
		echo json_encode($msg);
	}

	public function editProduct(){
		$result = $this->m->editProduct();
		echo json_encode($result);
	}

	public function updateProduct(){
		$result = $this->m->updateProduct();
		$msg['success'] = false;
		$msg['type'] = 'update';
		if($result){
			$msg['success'] = true;
		}
		echo json_encode($msg);
	}

	public function deleteProduct(){
		$result = $this->m->deleteProduct();
		$msg['success'] = false;
		if($result){
			$msg['success'] = true;
		}
		echo json_encode($msg);
	}

}