<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class CategoryController extends Controller{
    public function foodBaverage(){
        return view('category.FoodBaverage');
    }
    public function beautyHealth(){
        return view('category.BeautyHealth');
    }
    public function babyKid(){
        return view('category.BabyKid');
    }
    public function homeCare(){
        return view('category.HomeCare');
    }
}
