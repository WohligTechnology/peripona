<?php
if ( !defined( "BASEPATH" ) )
exit( "No direct script access allowed" );
class message_model extends CI_Model
{
    public function create($name,$contact,$email,$city,$message,$martry,$approval)
    {
        $data=array("name" => $name,"contact" => $contact,"email" => $email,"city" => $city,"message" => $message,"martry" => $martry,"approval" => $approval);
        $query=$this->db->insert( "martyr_message", $data );
        $id=$this->db->insert_id();
        if(!$query)
        return  0;
        else
        return  $id;
    }
    public function beforeedit($id)
    {
        $this->db->where("id",$id);
        $query=$this->db->get("martyr_message")->row();
        return $query;
    }
    function getsinglemessage($id)
    {
        $this->db->where("id",$id);
        $query=$this->db->get("martyr_message")->row();
        return $query;
    }
    public function edit($id,$name,$contact,$email,$city,$message,$martry,$approval)
    {
        $data=array("name" => $name,"contact" => $contact,"email" => $email,"city" => $city,"message" => $message,"martry" => $martry,"approval" => $approval);
        $this->db->where( "id", $id );
        $query=$this->db->update( "martyr_message", $data );
        return 1;
    }
    public function delete($id)
    {
        $query=$this->db->query("DELETE FROM `martyr_message` WHERE `id`='$id'");
        return $query;
    }
    public function addmessage($id,$name,$contact,$city,$email,$message)
    {
        $data=array(
            "name" => $name,
            "contact" => $contact,
            "email" => $email,
            "city" => $city,
            "message" => $message,
            "martry" => $id,
            "approval" => 0
        );
        $query=$this->db->insert( "martyr_message", $data );
        $id=$this->db->insert_id();
        if(!$query)
        return  0;
        else
        return  $id;
    }
}
?>
