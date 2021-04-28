<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Page extends MX_Controller {

	public function __construct(){
		parent::__construct();
		$this->load->model('page_mdl');
		$this->module="page";
	}

//------------------------------------------------------------------------------------------------
// 					HOME PAGE
//------------------------------------------------------------------------------------------------	
	public function home(){

		$data['home_data']=Modules::run('inner/get_HomeData');
		$data['module']=$this->module;
		$data['view']="home";

		echo Modules::run('templates/main',$data);

	}

//------------------------------------------------------------------------------------------------
// 					ABOUT ME
//------------------------------------------------------------------------------------------------	
	public function denis_about_me(){
		
		$data['profile_data']=Modules::run('inner/get_profileData');
		$data['services']=Modules::run('inner/get_servicesData');
		$data['clients']=Modules::run('inner/get_clientsData');
		$data['module']=$this->module;
		$data['view']="about_me";

		echo Modules::run('templates/main',$data);

	}

//------------------------------------------------------------------------------------------------
// 					ABOUT ME
//------------------------------------------------------------------------------------------------	
	public function resume(){

		$data['academics']=Modules::run('inner/get_educationData');
		$data['experiences']=Modules::run('inner/get_experienceData');
		$data['ProgramingSkills']=Modules::run('inner/get_Programing_skills_data');
		$data['DesignSkills']=Modules::run('inner/get_Design_skills_data');
		$data['FrameworkSkills']=Modules::run('inner/get_Frameworks_skills_data');
		$data['OtherSkills']=Modules::run('inner/get_Others_skills_data');
		$data['module']=$this->module;
		$data['view']="my_resume";

		echo Modules::run('templates/main',$data);

	}




//------------------------------------------------------------------------------------------------
// 					PORTFOLIO
//------------------------------------------------------------------------------------------------	
	public function portfolio(){
		
		$data['portfolios']=Modules::run('inner/get_portfoliosData');
		$data['module']=$this->module;
		$data['view']="my_portfolio";
		echo Modules::run('templates/main',$data);

	}


//------------------------------------------------------------------------------------------------
// 					BLOG
//------------------------------------------------------------------------------------------------	
	public function blog(){

		$data['blogs']=Modules::run('inner/get_blogsData');
		$data['module']=$this->module;
		$data['view']="my_blog";

		echo Modules::run('templates/main',$data);

	}


	public function single_blog($blog_id){
		
		$data['blog']=$this->page_mdl->get_blogs_dataByID($blog_id);
		$data['module']=$this->module;
		$data['view']="single_blog";

		echo Modules::run('templates/main',$data);

	}




//------------------------------------------------------------------------------------------------
// 					CONTACT
//------------------------------------------------------------------------------------------------	
	public function contact(){
		
		$data['contacts']=Modules::run('inner/get_contactsData');
		$data['module']=$this->module;
		$data['view']="my_contacts";

		echo Modules::run('templates/main',$data);

	}

//--------------------------------------------------------------------------------------------------------------------------------- 	
	//send_mail on the contact page	
	public function send_mail($email_data=FALSE) { 

        $data=$this->input->post();
        
        $email_data=array(
            'names'=>$data['names'],'email' => $data['email'],'message'=>$data['message']
        );
        //print_r($email_data);
        $this->load->library('email', $config);
        
        
         // Mail config
        $to = 'dembedenisjb@gmail.com';
        $from = $email_data['email'];
        $fromName = $email_data['names'];
        $mailSubject = 'ainedembe-denis.com Contact Message from: "<b>"'.$email_data['names'].'"</b>"';
        
        // Mail content
        $mailContent = '
            <h3>Sender <b>'.$email_data['names'].'</b></h3>
            <p><b>Email: </b>'.$email_data['email'].'</p>
            <p><b>Message: </b><br>'.$email_data['message'].'</p>
        ';
        //print_r($mailContent);
        $config['mailtype'] = 'html';
        $this->email->initialize($config);
        $this->email->to($to);
        $this->email->from($from, $fromName);
        $this->email->subject($mailSubject);
        $this->email->message($mailContent);
        
        // Send email & return status
        
        if($this->email->send()){
           /// $msg=$this->session->set_flashdata('msg',"Thank you for time to write to me! Your Message has be recieved.");
            //redirect('page/contact');
            echo "Thank you for time to write to me! Your Message has be recieved.";
            
        }
        else{
            //$msg=$this->session->set_flashdata('msg',"Operation failed, please try again");
            //redirect('page/contact');
            echo "Operation failed, please try again";
        } 

    }
    

public function send()
{
    $this->load->library('email');
    $config['mailtype'] = 'html';
    //$config['charset'] = 'utf-8';
    //$config['wordwrap'] = TRUE;

    $this->email->initialize($config);

    $body    = '
        <strong>Name: </strong>'.$this->input->post("names").'<br />
        <strong>Email: </strong>'.$this->input->post("email").'<br />
        <strong>Message: </strong>'.$this->input->post("message").'<br />
    ';

    $emailto = 'dembedenisjb@gmail.com'; //any email
    $this->load->library('email');
    $this->email->from($this->input->post("email"), $this->input->post("names"));
    $this->email->to($emailto);
    $this->email->subject('New Request');
    $this->email->message($body);
    if ($this->email->send()) {
       echo 'success';
    } else {
       echo 'error';
    }
}



    public function sendemail()
    {
        $name = $_POST['names'];
        $email = $_POST['email'];
        $message = $_POST['message'];
        $to = 'dembedenisjb@gmail.com';
        $subject = 'New message from your website';
        $headers = "From: " . strip_tags($email) . "\r\n";
        $headers .= "Reply-To: ". strip_tags($email) . "\r\n";
        $headers .= "MIME-Version: 1.0\r\n";
        $headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";
        if (mail($to, $subject, $message, $headers))
        {
             echo "Your message has been correctly sent. Thank you for contacting us: we'll reply as soon as possible<br><h4 style='text-align: right;'>Lo Our staff</h4>";
        }
        else
        {
            echo "Ooops, I'm sorry but something went wrong sending your message. Please contact us at this address: ";
        }
    }




 }
