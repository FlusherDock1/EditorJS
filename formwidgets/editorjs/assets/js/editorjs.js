/*
 * Rich text editor with blocks form field control (WYSIWYG)
 *
 * Data attributes:
 * - data-control="reazzon-editorjs" - enables the editorjs plugin
 *
 */
oc.registerControl('reazzon-editorjs', class extends oc.ControlBase {
    connect()
    {
        this.textarea = document.getElementById(this.element.getAttribute('data-textarea'));
        this.editorjs = this.getEditor();

        addEventListener('ajax:setup', this.proxy(this.onSavePage));
    }

    disconnect()
    {
        removeEventListener('ajax:setup', this.proxy(this.onSavePage));
        this.editorjs.destroy();
        delete this.textarea;
        delete this.editorjs;
    }

    getEditor()
    {
        let settings = JSON.parse(this.element.getAttribute('data-settings')),
            tools = JSON.parse(this.element.getAttribute('data-tools')),
            tunes = JSON.parse(this.element.getAttribute('data-tunes')),
            parameters = {
                holder: this.element.getAttribute('id'),
                placeholder: settings.placeholder ? settings.placeholder : 'Tell your story...',
                defaultBlock: settings.defaultBlock ? settings.defaultBlock : 'paragraph',
                autofocus: settings.autofocus,
                i18n: settings.i18n,
                tools: tools,
                tunes: tunes
        };

        // Parsing already existing data from textarea
        if (this.textarea.value.length > 0 && this.isJson(this.textarea.value) === true) {
            parameters.data = JSON.parse(this.textarea.value)
        }

        // Init all plugins from config
        for (let [key, value] of Object.entries(tools)) {
            if (typeof value === 'string') {
                tools[key] = window[value];
            } else {
                value.class = window[value.class];
            }
        }

        return new EditorJS(parameters);
    }

    onSavePage(event)
    {
        const { context } = event.detail;

        // Catch onSave handler
        if (context.handler === 'onSave') {
            const { options } = context;

            // Prevent recursion
            if (options.editorjsTick === true) {
                return;
            }

            // Stop ajax request
            event.preventDefault();
            options.editorjsTick = true;

            // Output editorjs content to textarea and call onSave request again
            this.editorjs.save().then(outputData => {
                this.textarea.value = JSON.stringify(outputData);
                event.detail.promise = oc.request(context.el, context.handler, options);
            });
        }
    }

    isJson(string)
    {
        try {
            JSON.parse(string);
        } catch (e) {
            return false;
        }
        return true;
    }
});
