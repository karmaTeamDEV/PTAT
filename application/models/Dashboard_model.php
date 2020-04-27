
<?php

class Dashboard_model extends CI_Model {
		
	function update_data_table($data, $filed, $id, $table){
		//echo $id;exit;
		$this->db->where($filed, $id);
		$query = $this->db->update($table,$data); 
		return $id; 
	}	
	function ins_data_table($data,$table)
	{
		$this->db->insert($table, $data);
		//echo $this->db->last_query();exit;
		return $this->db->insert_id();
	} 

	function select_all_data_table($table) 
	{
		$query = $this->db->get($table);
		return $query->result_array(); 
	}
	
	function select_level_by_company($company_id){

		 $sql = " SELECT `id`,`company_id`,`level`,`description` 
		 		  FROM `master_levels`
		          WHERE company_id = ".$this->db->escape($company_id)."
		          AND status='0'";
		          //echo $sql;
		 $query = $this->db->query($sql);
		 return $query->result_array();
	}

	function select_all_company_biz($company_id){

		 $sql = " SELECT `id`,`business_impact`,`description`,`measure`,`status`,`ordering` 
				FROM `master_biz_impact` 
				WHERE company_id=".$this->db->escape($company_id)."
				AND status='0'
				ORDER BY `ordering`  ASC";
		 $query = $this->db->query($sql);
		 return $query->result_array();
	}

	function select_all_business_outcome($company_id){

		 $sql = " SELECT `id`,`business_impact`,`description`,`measure`,`status`,`ordering` 
				FROM `master_biz_impact` 
				WHERE company_id=".$this->db->escape($company_id)."
				AND status='0'
				ORDER BY business_impact  ASC";
		 $query = $this->db->query($sql);
		 return $query->result_array();
	}

	function select_all_color(){

		 $sql = " SELECT `id`,`name`,`class`
				FROM `master_color` 				
				ORDER BY `ordering`  ASC";
		 $query = $this->db->query($sql);
		 return $query->result_array();
	}


	function select_all_transaction_by_company($level_id,$company_id,$status_id,$business_impact_id,$end_date,$active_only,$stage_id){

			if($active_only){
				$filter_sql.=" AND tran_status.status='1' ";
			}

			if($end_date){
				$filter_sql.=" AND tran_status.end_date<=".$this->db->escape($end_date)."";
			}
			if($business_impact_id){
				$filter_sql.=" AND tran_outcomes.business_impact_id in (".$business_impact_id.")";
			}
			if($stage_id){
				$filter_sql.=" AND master_stages.id in (".$stage_id.")";
			}


		 $sql = "SELECT tran_outcomes.id,tran_outcomes.outcomes,master_stages.color,tran_status.id as tran_status_id,
				 tran_status.status_id,master_status.name,tran_status.start_date,tran_status.end_date,master_stages.stage,master_levels.level,master_biz_impact.business_impact, tran_status.status as outcome_status,tran_outcomes.description
				 
		 		 FROM `tran_outcomes` 
		 		 LEFT JOIN tran_status ON(tran_outcomes.id=tran_status.tran_outcome_id) 
		 		 LEFT JOIN master_stages ON(tran_outcomes.stage_id=master_stages.id) 
		 		 LEFT JOIN master_status ON(tran_status.status_id=master_status.id) 
		 		 LEFT JOIN master_levels ON(tran_outcomes.level_id=master_levels.id)
		 		 LEFT JOIN master_biz_impact ON(tran_outcomes.business_impact_id=master_biz_impact.id)
		 		
		 		 WHERE tran_outcomes.company_id=".$this->db->escape($company_id)."
		 		 AND tran_outcomes.status='0'
		 		 AND tran_status.status_id=".$this->db->escape($status_id)."
		 		 AND tran_outcomes.level_id=".$this->db->escape($level_id)." $filter_sql";
		 	//echo  $sql."<br><br>" ;//exit;
		 $query = $this->db->query($sql);
		 return $query->result_array();
	}
	/*function select_all_transaction_by_level($company_id,$level_id,$data_date){
		 $sql = "SELECT A.*,C.total,C.score,C.comment FROM
(SELECT tran_outcomes.id,tran_outcomes.outcomes,master_stages.color,tran_status.id AS tran_status_id, tran_status.status_id,master_status.name,
tran_status.start_date,tran_status.end_date,master_stages.stage ,master_levels.level,master_biz_impact.business_impact 
FROM `tran_outcomes` LEFT JOIN tran_status ON(tran_outcomes.id=tran_status.tran_outcome_id) 
LEFT JOIN master_stages ON(tran_outcomes.stage_id=master_stages.id) 
LEFT JOIN master_status ON(tran_status.status_id=master_status.id) 
LEFT JOIN master_levels ON(tran_outcomes.level_id=master_levels.id) 
LEFT JOIN master_biz_impact ON(tran_outcomes.business_impact_id=master_biz_impact.id) 
WHERE tran_outcomes.company_id=".$this->db->escape($company_id)." AND master_levels.id=".$this->db->escape($level_id)." ) AS A JOIN 
(SELECT tran_outcomes.id, MAX(tran_status.start_date) AS start_date
FROM `tran_outcomes` LEFT JOIN tran_status ON(tran_outcomes.id=tran_status.tran_outcome_id) 
LEFT JOIN master_stages ON(tran_outcomes.stage_id=master_stages.id) 
LEFT JOIN master_status ON(tran_status.status_id=master_status.id) 
LEFT JOIN master_levels ON(tran_outcomes.level_id=master_levels.id) 
LEFT JOIN master_biz_impact ON(tran_outcomes.business_impact_id=master_biz_impact.id) 
WHERE tran_outcomes.company_id=".$this->db->escape($company_id)." AND master_levels.id=".$this->db->escape($level_id)."  GROUP BY tran_outcomes.id) AS B ON(A.id=B.id AND A.start_date=B.start_date) LEFT JOIN spider_chart_data AS C ON (A.id=C.outcome_id AND C.company_id=".$this->db->escape($company_id)." AND C.data_date=".$this->db->escape(date('Y-m-d',strtotime($data_date))).")";
//echo $sql;exit;
		 $query = $this->db->query($sql);
		 return $query->result_array();

	}*/
	function select_all_transaction_by_level($company_id,$level_id,$data_date){
		 $sql = "SELECT DISTINCT A.id,A.*,C.total,C.score,C.comment FROM
(SELECT tran_outcomes.id,MAX(tran_status.id) AS tran_status_id 
FROM `tran_outcomes` LEFT JOIN tran_status ON(tran_outcomes.id=tran_status.tran_outcome_id) 
LEFT JOIN master_stages ON(tran_outcomes.stage_id=master_stages.id) 
LEFT JOIN master_status ON(tran_status.status_id=master_status.id) 
LEFT JOIN master_levels ON(tran_outcomes.level_id=master_levels.id) 
LEFT JOIN master_biz_impact ON(tran_outcomes.business_impact_id=master_biz_impact.id) 
WHERE tran_outcomes.company_id=".$this->db->escape($company_id)." AND master_levels.id=".$this->db->escape($level_id)."  GROUP BY tran_outcomes.id) AS B
 LEFT JOIN 
 (SELECT tran_outcomes.id,tran_outcomes.outcomes,master_stages.color,tran_status.id AS tran_status_id, tran_status.status_id,master_status.name,
tran_status.start_date,tran_status.end_date,master_stages.stage ,master_levels.level,master_biz_impact.business_impact 
FROM `tran_outcomes` LEFT JOIN tran_status ON(tran_outcomes.id=tran_status.tran_outcome_id) 
LEFT JOIN master_stages ON(tran_outcomes.stage_id=master_stages.id) 
LEFT JOIN master_status ON(tran_status.status_id=master_status.id) 
LEFT JOIN master_levels ON(tran_outcomes.level_id=master_levels.id) 
LEFT JOIN master_biz_impact ON(tran_outcomes.business_impact_id=master_biz_impact.id) 
WHERE tran_outcomes.company_id=".$this->db->escape($company_id)." AND master_levels.id=".$this->db->escape($level_id)." ) AS A
 ON(B.id=A.id AND B.tran_status_id=A.tran_status_id) 
LEFT JOIN spider_chart_data AS C ON (A.id=C.outcome_id AND C.company_id=".$this->db->escape($company_id)." AND C.data_date=".$this->db->escape(date('Y-m-d',strtotime($data_date))).")  WHERE A.id IS NOT NULL ";
//echo $sql;exit;
		 $query = $this->db->query($sql);
		 return $query->result_array();

	}
	function select_all_transaction_by_level_only($company_id,$level_id){
		 $sql = "SELECT DISTINCT A.id,A.outcomes FROM
(SELECT tran_outcomes.id,tran_outcomes.outcomes,master_stages.color,tran_status.id AS tran_status_id, tran_status.status_id,master_status.name,
tran_status.start_date,tran_status.end_date,master_stages.stage ,master_levels.level,master_biz_impact.business_impact 
FROM `tran_outcomes` LEFT JOIN tran_status ON(tran_outcomes.id=tran_status.tran_outcome_id) 
LEFT JOIN master_stages ON(tran_outcomes.stage_id=master_stages.id) 
LEFT JOIN master_status ON(tran_status.status_id=master_status.id) 
LEFT JOIN master_levels ON(tran_outcomes.level_id=master_levels.id) 
LEFT JOIN master_biz_impact ON(tran_outcomes.business_impact_id=master_biz_impact.id) 
WHERE tran_outcomes.company_id=".$this->db->escape($company_id)." AND master_levels.id=".$this->db->escape($level_id)." ) AS A JOIN 
(SELECT tran_outcomes.id, MAX(tran_status.start_date) AS start_date
FROM `tran_outcomes` LEFT JOIN tran_status ON(tran_outcomes.id=tran_status.tran_outcome_id) 
LEFT JOIN master_stages ON(tran_outcomes.stage_id=master_stages.id) 
LEFT JOIN master_status ON(tran_status.status_id=master_status.id) 
LEFT JOIN master_levels ON(tran_outcomes.level_id=master_levels.id) 
LEFT JOIN master_biz_impact ON(tran_outcomes.business_impact_id=master_biz_impact.id) 
WHERE tran_outcomes.company_id=".$this->db->escape($company_id)." AND master_levels.id=".$this->db->escape($level_id)."  GROUP BY tran_outcomes.id) AS B ON(A.id=B.id AND A.start_date=B.start_date) LEFT JOIN spider_chart_data AS C ON (A.id=C.outcome_id AND C.company_id=".$this->db->escape($company_id)." )  ORDER BY A.id";
//echo $sql;exit;
		 $query = $this->db->query($sql);
		 return $query->result_array();


	}
	function select_all_transaction_by_level_with_data($company_id,$level_id){
		 $sql = "SELECT A.*,C.data_date,C.total,C.score FROM
(SELECT tran_outcomes.id,tran_outcomes.outcomes,master_stages.color,tran_status.id AS tran_status_id, tran_status.status_id,master_status.name,
tran_status.start_date,tran_status.end_date,master_stages.stage ,master_levels.level,master_biz_impact.business_impact 
FROM `tran_outcomes` LEFT JOIN tran_status ON(tran_outcomes.id=tran_status.tran_outcome_id) 
LEFT JOIN master_stages ON(tran_outcomes.stage_id=master_stages.id) 
LEFT JOIN master_status ON(tran_status.status_id=master_status.id) 
LEFT JOIN master_levels ON(tran_outcomes.level_id=master_levels.id) 
LEFT JOIN master_biz_impact ON(tran_outcomes.business_impact_id=master_biz_impact.id) 
WHERE tran_outcomes.company_id=".$this->db->escape($company_id)." AND master_levels.id=".$this->db->escape($level_id)." ) AS A JOIN 
(SELECT tran_outcomes.id, MAX(tran_status.start_date) AS start_date
FROM `tran_outcomes` LEFT JOIN tran_status ON(tran_outcomes.id=tran_status.tran_outcome_id) 
LEFT JOIN master_stages ON(tran_outcomes.stage_id=master_stages.id) 
LEFT JOIN master_status ON(tran_status.status_id=master_status.id) 
LEFT JOIN master_levels ON(tran_outcomes.level_id=master_levels.id) 
LEFT JOIN master_biz_impact ON(tran_outcomes.business_impact_id=master_biz_impact.id) 
WHERE tran_outcomes.company_id=".$this->db->escape($company_id)." AND master_levels.id=".$this->db->escape($level_id)."  GROUP BY tran_outcomes.id) AS B ON(A.id=B.id AND A.start_date=B.start_date) LEFT JOIN spider_chart_data AS C ON (A.id=C.outcome_id AND C.company_id=".$this->db->escape($company_id)." )  WHERE  C.data_date IS NOT NULL  ORDER BY C.data_date";
//echo $sql;exit;
		 $query = $this->db->query($sql);
		 return $query->result_array();

	}

	function get_current_status_by_outcome($tran_status_id){

		 $sql = " SELECT `id`,`tran_outcome_id`,`status_id`,`start_date`,`end_date`,`note`,`status` 
				FROM `tran_status` 
				WHERE id=".$this->db->escape($tran_status_id)."";
		 $query = $this->db->query($sql);
		 return $query->result_array();
	}
	function get_spider_data_by_company_date_outcome($company_id,$data_date,$outcome_id){

		 $sql = " SELECT id 
		 FROM `spider_chart_data`
		  WHERE company_id=".$this->db->escape($company_id)." 
		  AND  data_date=".$this->db->escape($data_date)." 
		  AND  outcome_id=".$this->db->escape($outcome_id)."";

		 $query = $this->db->query($sql);
		 $result=$query->result_array();
		 return $result[0]['id'];
	}
	function select_all_history_by_outcome_id($outcome_id){

		 $sql = " SELECT tran_status.id,master_status.name,tran_status.`start_date`,tran_status.`end_date`,tran_status.`note`,concat(users.first_name,' ',users.last_name) as add_by,tran_status.status
				FROM `tran_status`
                LEFT JOIN master_status ON(tran_status.status_id=master_status.id) 
                LEFT JOIN users ON(tran_status.status_changed_id=users.id) 
				WHERE tran_status.`tran_outcome_id`=".$this->db->escape($outcome_id)."	
				ORDER by tran_status.`id` DESC";
		 $query = $this->db->query($sql);
		 return $query->result_array();
	}

	function select_all_color_history_by_outcome_id($outcome_id){

		 $sql = " SELECT tran_color.id,master_color.name,tran_color.`start_date`,tran_color.`end_date`,tran_color.`note`,concat(users.first_name,' ',users.last_name) as add_by,tran_color.status
					FROM `tran_color`
	                LEFT JOIN master_color ON(tran_color.class_id=master_color.id) 
	                LEFT JOIN users ON(tran_color.status_changed_id=users.id) 
					WHERE tran_color.`tran_outcome_id`=".$this->db->escape($outcome_id)."
					ORDER by tran_color.`id` DESC";
		 $query = $this->db->query($sql);
		 return $query->result_array();
	}

	function select_all_comment_by_outcome_id($outcome_id){

		 // $sql = " SELECT outcome_comments.note,outcome_comments.added_date,concat(users.first_name,' ',users.last_name) as addBy
			// 	FROM `outcome_comments`               
   //              LEFT JOIN users ON(outcome_comments.added_by=users.id) 
			// 	WHERE outcome_comments.tran_outcome_id=".$this->db->escape($outcome_id)."
   //              ORDER by outcome_comments.added_date DESC";

		$sql="SELECT A.* FROM(
				SELECT outcome_comments.note,outcome_comments.added_date,concat(users.first_name,' ',users.last_name) as addBy
					FROM `outcome_comments`               
				    LEFT JOIN users ON(outcome_comments.added_by=users.id)         
					WHERE outcome_comments.tran_outcome_id=".$this->db->escape($outcome_id)."

				UNION ALL
				
				SELECT comment,add_date,concat(users.first_name,' ',users.last_name) as addBy
				 FROM spider_chart_data 
				 LEFT JOIN users ON(spider_chart_data.added_by=users.id)
				 WHERE outcome_id =".$this->db->escape($outcome_id)." AND comment != '') as A
				 ORDER BY A.added_date DESC";
		 $query = $this->db->query($sql);
		 return $query->result_array();
	}	
	function select_all_comment_action_by_outcome_id($outcome_id){

		 // $sql = " SELECT outcome_comments.note,outcome_comments.added_date,concat(users.first_name,' ',users.last_name) as addBy
			// 	FROM `outcome_comments`               
   //              LEFT JOIN users ON(outcome_comments.added_by=users.id) 
			// 	WHERE outcome_comments.tran_outcome_id=".$this->db->escape($outcome_id)."
   //              ORDER by outcome_comments.added_date DESC";

		

				$sql= "SELECT A.* FROM(
				SELECT 'Comment' AS row_type,'' AS NAME,outcome_comments.note,'' AS start_date,'' AS end_date,outcome_comments.added_date,CONCAT(users.first_name,' ',users.last_name) AS addBy
					FROM `outcome_comments`               
				    LEFT JOIN users ON(outcome_comments.added_by=users.id)         
					WHERE outcome_comments.tran_outcome_id=".$this->db->escape($outcome_id)."

				UNION ALL
				
				SELECT 'Comment' AS row_type,'' AS NAME,COMMENT AS note,'' AS start_date,'' AS end_date,add_date,CONCAT(users.first_name,' ',users.last_name) AS addBy
				 FROM spider_chart_data 
				 LEFT JOIN users ON(spider_chart_data.added_by=users.id)
				 WHERE outcome_id =".$this->db->escape($outcome_id)." AND COMMENT != ''
				 UNION ALL
				 
SELECT 'Status' AS row_type,master_status.name,tran_status.`note` ,tran_status.`start_date`,tran_status.`end_date`,tran_status.added_date AS add_date,CONCAT(users.first_name,' ',users.last_name) AS addBy
				FROM `tran_status`
                LEFT JOIN master_status ON(tran_status.status_id=master_status.id) 
                LEFT JOIN users ON(tran_status.status_changed_id=users.id) 
				WHERE tran_status.`tran_outcome_id`=".$this->db->escape($outcome_id)."	
	 UNION ALL			
	SELECT 'Color' AS row_type,master_color.name,tran_color.`note`,tran_color.`start_date`,tran_color.`end_date`,tran_color.added_date,CONCAT(users.first_name,' ',users.last_name) AS addBy
					FROM `tran_color`
	                LEFT JOIN master_color ON(tran_color.class_id=master_color.id) 
	                LEFT JOIN users ON(tran_color.status_changed_id=users.id) 
					WHERE tran_color.`tran_outcome_id`=".$this->db->escape($outcome_id)."			
							 
				 
				 ) AS A
				 ORDER BY A.added_date DESC";
				 //echo $sql."<br><br>";
		 $query = $this->db->query($sql);
		 return $query->result_array();
	}	

	function select_tran_color_by_outcome($outcome_id){

		 $sql = " SELECT tran_color.`id`,tran_color.`class_id`,tran_color.`start_date`,tran_color.`end_date`,tran_color.`note`,master_color.name,master_color.class
				FROM `tran_color` 
				LEFT JOIN master_color ON(tran_color.class_id=master_color.id) 
				WHERE tran_color.tran_outcome_id=".$this->db->escape($outcome_id)."
				AND tran_color.status='1'";
				//echo $sql;
		 $query = $this->db->query($sql);
		 return $query->result_array();
	}

	function select_business_impact_id($company_id){
		 $sql = " SELECT `business_impact_id` 
		 		 FROM `tran_outcomes` 
		 		  WHERE `company_id`=".$this->db->escape($company_id)."
				   group by `business_impact_id`
				   order by id 
				LIMIT 0,1";
		 $query = $this->db->query($sql);
		 $res = $query->result_array();
		 return $res[0]['business_impact_id'];
	}

	function select_message_by_type($msg){
		 $sql = " SELECT message 
		 FROM `message_list`
		 WHERE type= ".$this->db->escape($msg)." ";
		 $query = $this->db->query($sql);
		 $res = $query->result_array();
		 return $res[0]['message'];
	}

	function evaluation_results_line_chart_data($company_id){
		 $sql = "SELECT erd.stage_id ,stg.stage,DATE_FORMAT(erd.data_date,'%m-%Y') data_date,erd.score FROM evaluation_results_line_chart_data AS erd 
JOIN master_stages AS stg ON(erd.stage_id=stg.id) WHERE erd.company_id='1' ORDER BY erd.stage_id,erd.data_date";
				//echo $sql;
		 $query = $this->db->query($sql);
		 return $query->result_array();

	}
	function evaluation_results_line_chart_date_only($company_id){
		 $sql = "SELECT  DISTINCT DATE_FORMAT(erd.data_date,'%m-%Y') f_data_date FROM evaluation_results_line_chart_data AS erd 
JOIN master_stages AS stg ON(erd.stage_id=stg.id) WHERE erd.company_id='1' ORDER BY erd.stage_id,erd.data_date";
				//echo $sql;
		 $query = $this->db->query($sql);
		 return $query->result_array();

}

	function select_all_company(){
		 $sql = "SELECT id,company_name,logo
				  FROM `master_company`
				  WHERE status='0'";
		 //echo $sql;
		 $query = $this->db->query($sql);
		 return $query->result_array();
	}

	function select_all_userList($id='',$company_id){
		if($id){
			$ssql="AND users.`id`= ".$this->db->escape($id)."";
		}
		 $sql = "SELECT users.`id` ,users.`role`,users.`first_name`,users.`last_name`,
		 		users.`email`,users.`password`,users.`status`,users.company_id,(CASE
               WHEN users.`status` = 0 THEN 'Active' ELSE 'In-Active' END)  as user_status
		 		FROM `users` 		 		 
		 		WHERE users.company_id= ".$this->db->escape($company_id)."
		 		$ssql ";
		 //echo $sql;
		 $query = $this->db->query($sql);
		 return $query->result_array();
	}


	function select_all_companyList($company_id){
		if($company_id){
			$ssql=" AND `id`= ".$this->db->escape($company_id)."";
		}
		 $sql = "SELECT id,company_name,logo,address,status,description
				  FROM `master_company`
				  WHERE 1
		 		$ssql ";
		 //echo $sql;
		 $query = $this->db->query($sql);
		 return $query->result_array();
	}

	function select_all_biz_impactList($id='',$company_id){
		if($id){
			$ssql="AND master_biz_impact.`id`= ".$this->db->escape($id)."";
		}
		 $sql = "SELECT master_biz_impact.`id`, master_biz_impact.`company_id`, master_biz_impact.`business_impact`, master_biz_impact.`description`, master_biz_impact.`measure`, master_biz_impact.`status`, master_biz_impact.`ordering`,(CASE  WHEN master_biz_impact.`status` = 0 THEN 'Active' ELSE 'In-Active' END)  as biz_status 

		 		FROM `master_biz_impact` 		 		 
		 		WHERE  master_biz_impact.company_id= ".$this->db->escape($company_id)."
		 		$ssql ";
		 //echo $sql;
		 $query = $this->db->query($sql);
		 return $query->result_array();
	}

	function select_all_company_level($id='',$company_id){
		if($id){
			$ssql="AND master_levels.`id`= ".$this->db->escape($id)."";
		}
		 $sql = "SELECT master_levels.`id`, master_levels.`company_id`, master_levels.`level`, master_levels.`description`, master_levels.`status`, master_levels.`ordering`,(CASE  WHEN master_levels.`status` = 0 THEN 'Active' ELSE 'In-Active' END)  as level_status   
		 		FROM `master_levels`		 		 
		 		WHERE master_levels.company_id= ".$this->db->escape($company_id)."
		 		$ssql ";
		 //echo $sql;
		 $query = $this->db->query($sql);
		 return $query->result_array();
	} 
	function select_all_outcomeList($id='',$company_id){
		if($id){
			$ssql="AND tran_outcomes.`id`= ".$this->db->escape($id)."";
		}
		 $sql = "SELECT tran_outcomes.`id`,tran_outcomes.`company_id`,
		        tran_outcomes.`outcomes`, tran_outcomes.`description`,tran_outcomes.`status`,tran_outcomes.`business_impact_id` ,tran_outcomes.stage_id,tran_outcomes.level_id,
                master_biz_impact.business_impact,master_stages.stage,master_levels.level,master_color.name as color,master_status.name,tran_status.start_date,tran_status.status_id,tran_color.class_id,(CASE  WHEN tran_outcomes.`status` = 0 THEN 'Active' ELSE 'In-Active' END)  as outcome_status,master_stages.color as box_color

		        FROM `tran_outcomes`
                LEFT join master_biz_impact ON(tran_outcomes.business_impact_id=master_biz_impact.id)
                LEFT JOIN master_stages ON(tran_outcomes.stage_id=master_stages.id)
                LEFT JOIN master_levels ON(tran_outcomes.level_id=master_levels.id)
                LEFT JOIN tran_status ON(tran_outcomes.id=tran_status.tran_outcome_id AND tran_status.status='1')
                LEFT JOIN tran_color ON(tran_outcomes.id=tran_color.tran_outcome_id AND tran_color.status='1')
                LEFT JOIN master_color ON(tran_color.class_id=master_color.id)
                LEFT JOIN master_status ON(tran_status.status_id=master_status.id)
		 		WHERE tran_outcomes.company_id= ".$this->db->escape($company_id)."
		 		$ssql ";
		 //echo $sql;
		 $query = $this->db->query($sql);
		 return $query->result_array();
	}

	function get_capability_by_outcome($outcome_id,$business_impact_id){

		 $sql = " SELECT tran_outcomes_capability.capability,tran_capability_acceptance.acceptance,
				tran_capability_acceptance.`std_weight`,tran_capability_acceptance.id,tran_capability_acceptance.current_percentage,tran_capability_acceptance.score
				FROM tran_outcomes
				left join `tran_outcomes_capability` ON(tran_outcomes.id=tran_outcomes_capability.tran_outcome_id)
				LEFT JOIN  tran_capability_acceptance 
				ON(tran_outcomes_capability.id=tran_capability_acceptance.tran_capability_id)
				WHERE tran_outcomes_capability.`tran_outcome_id`=".$this->db->escape($outcome_id)."
				AND tran_outcomes.`business_impact_id`=".$this->db->escape($business_impact_id)."
				AND tran_outcomes_capability.status='0'
				AND tran_capability_acceptance.status='0'";
				//echo  $sql;
		 $query = $this->db->query($sql);
		 return $query->result_array();
	} 

	function add_business_outcomes($company_id){

		 $sql = " INSERT INTO master_biz_impact (`company_id`,`business_impact`,`description`,`measure`,`ordering`) 
		 		  SELECT ".$this->db->escape($company_id).",`business_impact`,`description`,`measure`,`ordering`
				  FROM pta_business_outcomes ";				 
		 $this->db->query($sql);
		 
	} 

	function add_levels($company_id){

		 $sql = "INSERT INTO master_levels (`company_id`, `level`, `description`,`ordering`)
		 		 SELECT ".$this->db->escape($company_id).",`level`,`description`,`ordering`
				 FROM pta_levels ";				 
		 $this->db->query($sql);
		 
	} 

	function add_agile_outcomes($company_id){

		 $ssql = "SELECT `id`
				  FROM `master_biz_impact` 
				  WHERE `company_id`=".$this->db->escape($company_id)."
				  AND `business_impact` ='Speed' ";		 
		 $query = $this->db->query($ssql);
		 $result = $query->result_array();

		 $sql_level = "SELECT `id`
				  FROM `master_levels` 
				  WHERE `company_id`=".$this->db->escape($company_id)." ";		 
		 $query1 = $this->db->query($sql_level);
		 $levelList = $query1->result_array();

		 foreach ($levelList as $key => $value) {

		 	 $sql = "INSERT INTO tran_outcomes (`business_impact_id`,`stage_id`,`level_id`,`company_id`,`outcomes`,`description`)
		 		 SELECT ".$this->db->escape($result[0]['id']).",`stage_id`,".$this->db->escape($value['id']).",".$this->db->escape($company_id).",`outcomes`,`description`
				 FROM pta_agile_outcomes 
				 WHERE level_id =".$this->db->escape($key+1)."";				 
		 	 $this->db->query($sql);	 
		 	 
		 } 

	} 

	function add_agile_outcomes_status_and_color($company_id,$loginID){
		
		 $sql = "INSERT INTO tran_status (`tran_outcome_id`,`status_id`,`start_date`,`status`,`status_changed_id`)
		 		 SELECT `id`,1,NOW(),1,".$this->db->escape($loginID)."  FROM `tran_outcomes` 
				 WHERE `company_id`=".$this->db->escape($company_id)." ";				 
		 $this->db->query($sql);

		 $sql1 = "INSERT INTO tran_color (`tran_outcome_id`,`class_id`,`start_date`,`status`,`status_changed_id`)
		 		 SELECT `id`,4,NOW(),1,".$this->db->escape($loginID)."  FROM `tran_outcomes` 
				 WHERE `company_id`=".$this->db->escape($company_id)." ";				 
		 $this->db->query($sql1);	 

	} 

	function select_all_outcomeList_by_level_id($company_id,$level_id,$biz_outcome_id){

		if($level_id){
			$ssql =" AND tran_outcomes.level_id= ".$this->db->escape($level_id)." ";
		}
		 
		 $sql = " SELECT tran_outcomes.`id`, 
		        tran_outcomes.`outcomes`, tran_status.start_date,tran_color.start_date as color_date,tran_status.status_id,tran_color.class_id,master_stages.color as box_color,tran_status.id as tran_status_id,tran_status.note,master_color.name as color_name,master_status.name as status_name,tran_color.id as tran_color_id,tran_color.note as color_note,master_levels.level,master_stages.stage,master_biz_impact.business_impact

		       FROM `tran_outcomes`               
                LEFT JOIN master_stages ON(tran_outcomes.stage_id=master_stages.id)                
                LEFT JOIN tran_status ON(tran_outcomes.id=tran_status.tran_outcome_id AND tran_status.status='1')
                LEFT JOIN tran_color ON(tran_outcomes.id=tran_color.tran_outcome_id AND tran_color.status='1') 
                LEFT JOIN master_color ON(tran_color.class_id=master_color.id)
                LEFT JOIN master_status ON(tran_status.status_id=master_status.id)
                LEFT JOIN master_levels ON(tran_outcomes.level_id=master_levels.id)
                LEFT JOIN master_biz_impact ON(tran_outcomes.business_impact_id=master_biz_impact.id)
		 		WHERE tran_outcomes.company_id= ".$this->db->escape($company_id)."
		 		AND tran_outcomes.business_impact_id= ".$this->db->escape($biz_outcome_id)."
		 		AND tran_status.status='1'
		 		AND tran_outcomes.status='0'
		 		$ssql  "; 
		 // echo $sql;
		 $query = $this->db->query($sql);
		 return $query->result_array();
	}

	function select_all_login_logout_history($company_id="",$login_id=""){
		$ssql ='';
		if($company_id){
			$ssql .=" AND users.company_id= ".$this->db->escape($company_id)." ";
		}
		if($login_id){
			$ssql .=" AND user_activity.login_id= ".$this->db->escape($login_id)." ";
		}
		 
		 $sql = " SELECT  `login_id`, `ip_address`, `timezone`, `start_time`, `end_time`, `added_date` ,users.company_id,concat(users.first_name,' ',users.last_name) as username,master_company.company_name

				FROM `user_activity`
				LEFT JOIN users ON(user_activity.login_id=users.id) 
				LEFT JOIN master_company ON(users.company_id=master_company.id) 
				WHERE 1
		 		$ssql  "; 
		 //echo $sql;
		 $query = $this->db->query($sql);
		 return $query->result_array();
	}

	
}
?>