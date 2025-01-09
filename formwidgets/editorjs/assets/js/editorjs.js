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
        this.initEditor();
        this.initListeners();
    }

    disconnect()
    {
        this.editorjs.destroy();
        delete this.textarea;
        delete this.settings;
        delete this.tools;
        delete this.tunes;
        delete this.parameters;
    }

    initEditor()
    {
        this.textarea = document.querySelector('#' + this.element.getAttribute('data-textarea'));
        this.settings = JSON.parse(this.element.getAttribute('data-settings'));
        this.tools = JSON.parse(this.element.getAttribute('data-tools'));
        this.tunes = JSON.parse(this.element.getAttribute('data-tunes'));
        this.parameters = {
            holder: this.element.getAttribute('id'),
            placeholder: this.settings.placeholder ? this.settings.placeholder : 'Tell your story...',
            defaultBlock: this.settings.defaultBlock ? this.settings.defaultBlock : 'paragraph',
            autofocus: this.settings.autofocus,
            i18n: this.settings.i18n,
            tools: this.tools,
            tunes: this.tunes
        };

        console.log(this.parameters);

        // Parsing already existing data from textarea
        if (this.textarea.value.length > 0 && this.isJson(this.textarea.value) === true) {
            this.parameters.data = JSON.parse(this.textarea.value)
        }

        // Init all plugins from config
        for (let [key, value] of Object.entries(this.tools)) {
            if (typeof value === 'string') {
                this.tools[key] = window[value];
            } else {
                value.class = window[value.class];
            }
        }

        this.editorjs = new EditorJS(this.parameters);
    }

    initListeners()
    {
        window.addEventListener('ajax:setup', (event) =>{
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
        });
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
