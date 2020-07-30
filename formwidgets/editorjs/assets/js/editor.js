/*
 * Rich text editor with blocks form field control (WYSIWYG)
 *
 * Data attributes:
 * - data-control="editor" - enables the editorjs plugin
 *
 * JavaScript API:
 * $('div#id').editor()
 *
 */

+function ($) {
    "use strict";
    var Base = $.oc.foundation.base,
        BaseProto = Base.prototype

    // Editor CLASS DEFINITION
    // ============================

    var Editor = function (element, options) {
        this.options = options
        this.prevented = false
        this.saving = false
        this.$el = $(element)
        this.$form = this.$el.closest('form')
        this.$textarea = this.$el.find('>textarea:first')
        this.$editor = null
        this.toolSettings = this.$el.data('settings')

        $.oc.foundation.controlUtils.markDisposable(element)

        Base.call(this)

        this.init()
    }

    Editor.prototype = Object.create(BaseProto)
    Editor.prototype.constructor = Editor

    Editor.prototype.init = function () {
        this.initEditorJS();
        this.$form.on('oc.beforeRequest', this.proxy(this.syncContent))
    }

    Editor.prototype.initEditorJS = function (){

        // Init all plugin classes from config
        for (let [key, value] of Object.entries(this.toolSettings)) {
            value.class = window[value.class];
        }

        // Parameters for EditorJS
        let parameters = {
            holder: this.$el.attr('id'),
            placeholder: this.$el.data('placeholder') ? this.$el.data('placeholder') : 'Tell your story...',
            tools: this.toolSettings
        }

        // Parsing already existing data from textarea
        if (this.$textarea.val().length > 0 && this.isJson(this.$textarea.val()) === true){
            parameters.data = JSON.parse(this.$textarea.val())
        }

        this.$editor = new EditorJS(parameters);
    }

    Editor.prototype.dispose = function() {
        this.unregisterHandlers()

        this.$textarea.Editor('destroy')

        this.$el.removeData('oc.editorjs')

        this.options = null
        this.prevented = null
        this.saving = null
        this.$el = null
        this.$form = null
        this.$textarea = null
        this.$editor = null
        this.toolSettings = null

        BaseProto.dispose.call(this)
    }

    /*
     * Instantly synchronizes HTML content.
     */
    Editor.prototype.syncContent = function (e) {
        console.log(e);
        this.$editor.save().then((outputData) => {
            this.$textarea.val(JSON.stringify(outputData))
        }).catch((error) => {
            console.log('Saving failed: ', error)
        });
    }

    Editor.prototype.unregisterHandlers = function() {
        this.$form.off('oc.beforeRequest', this.proxy(this.syncContent))
        this.$el.off('dispose-control', this.proxy(this.dispose))
    }

    Editor.prototype.isJson = function (string) {
        try {
            JSON.parse(string);
        } catch (e) {
            return false;
        }
        return true;
    }

    // Editor PLUGIN DEFINITION
    // ============================

    var old = $.fn.Editor

    $.fn.Editor = function (option) {
        var args = Array.prototype.slice.call(arguments, 1), result
        this.each(function () {
            var $this = $(this)
            var data = $this.data('oc.editorjs')
            var options = $.extend({}, Editor.DEFAULTS, $this.data(), typeof option == 'object' && option)
            if (!data) $this.data('oc.editorjs', (data = new Editor(this, options)))
            if (typeof option == 'string') result = data[option].apply(data, args)
            if (typeof result != 'undefined') return false
        })

        return result ? result : this
    }

    $.fn.Editor.Constructor = Editor

    // Editor NO CONFLICT
    // =================

    $.fn.Editor.noConflict = function () {
        $.fn.Editor = old
        return this
    }

    // Editor DATA-API
    // ===============

    $(document).render(function () {
        $('[data-control="editorjs"]').Editor();
    })

}(window.jQuery);