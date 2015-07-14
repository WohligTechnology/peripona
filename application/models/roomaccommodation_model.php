<?php
if ( !defined( "BASEPATH" ) )
exit( "No direct script access allowed" );
class roomaccommodation_model extends CI_Model
{
    public function create($order,$room,$title,$description)
    {
        $data=array("order" => $order,"room" => $room,"title" => $title,"description" => $description);
        $query=$this->db->insert( "chennai_roomaccommodation", $data );
        $id=$this->db->insert_id();
        if(!$query)
        return  0;
        else
        return  $id;
    }
    public function beforeedit($id)
    {
        $this->db->where("id",$id);
        $query=$this->db->get("chennai_roomaccommodation")->row();
        return $query;
    }
    function getsingleroomaccommodation($id)
    {
        $this->db->where("id",$id);
        $query=$this->db->get("chennai_roomaccommodation")->row();
        return $query;
    }
    public function edit($id,$order,$room,$title,$description)
    {
        $data=array("order" => $order,"room" => $room,"title" => $title,"description" => $description);
        $this->db->where( "id", $id );
        $query=$this->db->update( "chennai_roomaccommodation", $data );
        return 1;
    }
    public function delete($id)
    {
        $query=$this->db->query("DELETE FROM `chennai_roomaccommodation` WHERE `id`='$id'");
        return $query;
    }
    public function getaccommodationbyroom($id)
    {
        $query=$this->db->query("SELECT * FROM `chennai_roomaccommodation` WHERE `room`='$id'")->result();
        return $query;
    }
}
?>
