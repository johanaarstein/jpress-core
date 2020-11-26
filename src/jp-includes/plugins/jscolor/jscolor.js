window.jscolor || (window.jscolor = function() {
  var e, t, n, r, o, i = {
    register: function() {
        i.attachDOMReadyEvent(i.init), i.attachEvent(document, "mousedown", i.onDocumentMouseDown), i.attachEvent(document, "touchstart", i.onDocumentTouchStart), i.attachEvent(window, "resize", i.onWindowResize)
    },
    init: function() {
        i.jscolor.lookupClass && i.jscolor.installByClassName(i.jscolor.lookupClass)
    },
    tryInstallOnElements: function(e, t) {
      for (var n = new RegExp("(^|\\s)(" + t + ")(\\s*(\\{[^}]*\\})|\\s|$)", "i"), r = 0; r < e.length; r += 1) {
        var o;
        if (void 0 === e[r].type || "color" != e[r].type.toLowerCase() || !i.isColorAttrSupported) {
          if (!e[r].jscolor && e[r].className && (o = e[r].className.match(n))) {
            var s = e[r],
                l = null,
                a = i.getDataAttr(s, "jscolor");
            null !== a ? l = a : o[4] && (l = o[4]);
            var d = {};
            if (l) try {
                d = new Function("return (" + l + ")")()
            } catch (e) {
                i.warn("Error parsing jscolor options: " + e + ":\n" + l)
            }
            s.jscolor = new i.jscolor(s, d)
          }
        }
      }
    },
    isColorAttrSupported: (o = document.createElement("input"), !(!o.setAttribute || (o.setAttribute("type", "color"), "color" != o.type.toLowerCase()))),
    isCanvasSupported: function() {
        var e = document.createElement("canvas");
        return !(!e.getContext || !e.getContext("2d"))
    }(),
    fetchElement: function(e) {
        return "string" == typeof e ? document.getElementById(e) : e
    },
    isElementType: function(e, t) {
        return e.nodeName.toLowerCase() === t.toLowerCase()
    },
    getDataAttr: function(e, t) {
        var n = "data-" + t,
            r = e.getAttribute(n);
        return null !== r ? r : null
    },
    attachEvent: function(e, t, n) {
        e.addEventListener ? e.addEventListener(t, n, !1) : e.attachEvent && e.attachEvent("on" + t, n)
    },
    detachEvent: function(e, t, n) {
        e.removeEventListener ? e.removeEventListener(t, n, !1) : e.detachEvent && e.detachEvent("on" + t, n)
    },
    _attachedGroupEvents: {},
    attachGroupEvent: function(e, t, n, r) {
        i._attachedGroupEvents.hasOwnProperty(e) || (i._attachedGroupEvents[e] = []), i._attachedGroupEvents[e].push([t, n, r]), i.attachEvent(t, n, r)
    },
    detachGroupEvents: function(e) {
        if (i._attachedGroupEvents.hasOwnProperty(e)) {
            for (var t = 0; t < i._attachedGroupEvents[e].length; t += 1) {
                var n = i._attachedGroupEvents[e][t];
                i.detachEvent(n[0], n[1], n[2])
            }
            delete i._attachedGroupEvents[e]
        }
    },
    attachDOMReadyEvent: function(e) {
        var t = !1,
            n = function() {
                t || (t = !0, e())
            };
        if ("complete" !== document.readyState) {
            if (document.addEventListener) document.addEventListener("DOMContentLoaded", n, !1), window.addEventListener("load", n, !1);
            else if (document.attachEvent && (document.attachEvent("onreadystatechange", function() {
                    "complete" === document.readyState && (document.detachEvent("onreadystatechange", arguments.callee), n())
                }), window.attachEvent("onload", n), document.documentElement.doScroll && window == window.top)) {
                var r = function() {
                    if (document.body) try {
                        document.documentElement.doScroll("left"), n()
                    } catch (e) {
                        setTimeout(r, 1)
                    }
                };
                r()
            }
        } else setTimeout(n, 1)
    },
    warn: function(e) {
        window.console && window.console.warn && window.console.warn(e)
    },
    preventDefault: function(e) {
        e.preventDefault && e.preventDefault(), e.returnValue = !1
    },
    captureTarget: function(e) {
        e.setCapture && (i._capturedTarget = e, i._capturedTarget.setCapture())
    },
    releaseTarget: function() {
        i._capturedTarget && (i._capturedTarget.releaseCapture(), i._capturedTarget = null)
    },
    fireEvent: function(e, t) {
        if (e)
            if (document.createEvent) {
                let n = document.createEvent("HTMLEvents");
                n.initEvent(t, !0, !0), e.dispatchEvent(n)
            } else if (document.createEventObject) {
            let n = document.createEventObject();
            e.fireEvent("on" + t, n)
        } else e["on" + t] && e["on" + t]()
    },
    classNameToList: function(e) {
        return e.replace(/^\s+|\s+$/g, "").split(/\s+/)
    },
    hasClass: function(e, t) {
        return !!t && -1 != (" " + e.className.replace(/\s+/g, " ") + " ").indexOf(" " + t + " ")
    },
    setClass: function(e, t) {
        for (var n = i.classNameToList(t), r = 0; r < n.length; r += 1) i.hasClass(e, n[r]) || (e.className += (e.className ? " " : "") + n[r])
    },
    unsetClass: function(e, t) {
        for (var n = i.classNameToList(t), r = 0; r < n.length; r += 1) {
            var o = new RegExp("^\\s*" + n[r] + "\\s*|\\s*" + n[r] + "\\s*$|\\s+" + n[r] + "(\\s+)", "g");
            e.className = e.className.replace(o, "$1")
        }
    },
    getStyle: function(e) {
        return window.getComputedStyle ? window.getComputedStyle(e) : e.currentStyle
    },
    setStyle: (t = document.createElement("div"), n = function(e) {
        for (var n = 0; n < e.length; n += 1)
            if (e[n] in t.style) return e[n]
    }, r = {
        borderRadius: n(["borderRadius", "MozBorderRadius", "webkitBorderRadius"]),
        boxShadow: n(["boxShadow", "MozBoxShadow", "webkitBoxShadow"])
    }, function(e, t, n) {
        switch (t.toLowerCase()) {
            case "opacity":
                var o = Math.round(100 * parseFloat(n));
                e.style.opacity = n, e.style.filter = "alpha(opacity=" + o + ")";
                break;
            default:
                e.style[r[t]] = n
        }
    }),
    setBorderRadius: function(e, t) {
        i.setStyle(e, "borderRadius", t || "0")
    },
    setBoxShadow: function(e, t) {
        i.setStyle(e, "boxShadow", t || "none")
    },
    getElementPos: function(e, t) {
        var n = 0,
            r = 0,
            o = e.getBoundingClientRect();
        if (n = o.left, r = o.top, !t) {
            var s = i.getViewPos();
            n += s[0], r += s[1]
        }
        return [n, r]
    },
    getElementSize: function(e) {
        return [e.offsetWidth, e.offsetHeight]
    },
    getAbsPointerPos: function(e) {
        e || (e = window.event);
        var t = 0,
            n = 0;
        return void 0 !== e.changedTouches && e.changedTouches.length ? (t = e.changedTouches[0].clientX, n = e.changedTouches[0].clientY) : "number" == typeof e.clientX && (t = e.clientX, n = e.clientY), {
            x: t,
            y: n
        }
    },
    getRelPointerPos: function(e) {
        e || (e = window.event);
        var t = (e.target || e.srcElement).getBoundingClientRect(),
            n = 0,
            r = 0;
        return void 0 !== e.changedTouches && e.changedTouches.length ? (n = e.changedTouches[0].clientX, r = e.changedTouches[0].clientY) : "number" == typeof e.clientX && (n = e.clientX, r = e.clientY), {
            x: n - t.left,
            y: r - t.top
        }
    },
    getViewPos: function() {
        var e = document.documentElement;
        return [(window.pageXOffset || e.scrollLeft) - (e.clientLeft || 0), (window.pageYOffset || e.scrollTop) - (e.clientTop || 0)]
    },
    getViewSize: function() {
        var e = document.documentElement;
        return [window.innerWidth || e.clientWidth, window.innerHeight || e.clientHeight]
    },
    redrawPosition: function() {
        if (i.picker && i.picker.owner) {
            var e, t, n = i.picker.owner;
            n.fixed ? (e = i.getElementPos(n.targetElement, !0), t = [0, 0]) : (e = i.getElementPos(n.targetElement), t = i.getViewPos());
            var r, o, s, l = i.getElementSize(n.targetElement),
                a = i.getViewSize(),
                d = i.getPickerOuterDims(n);
            switch (n.position.toLowerCase()) {
                case "left":
                    r = 1, o = 0, s = -1;
                    break;
                case "right":
                    r = 1, o = 0, s = 1;
                    break;
                case "top":
                    r = 0, o = 1, s = -1;
                    break;
                default:
                    r = 0, o = 1, s = 1
            }
            var c = (l[o] + d[o]) / 2;
            if (n.smartPosition) h = [-t[r] + e[r] + d[r] > a[r] && -t[r] + e[r] + l[r] / 2 > a[r] / 2 && e[r] + l[r] - d[r] >= 0 ? e[r] + l[r] - d[r] : e[r], -t[o] + e[o] + l[o] + d[o] - c + c * s > a[o] ? -t[o] + e[o] + l[o] / 2 > a[o] / 2 && e[o] + l[o] - c - c * s >= 0 ? e[o] + l[o] - c - c * s : e[o] + l[o] - c + c * s : e[o] + l[o] - c + c * s >= 0 ? e[o] + l[o] - c + c * s : e[o] + l[o] - c - c * s];
            else var h = [e[r], e[o] + l[o] - c + c * s];
            var p = h[r],
                u = h[o],
                m = n.fixed ? "fixed" : "absolute",
                v = (h[0] + d[0] > e[0] || h[0] < e[0] + l[0]) && h[1] + d[1] < e[1] + l[1];
            i._drawPosition(n, p, u, m, v)
        }
    },
    _drawPosition: function(e, t, n, r, o) {
        var s = o ? 0 : e.shadowBlur;
        i.picker.wrap.style.position = r, i.picker.wrap.style.left = t + "px", i.picker.wrap.style.top = n + "px", i.setBoxShadow(i.picker.boxS, e.shadow ? new i.BoxShadow(0, s, e.shadowBlur, 0, e.shadowColor) : null)
    },
    getPickerDims: function(e) {
        var t = !!i.getSliderComponent(e);
        return [2 * e.insetWidth + 2 * e.padding + e.width + (t ? 2 * e.insetWidth + i.getPadToSliderPadding(e) + e.sliderSize : 0), 2 * e.insetWidth + 2 * e.padding + e.height + (e.closable ? 2 * e.insetWidth + e.padding + e.buttonHeight : 0)]
    },
    getPickerOuterDims: function(e) {
        var t = i.getPickerDims(e);
        return [t[0] + 2 * e.borderWidth, t[1] + 2 * e.borderWidth]
    },
    getPadToSliderPadding: function(e) {
        return Math.max(e.padding, 1.5 * (2 * e.pointerBorderWidth + e.pointerThickness))
    },
    getPadYComponent: function(e) {
        switch (e.mode.charAt(1).toLowerCase()) {
            case "v":
                return "v"
        }
        return "s"
    },
    getSliderComponent: function(e) {
        if (e.mode.length > 2) switch (e.mode.charAt(2).toLowerCase()) {
            case "s":
                return "s";
            case "v":
                return "v"
        }
        return null
    },
    onDocumentMouseDown: function(e) {
        e || (e = window.event);
        var t = e.target || e.srcElement;
        t._jscLinkedInstance ? t._jscLinkedInstance.showOnClick && t._jscLinkedInstance.show() : t._jscControlName ? i.onControlPointerStart(e, t, t._jscControlName, "mouse") : i.picker && i.picker.owner && i.picker.owner.hide()
    },
    onDocumentTouchStart: function(e) {
        e || (e = window.event);
        var t = e.target || e.srcElement;
        t._jscLinkedInstance ? t._jscLinkedInstance.showOnClick && t._jscLinkedInstance.show() : t._jscControlName ? i.onControlPointerStart(e, t, t._jscControlName, "touch") : i.picker && i.picker.owner && i.picker.owner.hide()
    },
    onWindowResize: function(e) {
        i.redrawPosition()
    },
    onParentScroll: function(e) {
        i.picker && i.picker.owner && i.picker.owner.hide()
    },
    _pointerMoveEvent: {
        mouse: "mousemove",
        touch: "touchmove"
    },
    _pointerEndEvent: {
        mouse: "mouseup",
        touch: "touchend"
    },
    _pointerOrigin: null,
    _capturedTarget: null,
    onControlPointerStart: function(e, t, n, r) {
        var o = t._jscInstance;
        i.preventDefault(e), i.captureTarget(t);
        var s = function(o, s) {
            i.attachGroupEvent("drag", o, i._pointerMoveEvent[r], i.onDocumentPointerMove(e, t, n, r, s)), i.attachGroupEvent("drag", o, i._pointerEndEvent[r], i.onDocumentPointerEnd(e, t, n, r))
        };
        if (s(document, [0, 0]), window.parent && window.frameElement) {
            var l = window.frameElement.getBoundingClientRect(),
                a = [-l.left, -l.top];
            s(window.parent.window.document, a)
        }
        var d = i.getAbsPointerPos(e),
            c = i.getRelPointerPos(e);
        switch (i._pointerOrigin = {
            x: d.x - c.x,
            y: d.y - c.y
        }, n) {
            case "pad":
                switch (i.getSliderComponent(o)) {
                    case "s":
                        0 === o.hsv[1] && o.fromHSV(null, 100, null);
                        break;
                    case "v":
                        0 === o.hsv[2] && o.fromHSV(null, null, 100)
                }
                i.setPad(o, e, 0, 0);
                break;
            case "sld":
                i.setSld(o, e, 0)
        }
        i.dispatchFineChange(o)
    },
    onDocumentPointerMove: function(e, t, n, r, o) {
        return function(e) {
            var r = t._jscInstance;
            switch (n) {
                case "pad":
                    e || (e = window.event), i.setPad(r, e, o[0], o[1]), i.dispatchFineChange(r);
                    break;
                case "sld":
                    e || (e = window.event), i.setSld(r, e, o[1]), i.dispatchFineChange(r)
            }
        }
    },
    onDocumentPointerEnd: function(e, t, n, r) {
        return function(e) {
            var n = t._jscInstance;
            i.detachGroupEvents("drag"), i.releaseTarget(), i.dispatchChange(n)
        }
    },
    dispatchChange: function(e) {
        e.valueElement && i.isElementType(e.valueElement, "input") && i.fireEvent(e.valueElement, "change")
    },
    dispatchFineChange: function(e) {
        e.onFineChange && ("string" == typeof e.onFineChange ? new Function(e.onFineChange) : e.onFineChange).call(e)
    },
    setPad: function(e, t, n, r) {
        var o = i.getAbsPointerPos(t),
            s = n + o.x - i._pointerOrigin.x - e.padding - e.insetWidth,
            l = r + o.y - i._pointerOrigin.y - e.padding - e.insetWidth,
            a = s * (360 / (e.width - 1)),
            d = 100 - l * (100 / (e.height - 1));
        switch (i.getPadYComponent(e)) {
            case "s":
                e.fromHSV(a, d, null, i.leaveSld);
                break;
            case "v":
                e.fromHSV(a, null, d, i.leaveSld)
        }
    },
    setSld: function(e, t, n) {
        var r = 100 - (n + i.getAbsPointerPos(t).y - i._pointerOrigin.y - e.padding - e.insetWidth) * (100 / (e.height - 1));
        switch (i.getSliderComponent(e)) {
            case "s":
                e.fromHSV(null, r, null, i.leavePad);
                break;
            case "v":
                e.fromHSV(null, null, r, i.leavePad)
        }
    },
    _vmlNS: "jsc_vml_",
    _vmlCSS: "jsc_vml_css_",
    _vmlReady: !1,
    initVML: function() {
        if (!i._vmlReady) {
            var e = document;
            if (e.namespaces[i._vmlNS] || e.namespaces.add(i._vmlNS, "urn:schemas-microsoft-com:vml"), !e.styleSheets[i._vmlCSS]) {
                var t = ["shape", "shapetype", "group", "background", "path", "formulas", "handles", "fill", "stroke", "shadow", "textbox", "textpath", "imagedata", "line", "polyline", "curve", "rect", "roundrect", "oval", "arc", "image"],
                    n = e.createStyleSheet();
                n.owningElement.id = i._vmlCSS;
                for (var r = 0; r < t.length; r += 1) n.addRule(i._vmlNS + "\\:" + t[r], "behavior:url(#default#VML);")
            }
            i._vmlReady = !0
        }
    },
    createPalette: function() {
        var e = {
            elm: null,
            draw: null
        };
        if (i.isCanvasSupported) {
            var t = document.createElement("canvas"),
                n = t.getContext("2d");
            let r = function(e, r, o) {
                t.width = e, t.height = r, n.clearRect(0, 0, t.width, t.height);
                var i = n.createLinearGradient(0, 0, t.width, 0);
                i.addColorStop(0, "#F00"), i.addColorStop(1 / 6, "#FF0"), i.addColorStop(2 / 6, "#0F0"), i.addColorStop(.5, "#0FF"), i.addColorStop(4 / 6, "#00F"), i.addColorStop(5 / 6, "#F0F"), i.addColorStop(1, "#F00"), n.fillStyle = i, n.fillRect(0, 0, t.width, t.height);
                var s = n.createLinearGradient(0, 0, 0, t.height);
                switch (o.toLowerCase()) {
                    case "s":
                        s.addColorStop(0, "rgba(255,255,255,0)"), s.addColorStop(1, "rgba(255,255,255,1)");
                        break;
                    case "v":
                        s.addColorStop(0, "rgba(0,0,0,0)"), s.addColorStop(1, "rgba(0,0,0,1)")
                }
                n.fillStyle = s, n.fillRect(0, 0, t.width, t.height)
            };
            e.elm = t, e.draw = r
        } else {
            i.initVML();
            var r = document.createElement("div");
            r.style.position = "relative", r.style.overflow = "hidden";
            var o = document.createElement(i._vmlNS + ":fill");
            o.type = "gradient", o.method = "linear", o.angle = "90", o.colors = "16.67% #F0F, 33.33% #00F, 50% #0FF, 66.67% #0F0, 83.33% #FF0";
            var s = document.createElement(i._vmlNS + ":rect");
            s.style.position = "absolute", s.style.left = "-1px", s.style.top = "-1px", s.stroked = !1, s.appendChild(o), r.appendChild(s);
            var l = document.createElement(i._vmlNS + ":fill");
            l.type = "gradient", l.method = "linear", l.angle = "180", l.opacity = "0";
            var a = document.createElement(i._vmlNS + ":rect");
            a.style.position = "absolute", a.style.left = "-1px", a.style.top = "-1px", a.stroked = !1, a.appendChild(l), r.appendChild(a);
            let t = function(e, t, n) {
                switch (r.style.width = e + "px", r.style.height = t + "px", s.style.width = a.style.width = e + 1 + "px", s.style.height = a.style.height = t + 1 + "px", o.color = "#F00", o.color2 = "#F00", n.toLowerCase()) {
                    case "s":
                        l.color = l.color2 = "#FFF";
                        break;
                    case "v":
                        l.color = l.color2 = "#000"
                }
            };
            e.elm = r, e.draw = t
        }
        return e
    },
    createSliderGradient: function() {
        var e = {
            elm: null,
            draw: null
        };
        if (i.isCanvasSupported) {
            var t = document.createElement("canvas"),
                n = t.getContext("2d");
            let r = function(e, r, o, i) {
                t.width = e, t.height = r, n.clearRect(0, 0, t.width, t.height);
                var s = n.createLinearGradient(0, 0, 0, t.height);
                s.addColorStop(0, o), s.addColorStop(1, i), n.fillStyle = s, n.fillRect(0, 0, t.width, t.height)
            };
            e.elm = t, e.draw = r
        } else {
            i.initVML();
            var r = document.createElement("div");
            r.style.position = "relative", r.style.overflow = "hidden";
            var o = document.createElement(i._vmlNS + ":fill");
            o.type = "gradient", o.method = "linear", o.angle = "180";
            var s = document.createElement(i._vmlNS + ":rect");
            s.style.position = "absolute", s.style.left = "-1px", s.style.top = "-1px", s.stroked = !1, s.appendChild(o), r.appendChild(s);
            let t = function(e, t, n, i) {
                r.style.width = e + "px", r.style.height = t + "px", s.style.width = e + 1 + "px", s.style.height = t + 1 + "px", o.color = n, o.color2 = i
            };
            e.elm = r, e.draw = t
        }
        return e
    },
    leaveValue: 1,
    leaveStyle: 2,
    leavePad: 4,
    leaveSld: 8,
    BoxShadow: (e = function(e, t, n, r, o, i) {
        this.hShadow = e, this.vShadow = t, this.blur = n, this.spread = r, this.color = o, this.inset = !!i
    }, e.prototype.toString = function() {
        var e = [Math.round(this.hShadow) + "px", Math.round(this.vShadow) + "px", Math.round(this.blur) + "px", Math.round(this.spread) + "px", this.color];
        return this.inset && e.push("inset"), e.join(" ")
    }, e),
    jscolor: function(e, t) {
        for (var n in this.value = null, this.valueElement = e, this.styleElement = e, this.required = !0, this.refine = !0, this.hash = !1, this.uppercase = !0, this.onFineChange = null, this.activeClass = "jscolor-active", this.overwriteImportant = !1, this.minS = 0, this.maxS = 100, this.minV = 0, this.maxV = 100, this.hsv = [0, 0, 100], this.rgb = [255, 255, 255], this.width = 181, this.height = 101, this.showOnClick = !0, this.mode = "HSV", this.position = "bottom", this.smartPosition = !0, this.sliderSize = 16, this.crossSize = 8, this.closable = !1, this.closeText = "Close", this.buttonColor = "#000000", this.buttonHeight = 18, this.padding = 12, this.backgroundColor = "#FFFFFF", this.borderWidth = 1, this.borderColor = "#BBBBBB", this.borderRadius = 8, this.insetWidth = 1, this.insetColor = "#BBBBBB", this.shadow = !0, this.shadowBlur = 15, this.shadowColor = "rgba(0,0,0,0.2)", this.pointerColor = "#4C4C4C", this.pointerBorderColor = "#FFFFFF", this.pointerBorderWidth = 1, this.pointerThickness = 2, this.zIndex = 1e3, this.container = null, t) t.hasOwnProperty(n) && (this[n] = t[n]);

        function r(e, t, n) {
            var r = n / 100 * 255;
            if (null === e) return [r, r, r];
            e /= 60, t /= 100;
            var o = Math.floor(e),
                i = r * (1 - t),
                s = r * (1 - t * (o % 2 ? e - o : 1 - (e - o)));
            switch (o) {
                case 6:
                case 0:
                    return [r, s, i];
                case 1:
                    return [s, r, i];
                case 2:
                    return [i, r, s];
                case 3:
                    return [i, s, r];
                case 4:
                    return [s, i, r];
                case 5:
                    return [r, i, s]
            }
        }

        function o() {
            h._processParentElementsInDOM(), i.picker || (i.picker = {
                owner: null,
                wrap: document.createElement("div"),
                box: document.createElement("div"),
                boxS: document.createElement("div"),
                boxB: document.createElement("div"),
                pad: document.createElement("div"),
                padB: document.createElement("div"),
                padM: document.createElement("div"),
                padPal: i.createPalette(),
                cross: document.createElement("div"),
                crossBY: document.createElement("div"),
                crossBX: document.createElement("div"),
                crossLY: document.createElement("div"),
                crossLX: document.createElement("div"),
                sld: document.createElement("div"),
                sldB: document.createElement("div"),
                sldM: document.createElement("div"),
                sldGrad: i.createSliderGradient(),
                sldPtrS: document.createElement("div"),
                sldPtrIB: document.createElement("div"),
                sldPtrMB: document.createElement("div"),
                sldPtrOB: document.createElement("div"),
                btn: document.createElement("div"),
                btnT: document.createElement("span")
            }, i.picker.pad.appendChild(i.picker.padPal.elm), i.picker.padB.appendChild(i.picker.pad), i.picker.cross.appendChild(i.picker.crossBY), i.picker.cross.appendChild(i.picker.crossBX), i.picker.cross.appendChild(i.picker.crossLY), i.picker.cross.appendChild(i.picker.crossLX), i.picker.padB.appendChild(i.picker.cross), i.picker.box.appendChild(i.picker.padB), i.picker.box.appendChild(i.picker.padM), i.picker.sld.appendChild(i.picker.sldGrad.elm), i.picker.sldB.appendChild(i.picker.sld), i.picker.sldB.appendChild(i.picker.sldPtrOB), i.picker.sldPtrOB.appendChild(i.picker.sldPtrMB), i.picker.sldPtrMB.appendChild(i.picker.sldPtrIB), i.picker.sldPtrIB.appendChild(i.picker.sldPtrS), i.picker.box.appendChild(i.picker.sldB), i.picker.box.appendChild(i.picker.sldM), i.picker.btn.appendChild(i.picker.btnT), i.picker.box.appendChild(i.picker.btn), i.picker.boxB.appendChild(i.picker.box), i.picker.wrap.appendChild(i.picker.boxS), i.picker.wrap.appendChild(i.picker.boxB));
            var e, t, n = i.picker,
                r = !!i.getSliderComponent(h),
                o = i.getPickerDims(h),
                a = 2 * h.pointerBorderWidth + h.pointerThickness + 2 * h.crossSize,
                d = i.getPadToSliderPadding(h),
                c = Math.min(h.borderRadius, Math.round(h.padding * Math.PI));
            n.wrap.style.clear = "both", n.wrap.style.width = o[0] + 2 * h.borderWidth + "px", n.wrap.style.height = o[1] + 2 * h.borderWidth + "px", n.wrap.style.zIndex = h.zIndex, n.box.style.width = o[0] + "px", n.box.style.height = o[1] + "px", n.boxS.style.position = "absolute", n.boxS.style.left = "0", n.boxS.style.top = "0", n.boxS.style.width = "100%", n.boxS.style.height = "100%", i.setBorderRadius(n.boxS, c + "px"), n.boxB.style.position = "relative", n.boxB.style.border = h.borderWidth + "px solid", n.boxB.style.borderColor = h.borderColor, n.boxB.style.background = h.backgroundColor, i.setBorderRadius(n.boxB, c + "px"), n.padM.style.background = n.sldM.style.background = "#FFF", i.setStyle(n.padM, "opacity", "0"), i.setStyle(n.sldM, "opacity", "0"), n.pad.style.position = "relative", n.pad.style.width = h.width + "px", n.pad.style.height = h.height + "px", n.padPal.draw(h.width, h.height, i.getPadYComponent(h)), n.padB.style.position = "absolute", n.padB.style.left = h.padding + "px", n.padB.style.top = h.padding + "px", n.padB.style.border = h.insetWidth + "px solid", n.padB.style.borderColor = h.insetColor, n.padM._jscInstance = h, n.padM._jscControlName = "pad", n.padM.style.position = "absolute", n.padM.style.left = "0", n.padM.style.top = "0", n.padM.style.width = h.padding + 2 * h.insetWidth + h.width + d / 2 + "px", n.padM.style.height = o[1] + "px", n.padM.style.cursor = "crosshair", n.cross.style.position = "absolute", n.cross.style.left = n.cross.style.top = "0", n.cross.style.width = n.cross.style.height = a + "px", n.crossBY.style.position = n.crossBX.style.position = "absolute", n.crossBY.style.background = n.crossBX.style.background = h.pointerBorderColor, n.crossBY.style.width = n.crossBX.style.height = 2 * h.pointerBorderWidth + h.pointerThickness + "px", n.crossBY.style.height = n.crossBX.style.width = a + "px", n.crossBY.style.left = n.crossBX.style.top = Math.floor(a / 2) - Math.floor(h.pointerThickness / 2) - h.pointerBorderWidth + "px", n.crossBY.style.top = n.crossBX.style.left = "0", n.crossLY.style.position = n.crossLX.style.position = "absolute", n.crossLY.style.background = n.crossLX.style.background = h.pointerColor, n.crossLY.style.height = n.crossLX.style.width = a - 2 * h.pointerBorderWidth + "px", n.crossLY.style.width = n.crossLX.style.height = h.pointerThickness + "px", n.crossLY.style.left = n.crossLX.style.top = Math.floor(a / 2) - Math.floor(h.pointerThickness / 2) + "px", n.crossLY.style.top = n.crossLX.style.left = h.pointerBorderWidth + "px", n.sld.style.overflow = "hidden", n.sld.style.width = h.sliderSize + "px", n.sld.style.height = h.height + "px", n.sldGrad.draw(h.sliderSize, h.height, "#000", "#000"), n.sldB.style.display = r ? "block" : "none", n.sldB.style.position = "absolute", n.sldB.style.right = h.padding + "px", n.sldB.style.top = h.padding + "px", n.sldB.style.border = h.insetWidth + "px solid", n.sldB.style.borderColor = h.insetColor, n.sldM._jscInstance = h, n.sldM._jscControlName = "sld", n.sldM.style.display = r ? "block" : "none", n.sldM.style.position = "absolute", n.sldM.style.right = "0", n.sldM.style.top = "0", n.sldM.style.width = h.sliderSize + d / 2 + h.padding + 2 * h.insetWidth + "px", n.sldM.style.height = o[1] + "px", n.sldM.style.cursor = "default", n.sldPtrIB.style.border = n.sldPtrOB.style.border = h.pointerBorderWidth + "px solid " + h.pointerBorderColor, n.sldPtrOB.style.position = "absolute", n.sldPtrOB.style.left = -(2 * h.pointerBorderWidth + h.pointerThickness) + "px", n.sldPtrOB.style.top = "0", n.sldPtrMB.style.border = h.pointerThickness + "px solid " + h.pointerColor, n.sldPtrS.style.width = h.sliderSize + "px", n.sldPtrS.style.height = u + "px", n.btn.style.display = h.closable ? "block" : "none", n.btn.style.position = "absolute", n.btn.style.left = h.padding + "px", n.btn.style.bottom = h.padding + "px", n.btn.style.padding = "0 15px", n.btn.style.height = h.buttonHeight + "px", n.btn.style.border = h.insetWidth + "px solid", e = h.insetColor.split(/\s+/), t = e.length < 2 ? e[0] : e[1] + " " + e[0] + " " + e[0] + " " + e[1], n.btn.style.borderColor = t, n.btn.style.color = h.buttonColor, n.btn.style.font = "12px sans-serif", n.btn.style.textAlign = "center";
            try {
                n.btn.style.cursor = "pointer"
            } catch (e) {
                n.btn.style.cursor = "hand"
            }
            n.btn.onmousedown = function() {
                h.hide()
            }, n.btnT.style.lineHeight = h.buttonHeight + "px", n.btnT.innerHTML = "", n.btnT.appendChild(document.createTextNode(h.closeText)), s(), l(), i.picker.owner && i.picker.owner !== h && i.unsetClass(i.picker.owner.targetElement, h.activeClass), i.picker.owner = h, i.isElementType(p, "body") ? i.redrawPosition() : i._drawPosition(h, 0, 0, "relative", !1), n.wrap.parentNode != p && p.appendChild(n.wrap), i.setClass(h.targetElement, h.activeClass)
        }

        function s() {
            switch (i.getPadYComponent(h)) {
                case "s":
                    var e = 1;
                    break;
                case "v":
                    e = 2
            }
            var t = Math.round(h.hsv[0] / 360 * (h.width - 1)),
                n = Math.round((1 - h.hsv[e] / 100) * (h.height - 1)),
                o = 2 * h.pointerBorderWidth + h.pointerThickness + 2 * h.crossSize,
                s = -Math.floor(o / 2);
            switch (i.picker.cross.style.left = t + s + "px", i.picker.cross.style.top = n + s + "px", i.getSliderComponent(h)) {
                case "s":
                    var l = r(h.hsv[0], 100, h.hsv[2]),
                        a = r(h.hsv[0], 0, h.hsv[2]),
                        d = "rgb(" + Math.round(l[0]) + "," + Math.round(l[1]) + "," + Math.round(l[2]) + ")",
                        c = "rgb(" + Math.round(a[0]) + "," + Math.round(a[1]) + "," + Math.round(a[2]) + ")";
                    i.picker.sldGrad.draw(h.sliderSize, h.height, d, c);
                    break;
                case "v":
                    var p = r(h.hsv[0], h.hsv[1], 100);
                    d = "rgb(" + Math.round(p[0]) + "," + Math.round(p[1]) + "," + Math.round(p[2]) + ")", c = "#000";
                    i.picker.sldGrad.draw(h.sliderSize, h.height, d, c)
            }
        }

        function l() {
            var e = i.getSliderComponent(h);
            if (e) {
                switch (e) {
                    case "s":
                        var t = 1;
                        break;
                    case "v":
                        t = 2
                }
                var n = Math.round((1 - h.hsv[t] / 100) * (h.height - 1));
                i.picker.sldPtrOB.style.top = n - (2 * h.pointerBorderWidth + h.pointerThickness) - Math.floor(u / 2) + "px"
            }
        }

        function a() {
            return i.picker && i.picker.owner === h
        }
        if (this.hide = function() {
                a() && (i.unsetClass(h.targetElement, h.activeClass), i.picker.wrap.parentNode.removeChild(i.picker.wrap), delete i.picker.owner)
            }, this.show = function() {
                o()
            }, this.redraw = function() {
                a() && o()
            }, this.importColor = function() {
                this.valueElement && i.isElementType(this.valueElement, "input") ? this.refine ? !this.required && /^\s*$/.test(this.valueElement.value) ? (this.valueElement.value = "", this.styleElement && (this.styleElement.style.backgroundImage = this.styleElement._jscOrigStyle.backgroundImage, this.styleElement.style.backgroundColor = this.styleElement._jscOrigStyle.backgroundColor, this.styleElement.style.color = this.styleElement._jscOrigStyle.color), this.exportColor(i.leaveValue | i.leaveStyle)) : this.fromString(this.valueElement.value) || this.exportColor() : this.fromString(this.valueElement.value, i.leaveValue) || (this.styleElement && (this.styleElement.style.backgroundImage = this.styleElement._jscOrigStyle.backgroundImage, this.styleElement.style.backgroundColor = this.styleElement._jscOrigStyle.backgroundColor, this.styleElement.style.color = this.styleElement._jscOrigStyle.color), this.exportColor(i.leaveValue | i.leaveStyle)) : this.exportColor()
            }, this.exportColor = function(e) {
                if (!(e & i.leaveValue) && this.valueElement) {
                    var t = this.toString();
                    this.uppercase && (t = t.toUpperCase()), this.hash && (t = "#" + t), i.isElementType(this.valueElement, "input") ? this.valueElement.value = t : this.valueElement.innerHTML = t
                }
                if (!(e & i.leaveStyle) && this.styleElement) {
                    var n = "#" + this.toString(); //,
                        // r = this.isLight() ? "#000" : "#FFF";
                    // this.styleElement.style.backgroundImage = "none", this.styleElement.style.backgroundColor = n, this.styleElement.style.color = r, this.overwriteImportant && this.styleElement.setAttribute("style", "background: " + n + " !important; color: " + r + " !important;")
                    this.styleElement.style.backgroundImage = "none", this.styleElement.style.backgroundColor = n, this.overwriteImportant && this.styleElement.setAttribute("style", "background: " + n + " !important;")
                }
                e & i.leavePad || !a() || s(), e & i.leaveSld || !a() || l()
            }, this.fromHSV = function(e, t, n, o) {
                if (null !== e) {
                    if (isNaN(e)) return !1;
                    e = Math.max(0, Math.min(360, e))
                }
                if (null !== t) {
                    if (isNaN(t)) return !1;
                    t = Math.max(0, Math.min(100, this.maxS, t), this.minS)
                }
                if (null !== n) {
                    if (isNaN(n)) return !1;
                    n = Math.max(0, Math.min(100, this.maxV, n), this.minV)
                }
                this.rgb = r(null === e ? this.hsv[0] : this.hsv[0] = e, null === t ? this.hsv[1] : this.hsv[1] = t, null === n ? this.hsv[2] : this.hsv[2] = n), this.exportColor(o)
            }, this.fromRGB = function(e, t, n, o) {
                if (null !== e) {
                    if (isNaN(e)) return !1;
                    e = Math.max(0, Math.min(255, e))
                }
                if (null !== t) {
                    if (isNaN(t)) return !1;
                    t = Math.max(0, Math.min(255, t))
                }
                if (null !== n) {
                    if (isNaN(n)) return !1;
                    n = Math.max(0, Math.min(255, n))
                }
                var i = function(e, t, n) {
                    e /= 255, t /= 255, n /= 255;
                    var r = Math.min(Math.min(e, t), n),
                        o = Math.max(Math.max(e, t), n),
                        i = o - r;
                    if (0 === i) return [null, 0, 100 * o];
                    var s = e === r ? 3 + (n - t) / i : t === r ? 5 + (e - n) / i : 1 + (t - e) / i;
                    return [60 * (6 === s ? 0 : s), i / o * 100, 100 * o]
                }(null === e ? this.rgb[0] : e, null === t ? this.rgb[1] : t, null === n ? this.rgb[2] : n);
                null !== i[0] && (this.hsv[0] = Math.max(0, Math.min(360, i[0]))), 0 !== i[2] && (this.hsv[1] = null === i[1] ? null : Math.max(0, this.minS, Math.min(100, this.maxS, i[1]))), this.hsv[2] = null === i[2] ? null : Math.max(0, this.minV, Math.min(100, this.maxV, i[2]));
                var s = r(this.hsv[0], this.hsv[1], this.hsv[2]);
                this.rgb[0] = s[0], this.rgb[1] = s[1], this.rgb[2] = s[2], this.exportColor(o)
            }, this.fromString = function(e, t) {
                var n;
                if (n = e.match(/^\W*([0-9A-F]{3}([0-9A-F]{3})?)\W*$/i)) return 6 === n[1].length ? this.fromRGB(parseInt(n[1].substr(0, 2), 16), parseInt(n[1].substr(2, 2), 16), parseInt(n[1].substr(4, 2), 16), t) : this.fromRGB(parseInt(n[1].charAt(0) + n[1].charAt(0), 16), parseInt(n[1].charAt(1) + n[1].charAt(1), 16), parseInt(n[1].charAt(2) + n[1].charAt(2), 16), t), !0;
                if (n = e.match(/^\W*rgba?\(([^)]*)\)\W*$/i)) {
                    var r, o, i, s = n[1].split(","),
                        l = /^\s*(\d*)(\.\d+)?\s*$/;
                    if (s.length >= 3 && (r = s[0].match(l)) && (o = s[1].match(l)) && (i = s[2].match(l))) {
                        var a = parseFloat((r[1] || "0") + (r[2] || "")),
                            d = parseFloat((o[1] || "0") + (o[2] || "")),
                            c = parseFloat((i[1] || "0") + (i[2] || ""));
                        return this.fromRGB(a, d, c, t), !0
                    }
                }
                return !1
            }, this.toString = function() {
                return (256 | Math.round(this.rgb[0])).toString(16).substr(1) + (256 | Math.round(this.rgb[1])).toString(16).substr(1) + (256 | Math.round(this.rgb[2])).toString(16).substr(1)
            }, this.toHEXString = function() {
                return "#" + this.toString().toUpperCase()
            }, this.toRGBString = function() {
                return "rgb(" + Math.round(this.rgb[0]) + "," + Math.round(this.rgb[1]) + "," + Math.round(this.rgb[2]) + ")"
            }, this.isLight = function() {
                return .213 * this.rgb[0] + .715 * this.rgb[1] + .072 * this.rgb[2] > 127.5
            }, this._processParentElementsInDOM = function() {
                if (!this._linkedElementsProcessed) {
                    this._linkedElementsProcessed = !0;
                    var e = this.targetElement;
                    do {
                        var t = i.getStyle(e);
                        t && "fixed" === t.position.toLowerCase() && (this.fixed = !0), e !== this.targetElement && (e._jscEventsAttached || (i.attachEvent(e, "scroll", i.onParentScroll), e._jscEventsAttached = !0))
                    } while ((e = e.parentNode) && !i.isElementType(e, "body"))
                }
            }, "string" == typeof e) {
            var d = e,
                c = document.getElementById(d);
            c ? this.targetElement = c : i.warn("Could not find target element with ID '" + d + "'")
        } else e ? this.targetElement = e : i.warn("Invalid target element: '" + e + "'");
        if (this.targetElement._jscLinkedInstance) i.warn("Cannot link jscolor twice to the same element. Skipping.");
        else {
            this.targetElement._jscLinkedInstance = this, this.valueElement = i.fetchElement(this.valueElement), this.styleElement = i.fetchElement(this.styleElement);
            var h = this,
                p = this.container ? i.fetchElement(this.container) : document.getElementsByTagName("body")[0],
                u = 3;
            if (i.isElementType(this.targetElement, "button"))
                if (this.targetElement.onclick) {
                    var m = this.targetElement.onclick;
                    this.targetElement.onclick = function(e) {
                        return m.call(this, e), !1
                    }
                } else this.targetElement.onclick = function() {
                    return !1
                };
            if (this.valueElement && i.isElementType(this.valueElement, "input")) {
                var v = function() {
                    h.fromString(h.valueElement.value, i.leaveValue), i.dispatchFineChange(h)
                };
                i.attachEvent(this.valueElement, "keyup", v), i.attachEvent(this.valueElement, "input", v), i.attachEvent(this.valueElement, "blur", function() {
                    h.importColor()
                }), this.valueElement.setAttribute("autocomplete", "off")
            }
            this.styleElement && (this.styleElement._jscOrigStyle = {
                backgroundImage: this.styleElement.style.backgroundImage,
                backgroundColor: this.styleElement.style.backgroundColor,
                color: this.styleElement.style.color
            }), this.value ? this.fromString(this.value) || this.exportColor() : this.importColor()
        }
    }
  };
  return i.jscolor.lookupClass = "jscolor", i.jscolor.installByClassName = function(e) {
    var t = document.getElementsByTagName("input"),
        n = document.getElementsByTagName("button");
    i.tryInstallOnElements(t, e), i.tryInstallOnElements(n, e)
  }, i.register(), i.jscolor
}());

// babel plugins/jscolor/jscolor.js --out-file plugins/jscolor/jscolor.min.js
