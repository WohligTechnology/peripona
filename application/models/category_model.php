<?php
if ( !defined( "BASEPATH" ) )
exit( "No direct script access allowed" );
class category_model extends CI_Model
{
    public function create($name,$ministry,$order)
    {
        $data=array("name" => $name,"ministry" => $ministry,"order" => $order);
        $query=$this->db->insert( "martyr_category", $data );
        $id=$this->db->insert_id();
        if(!$query)
            return  0;
        else
            return  $id;
    }
    public function beforeedit($id)
    {
        $this->db->where("id",$id);
        $query=$this->db->get("martyr_category")->row();
        return $query;
    }
    function getsinglecategory($id)
    {
        $this->db->where("id",$id);
        $query=$this->db->get("martyr_category")->row();
        return $query;
    }
    public function edit($id,$name,$ministry,$order)
    {
        $data=array("name" => $name,"ministry" => $ministry,"order" => $order);
        $this->db->where( "id", $id );
        $query=$this->db->update( "martyr_category", $data );
        return 1;
    }
    public function delete($id)
    {
        $query=$this->db->query("DELETE FROM `martyr_category` WHERE `id`='$id'");
        return $query;
    }
    public function getcategorydropdown()
	{
		$query=$this->db->query("SELECT * FROM `martyr_category`  ORDER BY `id` ASC")->result();
		$return=array(
		"" => ""
		);
		foreach($query as $row)
		{
			$return[$row->id]=$row->name;
		}
		
		return $return;
	}
    public function getcategorytree($id) 
    {
        $return=new stdClass();
        if($id!=0)
        {
            $querymain=$this->db->query("SELECT * FROM `navigation` WHERE `id`='$id'")->row();
        }
        else
        {
            $querymain=new stdClass();
            $querymain->id=0;
            $querymain->name="Root";
        }
        $query=$this->db->query("SELECT * FROM `navigation` WHERE `parent`='$id'  ORDER BY `id` ASC");
        
        $return->id=$querymain->id;
        $return->name=$querymain->name;
        $return->children=array();
        
        if($query->num_rows()==0)
        {
            
        }
        else
        {
            $query=$query->result();
            foreach($query as $row)
            {
                array_push($return->children,$this->getcategorytree($row->id));
            }
        }
        return $return;
    }

}
?>
