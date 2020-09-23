/*
 * Rich text editor with blocks form field control (WYSIWYG)
 *
 * Data attributes:
 * - data-control="mleditor" - enables the editorjs plugin
 *
 * JavaScript API:
 * $('div#id').mleditor()
 *
 */

+function ($) {
    "use strict";
    var Base = $.oc.foundation.base,
        BaseProto = Base.prototype

    // Editor CLASS DEFINITION
    // ============================

    var MLEditor = function (element, options) {
        this.options = options
        this.$el = $(element)
        this.parameters = null
        this.$form = this.$el.closest('form')
        this.$textarea = $(options.textareaElement)
        this.$editor = null
        this.$editorjs = $('[data-control=editorjs]:first', this.$el)
        this.toolSettings = this.$el.data('settings')
        this.$locale = $('[data-editor-active-locale]', this.$el)
        this.oldLocale = null;
        this.currentLocale = this.$locale.val();
        $.oc.foundation.controlUtils.markDisposable(element)

        Base.call(this)

        this.init()
    }

    MLEditor.prototype = Object.create(BaseProto)
    MLEditor.prototype.constructor = MLEditor

    MLEditor.prototype.init = function () {
        this.$el.multiLingual()

        this.$el.on('setLocale.oc.multilingual', this.proxy(this.onSetLocale))
        this.$textarea.on('syncContent.oc.editorjs', this.proxy(this.onSyncContent))
        this.$el.one('dispose-control', this.proxy(this.dispose))
    }

    MLEditor.prototype.dispose = function () {
        this.$el.off('setLocale.oc.multilingual', this.proxy(this.onSetLocale))

        this.$el.off('dispose-control', this.proxy(this.dispose))

        this.$el.removeData('oc.mlRichEditor')

        this.$textarea = null
        this.$editorjs = null
        this.$el = null

        this.options = null

        BaseProto.dispose.call(this)
    }

    MLEditor.prototype.onSetLocale = function (e, locale, localeValue) {
        if (typeof localeValue === 'string' && this.$editorjs.data('oc.editorjs')) {
            const editor = this.$editorjs.data('oc.editorjs').$editor;

            // setLocales
            this.oldLocale = this.$locale.val();
            this.currentLocale = locale;
            this.$locale.val(this.currentLocale);

            editor.clear();

            let jsonData = null;

            // setPrepare
            if (localeValue !== '') {
                try {
                    jsonData = JSON.parse(localeValue);
                } catch (e) {
                    console.log('editorjs - Error parse content: ', e.message);
                }
            }

            if (jsonData === null) return;
            editor.blocks.render(jsonData);
        }
    }

    MLEditor.prototype.onSyncContent = function (ev, editor, data) {
        this.$el.multiLingual('setLocaleValue', JSON.stringify(data), this.currentLocale);
    }

    MLEditor.prototype.isJson = function (string) {
        try {
            JSON.parse(string);
        } catch (e) {
            return false;
        }
        return true;
    }

    // Editor PLUGIN DEFINITION
    // ============================

    var old = $.fn.MLEditor

    $.fn.MLEditor = function (option) {
        var args = Array.prototype.slice.call(arguments, 1), result
        this.each(function () {
            var $this = $(this)
            var data = $this.data('oc.editorjs')
            var options = $.extend({}, MLEditor.DEFAULTS, $this.data(), typeof option == 'object' && option)
            if (!data) $this.data('oc.editorjs', (data = new MLEditor(this, options)))
            if (typeof option == 'string') result = data[option].apply(data, args)
            if (typeof result != 'undefined') return false
        })

        return result ? result : this
    }

    $.fn.MLEditor.Constructor = MLEditor

    // Editor NO CONFLICT
    // =================

    $.fn.MLEditor.noConflict = function () {
        $.fn.MLEditor = old
        return this
    }

    // Editor DATA-API
    // ===============

    $(document).render(function () {
        $('[data-control="mleditorjs"]').MLEditor();
    })

}(window.jQuery);