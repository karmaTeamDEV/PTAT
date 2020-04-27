
<?php

class Member_model extends CI_Model {
		
	function update_data_table($data, $filed, $id, $table){
		//echo $id;exit;
		$this->db->where($filed, $id);
		$query = $this->db->update($table,$data); 
		return $id; 
	}	
	function ins_data_table($data,$table)
	{
		$this->db->insert($table, $data);
		//echo $this->db->last_query();
		return $this->db->insert_id();
	} 
	function login_member($email,$password){
		$sql = "SELECT id,email,company_id,role,first_name,last_name,status
				  FROM users
				  WHERE email = ".$this->db->escape($email)." 
				  AND password=".$this->db->escape($password)." ";
				   
		 $query = $this->db->query($sql);
		 return $query->result_array();
	}

	function get_company_logo($company_id){
		$sql = "SELECT company_name,logo FROM `master_company`
				WHERE id = ".$this->db->escape($company_id)." ";
				   
		 $query = $this->db->query($sql);
		 return $query->result_array();
	}
	
}
?>