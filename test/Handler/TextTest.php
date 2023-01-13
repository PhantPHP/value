<?php

declare(strict_types=1);

namespace Test;

use Phant\Value\Handler\Text;

final class TextTest extends \PHPUnit\Framework\TestCase
{
    public function testGet(): void
    {
        $item = new Text('Lorem ipsum dolor sit amet ...');

        $this->assertIsString($item->get());
        $this->assertEquals((string) $item, $item->get());
    }

    public function testRemoveUselessSpaces(): void
    {
        $this->assertEquals(
            'Lorem ipsum dolor sit amet',
            (string) (new Text(
                ' Lorem ipsum      dolor sit amet '
            ))->removeUselessSpaces()
        );
    }

    public function testUseNonBreakingSpaces(): void
    {
        $this->assertEquals(
            'Lorem ipsum dolor sit amet',
            (string) (new Text(
                'Lorem ipsum dolor sit amet'
            ))->useNonBreakingSpaces()
        );
    }

    public function testMakeTypographicSpaces(): void
    {
        $this->assertEquals(
            'A « café latte », is not expensive !',
            (string) (new Text(
                'A «café latte» ,is not expensive!'
            ))->makeTypographicSpaces()
        );
    }

    public function testUpperInitial(): void
    {
        $this->assertEquals(
            'Être',
            (string) (new Text(
                'être'
            ))->upperInitial()
        );
    }

    public function testlowerInitial(): void
    {
        $this->assertEquals(
            'être',
            (string) (new Text(
                'Être'
            ))->lowerInitial()
        );
    }

    public function testUpper(): void
    {
        $this->assertEquals(
            'ÊTRE',
            (string) (new Text(
                'être'
            ))->upper()
        );
    }

    public function testLower(): void
    {
        $this->assertEquals(
            'être',
            (string) (new Text(
                'ÊTRE'
            ))->lower()
        );
    }

    public function testRemoveAccents(): void
    {
        $this->assertEquals(
            'A cafe',
            (string) (new Text(
                'A café'
            ))->removeAccents()
        );
    }

    public function testBeginsWithVowel(): void
    {
        $this->assertEquals(true, (new Text(' Yes '))->beginsWithVowel());
        $this->assertEquals(false, (new Text(' No '))->beginsWithVowel());
    }
}
