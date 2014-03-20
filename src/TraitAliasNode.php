<?php
namespace Pharborist;

/**
 * A trait alias. Eg. B::bigTalk as talk;
 * @package Pharborist
 */
class TraitAliasNode extends Node {
  /**
   * @var Node
   */
  public $methodName;

  /**
   * @var Node
   */
  public $visibility;

  /**
   * @var Node
   */
  public $alias;
}