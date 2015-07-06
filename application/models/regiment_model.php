<?php
if ( !defined( "BASEPATH" ) )
exit( "No direct script access allowed" );
class regiment_model extends CI_Model
{
    public function create($subcategory,$name,$order)
    {
        $data=array("subcategory" => $subcategory,"name" => $name,"order" => $order);
        $query=$this->db->insert( "martyr_regiment", $data );
        $id=$this->db->insert_id();
        if(!$query)
            return  0;
        else
            return  $id;
    }
    public function beforeedit($id)
    {
        $this->db->where("id",$id);
        $query=$this->db->get("martyr_regiment")->row();
        return $query;
    }
    function getsingleregiment($id)
    {
        $this->db->where("id",$id);
        $query=$this->db->get("martyr_regiment")->row();
        return $query;
    }
    public function edit($id,$subcategory,$name,$order)
    {
        $data=array("subcategory" => $subcategory,"name" => $name,"order" => $order);
        $this->db->where( "id", $id );
        $query=$this->db->update( "martyr_regiment", $data );
        return 1;
    }
    
    public function delete($id)
    {
        $query=$this->db->query("DELETE FROM `martyr_regiment` WHERE `id`='$id'");
        return $query;
    }
    
    public function getregimentdropdown()
	{
		$query=$this->db->query("SELECT * FROM `martyr_regiment`  ORDER BY `id` ASC")->result();
		$return=array(
		"" => ""
		);
		foreach($query as $row)
		{
			$return[$row->id]=$row->name;
		}
		
		return $return;
	}
    
	public function getregimentbycategory($id)
	{
		$query=$this->db->query("SELECT `martyr_martyr`.`id`, `martyr_martyr`.`regiment`, `martyr_martyr`.`name`, `martyr_martyr`.`rank`, `martyr_martyr`.`unit`, `martyr_martyr`.`homestate`, `martyr_martyr`.`operation`, `martyr_martyr`.`dateofdeath`, `martyr_martyr`.`image`, `martyr_martyr`.`age`, `martyr_martyr`.`description`, `martyr_martyr`.`status`, `martyr_martyr`.`lights`, `martyr_martyr`.`email` ,`martyr_regiment`.`name` AS `regimentname`,`navigation`.`name` AS `navigationname`
        FROM `martyr_martyr` 
        LEFT OUTER JOIN `martyr_regiment` ON `martyr_martyr`.`regiment`= `martyr_regiment`.`id`
        LEFT OUTER JOIN `navigation` ON `martyr_regiment`.`subcategory`= `navigation`.`id`
        WHERE `martyr_regiment`.`subcategory`='$id'
ORDER BY `martyr_regiment`.`order`")->result();
		return $query;
	}
    public function addlight($id)
    {
        $query=$this->db->query("SELECT `lights` FROM `martyr_martyr` WHERE `id`='$id'")->row();
        $previouslikes=$query->lights;
        $likes=intval($previouslikes)+1;
        $queryaddlamp=$this->db->query("UPDATE `martyr_martyr` SET `lights`='$likes' WHERE `id`='$id'");
        return 1;
    }
}
?>
