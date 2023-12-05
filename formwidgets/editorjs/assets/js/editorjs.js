/*
 * Rich text editor with blocks form field control (WYSIWYG)
 *
 * Data attributes:
 * - data-control="reazzoneditorjs" - enables the editorjs plugin
 *
 */
'use strict';

oc.registerControl('reazzoneditorjs', class extends oc.ControlBase {
    connect() {
        this.initEditor();
        this.initListeners();
    }

    disconnect() {
        this.editorjs.destroy();
        delete this.settings;
        delete this.blocks;
        delete this.tunesSettings;
        delete this.inlineToolbarSettings;
    }

    initEditor() {
        this.textarea = document.querySelector('#' + this.element.getAttribute('data-textarea'));
        this.settings = JSON.parse(this.element.getAttribute('data-settings'));
        this.blocks = JSON.parse(this.element.getAttribute('data-blocks'));
        this.tunes = JSON.parse(this.element.getAttribute('data-tunes'));
        this.inlineToolbar = JSON.parse(this.element.getAttribute('data-inlineToolbars'));
        this.parameters = {
            holder: this.element.getAttribute('id'),
            placeholder: this.settings.placeholder ? this.settings.placeholder : 'Tell your story...',
            defaultBlock: this.settings.defaultBlock ? this.settings.defaultBlock : 'paragraph',
            autofocus: this.settings.autofocus,
            i18n: this.settings.i18n,
            tools: this.blocks,
            tunes: this.tunes,
            inlineToolbar: this.inlineToolbar,
            onChange: () => this.syncContent()
        };

        // Parsing already existing data from textarea
        if (this.textarea.value.length > 0 && this.isJson(this.textarea.value) === true) {
            this.parameters.data = JSON.parse(this.textarea.value)
        }

        // Init all plugins from config
        for (let [key, value] of Object.entries(this.blocks)) {
            value.class = window[value.class];
        }

        for (let [key, value] of Object.entries(this.tunes)) {
            value.class = window[value.class];
        }

        this.editorjs = new EditorJS(this.parameters);
    }

    initListeners() {
        // TODO pause onSave on page and call syncContent
        // window.addEventListener('ajax:request-start', (event) => {
        //     console.log(event);
        //     const { xhr } = event.detail;
        //     console.log(xhr);
        //     event.preventDefault();
        //     event.stopPropagation();
        // });
    }

    syncContent() {
        this.editorjs.save().then(outputData => {
            this.textarea.value = JSON.stringify(outputData);
        }).catch(error => console.log('editorjs - Error get content: ', error.message));
    }

    isJson(string) {
        try {
            JSON.parse(string);
        } catch (e) {
            return false;
        }
        return true;
    }
});
