<?php
if ( !defined( 'BASEPATH' ) )
	exit( 'No direct script access allowed' );
class Navigation_model extends CI_Model
{
	//navigation
	public function createnavigation($name,$parent,$status)
	{
		$data  = array(
			'name' => $name,
			'parent' => $parent,
			'status' => $status
		);
		$query=$this->db->insert( 'navigation', $data );
		
		return  1;
	}
	
    function viewnavigation()
	{
		$query=$this->db->query("SELECT `navigation`.`id`,`navigation`.`name`,`navigation`.`status`,`tab2`.`name` as `parent` FROM `navigation` 
		LEFT JOIN `navigation` as `tab2` ON `tab2`.`id`=`navigation`.`parent`
		ORDER BY `navigation`.`id` ASC")->result();
		return $query;
	}
    function viewparentnavigation()
	{
		$query=$this->db->query("SELECT `navigation`.`id`,`navigation`.`name`,`navigation`.`status`
        FROM `navigation` 
        WHERE `navigation`.`parent`=0
		ORDER BY `navigation`.`id` ASC")->result();
		return $query;
	}
    function getsubnavigationbyparent($id)
	{
		$query=$this->db->query("SELECT `navigation`.`id`,`navigation`.`name`,`navigation`.`status`
        FROM `navigation` 
        WHERE `navigation`.`parent`='$id'
		ORDER BY `navigation`.`id` ASC")->result();
		return $query;
	}
    
	public function getstatusdropdown()
	{
		$status= array(
			 "1" => "Has Types",
			 "0" => "No Types",
			);
		return $status;
	}
    function viewmainnavigation()
	{
		$query=$this->db->query("SELECT `navigation`.`id`,`navigation`.`name`,`navigation`.`status`,`tab2`.`name` as `parent` FROM `navigation` 
		LEFT JOIN `navigation` as `tab2` ON `tab2`.`id`=`navigation`.`parent` WHERE `navigation`.`parent`='0'
		ORDER BY `navigation`.`id` ASC")->result();
		return $query;
	}
    function viewallsubnavigation()
	{
		$query=$this->db->query("SELECT `subnavigation`.`id`,`subnavigation`.`name` FROM `subnavigation`")->result();
		return $query;
	}
	public function beforeeditnavigation( $id )
	{
		$this->db->where( 'id', $id );
		$query=$this->db->get( 'navigation' )->row();
		return $query;
	}
	
	public function editnavigation( $id,$name,$parent,$status)
	{
		$data = array(
			'name' => $name,
			'parent' => $parent,
			'status' => $status
		
		);
		$this->db->where( 'id', $id );
		$query=$this->db->update( 'navigation', $data );
		
		return 1;
	}
	function deletenavigation($id)
	{
		$query=$this->db->query("DELETE FROM `navigation` WHERE `id`='$id'");
		
	}
    
	public function getnavigationdropdown()
	{
		$query=$this->db->query("SELECT * FROM `navigation` ORDER BY `id` ASC")->result();
		$return=array(
		"" => ""
		);
		foreach($query as $row)
		{
			$return[$row->id]=$row->name;
		}
		
		return $return;
	}
    
    public function getsubcategorydropdown()
	{
		$query=$this->db->query("SELECT * FROM `navigation`  ORDER BY `id` ASC")->result();
		$return=array(
		"" => ""
		);
		foreach($query as $row)
		{
			$return[$row->id]=$row->name;
		}
		
		return $return;
	}
}
?>