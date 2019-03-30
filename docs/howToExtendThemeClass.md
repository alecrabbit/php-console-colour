### How to extend `Theme::class`
If you want to add theme methods you need to create your own class `MyTheme` or whatever name you want.

Let's say we want to add `fire` and `lagoon` themes
```php
/**
 * @method fire(string $text)
 * @method lagoon(string $text)
 */
class MyTheme extends Theme
{
    // These strings are used as methods names
    public const FIRE = 'fire';
    public const LAGOON = 'lagoon';

    public const MY_THEMES = [
        // name => [styles],
        self::FIRE => [Styles::LIGHT_RED, Styles::BOLD, Styles::BG_WHITE, Styles::ITALIC],
        self::LAGOON => [Styles::LIGHT_BLUE, Styles::BG_BLACK, Styles::UNDERLINE],
    ];

    /**
     * @return array
     */
    protected function prepareThemes(): array
    {
        return \array_merge(self::MY_THEMES, parent::prepareThemes());
    }
}
```

And that's it! 
