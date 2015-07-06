<?php if ( ! defined("BASEPATH")) exit("No direct script access allowed");
class Json extends CI_Controller 
{function getallministry()
{
$elements=array();
$elements[0]=new stdClass();
$elements[0]->field="`martyr_ministry`.`id`";
$elements[0]->sort="1";
$elements[0]->header="ID";
$elements[0]->alias="id";

$elements=array();
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
}
if($orderby=="")
{
$orderby="id";
$orderorder="ASC";
}
$data["message"]=$this->chintantable->query($pageno,$maxrow,$orderby,$orderorder,$search,$elements,"FROM `martyr_ministry`");
$this->load->view("json",$data);
}
public function getsingleministry()
{
$id=$this->input->get_post("id");
$data["message"]=$this->ministry_model->getsingleministry($id);
$this->load->view("json",$data);
}
function getallcategory()
{
$elements=array();
$elements[0]=new stdClass();
$elements[0]->field="`martyr_category`.`id`";
$elements[0]->sort="1";
$elements[0]->header="ID";
$elements[0]->alias="id";

$elements=array();
$elements[1]=new stdClass();
$elements[1]->field="`martyr_category`.`name`";
$elements[1]->sort="1";
$elements[1]->header="Name";
$elements[1]->alias="name";

$elements=array();
$elements[2]=new stdClass();
$elements[2]->field="`martyr_category`.`ministry`";
$elements[2]->sort="1";
$elements[2]->header="Ministry";
$elements[2]->alias="ministry";

$elements=array();
$elements[3]=new stdClass();
$elements[3]->field="`martyr_category`.`order`";
$elements[3]->sort="1";
$elements[3]->header="Order";
$elements[3]->alias="order";

$search=$this->input->get_post("search");
$pageno=$this->input->get_post("pageno");
$orderby=$this->input->get_post("orderby");
$orderorder=$this->input->get_post("orderorder");
$maxrow=$this->input->get_post("maxrow");
if($maxrow=="")
{
}
if($orderby=="")
{
$orderby="id";
$orderorder="ASC";
}
$data["message"]=$this->chintantable->query($pageno,$maxrow,$orderby,$orderorder,$search,$elements,"FROM `martyr_category`");
$this->load->view("json",$data);
}
public function getsinglecategory()
{
$id=$this->input->get_post("id");
$data["message"]=$this->category_model->getsinglecategory($id);
$this->load->view("json",$data);
}
function getallsubcategory()
{
$elements=array();
$elements[0]=new stdClass();
$elements[0]->field="`martyr_subcategory`.`id`";
$elements[0]->sort="1";
$elements[0]->header="ID";
$elements[0]->alias="id";

$elements=array();
$elements[1]=new stdClass();
$elements[1]->field="`martyr_subcategory`.`category`";
$elements[1]->sort="1";
$elements[1]->header="Category";
$elements[1]->alias="category";

$elements=array();
$elements[2]=new stdClass();
$elements[2]->field="`martyr_subcategory`.`name`";
$elements[2]->sort="1";
$elements[2]->header="Name";
$elements[2]->alias="name";

$elements=array();
$elements[3]=new stdClass();
$elements[3]->field="`martyr_subcategory`.`order`";
$elements[3]->sort="1";
$elements[3]->header="Order";
$elements[3]->alias="order";

$search=$this->input->get_post("search");
$pageno=$this->input->get_post("pageno");
$orderby=$this->input->get_post("orderby");
$orderorder=$this->input->get_post("orderorder");
$maxrow=$this->input->get_post("maxrow");
if($maxrow=="")
{
}
if($orderby=="")
{
$orderby="id";
$orderorder="ASC";
}
$data["message"]=$this->chintantable->query($pageno,$maxrow,$orderby,$orderorder,$search,$elements,"FROM `martyr_subcategory`");
$this->load->view("json",$data);
}
public function getsinglesubcategory()
{
$id=$this->input->get_post("id");
$data["message"]=$this->subcategory_model->getsinglesubcategory($id);
$this->load->view("json",$data);
}
function getallregiment()
{
$elements=array();
$elements[0]=new stdClass();
$elements[0]->field="`martyr_regiment`.`id`";
$elements[0]->sort="1";
$elements[0]->header="ID";
$elements[0]->alias="id";

$elements=array();
$elements[1]=new stdClass();
$elements[1]->field="`martyr_regiment`.`subcategory`";
$elements[1]->sort="1";
$elements[1]->header="Sub Category";
$elements[1]->alias="subcategory";

$elements=array();
$elements[2]=new stdClass();
$elements[2]->field="`martyr_regiment`.`name`";
$elements[2]->sort="1";
$elements[2]->header="Name";
$elements[2]->alias="name";

$elements=array();
$elements[3]=new stdClass();
$elements[3]->field="`martyr_regiment`.`order`";
$elements[3]->sort="1";
$elements[3]->header="Order";
$elements[3]->alias="order";

$search=$this->input->get_post("search");
$pageno=$this->input->get_post("pageno");
$orderby=$this->input->get_post("orderby");
$orderorder=$this->input->get_post("orderorder");
$maxrow=$this->input->get_post("maxrow");
if($maxrow=="")
{
}
if($orderby=="")
{
$orderby="id";
$orderorder="ASC";
}
$data["message"]=$this->chintantable->query($pageno,$maxrow,$orderby,$orderorder,$search,$elements,"FROM `martyr_regiment`");
$this->load->view("json",$data);
}
public function getsingleregiment()
{
$id=$this->input->get_post("id");
$data["message"]=$this->regiment_model->getsingleregiment($id);
$this->load->view("json",$data);
}
function getallmartyr()
{
$elements=array();
$elements[0]=new stdClass();
$elements[0]->field="`martyr_martyr`.`id`";
$elements[0]->sort="1";
$elements[0]->header="ID";
$elements[0]->alias="id";

$elements=array();
$elements[1]=new stdClass();
$elements[1]->field="`martyr_martyr`.`regiment`";
$elements[1]->sort="1";
$elements[1]->header="Regiment";
$elements[1]->alias="regiment";

$elements=array();
$elements[2]=new stdClass();
$elements[2]->field="`martyr_martyr`.`name`";
$elements[2]->sort="1";
$elements[2]->header="Name";
$elements[2]->alias="name";

$elements=array();
$elements[3]=new stdClass();
$elements[3]->field="`martyr_martyr`.`rank`";
$elements[3]->sort="1";
$elements[3]->header="Rank";
$elements[3]->alias="rank";

$elements=array();
$elements[4]=new stdClass();
$elements[4]->field="`martyr_martyr`.`unit`";
$elements[4]->sort="1";
$elements[4]->header="Unit";
$elements[4]->alias="unit";

$elements=array();
$elements[5]=new stdClass();
$elements[5]->field="`martyr_martyr`.`homestate`";
$elements[5]->sort="1";
$elements[5]->header="Home State";
$elements[5]->alias="homestate";

$elements=array();
$elements[6]=new stdClass();
$elements[6]->field="`martyr_martyr`.`operation`";
$elements[6]->sort="1";
$elements[6]->header="Operation";
$elements[6]->alias="operation";

$elements=array();
$elements[7]=new stdClass();
$elements[7]->field="`martyr_martyr`.`dateofdeath`";
$elements[7]->sort="1";
$elements[7]->header="Date Of Death";
$elements[7]->alias="dateofdeath";

$elements=array();
$elements[8]=new stdClass();
$elements[8]->field="`martyr_martyr`.`image`";
$elements[8]->sort="1";
$elements[8]->header="Image";
$elements[8]->alias="image";

$elements=array();
$elements[9]=new stdClass();
$elements[9]->field="`martyr_martyr`.`age`";
$elements[9]->sort="1";
$elements[9]->header="Age";
$elements[9]->alias="age";

$elements=array();
$elements[10]=new stdClass();
$elements[10]->field="`martyr_martyr`.`description`";
$elements[10]->sort="1";
$elements[10]->header="Description";
$elements[10]->alias="description";

$elements=array();
$elements[11]=new stdClass();
$elements[11]->field="`martyr_martyr`.`status`";
$elements[11]->sort="1";
$elements[11]->header="Status";
$elements[11]->alias="status";

$elements=array();
$elements[12]=new stdClass();
$elements[12]->field="`martyr_martyr`.`lights`";
$elements[12]->sort="1";
$elements[12]->header="Lights";
$elements[12]->alias="lights";

$elements=array();
$elements[13]=new stdClass();
$elements[13]->field="`martyr_martyr`.`email`";
$elements[13]->sort="1";
$elements[13]->header="Email";
$elements[13]->alias="email";

$search=$this->input->get_post("search");
$pageno=$this->input->get_post("pageno");
$orderby=$this->input->get_post("orderby");
$orderorder=$this->input->get_post("orderorder");
$maxrow=$this->input->get_post("maxrow");
if($maxrow=="")
{
}
if($orderby=="")
{
$orderby="id";
$orderorder="ASC";
}
$data["message"]=$this->chintantable->query($pageno,$maxrow,$orderby,$orderorder,$search,$elements,"FROM `martyr_martyr`");
$this->load->view("json",$data);
}
public function getsinglemartyr()
{
$id=$this->input->get_post("id");
$data["message"]=$this->martyr_model->getsinglemartyr($id);
$this->load->view("json",$data);
}
function getallmessage()
{
$elements=array();
$elements[0]=new stdClass();
$elements[0]->field="`martyr_message`.`id`";
$elements[0]->sort="1";
$elements[0]->header="ID";
$elements[0]->alias="id";

$elements=array();
$elements[1]=new stdClass();
$elements[1]->field="`martyr_message`.`name`";
$elements[1]->sort="1";
$elements[1]->header="Name";
$elements[1]->alias="name";

$elements=array();
$elements[2]=new stdClass();
$elements[2]->field="`martyr_message`.`contact`";
$elements[2]->sort="1";
$elements[2]->header="Contact Number";
$elements[2]->alias="contact";

$elements=array();
$elements[3]=new stdClass();
$elements[3]->field="`martyr_message`.`email`";
$elements[3]->sort="1";
$elements[3]->header="Email";
$elements[3]->alias="email";

$elements=array();
$elements[4]=new stdClass();
$elements[4]->field="`martyr_message`.`city`";
$elements[4]->sort="1";
$elements[4]->header="City";
$elements[4]->alias="city";

$elements=array();
$elements[5]=new stdClass();
$elements[5]->field="`martyr_message`.`message`";
$elements[5]->sort="1";
$elements[5]->header="Message";
$elements[5]->alias="message";

$elements=array();
$elements[6]=new stdClass();
$elements[6]->field="`martyr_message`.`martry`";
$elements[6]->sort="1";
$elements[6]->header="Martry";
$elements[6]->alias="martry";

$elements=array();
$elements[7]=new stdClass();
$elements[7]->field="`martyr_message`.`approval`";
$elements[7]->sort="1";
$elements[7]->header="Approval";
$elements[7]->alias="approval";

$search=$this->input->get_post("search");
$pageno=$this->input->get_post("pageno");
$orderby=$this->input->get_post("orderby");
$orderorder=$this->input->get_post("orderorder");
$maxrow=$this->input->get_post("maxrow");
if($maxrow=="")
{
}
if($orderby=="")
{
$orderby="id";
$orderorder="ASC";
}
$data["message"]=$this->chintantable->query($pageno,$maxrow,$orderby,$orderorder,$search,$elements,"FROM `martyr_message`");
$this->load->view("json",$data);
}
public function getsinglemessage()
{
$id=$this->input->get_post("id");
$data["message"]=$this->message_model->getsinglemessage($id);
$this->load->view("json",$data);
}
} ?>