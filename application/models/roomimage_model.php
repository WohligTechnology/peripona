<?php
if ( !defined( "BASEPATH" ) )
exit( "No direct script access allowed" );
class roomimage_model extends CI_Model
{
    public function create($room,$name,$image,$order)
    {
        $data=array("room" => $room,"name" => $name,"image" => $image,"order" => $order);
        $query=$this->db->insert( "chennai_roomimage", $data );
        $id=$this->db->insert_id();
        if(!$query)
        return  0;
        else
        return  $id;
    }
    public function beforeedit($id)
    {
        $this->db->where("id",$id);
        $query=$this->db->get("chennai_roomimage")->row();
        return $query;
    }
    function getsingleroomimage($id)
    {
        $this->db->where("id",$id);
        $query=$this->db->get("chennai_roomimage")->row();
        return $query;
    }
    public function edit($id,$room,$name,$image,$order)
    {
        $data=array("room" => $room,"name" => $name,"image" => $image,"order" => $order);
        $this->db->where( "id", $id );
        $query=$this->db->update( "chennai_roomimage", $data );
        return 1;
    }
    public function delete($id)
    {
        $query=$this->db->query("DELETE FROM `chennai_roomimage` WHERE `id`='$id'");
        return $query;
    }
    
    public function getimagesbyroom($id)
    {
        $query=$this->db->query("SELECT * FROM `chennai_roomimage` WHERE `room`='$id'")->result();
        return $query;
    }
}
?>
