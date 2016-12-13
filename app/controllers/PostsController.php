<?php 

namespace App\Controllers;

use Rayms\View\View;
use App\Models\Post;

class PostsController {

	public function index()
	{

		$view = new View('posts/index.php');
		$view->assign('hey',"GAGO RAYMUND !");
	
	}

	public function create()
	{
		$view = new View('posts/create.php');
	}

	public function store()
	{

		var_dump($_POST);
	}

}

