(function(){"use strict";try{if(typeof document<"u"){var e=document.createElement("style");e.appendChild(document.createTextNode(`.cdx-warning{position:relative}@media all and (min-width: 736px){.cdx-warning{padding-left:36px}}.cdx-warning [contentEditable=true][data-placeholder]:before{position:absolute;content:attr(data-placeholder);color:#707684;font-weight:400;opacity:0}.cdx-warning [contentEditable=true][data-placeholder]:empty:before{opacity:1}.cdx-warning [contentEditable=true][data-placeholder]:empty:focus:before{opacity:0}.cdx-warning:before{content:"";background-image:url("data:image/svg+xml,%3Csvg width='24' height='24' viewBox='0 0 24 24' fill='none' xmlns='http://www.w3.org/2000/svg'%3E%3Crect x='5' y='5' width='14' height='14' rx='4' stroke='black' stroke-width='2'/%3E%3Cline x1='12' y1='9' x2='12' y2='12' stroke='black' stroke-width='2' stroke-linecap='round'/%3E%3Cpath d='M12 15.02V15.01' stroke='black' stroke-width='2' stroke-linecap='round'/%3E%3C/svg%3E");width:24px;height:24px;background-size:24px 24px;position:absolute;margin-top:8px;left:0}@media all and (max-width: 735px){.cdx-warning:before{display:none}}.cdx-warning__message{min-height:85px}.cdx-warning__title{margin-bottom:6px}`)),document.head.appendChild(e)}}catch(t){console.error("vite-plugin-css-injected-by-js",t)}})();
const n = '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24"><rect width="14" height="14" x="5" y="5" stroke="currentColor" stroke-width="2" rx="4"/><line x1="12" x2="12" y1="9" y2="12" stroke="currentColor" stroke-linecap="round" stroke-width="2"/><path stroke="currentColor" stroke-linecap="round" stroke-width="2" d="M12 15.02V15.01"/></svg>';
class r {
  /**
   * Notify core that read-only mode is supported
   */
  static get isReadOnlySupported() {
    return !0;
  }
  /**
   * Get Toolbox settings
   *
   * @public
   * @returns {string}
   */
  static get toolbox() {
    return {
      icon: n,
      title: "Warning"
    };
  }
  /**
   * Allow to press Enter inside the Warning
   *
   * @public
   * @returns {boolean}
   */
  static get enableLineBreaks() {
    return !0;
  }
  /**
   * Default placeholder for warning title
   *
   * @public
   * @returns {string}
   */
  static get DEFAULT_TITLE_PLACEHOLDER() {
    return "Title";
  }
  /**
   * Default placeholder for warning message
   *
   * @public
   * @returns {string}
   */
  static get DEFAULT_MESSAGE_PLACEHOLDER() {
    return "Message";
  }
  /**
   * Warning Tool`s styles
   *
   * @returns {object}
   */
  get CSS() {
    return {
      baseClass: this.api.styles.block,
      wrapper: "cdx-warning",
      title: "cdx-warning__title",
      input: this.api.styles.input,
      message: "cdx-warning__message"
    };
  }
  /**
   * Render plugin`s main Element and fill it with saved data
   *
   * @param {WarningData} data — previously saved data
   * @param {WarningConfig} config — user config for Tool
   * @param {object} api - Editor.js API
   * @param {boolean} readOnly - read-only mode flag
   */
  constructor({ data: e, config: t, api: s, readOnly: i }) {
    this.api = s, this.readOnly = i, this.titlePlaceholder = t.titlePlaceholder || r.DEFAULT_TITLE_PLACEHOLDER, this.messagePlaceholder = t.messagePlaceholder || r.DEFAULT_MESSAGE_PLACEHOLDER, this.data = {
      title: e.title || "",
      message: e.message || ""
    };
  }
  /**
   * Create Warning Tool container with inputs
   *
   * @returns {Element}
   */
  render() {
    const e = this._make("div", [this.CSS.baseClass, this.CSS.wrapper]), t = this._make("div", [this.CSS.input, this.CSS.title], {
      contentEditable: !this.readOnly,
      innerHTML: this.data.title
    }), s = this._make("div", [this.CSS.input, this.CSS.message], {
      contentEditable: !this.readOnly,
      innerHTML: this.data.message
    });
    return t.dataset.placeholder = this.titlePlaceholder, s.dataset.placeholder = this.messagePlaceholder, e.appendChild(t), e.appendChild(s), e;
  }
  /**
   * Extract Warning data from Warning Tool element
   *
   * @param {HTMLDivElement} warningElement - element to save
   * @returns {WarningData}
   */
  save(e) {
    const t = e.querySelector(`.${this.CSS.title}`), s = e.querySelector(`.${this.CSS.message}`);
    return Object.assign(this.data, {
      title: t.innerHTML,
      message: s.innerHTML
    });
  }
  /**
   * Helper for making Elements with attributes
   *
   * @param  {string} tagName           - new Element tag name
   * @param  {Array|string} classNames  - list or name of CSS classname(s)
   * @param  {object} attributes        - any attributes
   * @returns {Element}
   */
  _make(e, t = null, s = {}) {
    const i = document.createElement(e);
    Array.isArray(t) ? i.classList.add(...t) : t && i.classList.add(t);
    for (const a in s)
      i[a] = s[a];
    return i;
  }
  /**
   * Sanitizer config for Warning Tool saved data
   *
   * @returns {object}
   */
  static get sanitize() {
    return {
      title: {},
      message: {}
    };
  }
}
export {
  r as default
};
