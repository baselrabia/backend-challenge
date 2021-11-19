<?php

namespace App\Http\Controllers;
 
use App\Http\Controllers\Controller;
 

class PageController extends Controller
{
 
   
 
    public function home()
    {
        Authorize('view-home');
 
        return SuccessResponse([],'Welcome to the home page');
    }



    public function dashboard()
    {
        Authorize('view-dashboard');

        return SuccessResponse([], 'Seems That you had Access To Our Dashboard, Welcome Kido :D');

    }


    public function viewPost()
    {
        Authorize('view-Post');

        return SuccessResponse([], 'Oh You Can See Our Posts , Ummmmmm Big Progress');
    }




    public function uploadPhoto()
    {
        Authorize('upload-photo');

        return SuccessResponse([], "Now You Can Upload Photos , Where's yours ;D ");
    }
    
}
