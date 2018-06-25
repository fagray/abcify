<?php 

namespace App\Models;

class Auth {

    /**
     * Guard if the user is authorize to do any transactions
     *
     * @return       
     */
    public function authorize()
    {
        if (authUser()['user_id'] == null )
        {
            sessionSet('flash','You need to login first!');
            return false;
        }
        return true;
    }


}

