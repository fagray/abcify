<?php

namespace Rayms\View\Providers;

class ViewServiceProvider {

	public $data = array();

   public function __construct($template)
	{
	    try {
	        $file = $_SERVER['DOCUMENT_ROOT'].'/app/views/'.$template;

	        if (file_exists($file)) {
	            $this->render = $file;

	        } else {
	            throw new customException('Template ' . $template . ' not found!');
	        }
	    }

	    catch (customException $e) {
	        echo $e->errorMessage();
	    }
	    return $this;
	}

	public function assign($key, $value)
	{
	    $this->data[$key] = $value;
	}

	public function __destruct()
	{
	    extract($this->data);
	    require_once($this->render);
	}
}

