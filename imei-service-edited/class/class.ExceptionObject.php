<?php
/**
 * Created by JetBrains PhpStorm.
 * User: zhalnin
 * Date: 07.12.12
 * Time: 15:06
 * To change this template use File | Settings | File Templates.
 */
 /**
 * Arise when missing object of class
 * is initialized
 */
class ExceptionObject extends Exception
{
  // Name of noneexistent object
  protected $_key;

  public function __construct($key, $message)
  {
    // Protected object
    $this->_key = $key;

    // Invoke construct of parent class
    parent::__construct($message);
  }

  // Take protected member
  public function getKey()
  {
    return $this->_key;
  }
}
?>