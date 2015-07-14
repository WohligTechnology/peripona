<?php
if ( !defined( "BASEPATH" ) )
exit( "No direct script access allowed" );
class contactus_model extends CI_Model
{
public function create($firstname,$lastname,$email,$contact,$status,$request)
{
$data=array("firstname" => $firstname,"lastname" => $lastname,"email" => $email,"contact" => $contact,"status" => $status,"request" => $request);
$query=$this->db->insert( "contactus", $data );
$id=$this->db->insert_id();
if(!$query)
return  0;
else
return  $id;
}
public function beforeedit($id)
{
$this->db->where("id",$id);
$query=$this->db->get("contactus")->row();
return $query;
}
function getsingleroom($id){
$this->db->where("id",$id);
$query=$this->db->get("contactus")->row();
return $query;
}
public function edit($id,$firstname,$lastname,$email,$contact,$status,$request,$timestamp)
{
$data=array("firstname" => $firstname,"lastname" => $lastname,"email" => $email,"contact" => $contact,"status" => $status,"request" => $request,"timestamp" => $timestamp);
$this->db->where( "id", $id );
$query=$this->db->update( "contactus", $data );
return 1;
}
public function deletecontactus($id)
{
$query=$this->db->query("DELETE FROM `contactus` WHERE `id`='$id'");
return $query;
}
	 public function getstatusdropdown()
	{
		$status=array(
		"0" => "Disable",
		"1" => "Enable"
		);
				
		return $status;
	}
}
?>
