<?php
if ( !defined( "BASEPATH" ) )
exit( "No direct script access allowed" );
class ministry_model extends CI_Model
{
    public function create($name)
    {
        $data=array("name" => $name);
        $query=$this->db->insert( "martyr_ministry", $data );
        $id=$this->db->insert_id();
        if(!$query)
            return  0;
        else
            return  $id;
    }
    public function beforeedit($id)
    {
        $this->db->where("id",$id);
        $query=$this->db->get("martyr_ministry")->row();
        return $query;
    }
    function getsingleministry($id)
    {
        $this->db->where("id",$id);
        $query=$this->db->get("martyr_ministry")->row();
        return $query;
    }
    public function edit($id,$name)
    {
        $data=array("name" => $name);
        $this->db->where( "id", $id );
        $query=$this->db->update( "martyr_ministry", $data );
        return 1;
    }
    public function delete($id)
    {
        $query=$this->db->query("DELETE FROM `martyr_ministry` WHERE `id`='$id'");
        return $query;
    }
    
    public function getministrydropdown()
	{
		$query=$this->db->query("SELECT * FROM `martyr_ministry`  ORDER BY `id` ASC")->result();
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
