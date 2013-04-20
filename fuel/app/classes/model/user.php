<?php
# fuel/app/classes/model/user.php
use Orm\Model;

class Model_User extends Model
{
	# Define our model properties
	protected static $_properties = array(
		'id',
		'username' => array(
			'label' => 'Screen Name',
			'validation' => array(
				'required', 
				'min_length' => array(3), 
				'max_length' => array(20),
				'username', # Validate if username only contains alphanum and/or underscores
				'unique' => array('users.username'), # Make sure the username has not been taken.
			),
			'form' => array('type' => 'text'),
		),
		'password' => array(
			'validation'  => array(
				'required', 
				'min_length' => array(5)
			),
			'label' => 'Password',
			'form' => array('type' => 'password'),
		),
		'email' => array(
			'label' => 'Email',
			'validation' => array(
				'required',
				'valid_email',
				'unique' => array('users.email'),
				'max_length' => array(45),
			),
			'form' => array('type' => 'email'),
		),
		'name' => array(
			'label' => 'Name',
			'validation' => array(
				'required', 
				'min_length' => array(3), 
				'max_length' => array(45) 
			),
			'form' => array('type' => 'text'),
		),
		'date_of_birth' => array(
			'data_type' => 'date',
			'label' => 'Date of Birth',
			'validation' => array(
				'required',
				'valid_mysql_date',
			),
			'form' => array('type' => 'text', 'data-date-format' => 'yyyy-mm-dd'),
		),
		'gender' => array(
			'label'     => 'Gender',
			'validation' => array(
				'required',
			),
			'form'      => array(
				'type' => 'select', 'options' => array('0' => 'Male', '1' => 'Female'),
			),
		),
		'last_ip' => array(
			'form' => array(
				'type' => false, # Prevent this field from being generated on a form
			),
		),
		'created_at' => array(
			'form' => array(
				'type' => false, # Prevent this field from being generated on a form
			),
		),
		'updated_at' => array(
			'form' => array(
				'type' => false, # Prevent this field from being generated on a form
			),
		),
	);

	/* It's being observed! */
	protected static $_observers = array(
		# Make the Validation observer hook into these events
		# This ensures that even if you try to perform CRUD on this model
		# outside of a Fieldset form - for example an API call, it always validates
		'Orm\\Observer_Validation' => array(
			'events' => array('before_insert', 'before_update', 'before_save'),
		),
		'Orm\\Observer_CreatedAt' => array(
			'events' => array('before_insert'),
			'mysql_timestamp' => false,
		),
		'Orm\\Observer_UpdatedAt' => array(
			'events' => array('before_save'),
			'mysql_timestamp' => false,
		),
		'Orm\\Observer_User',
	);

	/* Exclude this columns from being shown in the Model_User object after calling to_aray() 
	* This will server as a bridge to our presenter
	*/
	protected static $_to_array_exclude = array(
		'password', 'last_ip'
  );
}
