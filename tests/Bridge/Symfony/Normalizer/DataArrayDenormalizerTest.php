<?php

declare(strict_types=1);

namespace steevanb\PhpTypedArray\Tests\Bridge\Symfony\Normalizer;

use PHPUnit\Framework\TestCase;
use steevanb\PhpTypedArray\Bridge\Symfony\Normalizer\ObjectArrayDenormalizer;
use Symfony\Component\Serializer\{
    Normalizer\ObjectNormalizer,
    Serializer
};

final class DataArrayDenormalizerTest extends TestCase
{
    public function testDenormalize(): void
    {
        $serializer = new Serializer([new ObjectArrayDenormalizer(), new ObjectNormalizer()]);
        /** @var DataArray $array */
        $array = $serializer->denormalize(
            [
                ['foo' => 'foo1', 'bar' => 42],
                ['foo' => 'foo2', 'bar' => 43]
            ],
            DataArray::class
        );

        static::assertCount(2, $array);

        /** @var Data $data1 */
        $data1 = $array[0];
        static::assertInstanceOf(Data::class, $data1);
        static::assertSame('foo1', $data1->foo);
        static::assertSame(42, $data1->bar);

        /** @var Data $data2 */
        $data2 = $array[1];
        static::assertInstanceOf(Data::class, $data2);
        static::assertSame('foo2', $data2->foo);
        static::assertSame(43, $data2->bar);
    }
}
