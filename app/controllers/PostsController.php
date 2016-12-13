<?php 

namespace App\Controllers;

use Rayms\View\View;
use App\Models\Post;

class PostsController {

	/**
	 * Show the listings of all resource
	 * @return  mixed
	 */
	public function index()
	{

		$view = new View('posts/index.php');
		$view->assign('hey',"GAGO RAYMUND !");
	
	}

	/**
	 * Show the form for creating new resource
	 * @return  mixed
	 */	
	public function create()
	{
		$view = new View('posts/create.php');
	}

	/**
	 * Store the newly created resource
	 * @return  mixed
	 */
	public function store()
	{

		var_dump($_POST);
	}

}

