<?php
namespace Pharborist;

/**
 * A node that has children.
 */
abstract class ParentNode extends Node {
  /**
   * @var Node[]
   */
  public $children = array();

  /**
   * Prepend a child to node.
   */
  public function prependChild(Node $child) {
    $child->parent = $this;
    array_unshift($this->children, $child);
    return $child;
  }

  /**
   * Append a child to node.
   * @param Node $child
   * @return Node
   */
  public function appendChild(Node $child) {
    $child->parent = $this;
    $this->children[] = $child;
    return $child;
  }

  /**
   * Append children to node.
   * @param Node[] $children
   */
  public function appendChildren(array $children) {
    foreach ($children as $child) {
      $this->appendChild($child);
    }
  }

  /**
   * Filters children to find matching nodes.
   * @param string $type
   *   Type of nodes to return.
   * @return Node[] matching children
   */
  public function filter($type) {
    $matches = array();
    foreach ($this->children as $child) {
      if ($child instanceof $type) {
        $matches[] = $child;
      }
    }
    return $matches;
  }

  /**
   * Find descendants that match given type.
   * @param string $type
   *   Type of nodes to return.
   * @return Node[] matching descendants
   */
  public function find($type) {
    $matches = array();
    if ($this instanceof $type) {
      $matches[] = $this;
    }
    foreach ($this->children as $child) {
      if ($child instanceof ParentNode) {
        $matches = array_merge($matches, $child->find($type));
      }
    }
    return $matches;
  }

  /**
   * @return SourcePosition
   */
  public function getSourcePosition() {
    if (count($this->children) === 0) {
      return $this->parent->getSourcePosition();
    }
    $child = $this->children[0];
    return $child->getSourcePosition();
  }

  /**
   * @return string
   */
  public function __toString() {
    $str = '';
    foreach ($this->children as $child) {
      $str .= (string) $child;
    }
    return $str;
  }
}