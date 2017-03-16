<?php
  class Pet {
    public $name;
    public $food;
    public $attention;
    public $rest;

    function __construct ($name, $food=50, $attention=50, $rest=50){
      $this->name = $name;
      $this->food = $food;
      $this->attention = $attention;
      $this->rest = $rest;
    }

    static function getHour () {
      $hour = date("h");
      return $hour;
    }

    static function getMin(){
      $min = date("i");
      return $min;
    }

    static function getSec(){
      $sec = date("s");
      return $sec;
    }

    static function reset(){
      session_destroy();
    }
  }
?>
