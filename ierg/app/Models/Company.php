<?php

  namespace App\Models;

  use \TypeRocket\Models\WPPost;

  class Company extends WPPost
  {
    protected $postType = 'company';
  }