<?php
/**
* 
*-----------------------------------------------------------------------
*
* Application Helpers
* 
*-----------------------------------------------------------------------
*
**/
!defined('APP_BASE') ? define('APP_BASE',realpath(__DIR__.'/../')) : null;


/**
 * Return the base path of the application
 *
 * @return     string  
 */
function basePath()
{
   return APP_BASE;
}

/**
 * Return the application path
 *
 * @return     string  
 */
function appPath()
{
    return APP_BASE.'/app';
}

/**
 * Return the application's public path
 *
 * @return     string  
 */
function publicPath()
{
    return APP_BASE.'/public';
}

/**
 * Load the asset file
 *
 * @param      string  $assetPath  
 *
 * @return       
 */
function asset($assetPath)
{
    $protocol = isset($_SERVER['HTTPS']) ? "https://" : "http://";
    return $protocol.$_SERVER['HTTP_HOST'].'/public'.$assetPath;
}

/**
 * Return the specified config value based on key
 *
 * @param      string  $key    
 *
 * @return     string  
 */
function config($key)
{
    // load the database configuration to get the values set by the user
    $dbConfiguration = require(__DIR__.'/./database.php');
    if (array_key_exists($key, $dbConfiguration['database']))
    {
        return $dbConfiguration['database'][$key];
    }
    return "Key not defined";
    
}

/**
 * Returns a layout file
 *
 * @param      string  $layoutName  
 *
 * @return     string  
 */
function includeLayout($layoutName)
{

    if ( file_exists(appPath().'/views/layouts/'.$layoutName) )
    {
        require_once appPath().'/views/layouts/'.$layoutName;
    }
    return "Template not found";
}

/**
 * Transform response into json format
 *
 * @param      array  $array  
 */
function json($array)
{
    echo json_encode($array);
}

/**
 * Return a session value based on the given session key
 *
 * @param      string  $key    
 *
 * @return       string
 */
function session($key)
{
    startSession();
    return $_SESSION[$key];
}

/**
 * Set a session variable
 *
 * @param      string  $key    
 * @param      string  $value  
 */
function sessionSet($key, $value)
{
    startSession();
    $_SESSION[$key] = $value;
}

/**
 * Returns the authenticated user
 *
 * @return     array  
 */
function authUser()
{
    startSession();
    if (!isset($_SESSION['auth_user_id'])){
       sessionSet('auth_user_id',null);
       sessionSet('auth_username',null);
       sessionSet('auth_name',null);
       return;
    }
    return [
        'user_id'       =>      $_SESSION['auth_user_id'], 
        'username'      =>      $_SESSION['auth_username'],
        'name'          =>      $_SESSION['auth_name']
    ];
    
}

/**
 * Starts a session.
 */
function startSession()
{
    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }
}

/**
 * Unset a session variable
 *
 * @param      string  $key    
 */
function unSetSession($key)
{
    startSession();
    $_SESSION[$key] = null;
}

/**
 * Redirect to a specified path
 *
 * @param      string  $path   
 */
function redirect($path)
{
    echo "<script>window.location.href='".$path."'</script>";
}

/**
 * Sanitize user input
 *
 * @param      array  $rawAttributes  
 *
 * @return     array   
 */
function sanitizeAttributes($rawAttributes)
{
    $cleanAttributes = array();
    foreach($rawAttributes as $key => $value){
        $cleanAttributes[$key] = htmlentities($value);
    }
    return $cleanAttributes;
}