<?php namespace MacchiatoPHP\Tests\Models;

class AbstractedDependencyClass {
  
  protected $dependency;
  protected $dependency2;

  public function __construct (BasicClass $dependency, SomeInterface $dependency2) {
    $this->dependency = $dependency;
    $this->dependency2 = $dependency2;
  } 

  public function getDependency() {
    return $this->dependency;
  }
  public function getDependency2() {
    return $this->dependency2;
  }

}