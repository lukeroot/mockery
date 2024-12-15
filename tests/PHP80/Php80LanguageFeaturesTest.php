<?php

namespace test\Mockery;

use ArrayIterator;
use DateTime;
use Iterator;
use IteratorAggregate;
use Mockery\Adapter\Phpunit\MockeryTestCase;
use ReturnTypeWillChange;

/**
 * @requires PHP 8.0.0-dev
 */
class Php80LanguageFeaturesTest extends MockeryTestCase
{
    public function testMockingIteratorAggregateDoesNotImplementIterator()
    {
        $mock = mock('test\Mockery\ImplementsIteratorAggregate');
        $this->assertInstanceOf('IteratorAggregate', $mock);
        $this->assertInstanceOf('Traversable', $mock);
        $this->assertNotInstanceOf('Iterator', $mock);
    }

    public function testMockingIteratorDoesNotImplementIterator()
    {
        $mock = mock('test\Mockery\ImplementsIterator');
        $this->assertInstanceOf('Iterator', $mock);
        $this->assertInstanceOf('Traversable', $mock);
    }

    /** @test */
    public function it_can_mock_a_class_with_a_mixed_argument_type_hint()
    {
        $mock = mock(ArgumentMixedTypeHint::class);
        $object = new \stdClass();
        $mock->allows()->foo($object)->once();

        $mock->foo($object);
    }

    /** @test */
    public function it_can_mock_a_class_with_a_union_argument_type_hint()
    {
        $mock = mock(ArgumentUnionTypeHint::class);
        $object = new ArgumentUnionTypeHint();
        $mock->allows()->foo($object)->once();

        $mock->foo($object);
    }

    /** @test */
    public function it_can_mock_a_class_with_a_union_argument_type_hint_including_null()
    {
        $mock = mock(ArgumentUnionTypeHintWithNull::class);
        $mock->allows()->foo(null)->once();

        $mock->foo(null);
    }

    /** @test */
    public function it_can_mock_a_class_with_a_parent_argument_type_hint()
    {
        $mock = mock(ArgumentParentTypeHint::class);
        $object = new ArgumentParentTypeHint();
        $mock->allows()->foo($object)->once();

        $mock->foo($object);
    }

    /** @test */
    public function it_can_mock_a_class_with_a_mixed_return_type_hint()
    {
        $mock = spy(ReturnTypeMixedTypeHint::class);

        $this->assertNull($mock->foo());
    }

    /** @test */
    public function it_can_mock_a_class_with_a_union_return_type_hint()
    {
        $mock = spy(ReturnTypeUnionTypeHint::class);

        $this->assertTrue(is_object($mock->foo()));
    }

    /** @test */
    public function it_can_mock_a_class_with_a_parent_return_type_hint()
    {
        $mock = spy(ReturnTypeParentTypeHint::class);

        $this->assertInstanceOf(\stdClass::class, $mock->foo());
    }

    /** @test */
    public function it_can_mock_a_class_with_a_named_argument_list()
    {
        $mock = mock(MultiArgument::class);

        $mock->allows()->foo(bar: 1, dol: '1')->times(3);

        $mock->foo(bar: 1, dol: '1');
        $mock->foo(bar: 1, bee: '', dol: '1');
        $mock->foo(1, '', '1');

        $mock->allows()->foo(bee: '1')->times(3);

        $mock->foo(bee: '1');
        $mock->foo(bar: 0, bee: '1');
        $mock->foo(0, '1');

        $mock->allows()->foo(bar: 1)->times(2);

        $mock->foo(bar: 1);
        $mock->foo(1);

        $spy = spy(MultiArgument::class);

        $param = ['bar' => 2, 'dol' => '2'];
        $spy->foo(...$param);

        $spy->shouldHaveReceived(method: 'foo', args: $param);
        $spy->shouldHaveReceived(method: 'foo', args: ['bar' => 2, 'bee' => '', 'dol' => '2']);
        $spy->shouldHaveReceived(method: 'foo', args: [2, '', '2']);

        $param = ['bee' => '2'];
        $spy->foo(...$param);

        $spy->shouldHaveReceived(method: 'foo', args: $param);
        $spy->shouldHaveReceived(method: 'foo', args: ['bar' => 0, 'bee' => '2']);
        $spy->shouldHaveReceived(method: 'foo', args: [0, '2']);

        $param = ['bar' => '2'];
        $spy->foo(...$param);
        $spy->shouldReceive(method: 'foo', args: $param);
        $spy->shouldReceive(method: 'foo', args: ['2']);
    }
}

class ImplementsIteratorAggregate implements IteratorAggregate
{
    public function getIterator(): ArrayIterator
    {
        return new ArrayIterator([]);
    }
}

class ImplementsIterator implements Iterator
{
    public function rewind(): void
    {
    }

    public function current(): mixed
    {
    }

    public function key(): mixed
    {
    }

    public function next(): void
    {
    }

    public function valid(): bool
    {
    }
}

class ArgumentMixedTypeHint
{
    public function foo(mixed $foo)
    {
    }
}

class ArgumentUnionTypeHint
{
    public function foo(string|array|self $foo)
    {
    }
}

class ArgumentUnionTypeHintWithNull
{
    public function foo(string|array|null $foo)
    {
    }
}

class ArgumentParentTypeHint extends \stdClass
{
    public function foo(parent $foo)
    {
    }
}

class MultiArgument
{
    public function foo(int $bar = 0, string $bee = '', string $dol = '')
    {
    }
}

class ReturnTypeMixedTypeHint
{
    public function foo(): mixed
    {
    }
}

class ReturnTypeUnionTypeHint
{
    public function foo(): ReturnTypeMixedTypeHint|self
    {
    }
}

class ReturnTypeParentTypeHint extends \stdClass
{
    public function foo(): parent
    {
    }
}
