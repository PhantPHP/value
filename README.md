# Value

## Requirements

PHP >= 8.1


## Install

`composer require phant/value`


## Usages

### 
```php
use Phant\Value\Handler\Text;

$sentence = ' Yesterday they opened a new «café» ,  would you like to go there? ';

echo (new Text($sentence))->testBeginsWithVowel() ? 'yes' : 'no'; // "yes"

echo (new Text($sentence))->removeUselessSpaces(); // "Yesterday they opened a new «café» , would you like to go there?"

echo (new Text($sentence))->removeAccents(); // " Yesterday they opened a new «cafe» ,would you like to go there? "

echo (new Text($sentence))->useNonBreakingSpaces(); // "Yesterday they opened a new « café », would you like to go there ?"

echo (new Text($sentence))->makeTypographicSpaces(); // "Yesterday they opened a new « café », would you like to go there ?"

echo (new Text($sentence))->upperInitial(); // "Yesterday they opened a new «café» ,would you like to go there? "

echo (new Text($sentence))->lowerInitial(); // "yesterday they opened a new «café» ,would you like to go there? "

echo (new Text($sentence))->upper(); // " YESTERDAY THEY OPENED A NEW «CAFÉ» ,WOULD YOU LIKE TO GO THERE? "

echo (new Text($sentence))->lower(); // " yesterday they opened a new «café» ,would you like to go there? "

```