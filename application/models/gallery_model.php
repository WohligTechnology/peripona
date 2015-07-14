<?php
if ( !defined( "BASEPATH" ) )
exit( "No direct script access allowed" );
class gallery_model extends CI_Model
{
public function create($name,$image,$order,$timestamp)
{
$data=array("name" => $name,"image" => $image,"order" => $order);
$query=$this->db->insert( "chennai_gallery", $data );
$id=$this->db->insert_id();
if(!$query)
return  0;
else
return  $id;
}
public function beforeedit($id)
{
$this->db->where("id",$id);
$query=$this->db->get("chennai_gallery")->row();
return $query;
}
function getsinglegallery($id){
$this->db->where("id",$id);
$query=$this->db->get("chennai_gallery")->row();
return $query;
}
public function edit($id,$name,$image,$order,$timestamp)
{
$data=array("name" => $name,"image" => $image,"order" => $order,"timestamp" => $timestamp);
$this->db->where( "id", $id );
$query=$this->db->update( "chennai_gallery", $data );
return 1;
}
public function delete($id)
{
$query=$this->db->query("DELETE FROM `chennai_gallery` WHERE `id`='$id'");
return $query;
}
public function getgallery()
{
$query=$this->db->query("SELECT * FROM `chennai_gallery`")->result();
return $query;
}
}
?>
