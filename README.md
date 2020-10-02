## **Editor for OctoberCMS**

Meet the new Editor. The most advanced "WYSWYG" (if you can say so) editor ever.

### **Key features**

- It is a block-styled editor
- It returns clean data output in JSON
- Designed to be extendable and pluggable with a simple API
- Native OctoberCMS events support for convenient extending of custom blocks

**Integrations ready:**
- RainLab.Blog
- RainLab.StaticPages
- Lovata.GoodNews
- Indikator.News

**Blocks supported:**
- Paragraph
- Header
- List (ul, ol)
- CheckList
- Link (Opengraph)
- Table
- Code
- Raw
- Embed
- Delimiter
- Image (paste url, drag'n'drop, upload)

### **What does it mean «block-styled editor»**

Workspace in classic editors is made of a single contenteditable element, used to create different HTML markups. Editor workspace consists of separate Blocks: paragraphs, headings, images, lists, quotes, etc. Each of them is an independent contenteditable element (or more complex structure) provided by Plugin and united by Editor's Core.

There are dozens of ready-to-use Blocks and the simple API for creation any Block you need. For example, you can implement Blocks for Tweets, Instagram posts, surveys and polls, CTA-buttons and even games.

### **What does it mean clean data output**

Classic WYSIWYG-editors produce raw HTML-markup with both content data and content appearance. On the contrary, Editor.js outputs JSON object with data of each Block.

Given data can be used as you want: render with HTML for Web clients, render natively for mobile apps, create markup for Facebook Instant Articles or Google AMP, generate an audio version and so on.

## **How to install**

Install plugin by OctoberCMS plugin updater.

Go to Settings –> Updates&Plugins find EditorJS in plugin search. Click on icon and install it.

## **Usage**

After installing plugin, you are now able to set in `fields.yaml`  `type:editorjs` to any desirable field. That's all.
You are not limited of how many editors can be rendered at one page.

### How to enable integrations

1. Make sure that the desirable plugin for integration is installed in system (list of supported plugins listed in Key Features section) 
2. Go to Settings
3. In the sidebar find `Editor Settings` button inside `Editor tab`
4. Enable desirable integrations
5. Done.

### How to render HTML from Editor JSON
To implement Editor to your Model, you must prepare a column in a database that is set to text.

1. Create a column with type `text` at your Model table, or use an already existing one.
2. Add `'ReaZzon.Editor.Behaviors.ConvertToHtml'` to $implement attribute of your model.
3. Add **get<YourColumnName>HtmlAttribute()** method and paste line of code as in the example below:
```
return $this->convertJsonToHtml($this->YourColumnName);
```
4. Render your field `{{ model.YourColumnName_html|raw }}`
5. Add editor styles to your page by `<link href="/plugins/reazzon/editor/assets/css/editorjs.css" rel="stylesheet">`

Example of model:
```
// ...
class Post extends Model
{

    // ...

    public $implement = [
        'ReaZzon.Editor.Behaviors.ConvertToHtml'
    ];

    // ...

    public function getContentHtmlAttribute()
    {
        return $this->convertJsonToHtml($this->content);
    }
}
```
Example of rendering:
```
{{ post.content_html|raw }}
```

## **Extending**

You can create any new block as you like by reading official documentation that you can find here [Editor.Js docs](https://editorjs.io/api)

After creating new JS scripts with new block type Class, you can go through steps below to extend EditorJS formwidget:
1. Create new method in your Plugin.php file named `registerEditorBlocks()`, and by example below add blocks array and scripts for them.
    ```
    /**
     * Registers additional blocks for EditorJS
     * @return array
     */
    public function registerEditorBlocks()
    {
        return [
            'raw' => [
                'settings' => [
                    'class' => 'RawTool'
                ],
                'validation' => [
                    'html' => [
                        'type' => 'string',
                        'allowedTags' => '*',
                    ]
                ],
                'scripts' => [
                    '/plugins/reazzon/editor/formwidgets/editorjs/assets/js/tools/raw.js',
                ],
                'view' => 'reazzon.editor::blocks.raw'
            ],
        ];
    }
    ```
2. Done.

Now you can even publish your editorjs extender plugin to marketplace, so everyone can use your block!

---

Editor.js developed by CodeX Club of web-development.
Adapted for OctoberCMS by Nick Khaetsky. [reazzon.ru](https://reazzon.ru)
