<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin_m extends CI_Model{
	public function showAllProduct(){
		
		$query = $this->db->get('product');
		if($query->num_rows() > 0){
			return $query->result();
		}else{
			return false;
		}
	}

	public function addProduct(){
		$field = array(
			'product_name'=>$this->input->post('product_name'),
			'product_code'=>$this->input->post('product_code'),
			'product_stock'=>$this->input->post('product_stock'),
			'product_image'=>$this->input->post('product_image'),
			'product_price'=>$this->input->post('product_price')
			
			);
		$this->db->insert('product', $field);
		if($this->db->affected_rows() > 0){
			return true;
		}else{
			return false;
		}
	}

	public function editProduct(){
		$product_id = $this->input->get('product_id');
		$this->db->where('product_id', $product_id);
		$query = $this->db->get('product');
		if($query->num_rows() > 0){
			return $query->row();
		}else{
			return false;
		}
	}

	public function updateProduct(){
		$product_id = $this->input->post('product_id');
		$field = array(
		'product_name'=>$this->input->post('product_name'),
		'product_code'=>$this->input->post('product_code'),
		'product_stock'=>$this->input->post('product_stock'),
		'prodcuct_image'=>$this->input->post('product_image'),
		'product_price'=>$this->input->post('product_price')
		
		);
		$this->db->where('product_id', $product_id);
		$this->db->update('product', $field);
		if($this->db->affected_rows() > 0){
			return true;
		}else{
			return false;
		}
	}

	function deleteProduct(){
		$product_id = $this->input->get('product_id');
		$this->db->where('product_id', $product_id);
		$this->db->delete('product');
		if($this->db->affected_rows() > 0){
			return true;
		}else{
			return false;
		}
	}
}