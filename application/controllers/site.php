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
    
    
    

    public function viewministry()
    {
        $access=array("1");
        $this->checkaccess($access);
        $data["page"]="viewministry";
        $data["base_url"]=site_url("site/viewministryjson");
        $data["title"]="View ministry";
        $this->load->view("template",$data);
    }
    function viewministryjson()
    {
        $elements=array();
        
        $elements[0]=new stdClass();
        $elements[0]->field="`martyr_ministry`.`id`";
        $elements[0]->sort="1";
        $elements[0]->header="ID";
        $elements[0]->alias="id";
        
        $elements[1]=new stdClass();
        $elements[1]->field="`martyr_ministry`.`name`";
        $elements[1]->sort="1";
        $elements[1]->header="Name";
        $elements[1]->alias="name";
        
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
        $data["message"]=$this->chintantable->query($pageno,$maxrow,$orderby,$orderorder,$search,$elements,"FROM `martyr_ministry`");
        $this->load->view("json",$data);
    }

    public function createministry()
    {
        $access=array("1");
        $this->checkaccess($access);
        $data["page"]="createministry";
        $data["title"]="Create ministry";
        $this->load->view("template",$data);
    }
    public function createministrysubmit() 
    {
        $access=array("1");
        $this->checkaccess($access);
        $this->form_validation->set_rules("name","Name","trim");
        if($this->form_validation->run()==FALSE)
        {
            $data["alerterror"]=validation_errors();
            $data["page"]="createministry";
            $data["title"]="Create ministry";
            $this->load->view("template",$data);
        }
        else
        {
            $name=$this->input->get_post("name");
            if($this->ministry_model->create($name)==0)
                $data["alerterror"]="New ministry could not be created.";
            else
                $data["alertsuccess"]="ministry created Successfully.";
            $data["redirect"]="site/viewministry";
            $this->load->view("redirect",$data);
        }
    }
    public function editministry()
    {
        $access=array("1");
        $this->checkaccess($access);
        $data["page"]="editministry";
        $data["title"]="Edit ministry";
        $data["before"]=$this->ministry_model->beforeedit($this->input->get("id"));
        $this->load->view("template",$data);
    }
    public function editministrysubmit()
    {
        $access=array("1");
        $this->checkaccess($access);
        $this->form_validation->set_rules("id","ID","trim");
        $this->form_validation->set_rules("name","Name","trim");
        if($this->form_validation->run()==FALSE)
        {
            $data["alerterror"]=validation_errors();
            $data["page"]="editministry";
            $data["title"]="Edit ministry";
            $data["before"]=$this->ministry_model->beforeedit($this->input->get("id"));
            $this->load->view("template",$data);
        }
        else
        {
            $id=$this->input->get_post("id");
            $name=$this->input->get_post("name");
            if($this->ministry_model->edit($id,$name)==0)
                $data["alerterror"]="New ministry could not be Updated.";
            else
                $data["alertsuccess"]="ministry Updated Successfully.";
            $data["redirect"]="site/viewministry";
            $this->load->view("redirect",$data);
        }
    }
    public function deleteministry()
    {
        $access=array("1");
        $this->checkaccess($access);
        $this->ministry_model->delete($this->input->get("id"));
        $data["redirect"]="site/viewministry";
        $this->load->view("redirect",$data);
    }
    public function viewcategory()
    {
        $access=array("1");
        $this->checkaccess($access);
        $data["page"]="viewcategory";
        $data["base_url"]=site_url("site/viewcategoryjson");
        $data["title"]="View category";
        $this->load->view("template",$data);
    }
    function viewcategoryjson()
    {
        $elements=array();
        
        $elements[0]=new stdClass();
        $elements[0]->field="`martyr_category`.`id`";
        $elements[0]->sort="1";
        $elements[0]->header="ID";
        $elements[0]->alias="id";
        
        $elements[1]=new stdClass();
        $elements[1]->field="`martyr_category`.`name`";
        $elements[1]->sort="1";
        $elements[1]->header="Name";
        $elements[1]->alias="name";
        
        $elements[2]=new stdClass();
        $elements[2]->field="`martyr_category`.`ministry`";
        $elements[2]->sort="1";
        $elements[2]->header="Ministry";
        $elements[2]->alias="ministry";
        
        $elements[3]=new stdClass();
        $elements[3]->field="`martyr_category`.`order`";
        $elements[3]->sort="1";
        $elements[3]->header="Order";
        $elements[3]->alias="order";
        
        $elements[4]=new stdClass();
        $elements[4]->field="`martyr_ministry`.`name`";
        $elements[4]->sort="1";
        $elements[4]->header="Ministry Name";
        $elements[4]->alias="ministryname";
        
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
        $data["message"]=$this->chintantable->query($pageno,$maxrow,$orderby,$orderorder,$search,$elements,"FROM `martyr_category` LEFT OUTER JOIN `martyr_ministry` ON `martyr_ministry`.`id`=`martyr_category`.`ministry`");
        $this->load->view("json",$data);
    }

    public function createcategory()
    {
        $access=array("1");
        $this->checkaccess($access);
        $data["page"]="createcategory";
        $data["ministry"]=$this->ministry_model->getministrydropdown();
        $data["title"]="Create category";
        $this->load->view("template",$data);
    }
    public function createcategorysubmit() 
    {
        $access=array("1");
        $this->checkaccess($access);
        $this->form_validation->set_rules("name","Name","trim");
        $this->form_validation->set_rules("ministry","Ministry","trim");
        $this->form_validation->set_rules("order","Order","trim");
        if($this->form_validation->run()==FALSE)
        {
            $data["alerterror"]=validation_errors();
            $data["page"]="createcategory";
            $data["title"]="Create category";
            $data["ministry"]=$this->ministry_model->getministrydropdown();
            $this->load->view("template",$data);
        }
        else
        {
            $name=$this->input->get_post("name");
            $ministry=$this->input->get_post("ministry");
            $order=$this->input->get_post("order");
            if($this->category_model->create($name,$ministry,$order)==0)
                $data["alerterror"]="New category could not be created.";
            else
                $data["alertsuccess"]="category created Successfully.";
            $data["redirect"]="site/viewcategory";
            $this->load->view("redirect",$data);
        }
    }
    public function editcategory()
    {
        $access=array("1");
        $this->checkaccess($access);
        $data["page"]="editcategory";
        $data["title"]="Edit category";
        $data["ministry"]=$this->ministry_model->getministrydropdown();
        $data["before"]=$this->category_model->beforeedit($this->input->get("id"));
        $this->load->view("template",$data);
    }
    public function editcategorysubmit()
    {
        $access=array("1");
        $this->checkaccess($access);
        $this->form_validation->set_rules("id","ID","trim");
        $this->form_validation->set_rules("name","Name","trim");
        $this->form_validation->set_rules("ministry","Ministry","trim");
        $this->form_validation->set_rules("order","Order","trim");
        if($this->form_validation->run()==FALSE)
        {
            $data["alerterror"]=validation_errors();
            $data["page"]="editcategory";
            $data["title"]="Edit category";
            $data["ministry"]=$this->ministry_model->getministrydropdown();
            $data["before"]=$this->category_model->beforeedit($this->input->get("id"));
            $this->load->view("template",$data);
        }
        else
        {
            $id=$this->input->get_post("id");
            $name=$this->input->get_post("name");
            $ministry=$this->input->get_post("ministry");
            $order=$this->input->get_post("order");
            if($this->category_model->edit($id,$name,$ministry,$order)==0)
                $data["alerterror"]="New category could not be Updated.";
            else
                $data["alertsuccess"]="category Updated Successfully.";
            $data["redirect"]="site/viewcategory";
            $this->load->view("redirect",$data);
        }
    }
    public function deletecategory()
    {
        $access=array("1");
        $this->checkaccess($access);
        $this->category_model->delete($this->input->get("id"));
        $data["redirect"]="site/viewcategory";
        $this->load->view("redirect",$data);
    }
    public function viewsubcategory()
    {
        $access=array("1");
        $this->checkaccess($access);
        $data["page"]="viewsubcategory";
        $data["base_url"]=site_url("site/viewsubcategoryjson");
        $data["title"]="View subcategory";
        $this->load->view("template",$data);
    }
    function viewsubcategoryjson()
    {
        $elements=array();
        
        $elements[0]=new stdClass();
        $elements[0]->field="`martyr_subcategory`.`id`";
        $elements[0]->sort="1";
        $elements[0]->header="ID";
        $elements[0]->alias="id";
        
        $elements[1]=new stdClass();
        $elements[1]->field="`martyr_subcategory`.`category`";
        $elements[1]->sort="1";
        $elements[1]->header="Category";
        $elements[1]->alias="category";
        
        $elements[2]=new stdClass();
        $elements[2]->field="`martyr_subcategory`.`name`";
        $elements[2]->sort="1";
        $elements[2]->header="Name";
        $elements[2]->alias="name";
        
        $elements[3]=new stdClass();
        $elements[3]->field="`martyr_subcategory`.`order`";
        $elements[3]->sort="1";
        $elements[3]->header="Order";
        $elements[3]->alias="order";
        
        $elements[4]=new stdClass();
        $elements[4]->field="`martyr_category`.`name`";
        $elements[4]->sort="1";
        $elements[4]->header="Category Name";
        $elements[4]->alias="categoryname";
        
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
        $data["message"]=$this->chintantable->query($pageno,$maxrow,$orderby,$orderorder,$search,$elements,"FROM `martyr_subcategory` LEFT OUTER JOIN `martyr_category` ON `martyr_category`.`id`=`martyr_subcategory`.`category`");
        $this->load->view("json",$data);
    }

    public function createsubcategory()
    {
        $access=array("1");
        $this->checkaccess($access);
        $data["page"]="createsubcategory";
        $data["title"]="Create subcategory";
        $data["category"]=$this->category_model->getcategorydropdown();
        $this->load->view("template",$data);
    }
    public function createsubcategorysubmit() 
    {
        $access=array("1");
        $this->checkaccess($access);
        $this->form_validation->set_rules("category","Category","trim");
        $this->form_validation->set_rules("name","Name","trim");
        $this->form_validation->set_rules("order","Order","trim");
        if($this->form_validation->run()==FALSE)
        {
            $data["alerterror"]=validation_errors();
            $data["page"]="createsubcategory";
            $data["title"]="Create subcategory";
            $data["category"]=$this->category_model->getcategorydropdown();
            $this->load->view("template",$data);
        }
        else
        {
            $category=$this->input->get_post("category");
            $name=$this->input->get_post("name");
            $order=$this->input->get_post("order");
            if($this->subcategory_model->create($category,$name,$order)==0)
                $data["alerterror"]="New subcategory could not be created.";
            else
                $data["alertsuccess"]="subcategory created Successfully.";
            $data["redirect"]="site/viewsubcategory";
            $this->load->view("redirect",$data);
        }
    }
    public function editsubcategory()
    {
        $access=array("1");
        $this->checkaccess($access);
        $data["page"]="editsubcategory";
        $data["title"]="Edit subcategory";
        $data["category"]=$this->category_model->getcategorydropdown();
        $data["before"]=$this->subcategory_model->beforeedit($this->input->get("id"));
        $this->load->view("template",$data);
    }
    public function editsubcategorysubmit()
    {
        $access=array("1");
        $this->checkaccess($access);
        $this->form_validation->set_rules("id","ID","trim");
        $this->form_validation->set_rules("category","Category","trim");
        $this->form_validation->set_rules("name","Name","trim");
        $this->form_validation->set_rules("order","Order","trim");
        if($this->form_validation->run()==FALSE)
        {
            $data["alerterror"]=validation_errors();
            $data["page"]="editsubcategory";
            $data["title"]="Edit subcategory";
            $data["category"]=$this->category_model->getcategorydropdown();
            $data["before"]=$this->subcategory_model->beforeedit($this->input->get("id"));
            $this->load->view("template",$data);
        }
        else
        {
            $id=$this->input->get_post("id");
            $category=$this->input->get_post("category");
            $name=$this->input->get_post("name");
            $order=$this->input->get_post("order");
            if($this->subcategory_model->edit($id,$category,$name,$order)==0)
                $data["alerterror"]="New subcategory could not be Updated.";
            else
                $data["alertsuccess"]="subcategory Updated Successfully.";
            $data["redirect"]="site/viewsubcategory";
            $this->load->view("redirect",$data);
        }
    }
    public function deletesubcategory()
    {
        $access=array("1");
        $this->checkaccess($access);
        $this->subcategory_model->delete($this->input->get("id"));
        $data["redirect"]="site/viewsubcategory";
        $this->load->view("redirect",$data);
    }
    
    public function viewregiment()
    {
        $access=array("1");
        $this->checkaccess($access);
        $data["page"]="viewregiment";
        $data["base_url"]=site_url("site/viewregimentjson");
        $data["title"]="View regiment";
        $this->load->view("template",$data);
    }
    function viewregimentjson()
    {
        $elements=array();
        
        $elements[0]=new stdClass();
        $elements[0]->field="`martyr_regiment`.`id`";
        $elements[0]->sort="1";
        $elements[0]->header="ID";
        $elements[0]->alias="id";
        
        $elements[1]=new stdClass();
        $elements[1]->field="`martyr_regiment`.`subcategory`";
        $elements[1]->sort="1";
        $elements[1]->header="Sub Category";
        $elements[1]->alias="subcategory";
        
        $elements[2]=new stdClass();
        $elements[2]->field="`martyr_regiment`.`name`";
        $elements[2]->sort="1";
        $elements[2]->header="Name";
        $elements[2]->alias="name";
        
        $elements[3]=new stdClass();
        $elements[3]->field="`martyr_regiment`.`order`";
        $elements[3]->sort="1";
        $elements[3]->header="Order";
        $elements[3]->alias="order";
        
        $elements[4]=new stdClass();
        $elements[4]->field="`navigation`.`name`";
        $elements[4]->sort="1";
        $elements[4]->header="Navigation";
        $elements[4]->alias="subcategoryname";
        
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
        $data["message"]=$this->chintantable->query($pageno,$maxrow,$orderby,$orderorder,$search,$elements,"FROM `martyr_regiment` LEFT OUTER JOIN `navigation` ON `navigation`.`id`=`martyr_regiment`.`subcategory`");
        $this->load->view("json",$data);
    }

    public function createregiment()
    {
        $access=array("1");
        $this->checkaccess($access);
        $data["page"]="createregiment";
        $data["title"]="Create regiment";
        $data["subcategory"]=$this->navigation_model->getsubcategorydropdown();
        $this->load->view("template",$data);
    }
    public function createregimentsubmit() 
    {
        $access=array("1");
        $this->checkaccess($access);
        $this->form_validation->set_rules("subcategory","Sub Category","trim");
        $this->form_validation->set_rules("name","Name","trim");
        $this->form_validation->set_rules("order","Order","trim");
        if($this->form_validation->run()==FALSE)
        {
            $data["alerterror"]=validation_errors();
            $data["page"]="createregiment";
            $data["title"]="Create regiment";
            $data["subcategory"]=$this->navigation_model->getsubcategorydropdown();
            $this->load->view("template",$data);
        }
        else
        {
            $subcategory=$this->input->get_post("subcategory");
            $name=$this->input->get_post("name");
            $order=$this->input->get_post("order");
            if($this->regiment_model->create($subcategory,$name,$order)==0)
                $data["alerterror"]="New regiment could not be created.";
            else
                $data["alertsuccess"]="regiment created Successfully.";
            $data["redirect"]="site/viewregiment";
            $this->load->view("redirect",$data);
        }
    }
    public function editregiment()
    {
        $access=array("1");
        $this->checkaccess($access);
        $data["page"]="editregiment";
        $data["title"]="Edit regiment";
            $data["subcategory"]=$this->navigation_model->getsubcategorydropdown();
        $data["before"]=$this->regiment_model->beforeedit($this->input->get("id"));
        $this->load->view("template",$data);
    }
    public function editregimentsubmit()
    {
        $access=array("1");
        $this->checkaccess($access);
        $this->form_validation->set_rules("id","ID","trim");
        $this->form_validation->set_rules("subcategory","Sub Category","trim");
        $this->form_validation->set_rules("name","Name","trim");
        $this->form_validation->set_rules("order","Order","trim");
        if($this->form_validation->run()==FALSE)
        {
            $data["alerterror"]=validation_errors();
            $data["page"]="editregiment";
            $data["title"]="Edit regiment";
            $data["subcategory"]=$this->navigation_model->getsubcategorydropdown();
            $data["before"]=$this->regiment_model->beforeedit($this->input->get("id"));
            $this->load->view("template",$data);
        }
        else
        {
            $id=$this->input->get_post("id");
            $subcategory=$this->input->get_post("subcategory");
            $name=$this->input->get_post("name");
            $order=$this->input->get_post("order");
            if($this->regiment_model->edit($id,$subcategory,$name,$order)==0)
                $data["alerterror"]="New regiment could not be Updated.";
            else
                $data["alertsuccess"]="regiment Updated Successfully.";
            $data["redirect"]="site/viewregiment";
            $this->load->view("redirect",$data);
        }
    }
    public function deleteregiment()
    {
        $access=array("1");
        $this->checkaccess($access);
        $this->regiment_model->delete($this->input->get("id"));
        $data["redirect"]="site/viewregiment";
        $this->load->view("redirect",$data);
    }
    public function viewmartyr()
    {
        $access=array("1");
        $this->checkaccess($access);
        $data["page"]="viewmartyr";
        $data["base_url"]=site_url("site/viewmartyrjson");
        $data["title"]="View martyr";
        $this->load->view("template",$data);
    }
    function viewmartyrjson()
    {
        $elements=array();
        
        $elements[0]=new stdClass();
        $elements[0]->field="`martyr_martyr`.`id`";
        $elements[0]->sort="1";
        $elements[0]->header="ID";
        $elements[0]->alias="id";
        
        $elements[1]=new stdClass();
        $elements[1]->field="`martyr_martyr`.`regiment`";
        $elements[1]->sort="1";
        $elements[1]->header="Regiment";
        $elements[1]->alias="regiment";
        
        $elements[2]=new stdClass();
        $elements[2]->field="`martyr_martyr`.`name`";
        $elements[2]->sort="1";
        $elements[2]->header="Name";
        $elements[2]->alias="name";
        
        $elements[3]=new stdClass();
        $elements[3]->field="`martyr_martyr`.`rank`";
        $elements[3]->sort="1";
        $elements[3]->header="Rank";
        $elements[3]->alias="rank";
        
        $elements[4]=new stdClass();
        $elements[4]->field="`martyr_martyr`.`unit`";
        $elements[4]->sort="1";
        $elements[4]->header="Unit";
        $elements[4]->alias="unit";
        
        $elements[5]=new stdClass();
        $elements[5]->field="`martyr_martyr`.`homestate`";
        $elements[5]->sort="1";
        $elements[5]->header="Home State";
        $elements[5]->alias="homestate";
        
        $elements[6]=new stdClass();
        $elements[6]->field="`martyr_martyr`.`operation`";
        $elements[6]->sort="1";
        $elements[6]->header="Operation";
        $elements[6]->alias="operation";
        
        $elements[7]=new stdClass();
        $elements[7]->field="`martyr_martyr`.`dateofdeath`";
        $elements[7]->sort="1";
        $elements[7]->header="Date Of Death";
        $elements[7]->alias="dateofdeath";
        
        $elements[8]=new stdClass();
        $elements[8]->field="`martyr_martyr`.`image`";
        $elements[8]->sort="1";
        $elements[8]->header="Image";
        $elements[8]->alias="image";
        
        $elements[9]=new stdClass();
        $elements[9]->field="`martyr_martyr`.`age`";
        $elements[9]->sort="1";
        $elements[9]->header="Age";
        $elements[9]->alias="age";
        
        $elements[10]=new stdClass();
        $elements[10]->field="`martyr_martyr`.`description`";
        $elements[10]->sort="1";
        $elements[10]->header="Description";
        $elements[10]->alias="description";
        
        $elements[11]=new stdClass();
        $elements[11]->field="`martyr_martyr`.`status`";
        $elements[11]->sort="1";
        $elements[11]->header="Status";
        $elements[11]->alias="status";
        
        $elements[12]=new stdClass();
        $elements[12]->field="`martyr_martyr`.`lights`";
        $elements[12]->sort="1";
        $elements[12]->header="Lights";
        $elements[12]->alias="lights";
        
        $elements[13]=new stdClass();
        $elements[13]->field="`martyr_martyr`.`email`";
        $elements[13]->sort="1";
        $elements[13]->header="Email";
        $elements[13]->alias="email";
        
        $elements[14]=new stdClass();
        $elements[14]->field="`martyr_regiment`.`name`";
        $elements[14]->sort="1";
        $elements[14]->header="Regimentname";
        $elements[14]->alias="regimentname";
        
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
        $data["message"]=$this->chintantable->query($pageno,$maxrow,$orderby,$orderorder,$search,$elements,"FROM `martyr_martyr` LEFT OUTER JOIN `martyr_regiment` ON `martyr_regiment`.`id`=`martyr_martyr`.`regiment`");
        $this->load->view("json",$data);
    }

    public function createmartyr()
    {
        $access=array("1");
        $this->checkaccess($access);
        $data["page"]="createmartyr";
        $data["title"]="Create martyr";
        $data["regiment"]=$this->regiment_model->getregimentdropdown();
        $data["status"]=$this->martyr_model->getstatusdropdown();
        $this->load->view("template",$data);
    }
    public function createmartyrsubmit() 
    {
        $access=array("1");
        $this->checkaccess($access);
        $this->form_validation->set_rules("regiment","Regiment","trim");
        $this->form_validation->set_rules("name","Name","trim");
        $this->form_validation->set_rules("rank","Rank","trim");
        $this->form_validation->set_rules("unit","Unit","trim");
        $this->form_validation->set_rules("homestate","Home State","trim");
        $this->form_validation->set_rules("operation","Operation","trim");
        $this->form_validation->set_rules("dateofdeath","Date Of Death","trim");
        $this->form_validation->set_rules("age","Age","trim");
        $this->form_validation->set_rules("description","Description","trim");
        $this->form_validation->set_rules("status","Status","trim");
        $this->form_validation->set_rules("lights","Lights","trim");
        $this->form_validation->set_rules("email","Email","trim");
        if($this->form_validation->run()==FALSE)
        {
            $data["alerterror"]=validation_errors();
            $data["page"]="createmartyr";
            $data["title"]="Create martyr";
            $data["status"]=$this->martyr_model->getstatusdropdown();
            $data["regiment"]=$this->regiment_model->getregimentdropdown();
            $this->load->view("template",$data);
        }
        else
        {
            $regiment=$this->input->get_post("regiment");
            $name=$this->input->get_post("name");
            $rank=$this->input->get_post("rank");
            $unit=$this->input->get_post("unit");
            $homestate=$this->input->get_post("homestate");
            $operation=$this->input->get_post("operation");
            $dateofdeath=$this->input->get_post("dateofdeath");
            $age=$this->input->get_post("age");
            $description=$this->input->get_post("description");
            $status=$this->input->get_post("status");
            $lights=$this->input->get_post("lights");
            $email=$this->input->get_post("email");
            
            
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
            
            if($this->martyr_model->create($regiment,$name,$rank,$unit,$homestate,$operation,$dateofdeath,$image,$age,$description,$status,$lights,$email)==0)
                $data["alerterror"]="New martyr could not be created.";
            else
                $data["alertsuccess"]="martyr created Successfully.";
            $data["redirect"]="site/viewmartyr";
            $this->load->view("redirect",$data);
        }
    }
    public function editmartyr()
    {
        $access=array("1");
        $this->checkaccess($access);
        $data["page"]="editmartyr";
        $data["title"]="Edit martyr";
        $data["status"]=$this->martyr_model->getstatusdropdown();
        $data["regiment"]=$this->regiment_model->getregimentdropdown();
        $data["before"]=$this->martyr_model->beforeedit($this->input->get("id"));
        $this->load->view("template",$data);
    }
    public function editmartyrsubmit()
    {
        $access=array("1");
        $this->checkaccess($access);
        $this->form_validation->set_rules("id","ID","trim");
        $this->form_validation->set_rules("regiment","Regiment","trim");
        $this->form_validation->set_rules("name","Name","trim");
        $this->form_validation->set_rules("rank","Rank","trim");
        $this->form_validation->set_rules("unit","Unit","trim");
        $this->form_validation->set_rules("homestate","Home State","trim");
        $this->form_validation->set_rules("operation","Operation","trim");
        $this->form_validation->set_rules("dateofdeath","Date Of Death","trim");
        $this->form_validation->set_rules("age","Age","trim");
        $this->form_validation->set_rules("description","Description","trim");
        $this->form_validation->set_rules("status","Status","trim");
        $this->form_validation->set_rules("lights","Lights","trim");
        $this->form_validation->set_rules("email","Email","trim");
        if($this->form_validation->run()==FALSE)
        {
            $data["alerterror"]=validation_errors();
            $data["page"]="editmartyr";
            $data["title"]="Edit martyr";
            $data["status"]=$this->martyr_model->getstatusdropdown();
            $data["regiment"]=$this->regiment_model->getregimentdropdown();
            $data["before"]=$this->martyr_model->beforeedit($this->input->get("id"));
            $this->load->view("template",$data);
        }
        else
        {
            $id=$this->input->get_post("id");
            $regiment=$this->input->get_post("regiment");
            $name=$this->input->get_post("name");
            $rank=$this->input->get_post("rank");
            $unit=$this->input->get_post("unit");
            $homestate=$this->input->get_post("homestate");
            $operation=$this->input->get_post("operation");
            $dateofdeath=$this->input->get_post("dateofdeath");
            $age=$this->input->get_post("age");
            $description=$this->input->get_post("description");
            $status=$this->input->get_post("status");
            $lights=$this->input->get_post("lights");
            $email=$this->input->get_post("email");
            
            
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
            $image=$this->martyr_model->getmartyrimagebyid($id);
               // print_r($image);
                $image=$image->image;
            }
            
            
            if($this->martyr_model->edit($id,$regiment,$name,$rank,$unit,$homestate,$operation,$dateofdeath,$image,$age,$description,$status,$lights,$email)==0)
                $data["alerterror"]="New martyr could not be Updated.";
            else
                $data["alertsuccess"]="martyr Updated Successfully.";
            $data["redirect"]="site/viewmartyr";
            $this->load->view("redirect",$data);
        }
    }
    public function deletemartyr()
    {
        $access=array("1");
        $this->checkaccess($access);
        $this->martyr_model->delete($this->input->get("id"));
        $data["redirect"]="site/viewmartyr";
        $this->load->view("redirect",$data);
    }
    public function viewmessage()
    {
        $access=array("1");
        $this->checkaccess($access);
        $data["page"]="viewmessage";
        $data["base_url"]=site_url("site/viewmessagejson");
        $data["title"]="View message";
        $this->load->view("template",$data);
    }
    function viewmessagejson()
    {
        $elements=array();
        
        $elements[0]=new stdClass();
        $elements[0]->field="`martyr_message`.`id`";
        $elements[0]->sort="1";
        $elements[0]->header="ID";
        $elements[0]->alias="id";
        
        $elements[1]=new stdClass();
        $elements[1]->field="`martyr_message`.`name`";
        $elements[1]->sort="1";
        $elements[1]->header="Name";
        $elements[1]->alias="name";
        
        $elements[2]=new stdClass();
        $elements[2]->field="`martyr_message`.`contact`";
        $elements[2]->sort="1";
        $elements[2]->header="Contact Number";
        $elements[2]->alias="contact";
        
        $elements[3]=new stdClass();
        $elements[3]->field="`martyr_message`.`email`";
        $elements[3]->sort="1";
        $elements[3]->header="Email";
        $elements[3]->alias="email";
        
        $elements[4]=new stdClass();
        $elements[4]->field="`martyr_message`.`city`";
        $elements[4]->sort="1";
        $elements[4]->header="City";
        $elements[4]->alias="city";
        
        $elements[5]=new stdClass();
        $elements[5]->field="`martyr_message`.`message`";
        $elements[5]->sort="1";
        $elements[5]->header="Message";
        $elements[5]->alias="message";
        
        $elements[6]=new stdClass();
        $elements[6]->field="`martyr_message`.`martry`";
        $elements[6]->sort="1";
        $elements[6]->header="Martry";
        $elements[6]->alias="martry";
        
        $elements[7]=new stdClass();
        $elements[7]->field="`martyr_message`.`approval`";
        $elements[7]->sort="1";
        $elements[7]->header="Approval";
        $elements[7]->alias="approval";
        
        $elements[8]=new stdClass();
        $elements[8]->field="`martyr_martyr`.`name`";
        $elements[8]->sort="1";
        $elements[8]->header="Martyrname";
        $elements[8]->alias="martyrname";
        
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
        $data["message"]=$this->chintantable->query($pageno,$maxrow,$orderby,$orderorder,$search,$elements,"FROM `martyr_message` LEFT OUTER JOIN `martyr_martyr` ON `martyr_martyr`.`id`=`martyr_message`.`martry`");
        $this->load->view("json",$data);
    }

    public function createmessage()
    {
        $access=array("1");
        $this->checkaccess($access);
        $data["page"]="createmessage";
        $data["title"]="Create message";
        $data["martry"]=$this->martyr_model->getmartyrdropdown();
        $data["approval"]=$this->martyr_model->getapprovalmaildropdown();
        $this->load->view("template",$data);
    }
    public function createmessagesubmit() 
    {
        $access=array("1");
        $this->checkaccess($access);
        $this->form_validation->set_rules("name","Name","trim");
        $this->form_validation->set_rules("contact","Contact Number","trim");
        $this->form_validation->set_rules("email","Email","trim");
        $this->form_validation->set_rules("city","City","trim");
        $this->form_validation->set_rules("message","Message","trim");
        $this->form_validation->set_rules("martry","Martry","trim");
        $this->form_validation->set_rules("approval","Approval","trim");
        if($this->form_validation->run()==FALSE)
        {
            $data["alerterror"]=validation_errors();
            $data["page"]="createmessage";
            $data["title"]="Create message";
            $data["approval"]=$this->martyr_model->getapprovalmaildropdown();
            $data["martry"]=$this->martyr_model->getmartyrdropdown();
            $this->load->view("template",$data);
        }
        else
        {
            $name=$this->input->get_post("name");
            $contact=$this->input->get_post("contact");
            $email=$this->input->get_post("email");
            $city=$this->input->get_post("city");
            $message=$this->input->get_post("message");
            $martry=$this->input->get_post("martry");
            $approval=$this->input->get_post("approval");
            if($this->message_model->create($name,$contact,$email,$city,$message,$martry,$approval)==0)
                $data["alerterror"]="New message could not be created.";
            else
                $data["alertsuccess"]="message created Successfully.";
            $data["redirect"]="site/viewmessage";
            $this->load->view("redirect",$data);
        }
    }
    public function editmessage()
    {
        $access=array("1");
        $this->checkaccess($access);
        $data["page"]="editmessage";
        $data["title"]="Edit message";
        $data["approval"]=$this->martyr_model->getapprovalmaildropdown();
        $data["martry"]=$this->martyr_model->getmartyrdropdown();
        $data["before"]=$this->message_model->beforeedit($this->input->get("id"));
        $this->load->view("template",$data);
    }
    public function editmessagesubmit()
    {
        $access=array("1");
        $this->checkaccess($access);
        $this->form_validation->set_rules("id","ID","trim");
        $this->form_validation->set_rules("name","Name","trim");
        $this->form_validation->set_rules("contact","Contact Number","trim");
        $this->form_validation->set_rules("email","Email","trim");
        $this->form_validation->set_rules("city","City","trim");
        $this->form_validation->set_rules("message","Message","trim");
        $this->form_validation->set_rules("martry","Martry","trim");
        $this->form_validation->set_rules("approval","Approval","trim");
        if($this->form_validation->run()==FALSE)
        {
            $data["alerterror"]=validation_errors();
            $data["page"]="editmessage";
            $data["title"]="Edit message";
            $data["approval"]=$this->martyr_model->getapprovalmaildropdown();
            $data["martry"]=$this->martyr_model->getmartyrdropdown();
            $data["before"]=$this->message_model->beforeedit($this->input->get("id"));
            $this->load->view("template",$data);
        }
        else
        {
            $id=$this->input->get_post("id");
            $name=$this->input->get_post("name");
            $contact=$this->input->get_post("contact");
            $email=$this->input->get_post("email");
            $city=$this->input->get_post("city");
            $message=$this->input->get_post("message");
            $martry=$this->input->get_post("martry");
            $approval=$this->input->get_post("approval");
            if($approval==1)
            {
                $martryquery=$this->db->query("SELECT `email` FROM `martyr_martyr` WHERE `id`='$martry'")->row();
                $martryemail=$martryquery->email;
                $martryemail = explode(",", $martryemail);
                $this->load->library('email');
                $this->email->from($email, 'Sare Jahan Se Acchha');
                $this->email->to($martryemail);
                $this->email->cc('');
                $this->email->bcc('');

                $this->email->subject('Sare Jahan Se Acchha Message');
                $this->email->message($message);

                $this->email->send();
            }
            if($this->message_model->edit($id,$name,$contact,$email,$city,$message,$martry,$approval)==0)
                $data["alerterror"]="New message could not be Updated.";
            else
                $data["alertsuccess"]="message Updated Successfully.";
            $data["redirect"]="site/viewmessage";
            $this->load->view("redirect",$data);
        }
    }
    public function deletemessage()
    {
        $access=array("1");
        $this->checkaccess($access);
        $this->message_model->delete($this->input->get("id"));
        $data["redirect"]="site/viewmessage";
        $this->load->view("redirect",$data);
    }

    function viewnavigation()
	{
		$access = array("1");
		$this->checkaccess($access);
		$data['table']=$this->navigation_model->viewparentnavigation();
		$data['page']='viewnavigation';
		$data['title']='View Navigation';
		$this->load->view('template',$data);
	}
     
    public function getsubcategorybyparent()
    {
        $categoryid=$this->input->get_post("categoryid");
        $data1=$this->navigation_model->getsubnavigationbyparent($categoryid);
        $data["message"]=$data1;
//        print_r($data);
        $this->load->view("json",$data);
    }
    
    public function createnavigation()
	{
		$access = array("1");
		$this->checkaccess($access);
		$data[ 'status' ] =$this->navigation_model->getstatusdropdown();
		$data['navigation']=$this->navigation_model->getnavigationdropdown();
		$data[ 'page' ] = 'createnavigation';
		$data[ 'title' ] = 'Create Navigation';
		$this->load->view( 'template', $data );	
	}
   
	function createnavigationsubmit()
	{
		$access = array("1");
		$this->checkaccess($access);
		$this->form_validation->set_rules('name','Name','trim|required');
		$this->form_validation->set_rules('parent','parent','trim|');
		$this->form_validation->set_rules('status','status','trim|');
		if($this->form_validation->run() == FALSE)	
		{
			$data['alerterror'] = validation_errors();
			$data[ 'status' ] =$this->navigation_model->getstatusdropdown();
            $data['navigation']=$this->navigation_model->getnavigationdropdown();
            $data[ 'page' ] = 'createnavigation';
            $data[ 'title' ] = 'Create Navigation';
            $this->load->view( 'template', $data );	
		}
		else
		{
			$name=$this->input->post('name');
			$parent=$this->input->post('parent');
			$status=$this->input->post('status');
			
			if($this->navigation_model->createnavigation($name,$parent,$status)==0)
			$data['alerterror']="New navigation could not be created.";
			else
			$data['alertsuccess']="navigation  created Successfully.";
//			$data['table']=$this->navigation_model->viewnavigation();
			$data['redirect']="site/viewnavigation";
			//$data['other']="template=$template";
			$this->load->view("redirect",$data);
		}
	}
    
	function editnavigation()
	{
		$access = array("1");
		$this->checkaccess($access);
		$data['before']=$this->navigation_model->beforeeditnavigation($this->input->get('id'));
		$data['navigation']=$this->navigation_model->getnavigationdropdown();
		$data[ 'status' ] =$this->navigation_model->getstatusdropdown();
		$data['page']='editnavigation';
		$data['title']='Edit navigation';
		$this->load->view('template',$data);
	}
	function editnavigationsubmit()
	{
		$access = array("1");
		$this->checkaccess($access);
		$this->form_validation->set_rules('name','Name','trim|required');
		$this->form_validation->set_rules('parent','parent','trim|');
		$this->form_validation->set_rules('status','status','trim|');
        
		if($this->form_validation->run() == FALSE)	
		{
			$data['alerterror'] = validation_errors();
			$data['before']=$this->navigation_model->beforeeditnavigation($this->input->get_post('id'));
            $data['navigation']=$this->navigation_model->getnavigationdropdown();
            $data[ 'status' ] =$this->navigation_model->getstatusdropdown();
            $data['page']='editnavigation';
            $data['title']='Edit navigation';
            $this->load->view('template',$data);
		}
		else
		{
			$id=$this->input->post('id');
			$name=$this->input->post('name');
			$parent=$this->input->post('parent');
			$status=$this->input->post('status');
			
			if($this->navigation_model->editnavigation($id,$name,$parent,$status)==0)
			$data['alerterror']="navigation Editing was unsuccesful";
			else
			$data['alertsuccess']="navigation edited Successfully.";
//			$data['table']=$this->navigation_model->viewnavigation();
			$data['redirect']="site/viewnavigation";
			$this->load->view("redirect",$data);
		}
	}
   
	function deletenavigation()
	{
		$access = array("1");
		$this->checkaccess($access);
		$this->navigation_model->deletenavigation($this->input->get('id'));
		$data['table']=$this->navigation_model->viewnavigation();
		$data['alertsuccess']="navigation Deleted Successfully";
        $data['redirect']="site/viewnavigation";
		$this->load->view("redirect",$data);
	}
	
	
}
?>
