<?php
namespace Bricks\ServiceLocator;
require_once('Manager.php');

/**
 * @author Artur Sh. Mamedbekov
 */
class ManagerTest extends \PHPUnit_Framework_TestCase{
  /**
   * @var int Число вызовов метода фабрики с шарингом.
   */
  public static $sharedFactoryCallCount = 0;

  /**
   * @var Manager Тестируемый объект.
	 */
	private $manager;

	public function setUp(){
    $this->manager = new Manager;
  }

  /**
   * Должен регистрировать сервис в хранилище.
   */
  public function testSet(){
    $this->manager->set('service', 'test');
    $this->assertEquals('test', $this->manager->get('service'));
  }

  /**
   * Должен проверять наличие сервиса в хранилище.
   */
  public function testHas(){
    $this->manager->set('service', 'test');
    $this->assertTrue($this->manager->has('service'));
    $this->assertFalse($this->manager->has('test'));
  }

  /**
   * Метод для тестирования вызова фабрики.
   */
  public function factoryTest(Manager $locator){
  }

  /**
   * Метод для тестирования вызова фабрики с шарингом.
   */
  public function sharedFactoryTest(Manager $locator){
    self::$sharedFactoryCallCount++;
    return self::$sharedFactoryCallCount;
  }

  /**
   * Должен регистрировать фабрику в хранилище.
   */
  public function testFactory(){
    $testMock = $this->getMock(get_class($this));
    $testMock->expects($this->once())
      ->method('factoryTest')
      ->with($this->equalTo($this->manager))
      ->will($this->returnValue('test'));

    $this->manager->factory('factory', 'factoryTest', $testMock);
    $this->assertEquals('test', $this->manager->get('factory'));
  }

  /**
   * Должен шарить сервис фабрики.
   */
  public function testFactory_shouldSharedFactory(){
    $this->manager->factory('factory', 'sharedFactoryTest', $this, true);
    $this->assertEquals(1, $this->manager->get('factory'));
    $this->assertEquals(1, $this->manager->get('factory'));
  }

  /**
   * Должен регистрировать псевдоним сервиса.
   */
  public function testAlias(){
    $this->manager->set('service', 'test');
    $this->manager->alias('service', 'alias');
    $this->assertEquals('test', $this->manager->get('service'));
    $this->assertEquals('test', $this->manager->get('alias'));
  }

  /**
   * Должен предоставлять сервис.
   */
  public function testGet(){
    $this->manager->set('service', 'test');
    $this->assertEquals('test', $this->manager->get('service'));
  }

  /**
   * Должен возвращать null если сервис отсутствует в хранилище.
   */
  public function testGet_shouldNullReturnIsServiceNotFound(){
    $this->assertNull($this->manager->get('service'));
  }


  /**
   * Должен проверять наличие сервиса в хранилище.
   */
  public function testOffsetExists(){
    $this->manager->set('service', 'test');
    $this->assertTrue(isset($this->manager['service']));
    $this->assertFalse(isset($this->manager['test']));
  }

  /**
   * Должен предоставлять сервис.
   */
  public function testOffsetGet(){
    $this->manager->set('service', 'test');
    $this->assertEquals('test', $this->manager['service']);
  }

  /**
   * Должен регистрировать сервис в хранилище.
   */
  public function testOffsetSet(){
    $this->manager['service'] = 'test';
    $this->assertEquals('test', $this->manager->get('service'));
  }

  /**
   * Должен выбрасывать исключение.
   */
  public function testOffsetUnset(){
    $this->setExpectedException(get_class(new \RuntimeException));
    unset($this->manager['service']);
  }
}
