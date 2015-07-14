<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Site extends CI_Controller 
{
	public function __construct( )
	{
		parent::__construct();
		
		$this->is_logged_in();
	}
	function is_logged_in( )
	{
		$is_logged_in = $this->session->userdata( 'logged_in' );
		if ( $is_logged_in !== 'true' || !isset( $is_logged_in ) ) {
			redirect( base_url() . 'index.php/login', 'refresh' );
		} //$is_logged_in !== 'true' || !isset( $is_logged_in )
	}
	function checkaccess($access)
	{
		$accesslevel=$this->session->userdata('accesslevel');
		if(!in_array($accesslevel,$access))
			redirect( base_url() . 'index.php/site?alerterror=You do not have access to this page. ', 'refresh' );
	}
	public function index()
	{
		$access = array("1","2");
		$this->checkaccess($access);
		$data[ 'page' ] = 'dashboard';
		$data[ 'title' ] = 'Welcome';
		$this->load->view( 'template', $data );	
	}
	public function createuser()
	{
		$access = array("1");
		$this->checkaccess($access);
		$data['accesslevel']=$this->user_model->getaccesslevels();
		$data[ 'status' ] =$this->user_model->getstatusdropdown();
		$data[ 'logintype' ] =$this->user_model->getlogintypedropdown();
//        $data['category']=$this->category_model->getcategorydropdown();
		$data[ 'page' ] = 'createuser';
		$data[ 'title' ] = 'Create User';
		$this->load->view( 'template', $data );	
	}
	function createusersubmit()
	{
		$access = array("1");
		$this->checkaccess($access);
		$this->form_validation->set_rules('name','Name','trim|required|max_length[30]');
		$this->form_validation->set_rules('email','Email','trim|required|valid_email|is_unique[user.email]');
		$this->form_validation->set_rules('password','Password','trim|required|min_length[6]|max_length[30]');
		$this->form_validation->set_rules('confirmpassword','Confirm Password','trim|required|matches[password]');
		$this->form_validation->set_rules('accessslevel','Accessslevel','trim');
		$this->form_validation->set_rules('status','status','trim|');
		$this->form_validation->set_rules('socialid','Socialid','trim');
		$this->form_validation->set_rules('logintype','logintype','trim');
		$this->form_validation->set_rules('json','json','trim');
		if($this->form_validation->run() == FALSE)	
		{
			$data['alerterror'] = validation_errors();
			$data['accesslevel']=$this->user_model->getaccesslevels();
            $data[ 'status' ] =$this->user_model->getstatusdropdown();
            $data[ 'logintype' ] =$this->user_model->getlogintypedropdown();
            $data['category']=$this->category_model->getcategorydropdown();
            $data[ 'page' ] = 'createuser';
            $data[ 'title' ] = 'Create User';
            $this->load->view( 'template', $data );	
		}
		else
		{
            $name=$this->input->post('name');
            $email=$this->input->post('email');
            $password=$this->input->post('password');
            $accesslevel=$this->input->post('accesslevel');
            $status=$this->input->post('status');
            $socialid=$this->input->post('socialid');
            $logintype=$this->input->post('logintype');
            $json=$this->input->post('json');
//            $category=$this->input->post('category');
            
            $config['upload_path'] = './uploads/';
			$config['allowed_types'] = 'gif|jpg|png|jpeg';
			$this->load->library('upload', $config);
			$filename="image";
			$image="";
			if (  $this->upload->do_upload($filename))
			{
				$uploaddata = $this->upload->data();
				$image=$uploaddata['file_name'];
                
                $config_r['source_image']   = './uploads/' . $uploaddata['file_name'];
                $config_r['maintain_ratio'] = TRUE;
                $config_t['create_thumb'] = FALSE;///add this
                $config_r['width']   = 800;
                $config_r['height'] = 800;
                $config_r['quality']    = 100;
                //end of configs

                $this->load->library('image_lib', $config_r); 
                $this->image_lib->initialize($config_r);
                if(!$this->image_lib->resize())
                {
                    echo "Failed." . $this->image_lib->display_errors();
                    //return false;
                }  
                else
                {
                    //print_r($this->image_lib->dest_image);
                    //dest_image
                    $image=$this->image_lib->dest_image;
                    //return false;
                }
                
			}
            
            
			if($this->user_model->create($name,$email,$password,$accesslevel,$status,$socialid,$logintype,$image,$json)==0)
			$data['alerterror']="New user could not be created.";
			else
			$data['alertsuccess']="User created Successfully.";
			$data['redirect']="site/viewusers";
			$this->load->view("redirect",$data);
		}
	}
    function viewusers()
	{
		$access = array("1");
		$this->checkaccess($access);
		$data['page']='viewusers';
        $data['base_url'] = site_url("site/viewusersjson");
        
		$data['title']='View Users';
		$this->load->view('template',$data);
	} 
    function viewusersjson()
	{
		$access = array("1");
		$this->checkaccess($access);
        
        
        $elements=array();
        $elements[0]=new stdClass();
        $elements[0]->field="`user`.`id`";
        $elements[0]->sort="1";
        $elements[0]->header="ID";
        $elements[0]->alias="id";
        
        
        $elements[1]=new stdClass();
        $elements[1]->field="`user`.`name`";
        $elements[1]->sort="1";
        $elements[1]->header="Name";
        $elements[1]->alias="name";
        
        $elements[2]=new stdClass();
        $elements[2]->field="`user`.`email`";
        $elements[2]->sort="1";
        $elements[2]->header="Email";
        $elements[2]->alias="email";
        
        $elements[3]=new stdClass();
        $elements[3]->field="`user`.`socialid`";
        $elements[3]->sort="1";
        $elements[3]->header="SocialId";
        $elements[3]->alias="socialid";
        
        $elements[4]=new stdClass();
        $elements[4]->field="`logintype`.`name`";
        $elements[4]->sort="1";
        $elements[4]->header="Logintype";
        $elements[4]->alias="logintype";
        
        $elements[5]=new stdClass();
        $elements[5]->field="`user`.`json`";
        $elements[5]->sort="1";
        $elements[5]->header="Json";
        $elements[5]->alias="json";
       
        $elements[6]=new stdClass();
        $elements[6]->field="`accesslevel`.`name`";
        $elements[6]->sort="1";
        $elements[6]->header="Accesslevel";
        $elements[6]->alias="accesslevelname";
       
        $elements[7]=new stdClass();
        $elements[7]->field="`statuses`.`name`";
        $elements[7]->sort="1";
        $elements[7]->header="Status";
        $elements[7]->alias="status";
       
        
        $search=$this->input->get_post("search");
        $pageno=$this->input->get_post("pageno");
        $orderby=$this->input->get_post("orderby");
        $orderorder=$this->input->get_post("orderorder");
        $maxrow=$this->input->get_post("maxrow");
        if($maxrow=="")
        {
            $maxrow=20;
        }
        
        if($orderby=="")
        {
            $orderby="id";
            $orderorder="ASC";
        }
       
        $data["message"]=$this->chintantable->query($pageno,$maxrow,$orderby,$orderorder,$search,$elements,"FROM `user` LEFT OUTER JOIN `logintype` ON `logintype`.`id`=`user`.`logintype` LEFT OUTER JOIN `accesslevel` ON `accesslevel`.`id`=`user`.`accesslevel` LEFT OUTER JOIN `statuses` ON `statuses`.`id`=`user`.`status`");
        
		$this->load->view("json",$data);
	} 
    
    
	function edituser()
	{
		$access = array("1");
		$this->checkaccess($access);
		$data[ 'status' ] =$this->user_model->getstatusdropdown();
		$data['accesslevel']=$this->user_model->getaccesslevels();
		$data[ 'logintype' ] =$this->user_model->getlogintypedropdown();
		$data['before']=$this->user_model->beforeedit($this->input->get('id'));
		$data['page']='edituser';
		$data['page2']='block/userblock';
		$data['title']='Edit User';
		$this->load->view('template',$data);
	}
	function editusersubmit()
	{
		$access = array("1");
		$this->checkaccess($access);
		
		$this->form_validation->set_rules('name','Name','trim|required|max_length[30]');
		$this->form_validation->set_rules('email','Email','trim|required|valid_email');
		$this->form_validation->set_rules('password','Password','trim|min_length[6]|max_length[30]');
		$this->form_validation->set_rules('confirmpassword','Confirm Password','trim|matches[password]');
		$this->form_validation->set_rules('accessslevel','Accessslevel','trim');
		$this->form_validation->set_rules('status','status','trim|');
		$this->form_validation->set_rules('socialid','Socialid','trim');
		$this->form_validation->set_rules('logintype','logintype','trim');
		$this->form_validation->set_rules('json','json','trim');
		if($this->form_validation->run() == FALSE)	
		{
			$data['alerterror'] = validation_errors();
			$data[ 'status' ] =$this->user_model->getstatusdropdown();
			$data['accesslevel']=$this->user_model->getaccesslevels();
            $data[ 'logintype' ] =$this->user_model->getlogintypedropdown();
			$data['before']=$this->user_model->beforeedit($this->input->post('id'));
			$data['page']='edituser';
//			$data['page2']='block/userblock';
			$data['title']='Edit User';
			$this->load->view('template',$data);
		}
		else
		{
            
            $id=$this->input->get_post('id');
            $name=$this->input->get_post('name');
            $email=$this->input->get_post('email');
            $password=$this->input->get_post('password');
            $accesslevel=$this->input->get_post('accesslevel');
            $status=$this->input->get_post('status');
            $socialid=$this->input->get_post('socialid');
            $logintype=$this->input->get_post('logintype');
            $json=$this->input->get_post('json');
//            $category=$this->input->get_post('category');
            
             $config['upload_path'] = './uploads/';
			$config['allowed_types'] = 'gif|jpg|png|jpeg';
			$this->load->library('upload', $config);
			$filename="image";
			$image="";
			if (  $this->upload->do_upload($filename))
			{
				$uploaddata = $this->upload->data();
				$image=$uploaddata['file_name'];
                
                $config_r['source_image']   = './uploads/' . $uploaddata['file_name'];
                $config_r['maintain_ratio'] = TRUE;
                $config_t['create_thumb'] = FALSE;///add this
                $config_r['width']   = 800;
                $config_r['height'] = 800;
                $config_r['quality']    = 100;
                //end of configs

                $this->load->library('image_lib', $config_r); 
                $this->image_lib->initialize($config_r);
                if(!$this->image_lib->resize())
                {
                    echo "Failed." . $this->image_lib->display_errors();
                    //return false;
                }  
                else
                {
                    //print_r($this->image_lib->dest_image);
                    //dest_image
                    $image=$this->image_lib->dest_image;
                    //return false;
                }
                
			}
            
            if($image=="")
            {
            $image=$this->user_model->getuserimagebyid($id);
               // print_r($image);
                $image=$image->image;
            }
            
            
			if($this->user_model->edit($id,$name,$email,$password,$accesslevel,$status,$socialid,$logintype,$image,$json)==0)
			$data['alerterror']="User Editing was unsuccesful";
			else
			$data['alertsuccess']="User edited Successfully.";
			
			$data['redirect']="site/viewusers";
			//$data['other']="template=$template";
			$this->load->view("redirect",$data);
			
		}
	}
	
	function deleteuser()
	{
		$access = array("1");
		$this->checkaccess($access);
		$this->user_model->deleteuser($this->input->get('id'));
//		$data['table']=$this->user_model->viewusers();
		$data['alertsuccess']="User Deleted Successfully";
		$data['redirect']="site/viewusers";
			//$data['other']="template=$template";
		$this->load->view("redirect",$data);
	}
	function changeuserstatus()
	{
		$access = array("1");
		$this->checkaccess($access);
		$this->user_model->changestatus($this->input->get('id'));
		$data['table']=$this->user_model->viewusers();
		$data['alertsuccess']="Status Changed Successfully";
		$data['redirect']="site/viewusers";
        $data['other']="template=$template";
        $this->load->view("redirect",$data);
	}
    
    
    
    public function viewroom()
{
$access=array("1");
$this->checkaccess($access);
$data["page"]="viewroom";
$data["base_url"]=site_url("site/viewroomjson");
$data["title"]="View room";
$this->load->view("template",$data);
}
function viewroomjson()
{
$elements=array();
$elements[0]=new stdClass();
$elements[0]->field="`chennai_room`.`id`";
$elements[0]->sort="1";
$elements[0]->header="ID";
$elements[0]->alias="id";
$elements[1]=new stdClass();
$elements[1]->field="`chennai_room`.`name`";
$elements[1]->sort="1";
$elements[1]->header="Name";
$elements[1]->alias="name";
$elements[2]=new stdClass();
$elements[2]->field="`chennai_room`.`image`";
$elements[2]->sort="1";
$elements[2]->header="Image";
$elements[2]->alias="image";
$elements[3]=new stdClass();
$elements[3]->field="`chennai_room`.`timestamp`";
$elements[3]->sort="1";
$elements[3]->header="Time stamp";
$elements[3]->alias="timestamp";
$elements[4]=new stdClass();
$elements[4]->field="`chennai_room`.`description`";
$elements[4]->sort="1";
$elements[4]->header="Description";
$elements[4]->alias="description";
$search=$this->input->get_post("search");
$pageno=$this->input->get_post("pageno");
$orderby=$this->input->get_post("orderby");
$orderorder=$this->input->get_post("orderorder");
$maxrow=$this->input->get_post("maxrow");
if($maxrow=="")
{
$maxrow=20;
}
if($orderby=="")
{
$orderby="id";
$orderorder="ASC";
}
$data["message"]=$this->chintantable->query($pageno,$maxrow,$orderby,$orderorder,$search,$elements,"FROM `chennai_room`");
$this->load->view("json",$data);
}

public function createroom()
{
$access=array("1");
$this->checkaccess($access);
$data["page"]="createroom";
$data["title"]="Create room";
$this->load->view("template",$data);
}
public function createroomsubmit() 
{
$access=array("1");
$this->checkaccess($access);
$this->form_validation->set_rules("name","Name","trim");
$this->form_validation->set_rules("image","Image","trim");
$this->form_validation->set_rules("timestamp","Time stamp","trim");
$this->form_validation->set_rules("description","Description","trim");
if($this->form_validation->run()==FALSE)
{
$data["alerterror"]=validation_errors();
$data["page"]="createroom";
$data["title"]="Create room";
$this->load->view("template",$data);
}
else
{
$name=$this->input->get_post("name");
//$image=$this->input->get_post("image");
$timestamp=$this->input->get_post("timestamp");
$description=$this->input->get_post("description");
//	$config['upload_path'] = './uploads/';
//			$config['allowed_types'] = 'gif|jpg|png|jpeg';
//			$this->load->library('upload', $config);
//			$filename="image";
//			$image="";
//			if (  $this->upload->do_upload($filename))
//			{
//				$uploaddata = $this->upload->data();
//				$image=$uploaddata['file_name'];
//                
//                $config_r['source_image']   = './uploads/' . $uploaddata['file_name'];
//                $config_r['maintain_ratio'] = TRUE;
//                $config_t['create_thumb'] = FALSE;///add this
//                $config_r['width']   = 800;
//                $config_r['height'] = 800;
//                $config_r['quality']    = 100;
//                //end of configs
//
//                $this->load->library('image_lib', $config_r); 
//                $this->image_lib->initialize($config_r);
//                if(!$this->image_lib->resize())
//                {
//                    echo "Failed." . $this->image_lib->display_errors();
//                    //return false;
//                }  
//                else
//                {
//                    //print_r($this->image_lib->dest_image);
//                    //dest_image
//                    $image=$this->image_lib->dest_image;
//                    //return false;
//                }
//                
//			}
    
            $config['upload_path'] = './uploads/';
			$config['allowed_types'] = 'gif|jpg|png|jpeg';
			$this->load->library('upload', $config);
			$filename="image";
			$image="";
			if ($this->upload->do_upload($filename))
			{
				$uploaddata = $this->upload->data();
				$image=$uploaddata['file_name'];
			}
//    print_r($uploaddata);
//    echo $image;
if($this->room_model->create($name,$image,$timestamp,$description)==0)
$data["alerterror"]="New room could not be created.";
else
$data["alertsuccess"]="room created Successfully.";
$data["redirect"]="site/viewroom";
$this->load->view("redirect",$data);
}
}
public function editroom()
{
$access=array("1");
$this->checkaccess($access);
$data["page"]="editroom";
$data["title"]="Edit room";
$data["before"]=$this->room_model->beforeedit($this->input->get("id"));
$this->load->view("template",$data);
}
public function editroomsubmit()
{
$access=array("1");
$this->checkaccess($access);
$this->form_validation->set_rules("id","ID","trim");
$this->form_validation->set_rules("name","Name","trim");
$this->form_validation->set_rules("image","Image","trim");
$this->form_validation->set_rules("timestamp","Time stamp","trim");
$this->form_validation->set_rules("description","Description","trim");
if($this->form_validation->run()==FALSE)
{
$data["alerterror"]=validation_errors();
$data["page"]="editroom";
$data["title"]="Edit room";
$data["before"]=$this->room_model->beforeedit($this->input->get("id"));
$this->load->view("template",$data);
}
else
{
$id=$this->input->get_post("id");
$name=$this->input->get_post("name");
//$image=$this->input->get_post("image");
$timestamp=$this->input->get_post("timestamp");
$description=$this->input->get_post("description");
	 $config['upload_path'] = './uploads/';
			$config['allowed_types'] = 'gif|jpg|png|jpeg';
			$this->load->library('upload', $config);
			$filename="image";
			$image="";
			if ($this->upload->do_upload($filename))
			{
				$uploaddata = $this->upload->data();
				$image=$uploaddata['file_name'];
			}
            
            if($image=="")
            {
            $image=$this->user_model->getuserimagebyid($id);
               // print_r($image);
                $image=$image->image;
            }
            
if($this->room_model->edit($id,$name,$image,$timestamp,$description)==0)
$data["alerterror"]="New room could not be Updated.";
else
$data["alertsuccess"]="room Updated Successfully.";
$data["redirect"]="site/viewroom";
$this->load->view("redirect",$data);
}
}
public function deleteroom()
{
$access=array("1");
$this->checkaccess($access);
$this->room_model->delete($this->input->get("id"));
$data["redirect"]="site/viewroom";
$this->load->view("redirect",$data);
}
public function viewroomaccommodation()
{
$access=array("1");
$this->checkaccess($access);
$data["page"]="viewroomaccommodation";
$data["base_url"]=site_url("site/viewroomaccommodationjson");
$data["title"]="View roomaccommodation";
$this->load->view("template",$data);
}
function viewroomaccommodationjson()
{
$elements=array();
$elements[0]=new stdClass();
$elements[0]->field="`chennai_roomaccommodation`.`id`";
$elements[0]->sort="1";
$elements[0]->header="ID";
$elements[0]->alias="id";
$elements[1]=new stdClass();
$elements[1]->field="`chennai_roomaccommodation`.`order`";
$elements[1]->sort="1";
$elements[1]->header="Order";
$elements[1]->alias="order";
$elements[2]=new stdClass();
$elements[2]->field="`chennai_roomaccommodation`.`room`";
$elements[2]->sort="1";
$elements[2]->header="Room";
$elements[2]->alias="room";
$elements[3]=new stdClass();
$elements[3]->field="`chennai_roomaccommodation`.`title`";
$elements[3]->sort="1";
$elements[3]->header="Title";
$elements[3]->alias="title";
$elements[4]=new stdClass();
$elements[4]->field="`chennai_roomaccommodation`.`description`";
$elements[4]->sort="1";
$elements[4]->header="Description";
$elements[4]->alias="description";
$search=$this->input->get_post("search");
$pageno=$this->input->get_post("pageno");
$orderby=$this->input->get_post("orderby");
$orderorder=$this->input->get_post("orderorder");
$maxrow=$this->input->get_post("maxrow");
if($maxrow=="")
{
$maxrow=20;
}
if($orderby=="")
{
$orderby="id";
$orderorder="ASC";
}
$data["message"]=$this->chintantable->query($pageno,$maxrow,$orderby,$orderorder,$search,$elements,"FROM `chennai_roomaccommodation`");
$this->load->view("json",$data);
}

public function createroomaccommodation()
{
$access=array("1");
$this->checkaccess($access);
$data["page"]="createroomaccommodation";
$data["title"]="Create roomaccommodation";
$data[ 'room' ] =$this->room_model->getroomdropdown();
$this->load->view("template",$data);
}
public function createroomaccommodationsubmit() 
{
$access=array("1");
$this->checkaccess($access);
$this->form_validation->set_rules("order","Order","trim");
$this->form_validation->set_rules("room","Room","trim");
$this->form_validation->set_rules("title","Title","trim");
$this->form_validation->set_rules("description","Description","trim");
if($this->form_validation->run()==FALSE)
{
$data["alerterror"]=validation_errors();
$data["page"]="createroomaccommodation";
$data[ 'room' ] =$this->room_model->getroomdropdown();
$data["title"]="Create roomaccommodation";
$this->load->view("template",$data);
}
else
{
$order=$this->input->get_post("order");
$room=$this->input->get_post("room");
$title=$this->input->get_post("title");
$description=$this->input->get_post("description");
if($this->roomaccommodation_model->create($order,$room,$title,$description)==0)
$data["alerterror"]="New roomaccommodation could not be created.";
else
$data["alertsuccess"]="roomaccommodation created Successfully.";
$data["redirect"]="site/viewroomaccommodation";
$this->load->view("redirect",$data);
}
}
public function editroomaccommodation()
{
$access=array("1");
$this->checkaccess($access);
$data["page"]="editroomaccommodation";
$data[ 'room' ] =$this->room_model->getroomdropdown();
$data["title"]="Edit roomaccommodation";
$data["before"]=$this->roomaccommodation_model->beforeedit($this->input->get("id"));
$this->load->view("template",$data);
}
public function editroomaccommodationsubmit()
{
$access=array("1");
$this->checkaccess($access);
$this->form_validation->set_rules("id","ID","trim");
$this->form_validation->set_rules("order","Order","trim");
$this->form_validation->set_rules("room","Room","trim");
$this->form_validation->set_rules("title","Title","trim");
$this->form_validation->set_rules("description","Description","trim");
if($this->form_validation->run()==FALSE)
{
$data["alerterror"]=validation_errors();
$data["page"]="editroomaccommodation";
$data[ 'room' ] =$this->room_model->getroomdropdown();
$data["title"]="Edit roomaccommodation";
$data["before"]=$this->roomaccommodation_model->beforeedit($this->input->get("id"));
$this->load->view("template",$data);
}
else
{
$id=$this->input->get_post("id");
$order=$this->input->get_post("order");
$room=$this->input->get_post("room");
$title=$this->input->get_post("title");
$description=$this->input->get_post("description");
if($this->roomaccommodation_model->edit($id,$order,$room,$title,$description)==0)
$data["alerterror"]="New roomaccommodation could not be Updated.";
else
$data["alertsuccess"]="roomaccommodation Updated Successfully.";
$data["redirect"]="site/viewroomaccommodation";
$this->load->view("redirect",$data);
}
}
public function deleteroomaccommodation()
{
$access=array("1");
$this->checkaccess($access);
$this->roomaccommodation_model->delete($this->input->get("id"));
$data["redirect"]="site/viewroomaccommodation";
$this->load->view("redirect",$data);
}
public function viewroomimage()
{
$access=array("1");
$this->checkaccess($access);
$data["page"]="viewroomimage";
$data[ 'room' ] =$this->room_model->getroomdropdown();
$data["base_url"]=site_url("site/viewroomimagejson");
$data["title"]="View roomimage";
$this->load->view("template",$data);
}
function viewroomimagejson()
{
$elements=array();
$elements[0]=new stdClass();
$elements[0]->field="`chennai_roomimage`.`id`";
$elements[0]->sort="1";
$elements[0]->header="ID";
$elements[0]->alias="id";
$elements[1]=new stdClass();
$elements[1]->field="`chennai_roomimage`.`room`";
$elements[1]->sort="1";
$elements[1]->header="Room";
$elements[1]->alias="room";
$elements[2]=new stdClass();
$elements[2]->field="`chennai_roomimage`.`name`";
$elements[2]->sort="1";
$elements[2]->header="Name";
$elements[2]->alias="name";
$elements[3]=new stdClass();
$elements[3]->field="`chennai_roomimage`.`image`";
$elements[3]->sort="1";
$elements[3]->header="Image";
$elements[3]->alias="image";
$elements[4]=new stdClass();
$elements[4]->field="`chennai_roomimage`.`order`";
$elements[4]->sort="1";
$elements[4]->header="Order";
$elements[4]->alias="order";
$search=$this->input->get_post("search");
$pageno=$this->input->get_post("pageno");
$orderby=$this->input->get_post("orderby");
$orderorder=$this->input->get_post("orderorder");
$maxrow=$this->input->get_post("maxrow");
if($maxrow=="")
{
$maxrow=20;
}
if($orderby=="")
{
$orderby="id";
$orderorder="ASC";
}
$data["message"]=$this->chintantable->query($pageno,$maxrow,$orderby,$orderorder,$search,$elements,"FROM `chennai_roomimage`");
$this->load->view("json",$data);
}

public function createroomimage()
{
$access=array("1");
$this->checkaccess($access);
$data["page"]="createroomimage";
$data[ 'room' ] =$this->room_model->getroomdropdown();
$data["title"]="Create roomimage";
$this->load->view("template",$data);
}
public function createroomimagesubmit() 
{
$access=array("1");
$this->checkaccess($access);
$this->form_validation->set_rules("room","Room","trim");
$this->form_validation->set_rules("name","Name","trim");
$this->form_validation->set_rules("image","Image","trim");
$this->form_validation->set_rules("order","Order","trim");
if($this->form_validation->run()==FALSE)
{
$data["alerterror"]=validation_errors();
$data["page"]="createroomimage";
$data[ 'room' ] =$this->room_model->getroomdropdown();
$data["title"]="Create roomimage";
$this->load->view("template",$data);
}
else
{
$room=$this->input->get_post("room");
$name=$this->input->get_post("name");
//$image=$this->input->get_post("image");
$order=$this->input->get_post("order");
	$config['upload_path'] = './uploads/';
			$config['allowed_types'] = 'gif|jpg|png|jpeg';
			$this->load->library('upload', $config);
			$filename="image";
			$image="";
			if ($this->upload->do_upload($filename))
			{
				$uploaddata = $this->upload->data();
				$image=$uploaddata['file_name'];
			}
            
if($this->roomimage_model->create($room,$name,$image,$order)==0)
$data["alerterror"]="New roomimage could not be created.";
else
$data["alertsuccess"]="roomimage created Successfully.";
$data["redirect"]="site/viewroomimage";
$this->load->view("redirect",$data);
}
}
public function editroomimage()
{
$access=array("1");
$this->checkaccess($access);
$data["page"]="editroomimage";
$data[ 'room' ] =$this->room_model->getroomdropdown();
$data["title"]="Edit roomimage";
$data["before"]=$this->roomimage_model->beforeedit($this->input->get("id"));
$this->load->view("template",$data);
}
public function editroomimagesubmit()
{
$access=array("1");
$this->checkaccess($access);
$this->form_validation->set_rules("id","ID","trim");
$this->form_validation->set_rules("room","Room","trim");
$this->form_validation->set_rules("name","Name","trim");
$this->form_validation->set_rules("image","Image","trim");
$this->form_validation->set_rules("order","Order","trim");
if($this->form_validation->run()==FALSE)
{
$data["alerterror"]=validation_errors();
$data["page"]="editroomimage";
$data[ 'room' ] =$this->room_model->getroomdropdown();
$data["title"]="Edit roomimage";
$data["before"]=$this->roomimage_model->beforeedit($this->input->get("id"));
$this->load->view("template",$data);
}
else
{
$id=$this->input->get_post("id");
$room=$this->input->get_post("room");
$name=$this->input->get_post("name");
//$image=$this->input->get_post("image");
$order=$this->input->get_post("order");
	 $config['upload_path'] = './uploads/';
			$config['allowed_types'] = 'gif|jpg|png|jpeg';
			$this->load->library('upload', $config);
			$filename="image";
			$image="";
			if ($this->upload->do_upload($filename))
			{
				$uploaddata = $this->upload->data();
				$image=$uploaddata['file_name'];
			}
            if($image=="")
            {
            $image=$this->user_model->getuserimagebyid($id);
               // print_r($image);
                $image=$image->image;
            }
            
if($this->roomimage_model->edit($id,$room,$name,$image,$order)==0)
$data["alerterror"]="New roomimage could not be Updated.";
else
$data["alertsuccess"]="roomimage Updated Successfully.";
$data["redirect"]="site/viewroomimage";
$this->load->view("redirect",$data);
}
}
public function deleteroomimage()
{
$access=array("1");
$this->checkaccess($access);
$this->roomimage_model->delete($this->input->get("id"));
$data["redirect"]="site/viewroomimage";
$this->load->view("redirect",$data);
}
public function viewgallery()
{
$access=array("1");
$this->checkaccess($access);
$data["page"]="viewgallery";
$data["base_url"]=site_url("site/viewgalleryjson");
$data["title"]="View gallery";
$this->load->view("template",$data);
}
function viewgalleryjson()
{
$elements=array();
$elements[0]=new stdClass();
$elements[0]->field="`chennai_gallery`.`id`";
$elements[0]->sort="1";
$elements[0]->header="ID";
$elements[0]->alias="id";
$elements[1]=new stdClass();
$elements[1]->field="`chennai_gallery`.`name`";
$elements[1]->sort="1";
$elements[1]->header="Name";
$elements[1]->alias="name";
$elements[2]=new stdClass();
$elements[2]->field="`chennai_gallery`.`image`";
$elements[2]->sort="1";
$elements[2]->header="Image";
$elements[2]->alias="image";
$elements[3]=new stdClass();
$elements[3]->field="`chennai_gallery`.`order`";
$elements[3]->sort="1";
$elements[3]->header="Order";
$elements[3]->alias="order";
$elements[4]=new stdClass();
$elements[4]->field="`chennai_gallery`.`timestamp`";
$elements[4]->sort="1";
$elements[4]->header="Time stamp";
$elements[4]->alias="timestamp";
$search=$this->input->get_post("search");
$pageno=$this->input->get_post("pageno");
$orderby=$this->input->get_post("orderby");
$orderorder=$this->input->get_post("orderorder");
$maxrow=$this->input->get_post("maxrow");
if($maxrow=="")
{
$maxrow=20;
}
if($orderby=="")
{
$orderby="id";
$orderorder="ASC";
}
$data["message"]=$this->chintantable->query($pageno,$maxrow,$orderby,$orderorder,$search,$elements,"FROM `chennai_gallery`");
$this->load->view("json",$data);
}

public function creategallery()
{
$access=array("1");
$this->checkaccess($access);
$data["page"]="creategallery";
$data["title"]="Create gallery";
$this->load->view("template",$data);
}
public function creategallerysubmit() 
{
$access=array("1");
$this->checkaccess($access);
$this->form_validation->set_rules("name","Name","trim");
$this->form_validation->set_rules("image","Image","trim");
$this->form_validation->set_rules("order","Order","trim");
$this->form_validation->set_rules("timestamp","Time stamp","trim");
if($this->form_validation->run()==FALSE)
{
$data["alerterror"]=validation_errors();
$data["page"]="creategallery";
$data["title"]="Create gallery";
$this->load->view("template",$data);
}
else
{
$name=$this->input->get_post("name");
//$image=$this->input->get_post("image");
$order=$this->input->get_post("order");
$timestamp=$this->input->get_post("timestamp");
	$config['upload_path'] = './uploads/';
			$config['allowed_types'] = 'gif|jpg|png|jpeg';
			$this->load->library('upload', $config);
			$filename="image";
			$image="";
			if ($this->upload->do_upload($filename))
			{
				$uploaddata = $this->upload->data();
				$image=$uploaddata['file_name'];
			}
            
if($this->gallery_model->create($name,$image,$order,$timestamp)==0)
$data["alerterror"]="New gallery could not be created.";
else
$data["alertsuccess"]="gallery created Successfully.";
$data["redirect"]="site/viewgallery";
$this->load->view("redirect",$data);
}
}
public function editgallery()
{
$access=array("1");
$this->checkaccess($access);
$data["page"]="editgallery";
$data["title"]="Edit gallery";
$data["before"]=$this->gallery_model->beforeedit($this->input->get("id"));
$this->load->view("template",$data);
}
public function editgallerysubmit()
{
$access=array("1");
$this->checkaccess($access);
$this->form_validation->set_rules("id","ID","trim");
$this->form_validation->set_rules("name","Name","trim");
$this->form_validation->set_rules("image","Image","trim");
$this->form_validation->set_rules("order","Order","trim");
$this->form_validation->set_rules("timestamp","Time stamp","trim");
if($this->form_validation->run()==FALSE)
{
$data["alerterror"]=validation_errors();
$data["page"]="editgallery";
$data["title"]="Edit gallery";
$data["before"]=$this->gallery_model->beforeedit($this->input->get("id"));
$this->load->view("template",$data);
}
else
{
$id=$this->input->get_post("id");
$name=$this->input->get_post("name");
//$image=$this->input->get_post("image");
$order=$this->input->get_post("order");
$timestamp=$this->input->get_post("timestamp");
	 $config['upload_path'] = './uploads/';
			$config['allowed_types'] = 'gif|jpg|png|jpeg';
			$this->load->library('upload', $config);
			$filename="image";
			$image="";
			if ($this->upload->do_upload($filename))
			{
				$uploaddata = $this->upload->data();
				$image=$uploaddata['file_name'];
			}
            
            if($image=="")
            {
            $image=$this->user_model->getuserimagebyid($id);
               // print_r($image);
                $image=$image->image;
            }
            
if($this->gallery_model->edit($id,$name,$image,$order,$timestamp)==0)
$data["alerterror"]="New gallery could not be Updated.";
else
$data["alertsuccess"]="gallery Updated Successfully.";
$data["redirect"]="site/viewgallery";
$this->load->view("redirect",$data);
}
}
public function deletegallery()
{
$access=array("1");
$this->checkaccess($access);
$this->gallery_model->delete($this->input->get("id"));
$data["redirect"]="site/viewgallery";
$this->load->view("redirect",$data);
}
	// contact us
	
	public function createcontactus()
	{
		$access = array("1");
		$this->checkaccess($access);
		$data[ 'status' ] =$this->contactus_model->getstatusdropdown();
		$data[ 'page' ] = 'createcontactus';
		$data[ 'title' ] = 'Create contactus';
		$this->load->view( 'template', $data );	
	}
	function createcontactussubmit()
	{
		$access = array("1");
		$this->checkaccess($access);
		$this->form_validation->set_rules('firstname','Firstname','trim|required|max_length[30]');
		$this->form_validation->set_rules('lastname','Lastname','trim|required|max_length[30]');
		$this->form_validation->set_rules('email','Email','trim|required|valid_email|is_unique[user.email]');
		$this->form_validation->set_rules('contact','contact','trim|required|max_length[30]');
		$this->form_validation->set_rules('status','status','trim|');
		$this->form_validation->set_rules('request','Request','trim|');
		if($this->form_validation->run() == FALSE)	
		{
			$data['alerterror'] = validation_errors();
            $data[ 'status' ] =$this->contactus_model->getstatusdropdown();
            $data[ 'page' ] = 'createcontactus';
            $data[ 'title' ] = 'Create contactus';
            $this->load->view( 'template', $data );	
		}
		else
		{
            $firstname=$this->input->post('firstname');
            $lastname=$this->input->post('lastname');
            $email=$this->input->post('email');
            $contact=$this->input->post('contact');
            $status=$this->input->post('status');
            $request=$this->input->post('request');
			if($this->contactus_model->create($firstname,$lastname,$email,$contact,$status,$request)==0)
			$data['alerterror']="New contactus could not be created.";
			else
			$data['alertsuccess']="contactus created Successfully.";
			$data['redirect']="site/viewcontactus";
			$this->load->view("redirect",$data);
		}
	}
    function viewcontactus()
	{
		$access = array("1");
		$this->checkaccess($access);
		$data['page']='viewcontactus';
        $data['base_url'] = site_url("site/viewcontactusjson");      
		$data['title']='View contactus';
		$this->load->view('template',$data);
	} 
    function viewcontactusjson()
	{
		$access = array("1");
		$this->checkaccess($access);
        
        
        $elements=array();
        $elements[0]=new stdClass();
        $elements[0]->field="`contactus`.`id`";
        $elements[0]->sort="1";
        $elements[0]->header="ID";
        $elements[0]->alias="id";
        
        
        $elements[1]=new stdClass();
        $elements[1]->field="`contactus`.`firstname`";
        $elements[1]->sort="1";
        $elements[1]->header="Firstname";
        $elements[1]->alias="firstname";
        
        $elements[2]=new stdClass();
        $elements[2]->field="`contactus`.`lastname`";
        $elements[2]->sort="1";
        $elements[2]->header="Lastname";
        $elements[2]->alias="lastname";
        
        $elements[3]=new stdClass();
        $elements[3]->field="`contactus`.`email`";
        $elements[3]->sort="1";
        $elements[3]->header="Email";
        $elements[3]->alias="email";
        
        $elements[4]=new stdClass();
        $elements[4]->field="`contactus`.`contact`";
        $elements[4]->sort="1";
        $elements[4]->header="Contact";
        $elements[4]->alias="contact";
		
		$elements[5]=new stdClass();
        $elements[5]->field="`contactus`.`status`";
        $elements[5]->sort="1";
        $elements[5]->header="Status";
        $elements[5]->alias="status";
		
		$elements[6]=new stdClass();
        $elements[6]->field="`contactus`.`timestamp`";
        $elements[6]->sort="1";
        $elements[6]->header="Timestamp";
        $elements[6]->alias="timestamp";
        
       
        
        $search=$this->input->get_post("search");
        $pageno=$this->input->get_post("pageno");
        $orderby=$this->input->get_post("orderby");
        $orderorder=$this->input->get_post("orderorder");
        $maxrow=$this->input->get_post("maxrow");
        if($maxrow=="")
        {
            $maxrow=20;
        }
        
        if($orderby=="")
        {
            $orderby="id";
            $orderorder="ASC";
        }
       
        $data["message"]=$this->chintantable->query($pageno,$maxrow,$orderby,$orderorder,$search,$elements,"FROM `contactus`");
        
		$this->load->view("json",$data);
	} 
    
    
	function editcontactus()
	{
		$access = array("1");
		$this->checkaccess($access);
		$data[ 'status' ] =$this->contactus_model->getstatusdropdown();
		$data['before']=$this->contactus_model->beforeedit($this->input->get('id'));
		$data['page']='editcontactus';
		$data['title']='Edit contactus';
		$this->load->view('template',$data);
	}
	function editcontactussubmit()
	{
		$access = array("1");
		$this->checkaccess($access);
		
		$this->form_validation->set_rules('firstname','Firstname','trim|required|max_length[30]');
		$this->form_validation->set_rules('lastname','Lastname','trim|required|max_length[30]');
		$this->form_validation->set_rules('email','Email','trim|required|valid_email|is_unique[user.email]');
		$this->form_validation->set_rules('contact','contact','trim|required|max_length[30]');
		$this->form_validation->set_rules('status','status','trim|');
		$this->form_validation->set_rules('request','Request','trim|');
		if($this->form_validation->run() == FALSE)	
		{
			$data['alerterror'] = validation_errors();
			$data[ 'status' ] =$this->contactus_model->getstatusdropdown();
			$data['before']=$this->contactus_model->beforeedit($this->input->post('id'));
			$data['page']='editcontactus';
//			$data['page2']='block/userblock';
			$data['title']='Edit contactus';
			$this->load->view('template',$data);
		}
		else
		{
            
            $id=$this->input->get_post('id');
            $firstname=$this->input->post('firstname');
            $lastname=$this->input->post('lastname');
            $email=$this->input->post('email');
            $contact=$this->input->post('contact');
            $status=$this->input->post('status');
            $request=$this->input->post('request');
            $timestamp=$this->input->post('timestamp');
//            $category=$this->input->get_post('category');
            
           
			if($this->contactus_model->edit($id,$firstname,$lastname,$email,$contact,$status,$request,$timestamp)==0)
			$data['alerterror']="contactus Editing was unsuccesful";
			else
			$data['alertsuccess']="contactus edited Successfully.";
			
			$data['redirect']="site/viewcontactus";
			//$data['other']="template=$template";
			$this->load->view("redirect",$data);
			
		}
	}
	
	function deletecontactus()
	{
		$access = array("1");
		$this->checkaccess($access);
		$this->contactus_model->deletecontactus($this->input->get('id'));
//		$data['table']=$this->contactus_model->viewusers();
		$data['alertsuccess']="contactus Deleted Successfully";
		$data['redirect']="site/viewcontactus";
			//$data['other']="template=$template";
		$this->load->view("redirect",$data);
	}

	
	// newsletter
	
	public function createnewsletter()
	{
		$access = array("1");
		$this->checkaccess($access);
		$data[ 'page' ] = 'createnewsletter';
		$data[ 'title' ] = 'Create newsletter';
		$this->load->view( 'template', $data );	
	}
	function createnewslettersubmit()
	{
		$access = array("1");
		$this->checkaccess($access);
		$this->form_validation->set_rules('email','Email','trim|required|valid_email|is_unique[user.email]');
		if($this->form_validation->run() == FALSE)	
		{
			$data['alerterror'] = validation_errors();
            $data[ 'page' ] = 'createnewsletter';
            $data[ 'title' ] = 'Create newsletter';
            $this->load->view( 'template', $data );	
		}
		else
		{
         
            $email=$this->input->post('email');         
			if($this->newsletter_model->create($email)==0)
			$data['alerterror']="New newsletter could not be created.";
			else
			$data['alertsuccess']="newsletter created Successfully.";
			$data['redirect']="site/viewnewsletter";
			$this->load->view("redirect",$data);
		}
	}
    function viewnewsletter()
	{
		$access = array("1");
		$this->checkaccess($access);
		$data['page']='viewnewsletter';
        $data['base_url'] = site_url("site/viewnewsletterjson");      
		$data['title']='View newsletter';
		$this->load->view('template',$data);
	} 
    function viewnewsletterjson()
	{
		$access = array("1");
		$this->checkaccess($access);
        
        
        $elements=array();
        $elements[0]=new stdClass();
        $elements[0]->field="`newsletter`.`id`";
        $elements[0]->sort="1";
        $elements[0]->header="ID";
        $elements[0]->alias="id";
        
        
        $elements[1]=new stdClass();
        $elements[1]->field="`newsletter`.`email`";
        $elements[1]->sort="1";
        $elements[1]->header="Email";
        $elements[1]->alias="email";
   
		
		$elements[2]=new stdClass();
        $elements[2]->field="`newsletter`.`timestamp`";
        $elements[2]->sort="1";
        $elements[2]->header="Timestamp";
        $elements[2]->alias="timestamp";
        
       
        
        $search=$this->input->get_post("search");
        $pageno=$this->input->get_post("pageno");
        $orderby=$this->input->get_post("orderby");
        $orderorder=$this->input->get_post("orderorder");
        $maxrow=$this->input->get_post("maxrow");
        if($maxrow=="")
        {
            $maxrow=20;
        }
        
        if($orderby=="")
        {
            $orderby="id";
            $orderorder="ASC";
        }
       
        $data["message"]=$this->chintantable->query($pageno,$maxrow,$orderby,$orderorder,$search,$elements,"FROM `newsletter`");
        
		$this->load->view("json",$data);
	} 
    
    
	function editnewsletter()
	{
		$access = array("1");
		$this->checkaccess($access);
		$data['before']=$this->newsletter_model->beforeedit($this->input->get('id'));
		$data['page']='editnewsletter';
		$data['title']='Edit newsletter';
		$this->load->view('template',$data);
	}
	function editnewslettersubmit()
	{
		$access = array("1");
		$this->checkaccess($access);
		
		$this->form_validation->set_rules('email','Email','trim|required|valid_email|is_unique[user.email]');
		if($this->form_validation->run() == FALSE)	
		{
			$data['alerterror'] = validation_errors();
			$data['before']=$this->newsletter_model->beforeedit($this->input->post('id'));
			$data['page']='editnewsletter';
//			$data['page2']='block/userblock';
			$data['title']='Edit newsletter';
			$this->load->view('template',$data);
		}
		else
		{
            
            $id=$this->input->get_post('id');
            $email=$this->input->post('email');
            $timestamp=$this->input->post('timestamp');
//            $category=$this->input->get_post('category');
            
           
			if($this->newsletter_model->edit($id,$email,$timestamp)==0)
			$data['alerterror']="newsletter Editing was unsuccesful";
			else
			$data['alertsuccess']="newsletter edited Successfully.";
			
			$data['redirect']="site/viewnewsletter";
			//$data['other']="template=$template";
			$this->load->view("redirect",$data);
			
		}
	}
	
	function deletenewsletter()
	{
		$access = array("1");
		$this->checkaccess($access);
		$this->newsletter_model->deletenewsletter($this->input->get('id'));
//		$data['table']=$this->newsletter_model->viewusers();
		$data['alertsuccess']="newsletter Deleted Successfully";
		$data['redirect']="site/viewnewsletter";
			//$data['other']="template=$template";
		$this->load->view("redirect",$data);
	}

}
?>
