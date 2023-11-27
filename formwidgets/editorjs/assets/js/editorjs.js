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

        this.editorjs = new EditorJS({
            holder: this.element.getAttribute('id'),
            placeholder: this.settings.placeholder ? this.settings.placeholder : 'Tell your story...',
            defaultBlock: this.settings.defaultBlock ? this.settings.defaultBlock : 'paragraph',
            autofocus: this.settings.autofocus,
            i18n: this.settings.i18n,
            tools: this.blockSettings,
            tunes: this.tunesSettings,
            inlineToolbar: this.inlineToolbarSettings,
            // onChange: () => {
            //     this.syncContent()
            // }
        });
    }

    initSettings() {
        this.settings = JSON.parse(this.element.getAttribute('data-settings'));
        this.blockSettings = JSON.parse(this.element.getAttribute('data-blocks-settings'));
        this.tunesSettings = JSON.parse(this.element.getAttribute('data-tunes-settings'));
        this.inlineToolbarSettings = JSON.parse(this.element.getAttribute('data-inlineToolbar-settings'));

        // Init all plugins from config
        for (let [key, value] of Object.entries(this.blockSettings)) {
            value.class = window[value.class];
        }
    }

    disconnect() {
        this.editorjs.destroy();
        delete this.settings;
        delete this.blockSettings;
        delete this.tunesSettings;
        delete this.inlineToolbarSettings;
    }
});
