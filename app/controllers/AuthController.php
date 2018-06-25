<?php 

namespace App\Controllers;

use Rayms\View\View;
use App\Models\User;


class AuthController {

	private $user;

	public function __construct()
	{
		$this->user = new User;
	}

	/**
	 * Show the login form
	 * @return  mixed
	 */
	public function login()
	{
		return new View('auth/login.php');
	}

	/**
	 * Authenticate user
	 *
	 * @return       
	 */
	public function authenticate()
	{
		$hashedPassword = md5($_POST['password']);
		$userData = ['username' => $_POST['username'],'password' => $hashedPassword];
		$user = $this->user->authenticate($userData);
		if ( ! $user )
		{
			sessionSet('flash','Invalid username or password!');
			return redirect('/login');
		}
		sessionSet('auth_user_id',$user[0]['user_id']);
		sessionSet('auth_username',$user[0]['username']);
		sessionSet('auth_name',$user[0]['name']);
		return redirect('/');
		
	}

	public function logout()
	{
		unsetSession('auth_user_id');
		unsetSession('auth_username');
		unsetSession('auth_name');
		return redirect('/'); 
	}

}

