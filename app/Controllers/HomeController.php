<?php

namespace App\Controllers;

class HomeController extends Controller{

  public function __construct(){

  }

  public function index ($request, $response){
      return  'Home Controller';
  }
}
