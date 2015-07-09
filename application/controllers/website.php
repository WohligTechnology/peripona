<?php
if ( !defined( 'BASEPATH' ) )
	exit( 'No direct script access allowed' );
class Website extends CI_Controller
{
	public function index( )
	{
		$data["page"]="home";
         $data['active']="home";
//        $data["category"]=$this->category_model->getcategorytree(0);
//        print_r($data["category"]);
        $this->load->view("frontend2",$data);
	}
    public function overview()
	{
		$data["page"]="overview";
        $data['active']="overview";
        $this->load->view("frontend",$data);
	}
    
    public function contact()
	{
		$data["page"]="contact";
        $data['active']="contact";
        $this->load->view("frontend",$data);
	}
    
    public function gallery()
	{
		$data["page"]="gallery";
        $this->load->view("frontend",$data);
	}  
      public function room()
	{
		$data["page"]="room";
        $this->load->view("frontend",$data);
	} 
       public function amenities()
	{
		$data["page"]="amenities";
        $data['active']="amenities";
        $this->load->view("frontend",$data);
	}   
    
    public function explore()
	{
		$data["page"]="explore";
         $data['active']="explore";
        $this->load->view("frontend",$data);
	}
    public function detail( )
	{
        $id=$this->input->get("id");
        $data["row"]=$this->martyr_model->getmartyrbyid($id);
		$data["page"]="details";
        //$data["category"]=$this->category_model->getallcategories();
        $this->load->view("frontend",$data);
	}
    
    public function regiments( )
	{
        $categoryid=$this->input->get("category");
        $data["table"]=$this->regiment_model->getregimentbycategory($categoryid);
		$data["page"]="regiments";
        //$data["category"]=$this->category_model->getallcategories();
        $this->load->view("frontend",$data);
	}
    
    public function lightalamp()
	{
        $id=$this->input->get("id");
        $data['id']=$this->input->get('id');
		$data["page"]="light";
        $data["row"]=$this->martyr_model->getmartyrbyid($id);
//        $this->regiment_model->addlight($id);
        $this->load->view("frontend",$data);
	}
    
    public function lightalampcount($id)
	{
        $this->regiment_model->addlight($id);
        return 1;
	}
    
    public function sendmessage()
	{
        $id=$this->input->get("id");
        $data['id']=$this->input->get('id');
        $data["row"]=$this->martyr_model->getmartyrbyid($id);
		$data["page"]="sendmessage";
//        $data["row"]=$this->martyr_model->sendamessage($id);
//        $this->regiment_model->addlight($id);
        $this->load->view("frontend",$data);
	}
    public function sendmessagesubmit()
	{
        $id=$this->input->post("id");
        $name=$this->input->post("name");
        $contact=$this->input->post("contact");
        $city=$this->input->post("city");
        $email=$this->input->post("email");
        $message=$this->input->post("message");
        if($id!="")
        {
        $this->message_model->addmessage($id,$name,$contact,$city,$email,$message);
        }
		$data["page"]="home";
        $data["category"]=$this->category_model->getcategorytree(0);
        $this->load->view("frontend",$data);
	}
    
        public function search()
        {
            $name=$this->input->get_post('name');
            $data['row']=$this->martyr_model->searchbyname($name);
            if(!empty($data['row']))
            {  
                $data["page"]="details";
                $this->load->view("frontend",$data);
            }
            else
            {
                $data["page"]="nodatafound";
                $this->load->view("frontend",$data);
            }
//            $data["page"]="details";
//            $this->load->view("frontend",$data);
        }
}
?>