<?php
namespace Bricks\ServiceLocator;

/**
 * Хранит сервисы.
 *
 * @author Artur Sh. Mamedbekov
 */
class Manager implements \ArrayAccess{
  /**
   * @var array Массив доступных сервисов.
   */
  private $services;

  /**
   * Регистрирует сервис в хранилище. В качестве сервиса могут выступать любые 
   * типы данных.
   *
   * @param string $name Имя сервиса, под которым он будет доступен из 
   * хранилища.
   * @param mixed $service Сервис.
   */
  public function set($name, $service){
    $this->services[$name] = $service;
  }

  /**
   * Проверяет наличие сервиса в хранилище.
   *
   * @param string $name Имя сервиса.
   *
   * @return bool true - если сервис с указанным именем зарегистрирован в 
   * хранилище.
   */
  public function has($name){
    return isset($this->services[$name]);
  }

  /**
   * Регистрация фабрики сервиса в хранилище.
   *
   * @warning Фабрика вызывается каждый раз при обращении к ней из хранилища.  
   * Если вам необходимо использовать ранее созданный фабрикой сервис при 
   * повторных обращениях, передайте в качестве третьего аргумента методу 
   * значение true.
   *
   * @param string $name Имя сервиса.
   * @param string|callable $factory Имя функции или анонимная функция, 
   * используемая в качестве фабрики.
   * При вызове фабрики в качестве первого параметра будет передано хранилище.
   * @param object|string $context [optional] Контекст вызова фабрики в виде 
   * объекта или имени класса, который будет инстанциирован.
   * @param bool $shared Если передано true, первый вызов фабрики заменит ее на 
   * возвращаемый ею сервис.
   */
  public function factory($name, $factory, $context = null, $shared = false){
    if(!is_null($context)){
      if(is_string($context)){
        $context = new $context;
      }
      $factory = [$context, $factory];
    }

    $this->services[$name] = ['factory' => $factory, 'shared' => $shared];
  }

  /**
   * Объявляет псевдоним сервиса.
   *
   * @param string $name Имя сервиса.
   * @param string $alias Псевдоним.
   */
  public function alias($name, $alias){
    if($this->has($name)){
      $this->services[$alias] = &$this->services[$name];
    }
  }

  /**
   * Предоставляет сервис.
   *
   * @param string $name Имя сервиса.
   *
   * @return mixed|null Сервис или null - если он не зарегистрирован.
   */
  public function get($name){
    if(!$this->has($name)){
      return null;
    }

    $service = $this->services[$name];

    if(is_array($service) && isset($service['factory'])){
      $shared = $service['shared'];
      $service = call_user_func_array($service['factory'], [$this]);
      if($shared){
        $this->set($name, $service);
      }
    }

    return $service;
  }

  public function offsetExists($offset){
    return $this->has($offset);
  }

  public function offsetGet($offset){
    return $this->get($offset);
  }

  public function offsetSet($offset, $value){
    $this->set($offset, $value);
  }

  /**
   * Не реализовано.
   */
  public function offsetUnset($offset){
    throw new \RuntimeException('You can not remove the service');
  }
}
