<?php

require_once 'core/init.php';

$user = new User();

if (!$user->isLoggedIn()) {
	Redirect::to('index.php');
} else {
}

if (Input::exists()) {
	if (Token::check(Input::get('token'))) {

		$validate = new Validate();
		$validate->check($_POST, array(
			'name' => array(
				'required' => true,
				'min' => 2,
				'max' => 32
			)
		));

		if ($validate->passed()) {
			//update
			try {
				$user->update(array(
					'username' => Input::get('name')
				));

				Session::flash('home', 'Your account has been updated.');
				Redirect::to('index.php');

			} catch(Exception $e) {
				die($e->getMessage());
			}
		} else {
			foreach ($validate->errors() as $error) {
					echo $error . '<br />';
			}
		}
	}
}
?>

<form action="" method="post">
	<div class="field">
		<label="name">Name</label>
		<input type="text" name="name" value="<?php echo escape($user->data()->name); ?>" />

		<input type="submit" value="Update" />
		<input type="hidden" name="token" value="<?php echo Token::generate(); ?>" />
	</div>
</form>
