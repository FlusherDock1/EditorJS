# Upgrade guide

- [Upgrading to 1.1 from 1.2](#upgrade-1.2)
- [Upgrading to 1.5.1 from 1.4](#upgrade-1.5.1)
- [Upgrading to 1.6.0 from 1.5.2](#upgrade-1.6.0)
- [Upgrading to 1.7.0 from 1.6.0](#upgrade-1.7.0)

<a name="upgrade-1.2"></a>
## Upgrading To 1.2

if you are not developing additional blocks for EditorJS, you can skip this instruction and safely update the plugin.


Version 1.2 brings new way to extend EditorJS completely abandoning events system.
For that you need to:
Instruction to upgrade:
1. Create new method `registerEditorBlocks()` in your Plugin.php
2. Move arrays with blocks and scripts to it like in example below
3. Done.

Before:
```
/**
 * Boot method, called right before the request route.
 *
 * @return array
 */
public function boot()
{
    \Event::listen('reazzon.editor.extend_editor_scripts', function (){
        return '/plugins/reazzon/testcontent/assets/js/raw.js';
    });
    \Event::listen('reazzon.editor.extend_editor_tools_config', function (){
        return [
            'raw' => [
                'class' => 'RawTool'
            ],
        ];
    });
}
```
After:
```
/**
 * Registers additional blocks for EditorJS
 * @return array
 */
public function registerEditorBlocks()
{
    return [
        'blocks' =>[
            'raw' => [
                'class' => 'RawTool'
            ],
        ],
        'scripts' => [
            '/plugins/reazzon/testcontent/assets/js/raw.js'
        ]
    ];
}
```

<a name="upgrade-1.5.1"></a>
## Upgrading To 1.5.1

You don't need your editorJS field to be jsonable. Remove it from $jsonable property of your model. Otherwise, your data will be corrupted.
## Upgrading To 1.6.0

In all your models where editorsjs field converts to html blocks you need to do these steps:

1. Remove ConvertEditor trait `use ConvertEditor;` from your model;
2. Add array property `$implement` and add to it `'ReaZzon.Editor.Behaviors.ConvertToHtml'`

    Example:
    ```
    class Post extends Model
    {
       // Remove use ConvertEditor;
       // ...

        public $implement = [
           'ReaZzon.Editor.Behaviors.ConvertToHtml'
        ];

       // ...
    }
    ```

3. That's it, now you can use your model as it was before.

## Upgrading To 1.7.0
Trait `ReaZzon\Editor\Traits\PluginHelper` is deprecated, please use standart Laravel Resources response and `ReaZzon\Editor\Classes\Exceptions\PluginErrorException` for throwing an error.

For third party frontend plugins, use `ReaZzon\Editor\Classes\Middlewares\PluginGroupMiddleware` to add standard access restrictions.

