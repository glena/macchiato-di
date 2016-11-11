<?php namespace MacchiatoPHP\Tests\Models;

class BasicClassWithOptionalParams {
  
  protected $value;
  protected $value2;

  public function __construct($param, $param2 = null) {
    $this->value = $param;
    $this->value2 = $param2;
  }

  public function getValue() {
    return $this->value;
  }

  public function getValue2() {
    return $this->value2;
  }

}