<?php
if ( !defined( "BASEPATH" ) )
exit( "No direct script access allowed" );
class newsletter_model extends CI_Model
{
public function create($email)
{
$data=array("email" => $email);
$query=$this->db->insert( "newsletter", $data );
$id=$this->db->insert_id();
if(!$query)
return  0;
else
return  $id;
}
public function beforeedit($id)
{
$this->db->where("id",$id);
$query=$this->db->get("newsletter")->row();
return $query;
}

public function edit($id,$email,$timestamp)
{
$data=array("email" => $email,"timestamp" => $timestamp);
$this->db->where( "id", $id );
$query=$this->db->update( "newsletter", $data );
return 1;
}
public function deletenewsletter($id)
{
$query=$this->db->query("DELETE FROM `newsletter` WHERE `id`='$id'");
return $query;
}
	
}
?>
