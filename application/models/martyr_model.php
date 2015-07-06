<?php
if ( !defined( "BASEPATH" ) )
exit( "No direct script access allowed" );
class martyr_model extends CI_Model
{
    public function create($regiment,$name,$rank,$unit,$homestate,$operation,$dateofdeath,$image,$age,$description,$status,$lights,$email)
    {
        $data=array("regiment" => $regiment,"name" => $name,"rank" => $rank,"unit" => $unit,"homestate" => $homestate,"operation" => $operation,"dateofdeath" => $dateofdeath,"image" => $image,"age" => $age,"description" => $description,"status" => $status,"lights" => $lights,"email" => $email);
        $query=$this->db->insert( "martyr_martyr", $data );
        $id=$this->db->insert_id();
        if(!$query)
            return  0;
        else
            return  $id;
    }
    public function beforeedit($id)
    {
        $this->db->where("id",$id);
        $query=$this->db->get("martyr_martyr")->row();
        return $query;
    }
    function getsinglemartyr($id)
    {
        $this->db->where("id",$id);
        $query=$this->db->get("martyr_martyr")->row();
        return $query;
    }
    public function edit($id,$regiment,$name,$rank,$unit,$homestate,$operation,$dateofdeath,$image,$age,$description,$status,$lights,$email)
    {
        $data=array("regiment" => $regiment,"name" => $name,"rank" => $rank,"unit" => $unit,"homestate" => $homestate,"operation" => $operation,"dateofdeath" => $dateofdeath,"image" => $image,"age" => $age,"description" => $description,"status" => $status,"lights" => $lights,"email" => $email);
        $this->db->where( "id", $id );
        $query=$this->db->update( "martyr_martyr", $data );
        return 1;
    }
    public function delete($id)
    {
        $query=$this->db->query("DELETE FROM `martyr_martyr` WHERE `id`='$id'");
        return $query;
    }
    
	public function getstatusdropdown()
	{
		$status= array(
			 "1" => "Enable",
			 "0" => "Disable"
			);
		return $status;
	}
    
	public function getapprovalmaildropdown()
	{
		$status= array(
            "0" => "Unapprove",
			 "1" => "Approve"
			);
		return $status;
	}
    
	public function getmartyrimagebyid($id)
	{
		$query=$this->db->query("SELECT `image` FROM `martyr_martyr` WHERE `id`='$id'")->row();
		return $query;
	}
	public function getmartyrbyid($id)
	{
		$query=$this->db->query("SELECT `martyr_martyr`.`id`, `martyr_martyr`.`regiment`, `martyr_martyr`.`name`, `martyr_martyr`.`rank`, `martyr_martyr`.`unit`, `martyr_martyr`.`homestate`, `martyr_martyr`.`operation`, `martyr_martyr`.`dateofdeath`, `martyr_martyr`.`image`, `martyr_martyr`.`age`, `martyr_martyr`.`description`, `martyr_martyr`.`status`, `martyr_martyr`.`lights`, `martyr_martyr`.`email` ,`martyr_regiment`.`name` AS `regimentname`,`martyr_regiment`.`subcategory` AS `categoryid`
        FROM `martyr_martyr` 
        LEFT OUTER JOIN `martyr_regiment` ON `martyr_martyr`.`regiment`= `martyr_regiment`.`id`
        LEFT OUTER JOIN `navigation` ON `martyr_regiment`.`subcategory`= `navigation`.`id`
        WHERE `martyr_martyr`.`id`='$id'")->row();
		return $query;
	}
    public function getmartyrdropdown()
	{
		$query=$this->db->query("SELECT * FROM `martyr_martyr`  ORDER BY `id` ASC")->result();
		$return=array(
		"" => ""
		);
		foreach($query as $row)
		{
			$return[$row->id]=$row->name;
		}
		
		return $return;
	}
    
	public function searchbyname($name)
	{
		$query=$this->db->query("SELECT `martyr_martyr`.`id`, `martyr_martyr`.`regiment`, `martyr_martyr`.`name`, `martyr_martyr`.`rank`, `martyr_martyr`.`unit`, `martyr_martyr`.`homestate`, `martyr_martyr`.`operation`, `martyr_martyr`.`dateofdeath`, `martyr_martyr`.`image`, `martyr_martyr`.`age`, `martyr_martyr`.`description`, `martyr_martyr`.`status`, `martyr_martyr`.`lights`, `martyr_martyr`.`email` ,`martyr_regiment`.`name` AS `regimentname`,`martyr_regiment`.`subcategory` AS `categoryid`
        FROM `martyr_martyr` 
        LEFT OUTER JOIN `martyr_regiment` ON `martyr_martyr`.`regiment`= `martyr_regiment`.`id`
        LEFT OUTER JOIN `navigation` ON `martyr_regiment`.`subcategory`= `navigation`.`id`
        WHERE `martyr_martyr`.`name` LIKE '%$name%'")->row();
		return $query;
	}
}
?>
