<?php
if ( !defined( "BASEPATH" ) )
exit( "No direct script access allowed" );
class room_model extends CI_Model
{
public function create($name,$image,$timestamp,$description)
{
$data=array("name" => $name,"image" => $image,"description" => $description);
$query=$this->db->insert( "chennai_room", $data );
$id=$this->db->insert_id();
if(!$query)
return  0;
else
return  $id;
}
public function beforeedit($id)
{
$this->db->where("id",$id);
$query=$this->db->get("chennai_room")->row();
return $query;
}
function getsingleroom($id){
$this->db->where("id",$id);
$query=$this->db->get("chennai_room")->row();
return $query;
}
public function edit($id,$name,$image,$timestamp,$description)
{
$data=array("name" => $name,"image" => $image,"timestamp" => $timestamp,"description" => $description);
$this->db->where( "id", $id );
$query=$this->db->update( "chennai_room", $data );
return 1;
}
public function delete($id)
{
$query=$this->db->query("DELETE FROM `chennai_room` WHERE `id`='$id'");
return $query;
}
	 public function getroomdropdown()
	{
		$query=$this->db->query("SELECT * FROM `chennai_room`  ORDER BY `id` ASC")->result();
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
