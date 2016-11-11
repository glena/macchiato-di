<?php namespace MacchiatoPHP\Tests\Models;

class ComposedClass implements SomeInterface {
  
  protected $dependency;

  public function __construct (BasicClass $dependency) {
    $this->dependency = $dependency;
  } 

  public function getDependency() {
    return $this->dependency;
  }

}