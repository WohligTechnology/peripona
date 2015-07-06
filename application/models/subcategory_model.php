<?php
if ( !defined( "BASEPATH" ) )
exit( "No direct script access allowed" );
class subcategory_model extends CI_Model
{
    public function create($category,$name,$order)
    {
        $data=array("category" => $category,"name" => $name,"order" => $order);
        $query=$this->db->insert( "martyr_subcategory", $data );
        $id=$this->db->insert_id();
        if(!$query)
            return  0;
        else
            return  $id;
    }
    public function beforeedit($id)
    {
        $this->db->where("id",$id);
        $query=$this->db->get("martyr_subcategory")->row();
        return $query;
    }
    function getsinglesubcategory($id)
    {
        $this->db->where("id",$id);
        $query=$this->db->get("martyr_subcategory")->row();
        return $query;
    }
    public function edit($id,$category,$name,$order)
    {
        $data=array("category" => $category,"name" => $name,"order" => $order);
        $this->db->where( "id", $id );
        $query=$this->db->update( "martyr_subcategory", $data );
        return 1;
    }
    public function delete($id)
    {
        $query=$this->db->query("DELETE FROM `martyr_subcategory` WHERE `id`='$id'");
        return $query;
    }
    
    public function getsubcategorydropdown()
	{
		$query=$this->db->query("SELECT * FROM `martyr_subcategory`  ORDER BY `id` ASC")->result();
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
