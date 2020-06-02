/*
 * Rich text editor with blocks form field control (WYSIWYG)
 *
 * Data attributes:
 * - data-control="editor" - enables the editorjs plugin
 *
 * JavaScript API:
 * $('input').editor()
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
        this.$el = $(element)
        this.$form = this.$el.closest('form')
        this.$textarea = this.$el.find('>textarea:first')
        this.$editor = null
        this.prevented = false
        this.saving = false

        $.oc.foundation.controlUtils.markDisposable(element)

        Base.call(this)

        this.init()
    }

    Editor.prototype = Object.create(BaseProto)
    Editor.prototype.constructor = Editor

    Editor.prototype.init = function () {
        this.initEditorJS();
        this.$form.on('oc.beforeRequest', this.proxy(this.onFormBeforeRequest))
    }

    /*
     * Instantly synchronizes HTML content.
     */
    Editor.prototype.onFormBeforeRequest = function (e) {

        if (!this.$editor) {
            return
        }

        if (this.prevented === false){
            this.prevented = true;
            e.preventDefault();
        }

        if (this.prevented === true && this.saving === false) {
            this.$editor.save().then((outputData) => {
                this.$textarea.val(JSON.stringify(outputData))
                this.saving = true;
                this.$form.request('onSave',{
                    data: {
                        redirect: 0,
                    }
                });
            }).catch((error) => {
                console.log('Saving failed: ', error)
            });
        }
    }


    Editor.prototype.initEditorJS = function (){
        this.$editor = new EditorJS({
            holder: this.$el.attr('id'),
            placeholder: this.$el.data('placeholder') ? this.$el.data('placeholder') : 'Tell your story...',
            tools: {
                header: {
                    class: Header,
                    shortcut: 'CMD+SHIFT+H',
                },
                Marker: {
                    class: Marker,
                    shortcut: 'CMD+SHIFT+M',
                },
                linkTool: {
                    class: LinkTool,
                    config: {
                        endpoint: '/editorjs/plugins/linkTool',
                    }
                },
                list: {
                    class: List,
                    inlineToolbar: true,
                },
                checklist: {
                    class: Checklist,
                    inlineToolbar: true,
                },
                table: {
                    class: Table,
                    inlineToolbar: true,
                    config: {
                        rows: 2,
                        cols: 3,
                    },
                },
                code: CodeTool,
            },
            data: JSON.parse(this.$textarea.val())
        });
    }

    // Editor PLUGIN DEFINITION
    // ============================

    var old = $.fn.Editor

    $.fn.Editor = function (option) {
        var args = Array.prototype.slice.call(arguments, 1), result
        this.each(function () {
            var $this = $(this)
            var data = $this.data('oc.Editor')
            var options = $.extend({}, Editor.DEFAULTS, $this.data(), typeof option == 'object' && option)
            if (!data) $this.data('oc.Editor', (data = new Editor(this, options)))
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
        $('[data-control="editor"]').Editor();
    })

}(window.jQuery);