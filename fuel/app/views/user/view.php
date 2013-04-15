<h2>Viewing #<?php echo $user->id; ?></h2>

<p>
	<strong>Username:</strong>
	<?php echo $user->username; ?></p>
<p>
	<strong>Password:</strong>
	<?php echo $user->password; ?></p>
<p>
	<strong>Email:</strong>
	<?php echo $user->email; ?></p>
<p>
	<strong>Name:</strong>
	<?php echo $user->name; ?></p>
<p>
	<strong>Date of birth:</strong>
	<?php echo $user->date_of_birth; ?></p>
<p>
	<strong>Gender:</strong>
	<?php echo $user->gender; ?></p>
<p>
	<strong>Last ip:</strong>
	<?php echo $user->last_ip; ?></p>

<?php echo Html::anchor('user/edit/'.$user->id, 'Edit'); ?> |
<?php echo Html::anchor('user', 'Back'); ?>