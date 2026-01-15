# Custom Icon Shortcut Plugin

A DokuWiki plugin that provides a simple syntax shortcut for displaying icons from a remote icon repository.

## Description

The Custom Icon Shortcut Plugin translates `{{customicon>iconname}}` syntax into an `<img>` tag, making it easy to display icons throughout your wiki without writing full HTML image tags.

## Features

- Simple syntax: `{{customicon>iconname}}`
- Configurable icon base URL and file extension
- Customizable fallback icon when requested icon doesn't exist
- Configurable CSS class for styling
- Optional icon sizing (width/height)
- Optional title attribute for tooltips
- Optional lazy loading for better performance
- Input sanitization for security
- Works with CommonMark plugin
- Helper function for use in PHP blocks

## Installation

### Via Git

```bash
cd lib/plugins/
git clone https://github.com/Darknetzz/dokuwiki-customicon.git customicon
```

### Manual Installation

1. Download the plugin from [GitHub](https://github.com/Darknetzz/dokuwiki-customicon)
2. Extract to `lib/plugins/customicon/`
3. The plugin should be automatically recognized by DokuWiki

## Configuration

Navigate to **Admin → Configuration Settings → Custom Icon Shortcut Plugin** to configure:

### Core Settings

- **Icon Base URL**: The base URL where your icons are hosted (default: `https://assets.kriss.run/icons/silk/png/`)
- **Icon Extension**: The file extension for your icons (default: `.png`)

### Appearance Settings

- **Fallback Icon**: Icon name to use when the requested icon fails to load (default: `help`)
- **Icon Class**: CSS class applied to all icons (default: `plugin_customicon`)
- **Icon Size**: Size in pixels for width and height attributes. Leave empty for no size constraint (default: empty)

### Behavior Settings

- **Icon Title**: Enable to add a `title` attribute with the icon name for tooltips (default: enabled)
- **Lazy Load**: Enable to add `loading="lazy"` attribute for lazy loading images (default: disabled)

### Default Configuration

- Base URL: `https://assets.kriss.run/icons/silk/png/`
- Extension: `.png`
- Fallback Icon: `help`
- Icon Class: `plugin_customicon`
- Icon Size: (empty - no size constraint)
- Icon Title: Enabled
- Lazy Load: Disabled

## Usage

### Basic Syntax

Simply use the syntax in your wiki pages:

```
{{customicon>house}}
```

This will render an image from: `https://assets.kriss.run/icons/silk/png/house.png`

### Examples

```
{{customicon>check}}     - Checkmark icon
{{customicon>cross}}     - Cross/X icon
{{customicon>help}}      - Help/question icon
{{customicon>shield}}    - Shield icon
{{customicon>arrow_refresh}} - Refresh arrow icon
```

### In Lists

```
  * {{customicon>house}} [[start|Home]]
  * {{customicon>computer}} [[servers:start|Servers]]
```

### With CommonMark Plugin

The plugin works seamlessly with the CommonMark plugin. Use `<!DOCTYPE markdown>` at the top of your page and the syntax will work:

```markdown
<!DOCTYPE markdown>

Here's an icon: {{customicon>house}}
```

### In HTML Blocks

When using HTML blocks, you can use the helper function in PHP blocks:

```html
<html>
<table>
<tr><td><PHP>
$plugin = plugin_load('syntax', 'customicon');
echo $plugin ? $plugin->getIconHTML('house') : '';
</PHP></td><td>Home</td></tr>
</table>
</html>
```

## Fallback Behavior

If an icon doesn't exist at the configured URL, the plugin automatically falls back to displaying the configured fallback icon (default: `help.png`) instead. This prevents broken image links. The fallback icon can be customized in the plugin configuration.

## Styling

You can style icons using CSS by targeting the configured icon class (default: `plugin_customicon`). For example:

```css
.plugin_customicon {
    vertical-align: middle;
    margin-right: 5px;
    opacity: 0.8;
}

.plugin_customicon:hover {
    opacity: 1.0;
}
```

If you've configured a custom icon class in the plugin settings, use that class name instead.

## Security

The plugin sanitizes all icon names by:
- Trimming whitespace
- Removing any characters except alphanumeric, underscore, and hyphen
- Preventing path traversal attacks

## Compatibility

- **DokuWiki**: Compatible with recent DokuWiki versions
- **CommonMark Plugin**: Fully compatible
- **HTML Blocks**: Works with htmlok plugin using PHP blocks

## Repository

- **GitHub**: https://github.com/Darknetzz/dokuwiki-customicon
- **Author**: Kristian Røste
- **Email**: dokuwiki@roste.org

## License

This plugin is released under the same license as DokuWiki (GPL 2).

## Support

For issues, feature requests, or contributions, please visit the [GitHub repository](https://github.com/Darknetzz/dokuwiki-customicon).
