<?php
namespace Pharborist;

/**
 * An integer scalar, like 2 or 30.
 */
class IntegerNode extends TokenNode implements ExpressionNode, ScalarNode {
  /**
   * @return int
   */
  public function getValue() {
    return (int) $this->getText();
  }
}
