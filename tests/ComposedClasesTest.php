<?php namespace MacchiatoPHP\Tests;

use MacchiatoPHP\DI\Container;

use MacchiatoPHP\Tests\Models\SomeInterface;
use MacchiatoPHP\Tests\Models\BasicClass;
use MacchiatoPHP\Tests\Models\BasicClassChild;
use MacchiatoPHP\Tests\Models\ComposedClass;
use MacchiatoPHP\Tests\Models\AbstractedDependencyClass;
use MacchiatoPHP\DI\InterfaceMappingException;

class ComposedClasesTest extends \PHPUnit_Framework_TestCase {
    
  public function testComposedClassCreation() {

    $container = new Container;
    $instance = $container->instantiate(ComposedClass::class);
    
    $this->assertInstanceOf(ComposedClass::class, $instance);
    $this->assertInstanceOf(BasicClass::class, $instance->getDependency());

  }    

  public function testComposedClassCreationWithCache() {
    
    $basicInstance = new BasicClass;
    $basicInstance->value = 'existingClass';

    $container = new Container;
    $container->setInstance(BasicClass::class, $basicInstance);

    $instance = $container->instantiate(ComposedClass::class);
    
    $this->assertInstanceOf(ComposedClass::class, $instance);
    $this->assertInstanceOf(BasicClass::class, $instance->getDependency());
    $this->assertEquals('existingClass', $instance->getDependency()->value);
  }    

  /**
   * @expectedException \MacchiatoPHP\DI\InterfaceMappingException
   */
  public function testAbstractedDependencyClassCreationWithoutBinding() {

    $container = new Container;
    $instance = $container->instantiate(AbstractedDependencyClass::class);
    
    $this->assertInstanceOf(AbstractedDependencyClass::class, $instance);

  }


  public function testAbstractedDependencyClassCreationWithBinding() {

    $container = new Container;
    $container->mapInterface(SomeInterface::class, ComposedClass::class);

    $instance = $container->instantiate(AbstractedDependencyClass::class);
    
    $this->assertInstanceOf(AbstractedDependencyClass::class, $instance);
    $this->assertInstanceOf(BasicClass::class, $instance->getDependency());
    $this->assertInstanceOf(ComposedClass::class, $instance->getDependency2());
    $this->assertInstanceOf(SomeInterface::class, $instance->getDependency2());

  }

  public function testAbstractedDependencyClassCreationWithParam() {

    $container = new Container;

    $basicInstance = new BasicClass;
    $basicInstance->value = 'existingClass';

    $param = new ComposedClass($basicInstance);

    $instance = $container->instantiate(AbstractedDependencyClass::class, $param);
    
    $this->assertInstanceOf(AbstractedDependencyClass::class, $instance);
    $this->assertInstanceOf(BasicClass::class, $instance->getDependency());
    $this->assertInstanceOf(ComposedClass::class, $instance->getDependency2());
    $this->assertInstanceOf(SomeInterface::class, $instance->getDependency2());
    $this->assertInstanceOf(BasicClass::class, $instance->getDependency2()->getDependency());
    $this->assertEquals('existingClass', $instance->getDependency2()->getDependency()->value);
  }
}
