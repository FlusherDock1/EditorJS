## **EditorJS for OctoberCMS**

This plugin enables [EditorJS](https://github.com/codex-team/editor.js) to be used as a form widget for your backend panel.
EditorJS is a versatile and modern content editor that stores content as JSON data, and renders it in any way you want.

### **Key features**

- It is a block-styled editor
- It returns clean data output in JSON
- Designed to be extendable and pluggable with a simple API
- Full compatibility with October CMS forms, use it with Tailor or anywhere else.
- Flexible extension base, you can create any blocks you need for your content.

**Integrations ready:**
- RainLab.Blog
- Lovata.GoodNews
- Tailor

**Blocks supported:**
- Text
- Header
- List
- Quote
- Image
- Attachment
- Table
- Code
- Warning
- Delimiter
- Raw HTML
- ... and any block that you want to create

### **What does it mean «block-styled editor»**

Workspace in classic editors is made of a single contenteditable element, used to create different HTML markups. Editor workspace consists of separate Blocks: paragraphs, headings, images, lists, quotes, etc. Each of them is an independent contenteditable element (or more complex structure) provided by Plugin and united by Editor's Core.

There are dozens of ready-to-use Blocks and the simple API for creation any Block you need. For example, you can implement Blocks for Tweets, Instagram posts, surveys and polls, CTA-buttons and even games.

### **What does it mean clean data output**

Classic WYSIWYG-editors produce raw HTML-markup with both content data and content appearance. On the contrary, Editor.js outputs JSON object with data of each Block.

Given data can be used as you want: render with HTML for Web clients, render natively for mobile apps, create markup for Facebook Instant Articles or Google AMP, generate an audio version and so on.

## **How to install**

You can install this plugin via October packet manager inside backend panel, or run command below:

```bash
php artisan plugin:install ReaZzon.Editor
```

## **Usage**

After installing plugin, you are now able to set in `fields.yaml`  `type: editorjs` to any desirable field.
You are not limited of how many editors can be rendered at one page.

### How to enable integrations

1. Make sure that the desirable plugin for integration is installed in system (list of supported plugins listed in Key Features section)
2. Go to Settings
3. Find `Editor` section and clock on `EditorJs Settings` button
4. Enable desirable integrations

### How to render HTML from EditorJS JSON

There are two ways of rendering EditorJS:

#### First: TWIG filter `|editorjs`

1. You have model with `type: editorjs` field.
2. Inside your theme use `|editorjs` filter to convert JSON data to html.
    ```twig
   {{ post.content|editorjs }}
    ```

#### Second: Accessor inside your model

For example, you have **content** field, that has editorjs json data.

1. Create accessor in your model. Note that your accessor should have different name.

    ```php
    public function getContentHtmlAttribute()
    {
        return \ReaZzon\Editor\Classes\JSONConverter::convertAndGetHTML($this->content);
    }
    ```
2. Use new attribute to render html wherever you want.
    ```twig
    {{ post.content_html }}
    ```

## **Create your own block**

Blocks are called Tools in EditorJS ecosystem.

First, you need to follow official documentation of [EditorJs](https://editorjs.io/api) and compile yourself js file with new tool.

After you got yours JS file, you can register it like all other tools registered inside **tools** folder.

1. Create new plugin
    ```bash
    php artisan create:plugin Acme.Foo
    ```
2. Create new file: /acme/foo/tools/ExampleTool.php
    ```php
    <?php namespace Acme\Foo\Tools;

    use ReaZzon\Editor\Classes\Tool;

    class ExampleTool extends Tool
    {
        public function registerSettings(): array
        {
            return [
                'class' => 'Example'
            ];
        }

        public function registerValidations(): array
        {
            return [
                'value' => [
                    'type' => 'string'
                ]
            ];
        }

        public function registerScripts(): array
        {
            return [
                '/acme/foo/assets/js/exampleTool.js'
            ];
        }

        public function registerView(): ?string
        {
            return 'acme.foo::blocks.example';
        }
    }
    ```
3. Create view file with html of your block: `/acme/foo/views/blocks/example.htm`
    ```twig
    <div class="my-example-block">
        {{ value }} {# any data you have inside your block #}
    </div>
    ```
4. Put your compiled JS file inside `assets/js` folder, and name it accordingly, example `exampleTool.js`
5. Register your new tool inside Plugin.php of your plugin
    ```php
    /**
     * registerEditorJsBlocks extension blocks for EditorJs
     */
    public function registerEditorJsTools(): array
    {
        return [
            \Acme\Foo\Tools\ExampleTool::class => 'example',
        ];
    }
    ```
6. Done! Your tool added to all editorjs.

---

Editor.js developed by CodeX Club of web-development.
Adapted for OctoberCMS by Nick Khaetsky. [reazzon.ru](https://reazzon.ru)
