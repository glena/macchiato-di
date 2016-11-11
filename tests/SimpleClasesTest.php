<?php namespace MacchiatoPHP\Tests;

use MacchiatoPHP\Tests\Models\BasicClass;
use MacchiatoPHP\Tests\Models\BasicClassWithParams;
use MacchiatoPHP\Tests\Models\BasicClassWithTwoParams;
use MacchiatoPHP\Tests\Models\BasicClassWithOptionalParams;
use MacchiatoPHP\DI\Container;

class SimpleClasesTest extends \PHPUnit_Framework_TestCase {
    
  public function testBasicClassCreation() {

    $container = new Container;
    $instance = $container->instantiate(BasicClass::class);
    
    $this->assertInstanceOf(BasicClass::class, $instance);

  }

  public function testBasicClassWithParamsCreation() {
    $value = 'the value';

    $container = new Container;
    $instance = $container->instantiate(BasicClassWithParams::class, $value);
    
    $this->assertInstanceOf(BasicClassWithParams::class, $instance);
    $this->assertEquals($value, $instance->getValue());
  }

  public function testBasicClassWithOptionalMissingParamsCreation() {
    $value = 'the value';

    $container = new Container;
    $instance = $container->instantiate(BasicClassWithOptionalParams::class, $value);
    
    $this->assertInstanceOf(BasicClassWithOptionalParams::class, $instance);
    $this->assertEquals($value, $instance->getValue());
    $this->assertNull($instance->getValue2());
  }

  public function testBasicClassWithOptionalParamsCreation() {
    $value = 'the value';
    $value2 = 'the second value';

    $container = new Container;
    $instance = $container->instantiate(BasicClassWithOptionalParams::class, $value, $value2);
    
    $this->assertInstanceOf(BasicClassWithOptionalParams::class, $instance);
    $this->assertEquals($value, $instance->getValue());
    $this->assertEquals($value2, $instance->getValue2());
  }

  public function testBasicClassWithTwoParamsCreation() {
    $value = 'the value';
    $value2 = 'the second value';

    $container = new Container;
    $instance = $container->instantiate(BasicClassWithTwoParams::class, $value, $value2);
    
    $this->assertInstanceOf(BasicClassWithTwoParams::class, $instance);
    $this->assertEquals($value, $instance->getValue());
    $this->assertEquals($value2, $instance->getValue2());
  }

  /**
   * @expectedException \MacchiatoPHP\DI\MissingParametersException
   */
  public function testBasicClassWithTwoMissingParamsCreation() {
    $value = 'the value';

    $container = new Container;
    $instance = $container->instantiate(BasicClassWithTwoParams::class, $value);
  }
}