<?php
namespace Pharborist;

class Psr2FormatterTest extends \PHPUnit_Framework_TestCase {
  protected function formatSnippet($snippet) {
    /** @var ParentNode $node */
    $node = Parser::parseSnippet($snippet);
    $formatter = FormatterFactory::getPsr2Formatter();
    $formatter->format($node);
    return $node->getText();
  }

  public function testIf() {
    $snippet = 'if( $a ) test(); elseif ($b ) test(); elseif ($c){test();}else test();';
    $actual = $this->formatSnippet($snippet);
    $expected = <<<'EOF'
if ($a) {
    test();
} elseif ($b) {
    test();
} elseif ($c) {
    test();
} else {
    test();
}
EOF;
    $this->assertEquals($expected, $actual);
  }

  public function testClass() {
    $snippet = 'class Test{public function test(){run();}}';
    $actual = $this->formatSnippet($snippet);
    $expected = <<<'EOF'
class Test
{
    public function test()
    {
        run();
    }
}
EOF;
    $this->assertEquals($expected, $actual);
  }

  public function testImplementsWrap() {
    $snippet = "class Test extends ParentClass implements
    TestInterface {}";
    $actual = $this->formatSnippet($snippet);
    $expected = <<<'EOF'
class Test extends ParentClass implements
    TestInterface
{
}
EOF;
    $this->assertEquals($expected, $actual);

    $snippet = "class Test extends ParentClass implements OneInterface,
    TwoInterface,ThreeInterface,FourInterface,FiveInterface {}";
    $actual = $this->formatSnippet($snippet);
    $expected = <<<'EOF'
class Test extends ParentClass implements
    OneInterface,
    TwoInterface,
    ThreeInterface,
    FourInterface,
    FiveInterface
{
}
EOF;
    $this->assertEquals($expected, $actual);

    $snippet = 'class Test extends ParentClass implements OneInterface,TwoInterface,ThreeInterface,FourInterface,FiveInterface {}';
    $actual = $this->formatSnippet($snippet);
    $expected = <<<'EOF'
class Test extends ParentClass implements
    OneInterface,
    TwoInterface,
    ThreeInterface,
    FourInterface,
    FiveInterface
{
}
EOF;
    $this->assertEquals($expected, $actual);
  }

  public function testExtendsWrap() {
    $snippet = "interface TestInterface extends
    ParentInterface {}";
    $actual = $this->formatSnippet($snippet);
    $expected = <<<'EOF'
interface TestInterface extends
    ParentInterface
{
}
EOF;
    $this->assertEquals($expected, $actual);

    $snippet = "interface TestInterface extends OneInterface,
    TwoInterface,ThreeInterface,FourInterface,FiveInterface {}";
    $actual = $this->formatSnippet($snippet);
    $expected = <<<'EOF'
interface TestInterface extends
    OneInterface,
    TwoInterface,
    ThreeInterface,
    FourInterface,
    FiveInterface
{
}
EOF;
    $this->assertEquals($expected, $actual);

    $snippet = 'interface TestInterface extends OneInterface,TwoInterface,ThreeInterface,FourInterface,FiveInterface {}';
    $actual = $this->formatSnippet($snippet);
    $expected = <<<'EOF'
interface TestInterface extends
    OneInterface,
    TwoInterface,
    ThreeInterface,
    FourInterface,
    FiveInterface
{
}
EOF;
    $this->assertEquals($expected, $actual);
  }

  public function testPsr2FunctionDeclaration() {
    $snippet = <<<'EOF'
function test(
$a,
$b) {}
EOF;
    $actual = $this->formatSnippet($snippet);
    $expected = <<<'EOF'
function test(
    $a,
    $b
) {
}
EOF;
    $this->assertEquals($expected, $actual);

    $snippet = 'function test($someLongParameterName, $anotherLongParameterName, $yetAnotherParameterName){}';
    $actual = $this->formatSnippet($snippet);
    $expected = <<<'EOF'
function test(
    $someLongParameterName,
    $anotherLongParameterName,
    $yetAnotherParameterName
) {
}
EOF;
    $this->assertEquals($expected, $actual);
  }
}