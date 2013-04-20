<?php
# fuel/app/classes/controller/user.php

class Controller_User extends Controller_Template 
{
	public $template = 'template.jade';

	/**
	* list Users
	* @access public
	* @param none
	* @return Response
	*/
	public function action_index()
	{
		$users = Model_User::find('all');
		$data['users'] = array_map(function($user){
			return $user->to_array(); # Proper exposure of the Model_User
		}, $users);
		$this->template->title = "Users";
		$this->template->content = View::forge('user/index.jade', $data);
	}

	/**
	 * View User record
	 * @access public
	 * @param int id
	 * @return Response
	 */
	public function action_view($id = null)
	{
		is_null($id) and Response::redirect('User');

		$user = Model_User::find($id);

		if ( ! $user )
		{
			Session::set_flash('error', 'Could not find user #'.$id);
			Response::redirect('User');
		}

		$data['user'] = $user->to_array();
		$this->template->title = "User";
		$this->template->content = View::forge('user/view.jade', $data);

	}

	/**
	 * Create User
	 * @access public
	 * @param none
	 * @return Response
	 */
	public function action_create()
	{
		# Forge a fieldset and add all Model_User properties to it
		$fieldset = \Fieldset::forge() -> add_model('Model_User');

		# Add a virtual password confirm field
		$fieldset -> add_after(
			'password_confirm', 
			'Retype Password', 
			array('type' => 'password'), 
			array( 
				array( 'min_length', 5 ), 
				array( 'match_field', 'password' ), 
				array( 'required' ), 
				), 
			'password');

		# Repopulate if Save action failed
		$fieldset -> repopulate();

		# Turn it into a form
		$form     = $fieldset->form();

		# Add our submit button
		$form -> add('submit', '', array('type' => 'submit', 'value' => 'Save', 'class' => 'btn btn-large btn-block btn-primary') ); 

		# Remember, this form is going to post to itself by defult
		# so we need to process the input in this same controller method
		if ( $fieldset -> validation() -> run() ) # Validation success
		{
			$fields = $fieldset->validated(); # Grab our input values

			# Best use a try/catch block
			# Model will throw a Orm\ValidationFailed exception if validation fails
			try {
				$user = new Model_User($fields);
				$user->save();

				Session::set_flash('success', 'Added user #'.$user->id.'.');

				Response::redirect('user');

			} catch (Exception $e) {
				Session::set_flash('error', $e->getMessage());
			}

		} else
		{
			Session::set_flash('error', $fieldset->validation()->show_errors());
		}

		$this->template->title = "Add User";
		$this->template->set('content', $form->build(), false);
	}

	/**
	 * Edit User
	 * @access public
	 * @param int $id
	 * @return Response
	 */
	public function action_edit($id = null)
	{
		is_null($id) and Response::redirect('User');
		
		if ( ! $user = Model_User::find($id) )
		{
			Session::set_flash('error', 'Could not find user #'.$id);
			Response::redirect('User');
		}

		$fieldset = \Fieldset::forge() -> add_model('Model_User')->populate($user, true);
		$fieldset->disable('password');

		$form     = $fieldset->form();
		$form -> add('submit', '', array('type' => 'submit', 'value' => 'Save', 'class' => 'btn btn-large btn-block btn-primary') );
		
		# Attempt to save on unempty input
		if (Input::method() == 'POST') {

			$fields = $fieldset->input();

			try {
				# Remove null values and those that haven't changed
				$clean_array = function(array $fields, Model_User $user){
					foreach ($fields as $key => $value) {
						if (empty($value) || $value == $user->$key) 
							unset($fields[$key]);
					}
					return $fields;
				};
				# Set property values and save
				$user->set($clean_array($fields, $user));
				$user->save();

				Session::set_flash('success', 'Updated user #' . $user->id . '.');

				Response::redirect('user');

			} catch (Orm\ValidationFailed $e) {
				Session::set_flash('error', $e->getMessage());
			}
		}

		$this->template->title = "User #" . $id;
		$this->template->set('content', $form->build(), false);
	}

	/**
	 * Delete User
	 * @access public
	 * @param int $id
	 * @return Response
	 */
	public function action_delete($id = null)
	{
		is_null($id) and Response::redirect('User');

		if ($user = Model_User::find($id))
		{
			$user->delete();

			Session::set_flash('success', 'Deleted user #'.$id);
		} else {
			Session::set_flash('error', 'Could not delete user #'.$id);
		}

		Response::redirect('user');

	}

}