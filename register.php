<?php

require_once 'core/init.php';

/* If form contains post content */
if (Input::exists()) {
	/* Checks to ensure form was filled out (CSRF Protection) */
	if (Token::check(Input::get('token'))) {

		$validate = new Validate();
		$validate->check($_POST, array(

			'username' => array(
				'required' => true,
				'min' => 2,
				'max' => 20,
				'unique' => 'users'
				),
				
			'password' => array(
				'required' => true,
				'min' => 6
			),

			'password_again' => array(
				'required' => true,
				'matches' => 'password'
			),

			'name' => array(
				'required' => true,
				'min' => 2,
				'max' => 25
			)
		));

		/* If form is valid create user */
		if ($validate->passed()) {
			$user = new User();
			
			$salt = Hash::salt(32);

			try {
				$user->create( array(
					'username' => Input::get('username'),
					'password' => Hash::make(Input::get('password'), $salt),
					'salt' => $salt
				));

				Session::flash('home', 'You have successfully registered!');
				Redirect::to('index.php');

			} catch (Exception $e) {
				die($e->getMessage());
			}
		} else {
			/* Display form errors */
			foreach ($validate->errors() as $err) {
				echo "$err <br />";
			}
		}
	}
}

?>

<form action="" method="post">
	<div class="field">
		<label for="username">Username</label>
		<input type="text" name="username" id="username" value="<?php escape(Input::get('username')); ?>" autocomplete="off" />
	</div>

	<div class="field">
		<label for="password">Choose a password</label>
		<input type="password" name="password" id="password" />
	</div>

	<div class="field">
		<label for="password_again">Please type your password again</label>
		<input type="password" name="password_again" id="password_again" />
	</div>

	<div class="field">
		<label for="name">Your name</label>
		<input type="text" name="name" id="name" />
	</div>

	<input type="hidden" name="token" value="<?php echo Token::generate() ?>" />

	<input type="submit" value="Register" />
</form>
