typeof exports === 'undefined' ? exports = {} : null;
"use strict";

function _classPrivateMethodInitSpec(t, e) {
    _checkPrivateRedeclaration(t, e), e.add(t)
}

function _defineProperty(t, e, s) {
    return e in t ? Object.defineProperty(t, e, {
        value: s,
        enumerable: !0,
        configurable: !0,
        writable: !0
    }) : t[e] = s, t
}

function _classPrivateMethodGet(t, e, s) {
    if (!e.has(t)) throw new TypeError("attempted to get private field on non-instance");
    return s
}

function _classPrivateFieldInitSpec(t, e, s) {
    _checkPrivateRedeclaration(t, e), e.set(t, s)
}

function _checkPrivateRedeclaration(t, e) {
    if (e.has(t)) throw new TypeError("Cannot initialize the same private elements twice on an object")
}

function _classPrivateFieldSet(t, e, s) {
    return _classApplyDescriptorSet(t, _classExtractFieldDescriptor(t, e, "set"), s), s
}

function _classApplyDescriptorSet(t, e, s) {
    if (e.set) e.set.call(t, s); else {
        if (!e.writable) throw new TypeError("attempted to set read only private field");
        e.value = s
    }
}

function _classPrivateFieldGet(t, e) {
    return _classApplyDescriptorGet(t, _classExtractFieldDescriptor(t, e, "get"))
}

function _classExtractFieldDescriptor(t, e, s) {
    if (!e.has(t)) throw new TypeError("attempted to " + s + " private field on non-instance");
    return e.get(t)
}

function _classApplyDescriptorGet(t, e) {
    return e.get ? e.get.call(t) : e.value
}

Object.defineProperty(exports, "__esModule", {value: !0}), exports.default = void 0;
var _count = new WeakMap;

class Toast {
    constructor() {
        _classPrivateFieldInitSpec(this, _count, {writable: !0, value: 0})
    }

    show({
             type: t,
             icon: e = "",
             title: s,
             subtitle: a = "",
             content: o = "",
             buttons: i = [],
             delay: n = 0,
             dismissible: r = !0
         }) {
        _classPrivateFieldSet(this, _count, 1 + +_classPrivateFieldGet(this, _count));
        const l = Bs5Utils.defaults.styles[t], d = l.btnClose.join(" "), c = l.border,
            b = document.createElement("div");
        b.setAttribute("id", `toast-${_classPrivateFieldGet(this, _count)}`), b.setAttribute("role", "alert"), b.setAttribute("aria-live", "assertive"), b.setAttribute("aria-atomic", "true"), b.classList.add("toast", "align-items-center"), c.forEach(t => {
            b.classList.add(t)
        });
        let u = "", m = [];
        Array.isArray(i) && i.length && (u += `<div class="d-flex justify-content-center mt-2 pt-2 border-top ${c.join(" ")}">`, i.forEach((t, e) => {
            switch (t.type || "button") {
                case"dismiss":
                    u += `<button type="button" class="${t.class}" data-bs-dismiss="toast">${t.text}</button>&nbsp;`;
                    break;
                default:
                    let s = `toast-${_classPrivateFieldGet(this, _count)}-button-${e}`;
                    u += `<button type="button" id="${s}" class="${t.class}">${t.text}</button>&nbsp;`, t.hasOwnProperty("handler") && "function" == typeof t.handler && m.push({
                        id: s,
                        handler: t.handler
                    })
            }
        }), u += "</div>"), b.innerHTML = `<div class="toast-header ${l.main.join(" ")}">\n                            ${e}\n                            <strong class="me-auto">${s}</strong>\n                            <small>${a}</small>\n                            ${r ? `<button type="button" class="btn-close ${d}" data-bs-dismiss="toast" aria-label="Close"></button>` : ""}\n                        </div>\n                        <div class="toast-body">\n                            ${o}\n                            ${u}\n                        </div>`, Bs5Utils.defaults.toasts.stacking || document.querySelectorAll(`#${Bs5Utils.defaults.toasts.container} .toast`).forEach(t => {
            t.remove()
        }), document.querySelector(`#${Bs5Utils.defaults.toasts.container}`).appendChild(b), b.addEventListener("hidden.bs.toast", function (t) {
            t.target.remove()
        }), m.forEach(t => {
            document.getElementById(t.id).addEventListener("click", t.handler)
        });
        const h = {autohide: n > 0 && "number" == typeof n};
        n > 0 && "number" == typeof n && (h.delay = n);
        const p = new bootstrap.Toast(b, h);
        return p.show(), p
    }
}

var _count2 = new WeakMap;

class Snack {
    constructor() {
        _classPrivateFieldInitSpec(this, _count2, {writable: !0, value: 0})
    }

    show(t, e, s = 0, a = !0) {
        _classPrivateFieldSet(this, _count2, 1 + +_classPrivateFieldGet(this, _count2));
        const o = Bs5Utils.defaults.styles[t], i = o.btnClose.join(" "), n = document.createElement("div");
        n.classList.add("toast", "align-items-center", "border-0", "text-white"), o.main.forEach(t => {
            n.classList.add(t)
        }), n.setAttribute("id", `snack-${_classPrivateFieldGet(this, _count2)}`), n.setAttribute("role", "alert"), n.setAttribute("aria-live", "assertive"), n.setAttribute("aria-atomic", "true"), n.innerHTML = `<div class="d-flex">\n                        <div class="toast-body">${e}</div>\n                        ${a ? `<button type="button" class="btn-close ${i} me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>` : ""}\n                      </div>`, Bs5Utils.defaults.toasts.stacking || document.querySelectorAll(`#${Bs5Utils.defaults.toasts.container} .toast`).forEach(t => {
            t.remove()
        }), document.querySelector(`#${Bs5Utils.defaults.toasts.container}`).appendChild(n), n.addEventListener("hidden.bs.toast", function (t) {
            t.target.remove()
        });
        const r = {autohide: s > 0 && "number" == typeof s};
        s > 0 && "number" == typeof s && (r.delay = s);
        const l = new bootstrap.Toast(n, r);
        return l.show(), l
    }
}

var _count3 = new WeakMap;

class Modal {
    constructor() {
        _classPrivateFieldInitSpec(this, _count3, {writable: !0, value: 0})
    }

    show({
             type: t,
             title: e = "",
             content: s = "",
             buttons: a = [],
             centered: o = !1,
             dismissible: i = !0,
             backdrop: n = !!i || "static",
             keyboard: r = i,
             focus: l = !0,
             fullscreen: d = !1,
             size: c = ""
         }) {
        _classPrivateFieldSet(this, _count3, 1 + +_classPrivateFieldGet(this, _count3)), c = ["sm", "lg", "xl"].includes(c) ? `modal-${c}` : "", d = d ? "modal-fullscreen" : "", o = o ? "modal-dialog-centered modal-dialog-scrollable" : "";
        const b = Bs5Utils.defaults.styles[t], u = b.btnClose.join(" "), m = b.border,
            h = document.createElement("div");
        h.setAttribute("id", `modal-${_classPrivateFieldGet(this, _count3)}`), h.setAttribute("tabindex", "-1"), h.classList.add("modal");
        let p = "", v = [];
        Array.isArray(a) && a.length && (p += `<div class="modal-footer ${m.join(" ")}">`, a.forEach((t, e) => {
            switch (t.type || "button") {
                case"dismiss":
                    p += `<button type="button" class="${t.class}" data-bs-dismiss="modal">${t.text}</button>`;
                    break;
                default:
                    let s = `modal-${_classPrivateFieldGet(this, _count3)}-button-${e}`;
                    p += `<button type="button" id="${s}" class="${t.class}">${t.text}</button>`, t.hasOwnProperty("handler") && "function" == typeof t.handler && v.push({
                        id: s,
                        handler: t.handler
                    })
            }
        }), p += "</div>"), h.innerHTML = ` <div class="modal-dialog ${o} ${d} ${c}">\n                                <div class="modal-content border-0">\n                                  ${e.length ? `<div class="modal-header border-0 ${b.main.join(" ")}">\n                                    <h5 class="modal-title">${e}</h5>\n                                    ${i ? `<button type="button" class="btn-close ${u}" data-bs-dismiss="modal" aria-label="Close"></button>` : ""}\n                                  </div>` : ""}\n                                  ${s.length ? `<div class="modal-body">${s}</div>` : ""}\n                                  ${p}\n                                </div>\n                              </div>`, document.body.appendChild(h), h.addEventListener("hidden.bs.modal", function (t) {
            t.target.remove()
        }), v.forEach(t => {
            document.getElementById(t.id).addEventListener("click", t.handler)
        });
        const f = {backdrop: n, keyboard: r, focus: l}, y = new bootstrap.Modal(h, f);
        return y.show(), y
    }
}

var _createToastContainer = new WeakSet;

class Bs5Utils {
    constructor() {
        _classPrivateMethodInitSpec(this, _createToastContainer), _classPrivateMethodGet(this, _createToastContainer, _createToastContainer2).call(this), this.Toast = new Toast, this.Snack = new Snack, this.Modal = new Modal
    }

    static registerStyle(t, e) {
        if ("object" != typeof e && Array.isArray(e)) throw"The styles parameter must be an object when you register component style.";
        Bs5Utils.defaults.styles[t] = e
    }
}

function _createToastContainer2() {
    let t = document.querySelector(`#${Bs5Utils.defaults.toasts.container}`);
    if (!t) {
        const e = {
            "top-left": "top-0 start-0 ms-1 mt-1",
            "top-center": "top-0 start-50 translate-middle-x mt-1",
            "top-right": "top-0 end-0 me-1 mt-1",
            "middle-left": "top-50 start-0 translate-middle-y ms-1",
            "middle-center": "top-50 start-50 translate-middle p-3",
            "middle-right": "top-50 end-0 translate-middle-y me-1",
            "bottom-left": "bottom-0 start-0 ms-1 mb-1",
            "bottom-center": "bottom-0 start-50 translate-middle-x mb-1",
            "bottom-right": "bottom-0 end-0 me-1 mb-1"
        };
        (t = document.createElement("div")).classList.add("position-relative"), t.setAttribute("aria-live", "polite"), t.setAttribute("aria-atomic", "true"), t.innerHTML = `<div id="${Bs5Utils.defaults.toasts.container}" class="toast-container position-fixed pb-1 ${e[Bs5Utils.defaults.toasts.position] || e["top-right"]}"></div>`, document.body.appendChild(t)
    }
}

exports.default = Bs5Utils, _defineProperty(Bs5Utils, "defaults", {
    toasts: {
        position: "top-right",
        container: "toast-container",
        stacking: !0
    },
    styles: {
        secondary: {
            btnClose: ["btn-close-white"],
            main: ["text-white", "bg-secondary"],
            border: ["border-secondary"]
        },
        light: {btnClose: [], main: ["text-dark", "bg-light", "border-bottom", "border-dark"], border: ["border-dark"]},
        white: {btnClose: [], main: ["text-dark", "bg-white", "border-bottom", "border-dark"], border: ["border-dark"]},
        dark: {btnClose: ["btn-close-white"], main: ["text-white", "bg-dark"], border: ["border-dark"]},
        info: {btnClose: ["btn-close-white"], main: ["text-white", "bg-info"], border: ["border-info"]},
        primary: {btnClose: ["btn-close-white"], main: ["text-white", "bg-primary"], border: ["border-primary"]},
        success: {btnClose: ["btn-close-white"], main: ["text-white", "bg-success"], border: ["border-success"]},
        warning: {btnClose: ["btn-close-white"], main: ["text-white", "bg-warning"], border: ["border-warning"]},
        danger: {btnClose: ["btn-close-white"], main: ["text-white", "bg-danger"], border: ["border-danger"]}
    }
});
