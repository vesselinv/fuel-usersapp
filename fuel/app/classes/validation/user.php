<?php
# fuel/app/classes/validation/user.php

class Validation extends Fuel\Core\Validation
{
	/**
	* Unique field validation
	* Use inside a Model:
	*
	* property_name =>  array(
	*		'validation' => array(
	*			'unique' => array('table_name.column_name')
	*		),
	* ),
	*/
	public static function _validation_unique($val, $options)
	{
		list($table, $field) = explode('.', $options);

		$result = \DB::select("LOWER (\"" . $field . "\")")
		->where($field, '=', MBSTRING ? mb_strtolower($val) : strtolower($val))
		->from($table)->execute();

		if($result->count() > 0)
			return false;
		else
			return true;
	}

	/**
	* Allow alphanumeric characters and underscores in screen names
	*/
	public static function _validation_username($val)
	{
		return $val === '' || preg_match('/^[A-Za-z][A-Za-z0-9]*(?:_[A-Za-z0-9]+)*$/', $val);
	}

	/**
	* Valid MySQL date -- YYYY-MM-DD
	*/
	public static function _validation_valid_mysql_date($val)
	{
		return $val === '' || preg_match('/\d{4}-\d{2}-\d{2}/', $val);
	}
}