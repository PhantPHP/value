<?php

declare(strict_types=1);

namespace Phant\Value\Handler;

class Text
{
    public const NonBreakingSpace = "\xC2\xA0";

    final public function __construct(
        protected string $value
    ) {
    }

    public function get(): string
    {
        return $this->value;
    }

    public function __toString(): string
    {
        return $this->get();
    }

    public function removeUselessSpaces(): self
    {
        $this->value = trim($this->value);
        $this->value = preg_replace('/\s{2,}/', ' ', $this->value);

        return $this;
    }

    public function useNonBreakingSpaces(): self
    {
        $this->value = preg_replace('/\s/', self::NonBreakingSpace, $this->value);

        return $this;
    }

    public function makeTypographicSpaces(): self
    {
        // add spaces
        $this->value = preg_replace('/\s*(!|\?|;|:|-|"|‘|’|%|\(|\)|\{|\}|\[|\])\s*/', ' $1 ', $this->value);
        $this->value = preg_replace('/\s*(«)\s*/', ' $1 ', $this->value);
        $this->value = preg_replace('/\s*(»)\s*/', ' $1 ', $this->value);
        $this->value = preg_replace('/\s*(“)\s*/', ' $1 ', $this->value);
        $this->value = preg_replace('/\s*(”)\s*/', ' $1 ', $this->value);

        // remove spaces
        $this->value = preg_replace('/\s*(\.|,|\.{3}|…)\s*/', '$1 ', $this->value);
        $this->value = trim($this->value);
        $this->value = preg_replace('/\s{2,}/', ' ', $this->value);

        // add non breaking spaces
        $this->value = preg_replace('/\s+(!|\?|;|:|-|"|’|%|\)|\}|\])/', self::NonBreakingSpace . '$1', $this->value);
        $this->value = preg_replace('/("|‘|\(|\{|\[)\s+/', '$1' . self::NonBreakingSpace, $this->value);
        $this->value = preg_replace('/(«)\s*/', '$1' . self::NonBreakingSpace, $this->value);
        $this->value = preg_replace('/\s*(»)/', self::NonBreakingSpace . '$1', $this->value);
        $this->value = preg_replace('/(“)\s*/', '$1' . self::NonBreakingSpace, $this->value);
        $this->value = preg_replace('/\s*(”)/', self::NonBreakingSpace . '$1', $this->value);

        return $this;
    }

    public function upperInitial(): self
    {
        $this->value = ltrim($this->value);
        $this->value = mb_strtoupper(mb_substr($this->value, 0, 1)) . mb_substr($this->value, 1);

        return $this;
    }

    public function lowerInitial(): self
    {
        $this->value = ltrim($this->value);
        $this->value = lcfirst($this->value);
        $this->value = mb_strtolower(mb_substr($this->value, 0, 1)) . mb_substr($this->value, 1);

        return $this;
    }

    public function upper(): self
    {
        $this->value = mb_strtoupper($this->value);

        return $this;
    }

    public function lower(): self
    {
        $this->value = mb_strtolower($this->value);

        return $this;
    }

    public function removeAccents(): self
    {
        $this->value = strtr(
            $this->value,
            [
                'Á'=>'A', 'À'=>'A', 'Â'=>'A', 'Ä'=>'A', 'Ã'=>'A', 'Ā'=>'A', 'Å'=>'A', 'Æ'=>'AE',
                'á'=>'a', 'à'=>'a', 'â'=>'a', 'ä'=>'a', 'ã'=>'a', 'ā'=>'a', 'å'=>'a', 'æ'=>'ae',
                'Þ'=>'B', 'ẞ'=>'SS',
                'þ'=>'b', 'ß'=>'ss',
                'Ç'=>'C',
                'ç'=>'c',
                'É'=>'E', 'È'=>'E', 'Ê'=>'E', 'Ë'=>'E', 'Ẽ'=>'E', 'Ē'=>'E', 'E̊'=>'E',
                'é'=>'e', 'è'=>'e', 'ê'=>'e', 'ë'=>'e', 'ẽ'=>'e', 'ē'=>'e', 'e̊'=>'e',
                'Í'=>'I', 'Ì'=>'I', 'Î'=>'I', 'Ï'=>'I', 'Ĩ'=>'I', 'Ī'=>'I', 'I̊'=>'I',
                'í'=>'i', 'ì'=>'i', 'î'=>'i', 'ï'=>'i', 'ĩ'=>'i', 'ī'=>'i', 'i̊'=>'i',
                'Ñ'=>'N',
                'ñ'=>'n',
                'Ó'=>'O', 'Ò'=>'O', 'Ô'=>'O', 'Ö'=>'O', 'Õ'=>'O', 'Ō'=>'O', 'O̊'=>'O', 'Ø'=>'O', 'Œ'=>'OE',
                'ó'=>'o', 'ò'=>'o', 'ô'=>'o', 'ö'=>'o', 'õ'=>'o', 'ō'=>'o', 'o̊'=>'o', 'ø'=>'o', 'œ'=>'oe', 'ð'=>'o',
                'Š'=>'S', 'š'=>'s',
                'Ú'=>'U', 'Ù'=>'U', 'Û'=>'U', 'Ü'=>'U', 'Ũ'=>'U', 'Ū'=>'U', 'Ů'=>'U',
                'ú'=>'u', 'ù'=>'u', 'û'=>'u', 'ü'=>'u', 'ũ'=>'u', 'ū'=>'u', 'ů'=>'u',
                'Ý'=>'Y', 'Ỳ'=>'Y', 'Ŷ'=>'Y', 'Ÿ'=>'Y', 'Ỹ'=>'Y', 'Ȳ'=>'Y', 'Y̊'=>'Y',
                'ý'=>'y', 'ỳ'=>'y', 'ŷ'=>'y', 'ÿ'=>'y', 'ỹ'=>'y', 'ȳ'=>'y', 'ẙ'=>'y',
                'Ž'=>'Z',
                'ž'=>'z',
            ]
        );

        return $this;
    }

    public function beginsWithVowel(): bool
    {
        $string = $this->value;
        $string = ltrim($string);
        $firstLetter = strtolower($string[0]);
        $firstLetter = (string) (new self($firstLetter))->removeAccents();

        return in_array($firstLetter, ['a','e','i','o','u','y']);
    }
}
