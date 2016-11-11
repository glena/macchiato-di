<?php namespace MacchiatoPHP\Tests\Models;

class BasicClassWithParams {
  
  protected $value;

  public function __construct($param) {
    $this->value = $param;
  }

  public function getValue() {
    return $this->value;
  }

}