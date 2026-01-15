# Custom Icon Shortcut Plugin

A DokuWiki plugin that provides a simple syntax shortcut for displaying icons from a remote icon repository.

## Description

The Custom Icon Shortcut Plugin translates `{{customicon>iconname}}` syntax into an `<img>` tag, making it easy to display icons throughout your wiki without writing full HTML image tags.

## Features

- Simple syntax: `{{customicon>iconname}}`
- Configurable icon base URL and file extension
- Automatic fallback to a help icon if the requested icon doesn't exist
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

Navigate to **Admin → Configuration Settings → Custom Icon Plugin** to configure:

- **Icon Base URL**: The base URL where your icons are hosted (default: `https://assets.kriss.run/icons/silk/png/`)
- **Icon Extension**: The file extension for your icons (default: `.png`)

### Default Configuration

- Base URL: `https://assets.kriss.run/icons/silk/png/`
- Extension: `.png`

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

If an icon doesn't exist at the configured URL, the plugin automatically falls back to displaying a help icon (`help.png`) instead. This prevents broken image links.

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
