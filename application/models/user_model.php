<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
	
	class User_model extends App_Model
	{
		public $_table='user';

		protected $protected_attributes=array('id');
		
		public $has_many=array();
		
		public $belongs_to=array();
		
		//public $after_get=array('after_get');

		public $before_create=array('_filter_data','created_at');

		public $before_update=array('_filter_data','updated_at');

		public $before_delete=array('before_delete');

	/*-----------------------------------------------------------------------*/

		public $logged_in=FALSE;
		
		public $data;
		
		public function __construct()
		{
			parent::__construct();
			
			$user=$this->session->userdata('user');
			$this->logged_in=!empty($user);
			
			if($this->logged_in)
				$this->data=$user;
		}

		public function has_role($role)
		{
			// order of awesomeness, greatest to least.
			$roles = array('developer','administrator','manager','blogger','user');

			if(empty($this->data['role']))
				return false;

			if(array_search($this->data['role'], $roles) <= array_search($role, $roles))
				return true;
			
			return false;
		}
		
		public function log_in()
		{
			$rules=array(
				array(
					'field'=>'email',
					'label'=>'E-mail',
					'rules'=>'required|max_length[64]|valid_email',
				),
				array(
					'field'=>'password',
					'label'=>'Password',
					'rules'=>'required|sha1',
				),
			);

			$this->load->library('form_validation');
			$this->form_validation->set_rules($rules);

			if($this->form_validation->run()!==FALSE)
			{
				$user=$this
					->get_by(array(
						'email'=>$this->input->post('email'),
						'password'=>$this->input->post('password'),
					));
				
				if(empty($user))
				{
					$this->form_validation->set_error('The e-mail address or password you entered was incorrect. Please try again.');
					return FALSE;
				}
				
				$this->session->set_userdata('user',$user);
				$this->data = $user;

				$this->update($user['id'],array(
					'last_login'=>date('Y-m-d H:i:s'),
				));

				return TRUE;
			}
			
			return FALSE;
		}
		
		public function log_out()
		{
			$this->session->unset_userdata('user');

			return TRUE;
		}

		public function generate_confirm_code()
		{
			return base64_encode(crypt(time(),'$2a$10$'.sha1('sekritz')));
		}
	}
	
/* End of file user_model.php */
/* Location: ./application/models/user_model.php */