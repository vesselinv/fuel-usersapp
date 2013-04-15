<?php
# fuel/app/test/model/user.php
/**
 * UserModelTest
 * 
 * @group model
 */
class UserModelTest extends \PHPUnit_Framework_TestCase
{
	# This should fail - invalid Username
	public function test_create1()
	{
		$data = array(
			'username' 				=> 'bitemyapple ',
			'password'				=> 'Not7ooShA34y!',
			'email' 					=> 'someone@gmail.com',
			'name'						=> 'Veselin',
			'date_of_birth' 	=> '1988-12-31',
			'gender'					=> '0'
		);

		$user = new \Model_User($data);

		try {
			$result = $user->save();
		} catch (\Exception $e) {
			$result = $e->getMessage();
		}

		$this->assertEquals(true, $result);
	}

	# This should fail - invalid Mysql date
	public function test_create2()
	{
		$data = array(
			'username' 				=> 'bitemyapple',
			'password'				=> 'Not7ooShA34y!',
			'email' 					=> 'someone@gmail.com',
			'name'						=> 'Veselin',
			'date_of_birth' 	=> '1988-2-31',
			'gender'					=> '0'
		);

		$user = new \Model_User($data);

		try {
			$result = $user->save();
		} catch (\Exception $e) {
			$result = $e->getMessage();
		}

		$this->assertEquals(true, $result);
	}

	# This should NOT Fail
	public function test_create3()
	{
		$data = array(
			'username' 				=> 'bitemyapple',
			'password'				=> 'Not7ooShA34y!',
			'email' 					=> 'someone@gmail.com',
			'name'						=> 'Veselin',
			'date_of_birth' 	=> '1988-12-31',
			'gender'					=> '0'
		);

		$user = new \Model_User($data);

		try {
			$result = $user->save();
		} catch (\Exception $e) {
			$result = $e->getMessage();
		}

		$this->assertEquals(true, $result);
	}

	# This shoudl fail - duplicate username
	public function test_create4()
	{
		$data = array(
			'username' 				=> 'bitemyapple',
			'password'				=> 'Not7ooShA34y!',
			'email' 					=> 'someone1@gmail.com',
			'name'						=> 'Veselin',
			'date_of_birth' 	=> '1988-12-31',
			'gender'					=> '0'
		);

		$user = new \Model_User($data);

		try {
			$result = $user->save();
		} catch (\Exception $e) {
			$result = $e->getMessage();
		}

		$this->assertEquals(true, $result);
	}

	# This should fail - duplicate email
	public function test_create5()
	{
		$data = array(
			'username' 				=> 'bitemyapple1',
			'password'				=> 'Not7ooShA34y!',
			'email' 					=> 'someone@gmail.com',
			'name'						=> 'Veselin',
			'date_of_birth' 	=> '1988-12-31',
			'gender'					=> '0'
		);

		$user = new \Model_User($data);

		try {
			$result = $user->save();
		} catch (\Exception $e) {
			$result = $e->getMessage();
		}

		$this->assertEquals(true, $result);
	}
}
