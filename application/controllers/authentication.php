<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Authentication extends App_Controller
{
	//protected $layout = 'layouts/authentication';

	public function __construct()
	{
		$this->models[] = 'content';
		parent::__construct();

		$this->asides['notifications'] = 'asides/notifications';
		
		// use min_css and min_js when possible to load assets through minify
		//$this->min_js[] = 'application.js';		
		//$this->min_css[] = 'application.css';
		
		/*
			LessCSS should only be used for development. 
			When you are ready to deploy, compile your less files into css files.
			Then remove any included .less files so that less.js will not be loaded.
		*/
		//$this->less_css[] = 'application.less';
	}

	public function _user_redirect()
	{
		switch($this->user->data['role'])
		{
			case 'developer':
			case 'administrator':
				redirect('/admin');
			case 'manager':
				redirect('/dashboard');
			case 'blogger':
				redirect('/admin/blog');
		}
		redirect('/');
	}

	public function index()
	{
		
	}

	public function log_in()
	{
		if($this->user->logged_in)
			$this->_user_redirect();

		$this->authenticate=FALSE;
		if($this->input->post())
			if($this->user->log_in())
				$this->_user_redirect();
			else
				$this->errors[] = 'Incorrect Information';
	}

	public function log_out()
	{	
		$this->user->log_out();
		redirect('/');
	}

	public function forgot_password()
	{
		$rules=array(
			array(
				'field'=>'email',
				'label'=>'E-mail',
				'rules'=>'trim|required|max_length[64]|valid_email',
			),
		);

		$this->load->library('form_validation');
		$this->form_validation->set_rules($rules);

		if($this->form_validation->run()!==FALSE)
		{
			$user=$this->user->get_by(array(
				'email'=>$this->input->post('email'),
			));

			if(!empty($user))
			{
				$data=array(
					'confirm_code'=>$this->user->generate_confirm_code(),
				);
				if($this->user->update($user['id'],$data))
				{
					$url = site_url('/authentication/reset_password/'.$user['id'].'/'.$data['confirm_code']);
					$message = "<body>To reset your password, visit the link below:<br/>\n<br/>\n<a href=\"$url\">$url</a></body>";
					send_email("Password Reset", $message, $user['email']);
					$this->form_validation->reset_values();
					$this->notifications[] = 'You have been sent an e-mail with a link that will allow you to reset your password.';
				}
			}
			else
			{
				$this->form_validation->set_error('That e-mail address was not found. Please check your e-mail address and try again.');
			}
		}
	}

	public function reset_password($id,$confirm_code)
	{
		$this->data['password_reset']=FALSE;
		$this->data['confirmed']=FALSE;
		$this->data['id']=$id;
		$this->data['confirm_code']=$confirm_code;

		$this->load->library('form_validation');

		$user=$this->user->get_by(array(
			'id'=>$id,
			'confirm_code'=>$confirm_code,
		));

		if(!empty($user))
		{
			$this->data['confirmed']=TRUE;
			$this->data['email']=$user['email'];

			$rules=array(
				array(
					'field'=>'password',
					'label'=>'Password',
					'rules'=>'trim|required|sha1',
				),
				array(
					'field'=>'confirm_password',
					'label'=>'Confirm Password',
					'rules'=>'trim|required|matches[password]|sha1',
				),
			);

			$this->form_validation->set_rules($rules);

			if($this->form_validation->run()!==FALSE)
			{
				$data=array(
					'password'=>$this->input->post('password'),
					'confirm_code'=>NULL,
				);

				if($this->user->update($id,$data))
				{
					$this->data['password_reset']=TRUE;
				}
				else
				{
					$this->form_validation->set_error('There was a problem resetting your password. Please try again.');
				}
			}
		}
	}
}

/* End of file administration.php */
/* Location: ./application/controllers/administration/administration.php */