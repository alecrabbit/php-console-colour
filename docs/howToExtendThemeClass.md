### How to extend `Theme::class`
If you want to add theme methods you need to create your own class `MyTheme` or whatever name you want.

Let's say you want to add `fire`, `lagoon`, `blink` and `alert` themes
```php
/**
 * @method fire(string $text)
 * @method lagoon(string $text)
 * @method blink(string $text)
 * @method alert(string $text)
 */
class MyThemes extends Themes
{
    // These strings are used as methods names
    public const FIRE = 'fire';
    public const LAGOON = 'lagoon';
    public const BLINK = 'blink';
    public const ALERT = 'alert';

    public const MY_STYLES = [
        // name => [styles],
        self::FIRE => [Color::LIGHT_RED, Effect::BOLD, BG::LIGHT_YELLOW, Effect::ITALIC],
        self::LAGOON => [Color::BLACK, BG::LIGHT_BLUE, Effect::UNDERLINE],
        self::BLINK => [Effect::BLINK, Color::LIGHT_CYAN],
        // You can use interface `Styles` to define your theme
        self::ALERT => [Styles::BLINK, Styles::WHITE, Styles::BG_LIGHT_RED],
    ];

    /**
     * @return array
     */
    protected function prepareThemes(): array
    {
        return \array_merge(self::MY_STYLES, parent::prepareThemes());
    }
}
```

And that's it! 
