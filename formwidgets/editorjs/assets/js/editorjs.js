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
        this.initSettings();
        this.initListeners();

        this.editorjs = new EditorJS(this.parameters);
    }

    initSettings() {
        this.textarea = document.querySelector('#' + this.element.getAttribute('data-textarea'));
        this.settings = JSON.parse(this.element.getAttribute('data-settings'));
        this.blockSettings = JSON.parse(this.element.getAttribute('data-blocks-settings'));
        this.tunesSettings = JSON.parse(this.element.getAttribute('data-tunes-settings'));
        this.inlineToolbarSettings = JSON.parse(this.element.getAttribute('data-inlineToolbar-settings'));
        this.parameters = {
            holder: this.element.getAttribute('id'),
            placeholder: this.settings.placeholder ? this.settings.placeholder : 'Tell your story...',
            defaultBlock: this.settings.defaultBlock ? this.settings.defaultBlock : 'paragraph',
            autofocus: this.settings.autofocus,
            i18n: this.settings.i18n,
            tools: this.blockSettings,
            tunes: this.tunesSettings,
            inlineToolbar: this.inlineToolbarSettings,
            onChange: () => this.syncContent()
        };

        // Parsing already existing data from textarea
        if (this.textarea.value.length > 0 && this.isJson(this.textarea.value) === true) {
            this.parameters.data = JSON.parse(this.textarea.value)
        }

        // Init all plugins from config
        for (let [key, value] of Object.entries(this.blockSettings)) {
            value.class = window[value.class];
        }
    }

    initListeners() {
        window.addEventListener('ajax:before-send', (event) => {
            console.log(event);
            const { options, promise } = event.detail;

            console.log(options);
            console.log(promise);
        });
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

    disconnect() {
        this.editorjs.destroy();
        delete this.settings;
        delete this.blockSettings;
        delete this.tunesSettings;
        delete this.inlineToolbarSettings;
    }
});
