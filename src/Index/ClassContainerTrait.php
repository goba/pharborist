<?php
namespace Pharborist\Index;

trait ClassContainerTrait {

  /**
   * @var \Doctrine\Common\Collections\Collection
   */
  protected $classes;

  public function getClasses() {
    return $this->classes;
  }

  public function getClass($class) {
    return $this->getClasses()->get($class);
  }

  public function hasClass($class) {
    return $this->getClasses()->containsKey($class);
  }

}