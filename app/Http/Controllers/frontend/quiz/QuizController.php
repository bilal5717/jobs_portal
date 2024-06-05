<?php

namespace App\Http\Controllers\frontend\quiz;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use App\User;
use App\Models\Quiz\Question;
use App\Models\Quiz\Quiz;
use Auth;

class QuizController extends Controller
{
    //
    public function index(){
    	$user = User::find(Auth::user()->id);
    	$userDetail = $user->UserDetail;
    	
		return view('frontend.quiz')
		->with('user', $user)
        ->with('userDetail', $userDetail);
	}
}
