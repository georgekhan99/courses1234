/*! ScrollMagic v2.0.2 | (c) 2015 Jan Paepke (@janpaepke) | license & info: http://janpaepke.github.io/ScrollMagic */
!function(e,t){"function"==typeof define&&define.amd?define(t):"object"==typeof exports?module.exports=t():e.ScrollMagic=t()}(this,function(){"use strict";var e=function(){};e.version="2.0.2",e.Controller=function(n){var i,o,s="ScrollMagic.Controller",a={f:"FORWARD",r:"REVERSE",p:"PAUSED"},l=t.defaults,c=this,u=r.extend({},l,n),f=[],d=!1,g=0,h=a.p,p=!0,v=0,m=!0,w=function(){for(var e in u)l.hasOwnProperty(e)||delete u[e];if(u.container=r.get.elements(u.container)[0],!u.container)throw s+" init failed.";p=u.container===window||u.container===document.body||!document.body.contains(u.container),p&&(u.container=window),v=u.vertical?r.get.height(u.container):r.get.width(u.container),u.container.addEventListener("resize",x),u.container.addEventListener("scroll",x),u.refreshInterval=parseInt(u.refreshInterval)||l.refreshInterval,y()},y=function(){u.refreshInterval>0&&(o=window.setTimeout(z,u.refreshInterval))},E=function(){return u.vertical?r.get.scrollTop(u.container):r.get.scrollLeft(u.container)},S=function(e){u.vertical?p?window.scrollTo(r.get.scrollLeft(),e):u.container.scrollTop=e:p?window.scrollTo(e,r.get.scrollTop()):u.container.scrollLeft=e},b=function(){if(m&&d){g=c.scrollPos();var e=r.type.Array(d)?d:f.slice(0);h===a.r&&e.reverse(),e.forEach(function(e){e.update(!0)}),0===e.length&&u.loglevel>=3,d=!1}},F=function(){i=r.rAF(b)},x=function(e){if("resize"==e.type)v=u.vertical?r.get.height(u.container):r.get.width(u.container),h=a.p;else{var t=g;g=c.scrollPos();var n=g-t;0!==n&&(h=n>0?a.f:a.r)}d||(d=!0,F())},z=function(){if(!p&&v!=(u.vertical?r.get.height(u.container):r.get.width(u.container))){var e;try{e=new Event("resize",{bubbles:!1,cancelable:!1})}catch(t){e=document.createEvent("Event"),e.initEvent("resize",!1,!1)}u.container.dispatchEvent(e)}f.forEach(function(e){e.refresh()}),y()};this._options=u;var T=function(e){if(e.length<=1)return e;var t=e.slice(0);return t.sort(function(e,t){return e.scrollOffset()>t.scrollOffset()?1:-1}),t};return this.addScene=function(t){if(r.type.Array(t))t.forEach(function(e){c.addScene(e)});else if(t instanceof e.Scene)if(t.controller()!==c)t.addTo(c);else if(f.indexOf(t)<0){f.push(t),f=T(f),t.on("shift.controller_sort",function(){f=T(f)});for(var n in u.globalSceneOptions)t[n]&&t[n].call(t,u.globalSceneOptions[n])}return c},this.removeScene=function(e){if(r.type.Array(e))e.forEach(function(e){c.removeScene(e)});else{var t=f.indexOf(e);t>-1&&(e.off("shift.controller_sort"),f.splice(t,1),e.remove())}return c},this.updateScene=function(t,n){return r.type.Array(t)?t.forEach(function(e){c.updateScene(e,n)}):n?t.update(!0):d!==!0&&t instanceof e.Scene&&(d=d||[],-1==d.indexOf(t)&&d.push(t),d=T(d),F()),c},this.update=function(e){return x({type:"resize"}),e&&b(),c},this.scrollTo=function(t){if(r.type.Number(t))S.call(u.container,t);else if(t instanceof e.Scene)t.controller()===c?c.scrollTo(t.scrollOffset()):log(2,"scrollTo(): The supplied scene does not belong to this controller. Scroll cancelled.",t);else if(r.type.Function(t))S=t;else{var n=r.get.elements(t)[0];if(n){var i=u.vertical?"top":"left",o=r.get.offset(u.container),s=r.get.offset(n);p||(o[i]-=c.scrollPos()),c.scrollTo(s[i]-o[i])}else log(2,"scrollTo(): The supplied argument is invalid. Scroll cancelled.",t)}return c},this.scrollPos=function(e){return arguments.length?(r.type.Function(e)&&(E=e),c):E.call(c)},this.info=function(e){var t={size:v,vertical:u.vertical,scrollPos:g,scrollDirection:h,container:u.container,isDocument:p};return arguments.length?void 0!==t[e]?t[e]:void 0:t},this.loglevel=function(e){return arguments.length?(u.loglevel!=e&&(u.loglevel=e),c):u.loglevel},this.enabled=function(e){return arguments.length?(m!=e&&(m=!!e,c.updateScene(f,!0)),c):m},this.destroy=function(e){window.clearTimeout(o);for(var t=f.length;t--;)f[t].destroy(e);return u.container.removeEventListener("resize",x),u.container.removeEventListener("scroll",x),r.cAF(i),null},w(),c};var t={defaults:{container:window,vertical:!0,globalSceneOptions:{},loglevel:2,refreshInterval:100}};e.Controller.addOption=function(e,n){t.defaults[e]=n},e.Controller.extend=function(t){var n=this;e.Controller=function(){return n.apply(this,arguments),this.$super=r.extend({},this),t.apply(this,arguments)||this},r.extend(e.Controller,n),e.Controller.prototype=n.prototype,e.Controller.prototype.constructor=e.Controller},e.Scene=function(t){var i,o,s="data-scrollmagic-pin-spacer",a=n.defaults,l=this,c=r.extend({},a,t),u="BEFORE",f=0,d={start:0,end:0},g=0,h=!0,p=function(){for(var e in c)a.hasOwnProperty(e)||delete c[e];for(var t in a)F(t);S(),l.on("change.internal",function(e){"loglevel"!==e.what&&"tweenChanges"!==e.what&&("triggerElement"===e.what?w():"reverse"===e.what&&l.update())}).on("shift.internal",function(){v(),l.update()})};this.addTo=function(t){return t instanceof e.Controller&&o!=t&&(o&&o.removeScene(l),o=t,S(),m(!0),w(!0),v(),o.info("container").addEventListener("resize",y),t.addScene(l),l.trigger("add",{controller:o}),l.update()),l},this.enabled=function(e){return arguments.length?(h!=e&&(h=!!e,l.update(!0)),l):h},this.remove=function(){if(o){o.info("container").removeEventListener("resize",y);var e=o;o=void 0,e.removeScene(l),l.trigger("remove")}return l},this.destroy=function(e){return l.trigger("destroy",{reset:e}),l.remove(),l.off("*.*"),null},this.update=function(e){if(o)if(e)if(o.enabled()&&h){var t,n=o.info("scrollPos");t=c.duration>0?(n-d.start)/(d.end-d.start):n>=d.start?1:0,l.trigger("update",{startPos:d.start,endPos:d.end,scrollPos:n}),l.progress(t)}else z&&"DURING"===u&&R(!0);else o.updateScene(l,!1);return l},this.refresh=function(){return m(),w(),l},this.progress=function(e){if(arguments.length){var t=!1,n=u,r=o?o.info("scrollDirection"):"PAUSED",i=c.reverse||e>=f;if(0===c.duration?(t=f!=e,f=1>e&&i?0:1,u=0===f?"BEFORE":"DURING"):0>=e&&"BEFORE"!==u&&i?(f=0,u="BEFORE",t=!0):e>0&&1>e&&i?(f=e,u="DURING",t=!0):e>=1&&"AFTER"!==u?(f=1,u="AFTER",t=!0):"DURING"!==u||i||R(),t){var s={progress:f,state:u,scrollDirection:r},a=u!=n,d=function(e){l.trigger(e,s)};a&&"DURING"!==n&&(d("enter"),d("BEFORE"===n?"start":"end")),d("progress"),a&&"DURING"!==u&&(d("BEFORE"===u?"start":"end"),d("leave"))}return l}return f};var v=function(){d={start:g+c.offset},o&&c.triggerElement&&(d.start-=o.info("size")*c.triggerHook),d.end=d.start+c.duration},m=function(e){if(i){var t="duration";b(t,i.call(l))&&!e&&(l.trigger("change",{what:t,newval:c[t]}),l.trigger("shift",{reason:t}))}},w=function(e){var t=0,n=c.triggerElement;if(o&&n){for(var i=o.info(),a=r.get.offset(i.container),u=i.vertical?"top":"left";n.parentNode.hasAttribute(s);)n=n.parentNode;var f=r.get.offset(n);i.isDocument||(a[u]-=o.scrollPos()),t=f[u]-a[u]}var d=t!=g;g=t,d&&!e&&l.trigger("shift",{reason:"triggerElementPosition"})},y=function(){c.triggerHook>0&&l.trigger("shift",{reason:"containerResize"})},E=r.extend(n.validate,{duration:function(e){if(r.type.String(e)&&e.match(/^(\.|\d)*\d+%$/)){var t=parseFloat(e)/100;e=function(){return o?o.info("size")*t:0}}if(r.type.Function(e)){i=e;try{e=parseFloat(i())}catch(n){e=-1}}if(e=parseFloat(e),!r.type.Number(e)||0>e)throw i?(i=void 0,0):0;return e}}),S=function(e){e=arguments.length?[e]:Object.keys(E),e.forEach(function(e){var t;if(E[e])try{t=E[e](c[e])}catch(n){t=a[e]}finally{c[e]=t}})},b=function(e,t){var n=!1,r=c[e];return c[e]!=t&&(c[e]=t,S(e),n=r!=c[e]),n},F=function(e){l[e]||(l[e]=function(t){return arguments.length?("duration"===e&&(i=void 0),b(e,t)&&(l.trigger("change",{what:e,newval:c[e]}),n.shifts.indexOf(e)>-1&&l.trigger("shift",{reason:e})),l):c[e]})};this.controller=function(){return o},this.state=function(){return u},this.scrollOffset=function(){return d.start},this.triggerPosition=function(){var e=c.offset;return o&&(e+=c.triggerElement?g:o.info("size")*l.triggerHook()),e};var x={};this.on=function(e,t){return r.type.Function(t)&&(e=e.trim().split(" "),e.forEach(function(e){var n=e.split("."),r=n[0],i=n[1];"*"!=r&&(x[r]||(x[r]=[]),x[r].push({namespace:i||"",callback:t}))})),l},this.off=function(e,t){return e?(e=e.trim().split(" "),e.forEach(function(e){var n=e.split("."),r=n[0],i=n[1]||"",o="*"===r?Object.keys(x):[r];o.forEach(function(e){for(var n=x[e]||[],r=n.length;r--;){var o=n[r];!o||i!==o.namespace&&"*"!==i||t&&t!=o.callback||n.splice(r,1)}n.length||delete x[e]})}),l):l},this.trigger=function(t,n){if(t){var r=t.trim().split("."),i=r[0],o=r[1],s=x[i];s&&s.forEach(function(t){o&&o!==t.namespace||t.callback.call(l,new e.Event(i,t.namespace,l,n))})}return l};var z,T;l.on("shift.internal",function(e){var t="duration"===e.reason;("AFTER"===u&&t||"DURING"===u&&0===c.duration)&&R(),t&&C()}).on("progress.internal",function(){R()}).on("add.internal",function(){C()}).on("destroy.internal",function(e){l.removePin(e.reset)});var R=function(e){if(z&&o){var t=o.info();if(e||"DURING"!==u){var n={position:T.inFlow?"relative":"absolute",top:0,left:0},i=r.css(z,"position")!=n.position;T.pushFollowers?c.duration>0&&("AFTER"===u&&0===parseFloat(r.css(T.spacer,"padding-top"))?i=!0:"BEFORE"===u&&0===parseFloat(r.css(T.spacer,"padding-bottom"))&&(i=!0)):n[t.vertical?"top":"left"]=c.duration*f,r.css(z,n),i&&C()}else{"fixed"!=r.css(z,"position")&&(r.css(z,{position:"fixed"}),C());var s=r.get.offset(T.spacer,!0),a=c.reverse||0===c.duration?t.scrollPos-d.start:Math.round(f*c.duration*10)/10;s[t.vertical?"top":"left"]+=a,r.css(z,{top:s.top,left:s.left})}}},C=function(){if(z&&o&&T.inFlow){var e="DURING"===u,t=o.info("vertical"),n=T.spacer.children[0],i=r.isMarginCollapseType(r.css(T.spacer,"display")),s={};T.relSize.width||T.relSize.autoFullWidth?e?r.css(z,{width:r.get.width(T.spacer)}):r.css(z,{width:"100%"}):(s["min-width"]=r.get.width(t?z:n,!0,!0),s.width=e?s["min-width"]:"auto"),T.relSize.height?e?r.css(z,{height:r.get.height(T.spacer)-c.duration}):r.css(z,{height:"100%"}):(s["min-height"]=r.get.height(t?n:z,!0,!i),s.height=e?s["min-height"]:"auto"),T.pushFollowers&&(s["padding"+(t?"Top":"Left")]=c.duration*f,s["padding"+(t?"Bottom":"Right")]=c.duration*(1-f)),r.css(T.spacer,s)}},L=function(){o&&z&&"DURING"===u&&!o.info("isDocument")&&R()},D=function(){o&&z&&"DURING"===u&&((T.relSize.width||T.relSize.autoFullWidth)&&r.get.width(window)!=r.get.width(T.spacer.parentNode)||T.relSize.height&&r.get.height(window)!=r.get.height(T.spacer.parentNode))&&C()},N=function(e){o&&z&&"DURING"===u&&!o.info("isDocument")&&(e.preventDefault(),o.scrollTo(o.info("scrollPos")-(e[o.info("vertical")?"wheelDeltaY":"wheelDeltaX"]/3||30*-e.detail)))};this.setPin=function(e,t){var n={pushFollowers:!0,spacerClass:"scrollmagic-pin-spacer"};if(t=r.extend({},n,t),e=r.get.elements(e)[0],!e)return l;if("fixed"===r.css(e,"position"))return l;if(z){if(z===e)return l;l.removePin()}z=e;var i=z.parentNode.style.display,o=["top","left","bottom","right","margin","marginLeft","marginRight","marginTop","marginBottom"];z.parentNode.style.display="none";var a="absolute"!=r.css(z,"position"),c=r.css(z,o.concat(["display"])),u=r.css(z,["width","height"]);z.parentNode.style.display=i,!a&&t.pushFollowers&&(t.pushFollowers=!1);var f=z.parentNode.insertBefore(document.createElement("div"),z),d=r.extend(c,{position:a?"relative":"absolute",boxSizing:"content-box",mozBoxSizing:"content-box",webkitBoxSizing:"content-box"});if(a||r.extend(d,r.css(z,["width","height"])),r.css(f,d),f.setAttribute(s,""),r.addClass(f,t.spacerClass),T={spacer:f,relSize:{width:"%"===u.width.slice(-1),height:"%"===u.height.slice(-1),autoFullWidth:"auto"===u.width&&a&&r.isMarginCollapseType(c.display)},pushFollowers:t.pushFollowers,inFlow:a},!z.___origStyle){z.___origStyle={};var g=z.style,h=o.concat(["width","height","position","boxSizing","mozBoxSizing","webkitBoxSizing"]);h.forEach(function(e){z.___origStyle[e]=g[e]||""})}return T.relSize.width&&r.css(f,{width:u.width}),T.relSize.height&&r.css(f,{height:u.height}),f.appendChild(z),r.css(z,{position:a?"relative":"absolute",margin:"auto",top:"auto",left:"auto",bottom:"auto",right:"auto"}),(T.relSize.width||T.relSize.autoFullWidth)&&r.css(z,{boxSizing:"border-box",mozBoxSizing:"border-box",webkitBoxSizing:"border-box"}),window.addEventListener("scroll",L),window.addEventListener("resize",L),window.addEventListener("resize",D),z.addEventListener("mousewheel",N),z.addEventListener("DOMMouseScroll",N),R(),l},this.removePin=function(e){if(z){if("DURING"===u&&R(!0),e||!o){var t=T.spacer.children[0];if(t.hasAttribute(s)){var n=T.spacer.style,i=["margin","marginLeft","marginRight","marginTop","marginBottom"];margins={},i.forEach(function(e){margins[e]=n[e]||""}),r.css(t,margins)}T.spacer.parentNode.insertBefore(t,T.spacer),T.spacer.parentNode.removeChild(T.spacer),z.parentNode.hasAttribute(s)||(r.css(z,z.___origStyle),delete z.___origStyle)}window.removeEventListener("scroll",L),window.removeEventListener("resize",L),window.removeEventListener("resize",D),z.removeEventListener("mousewheel",N),z.removeEventListener("DOMMouseScroll",N),z=void 0}return l};var O,A=[];return l.on("destroy.internal",function(e){l.removeClassToggle(e.reset)}),this.setClassToggle=function(e,t){var n=r.get.elements(e);return 0!==n.length&&r.type.String(t)?(A.length>0&&l.removeClassToggle(),O=t,A=n,l.on("enter.internal_class leave.internal_class",function(e){var t="enter"===e.type?r.addClass:r.removeClass;A.forEach(function(e){t(e,O)})}),l):l},this.removeClassToggle=function(e){return e&&A.forEach(function(e){r.removeClass(e,O)}),l.off("start.internal_class end.internal_class"),O=void 0,A=[],l},p(),l};var n={defaults:{duration:0,offset:0,triggerElement:void 0,triggerHook:.5,reverse:!0,loglevel:2},validate:{offset:function(e){if(e=parseFloat(e),!r.type.Number(e))throw 0;return e},triggerElement:function(e){if(e=e||void 0){var t=r.get.elements(e)[0];if(!t)throw 0;e=t}return e},triggerHook:function(e){var t={onCenter:.5,onEnter:1,onLeave:0};if(r.type.Number(e))e=Math.max(0,Math.min(parseFloat(e),1));else{if(!(e in t))throw 0;e=t[e]}return e},reverse:function(e){return!!e}},shifts:["duration","offset","triggerHook"]};e.Scene.addOption=function(e,t,r,i){e in n.defaults||(n.defaults[e]=t,n.validate[e]=r,i&&n.shifts.push(e))},e.Scene.extend=function(t){var n=this;e.Scene=function(){return n.apply(this,arguments),this.$super=r.extend({},this),t.apply(this,arguments)||this},r.extend(e.Scene,n),e.Scene.prototype=n.prototype,e.Scene.prototype.constructor=e.Scene},e.Event=function(e,t,n,r){r=r||{};for(var i in r)this[i]=r[i];return this.type=e,this.target=this.currentTarget=n,this.namespace=t||"",this.timeStamp=this.timestamp=Date.now(),this};var r=e._util=function(e){var t,n={},r=function(e){return parseFloat(e)||0},i=function(t){return t.currentStyle?t.currentStyle:e.getComputedStyle(t)},o=function(t,n,o,s){if(n=n===document?e:n,n===e)s=!1;else if(!f.DomElement(n))return 0;t=t.charAt(0).toUpperCase()+t.substr(1).toLowerCase();var a=(o?n["offset"+t]||n["outer"+t]:n["client"+t]||n["inner"+t])||0;if(o&&s){var l=i(n);a+="Height"===t?r(l.marginTop)+r(l.marginBottom):r(l.marginLeft)+r(l.marginRight)}return a},s=function(e){return e.replace(/^[^a-z]+([a-z])/g,"$1").replace(/-([a-z])/g,function(e){return e[1].toUpperCase()})};n.extend=function(e){for(e=e||{},t=1;t<arguments.length;t++)if(arguments[t])for(var n in arguments[t])arguments[t].hasOwnProperty(n)&&(e[n]=arguments[t][n]);return e},n.isMarginCollapseType=function(e){return["block","flex","list-item","table","-webkit-box"].indexOf(e)>-1};var a=0,l=["ms","moz","webkit","o"],c=e.requestAnimationFrame,u=e.cancelAnimationFrame;for(t=0;!c&&t<l.length;++t)c=e[l[t]+"RequestAnimationFrame"],u=e[l[t]+"CancelAnimationFrame"]||e[l[t]+"CancelRequestAnimationFrame"];c||(c=function(t){var n=(new Date).getTime(),r=Math.max(0,16-(n-a)),i=e.setTimeout(function(){t(n+r)},r);return a=n+r,i}),u||(u=function(t){e.clearTimeout(t)}),n.rAF=c.bind(e),n.cAF=u.bind(e);var f=n.type=function(e){return Object.prototype.toString.call(e).replace(/^\[object (.+)\]$/,"$1").toLowerCase()};f.String=function(e){return"string"===f(e)},f.Function=function(e){return"function"===f(e)},f.Array=function(e){return Array.isArray(e)},f.Number=function(e){return!f.Array(e)&&e-parseFloat(e)+1>=0},f.DomElement=function(e){return"object"==typeof HTMLElement?e instanceof HTMLElement:e&&"object"==typeof e&&null!==e&&1===e.nodeType&&"string"==typeof e.nodeName};var d=n.get={};return d.elements=function(t){var n=[];if(f.String(t))try{t=document.querySelectorAll(t)}catch(r){return n}if("nodelist"===f(t)||f.Array(t))for(var i=0,o=n.length=t.length;o>i;i++){var s=t[i];n[i]=f.DomElement(s)?s:d.elements(s)}else(f.DomElement(t)||t===document||t===e)&&(n=[t]);return n},d.scrollTop=function(t){return t&&"number"==typeof t.scrollTop?t.scrollTop:e.pageYOffset||0},d.scrollLeft=function(t){return t&&"number"==typeof t.scrollLeft?t.scrollLeft:e.pageXOffset||0},d.width=function(e,t,n){return o("width",e,t,n)},d.height=function(e,t,n){return o("height",e,t,n)},d.offset=function(e,t){var n={top:0,left:0};if(e&&e.getBoundingClientRect){var r=e.getBoundingClientRect();n.top=r.top,n.left=r.left,t||(n.top+=d.scrollTop(),n.left+=d.scrollLeft())}return n},n.addClass=function(e,t){t&&(e.classList?e.classList.add(t):e.className+=" "+t)},n.removeClass=function(e,t){t&&(e.classList?e.classList.remove(t):e.className=e.className.replace(RegExp("(^|\\b)"+t.split(" ").join("|")+"(\\b|$)","gi")," "))},n.css=function(e,t){if(f.String(t))return i(e)[s(t)];if(f.Array(t)){var n={},r=i(e);return t.forEach(function(e){n[e]=r[s(e)]}),n}for(var o in t){var a=t[o];a==parseFloat(a)&&(a+="px"),e.style[s(o)]=a}},n}(window||{});return e});
 /*! ScrollMagic v2.0.2 | (c) 2015 Jan Paepke (@janpaepke) | license & info: http://janpaepke.github.io/ScrollMagic */
!function(e,r){"function"==typeof define&&define.amd?define(["ScrollMagic"],r):r("object"==typeof exports?require("scrollmagic"):e.ScrollMagic||e.jQuery&&e.jQuery.ScrollMagic)}(this,function(e){"use strict";var r="0.85em",t="9999",i=15,o=e._util,n=0;e.Scene.extend(function(){var e,r=this;r.addIndicators=function(t){if(!e){var i={name:"",indent:0,parent:void 0,colorStart:"green",colorEnd:"red",colorTrigger:"blue"};t=o.extend({},i,t),n++,e=new s(r,t),r.on("add.plugin_addIndicators",e.add),r.on("remove.plugin_addIndicators",e.remove),r.on("destroy.plugin_addIndicators",r.removeIndicators),r.controller()&&e.add()}return r},r.removeIndicators=function(){return e&&(e.remove(),this.off("*.plugin_addIndicators"),e=void 0),r}}),e.Controller.addOption("addIndicators",!1),e.Controller.extend(function(){var r=this,t=r.info(),n=t.container,s=t.isDocument,d=t.vertical,a={groups:[]};this._indicators=a;var g=function(){a.updateBoundsPositions()},p=function(){a.updateTriggerGroupPositions()};return n.addEventListener("resize",p),s||(window.addEventListener("resize",p),window.addEventListener("scroll",p)),n.addEventListener("resize",g),n.addEventListener("scroll",g),this._indicators.updateBoundsPositions=function(e){for(var r,t,s,g=e?[o.extend({},e.triggerGroup,{members:[e]})]:a.groups,p=g.length,u={},c=d?"left":"top",l=d?"width":"height",f=d?o.get.scrollLeft(n)+o.get.width(n)-i:o.get.scrollTop(n)+o.get.height(n)-i;p--;)for(s=g[p],r=s.members.length,t=o.get[l](s.element.firstChild);r--;)u[c]=f-t,o.css(s.members[r].bounds,u)},this._indicators.updateTriggerGroupPositions=function(e){for(var t,g,p,u,c,l=e?[e]:a.groups,f=l.length,m=s?document.body:n,h=s?{top:0,left:0}:o.get.offset(m,!0),v=d?o.get.width(n)-i:o.get.height(n)-i,b=d?"width":"height",G=d?"Y":"X";f--;)t=l[f],g=t.element,p=t.triggerHook*r.info("size"),u=o.get[b](g.firstChild.firstChild),c=p>u?"translate"+G+"(-100%)":"",o.css(g,{top:h.top+(d?p:v-t.members[0].options.indent),left:h.left+(d?v-t.members[0].options.indent:p)}),o.css(g.firstChild.firstChild,{"-ms-transform":c,"-webkit-transform":c,transform:c})},this._indicators.updateTriggerGroupLabel=function(e){var r="trigger"+(e.members.length>1?"":" "+e.members[0].options.name),t=e.element.firstChild.firstChild,i=t.textContent!==r;i&&(t.textContent=r,d&&a.updateBoundsPositions())},this.addScene=function(t){this._options.addIndicators&&t instanceof e.Scene&&t.controller()===r&&t.addIndicators(),this.$super.addScene.apply(this,arguments)},this.destroy=function(){n.removeEventListener("resize",p),s||(window.removeEventListener("resize",p),window.removeEventListener("scroll",p)),n.removeEventListener("resize",g),n.removeEventListener("scroll",g),this.$super.destroy.apply(this,arguments)},r});var s=function(e,r){var t,i,s=this,a=d.bounds(),g=d.start(r.colorStart),p=d.end(r.colorEnd),u=r.parent&&o.get.elements(r.parent)[0];r.name=r.name||n,g.firstChild.textContent+=" "+r.name,p.textContent+=" "+r.name,a.appendChild(g),a.appendChild(p),s.options=r,s.bounds=a,s.triggerGroup=void 0,this.add=function(){i=e.controller(),t=i.info("vertical");var r=i.info("isDocument");u||(u=r?document.body:i.info("container")),r||"static"!==o.css(u,"position")||o.css(u,{position:"relative"}),e.on("change.plugin_addIndicators",l),e.on("shift.plugin_addIndicators",c),G(),h(),setTimeout(function(){i._indicators.updateBoundsPositions(s)},0)},this.remove=function(){if(s.triggerGroup){if(e.off("change.plugin_addIndicators",l),e.off("shift.plugin_addIndicators",c),s.triggerGroup.members.length>1){var r=s.triggerGroup;r.members.splice(r.members.indexOf(s),1),i._indicators.updateTriggerGroupLabel(r),i._indicators.updateTriggerGroupPositions(r),s.triggerGroup=void 0}else b();m()}};var c=function(){h()},l=function(e){"triggerHook"===e.what&&G()},f=function(){var e=i.info("vertical");o.css(g.firstChild,{"border-bottom-width":e?1:0,"border-right-width":e?0:1,bottom:e?-1:r.indent,right:e?r.indent:-1,padding:e?"0 8px":"2px 4px"}),o.css(p,{"border-top-width":e?1:0,"border-left-width":e?0:1,top:e?"100%":"",right:e?r.indent:"",bottom:e?"":r.indent,left:e?"":"100%",padding:e?"0 8px":"2px 4px"}),u.appendChild(a)},m=function(){a.parentNode.removeChild(a)},h=function(){a.parentNode!==u&&f();var r={};r[t?"top":"left"]=e.triggerPosition(),r[t?"height":"width"]=e.duration(),o.css(a,r),o.css(p,{display:e.duration()>0?"":"none"})},v=function(){var n=d.trigger(r.colorTrigger),a={};a[t?"right":"bottom"]=0,a[t?"border-top-width":"border-left-width"]=1,o.css(n.firstChild,a),o.css(n.firstChild.firstChild,{padding:t?"0 8px 3px 8px":"3px 4px"}),document.body.appendChild(n);var g={triggerHook:e.triggerHook(),element:n,members:[s]};i._indicators.groups.push(g),s.triggerGroup=g,i._indicators.updateTriggerGroupLabel(g),i._indicators.updateTriggerGroupPositions(g)},b=function(){i._indicators.groups.splice(i._indicators.groups.indexOf(s.triggerGroup),1),s.triggerGroup.element.parentNode.removeChild(s.triggerGroup.element),s.triggerGroup=void 0},G=function(){var r=e.triggerHook(),t=1e-4;if(!(s.triggerGroup&&Math.abs(s.triggerGroup.triggerHook-r)<t)){for(var o,n=i._indicators.groups,d=n.length;d--;)if(o=n[d],Math.abs(o.triggerHook-r)<t)return s.triggerGroup&&(1===s.triggerGroup.members.length?b():(s.triggerGroup.members.splice(s.triggerGroup.members.indexOf(s),1),i._indicators.updateTriggerGroupLabel(s.triggerGroup),i._indicators.updateTriggerGroupPositions(s.triggerGroup))),o.members.push(s),s.triggerGroup=o,void i._indicators.updateTriggerGroupLabel(o);if(s.triggerGroup){if(1===s.triggerGroup.members.length)return s.triggerGroup.triggerHook=r,void i._indicators.updateTriggerGroupPositions(s.triggerGroup);s.triggerGroup.members.splice(s.triggerGroup.members.indexOf(s),1),i._indicators.updateTriggerGroupLabel(s.triggerGroup),i._indicators.updateTriggerGroupPositions(s.triggerGroup),s.triggerGroup=void 0}v()}}},d={start:function(e){var r=document.createElement("div");r.textContent="start",o.css(r,{position:"absolute",overflow:"visible","border-width":0,"border-style":"solid",color:e,"border-color":e});var t=document.createElement("div");return o.css(t,{position:"absolute",overflow:"visible",width:0,height:0}),t.appendChild(r),t},end:function(e){var r=document.createElement("div");return r.textContent="end",o.css(r,{position:"absolute",overflow:"visible","border-width":0,"border-style":"solid",color:e,"border-color":e}),r},bounds:function(){var e=document.createElement("div");return o.css(e,{position:"absolute",overflow:"visible","white-space":"nowrap","pointer-events":"none","font-size":r}),e.style.zIndex=t,e},trigger:function(e){var i=document.createElement("div");i.textContent="trigger",o.css(i,{position:"relative"});var n=document.createElement("div");o.css(n,{position:"absolute",overflow:"visible","border-width":0,"border-style":"solid",color:e,"border-color":e}),n.appendChild(i);var s=document.createElement("div");return o.css(s,{position:"fixed",overflow:"visible","white-space":"nowrap","pointer-events":"none","font-size":r}),s.style.zIndex=t,s.appendChild(n),s}}});

/**
  * Script custom for theme
  */

(function ($) {
	"use strict";
	$(document).ready(function () {
		thim_course_builder.ready();
		var rtlval = false;

		if ($('body').hasClass('rtl')) {
			var rtlval = true;
		}
		/* Search form menu right */
		$('.menu-right .button_search').on("click", function () {
			$('.menu-right .search-form').toggle(300);
			$('.menu-right input.search-field').focus();
		});

		/*
		 * Add icon toggle curriculum in lesson popup
		 * */
		window.toggle_curiculum_sidebar = function (e) {
			var icon_popup = $('.icon-toggle-curriculum');
			icon_popup.toggleClass('open');

			if (icon_popup.hasClass('open')) {
				if (rtlval == false) {
					$('#popup-sidebar').stop().animate({'margin-left': '0'});
					$('#popup-main').stop().animate({'left': '400px'});
				} else {
					$('#popup-sidebar').stop().animate({'margin-right': '0'});
					$('#popup-main').stop().animate({'right': '400px'});
				}
			} else {
				if (rtlval == false) {
					$('#popup-sidebar').stop().animate({'margin-left': '-400px'});
					$('#popup-main').stop().animate({'left': '0'});
				} else {
					$('#popup-sidebar').stop().animate({'margin-right': '-400px'});
					$('#popup-main').stop().animate({'right': '0'});
				}
			}
		}

	});

	$(window).on('load', function () {
		thim_course_builder.load();
	});

	var thim_course_builder = window.thim_course_builder = {
		/**
		 * Call functions when document ready
		 */
		ready: function () {
			this.thim_topbar();
			this.header_menu();
			this.back_to_top();
			this.feature_preloading();
			this.sticky_sidebar();
			this.contactform7();
			this.blog_auto_height();
			this.header_search();
			this.off_canvas_menu();
			this.carousel();
			this.video_thumbnail();
			this.switch_layout();
			this.single_post_related();
			this.loadmore_profile();
			// this.profile_update();
			// this.profile_switch_tabs();
			// this.profile_slide_certificates();
			this.coming_soon_hover_effect();
			this.validate_login_form();
			this.login_popup_ajax();
			this.form_submission_validate();
			this.reset_password_ajax();
			this.archive_wishlist_button();
			this.learning_course_tab_nav();
			this.landing_review_detail();
			//setTimeout(this.add_loading_enroll_button(), 3000);
			this.open_lesson();
			this.show_password_form();
			this.thim_course_filter();
			this.thim_course_searching();
		},

		/**
		 * Call functions when window load.
		 */
		load: function () {
			this.header_menu_mobile();
			this.magic_line();
			this.post_gallery();
			this.curriculum_single_course();
			this.quick_view();
			this.show_current_curriculum_section();
			this.miniCartHover();

			if ($("body.woocommerce").length) {
				// this.product_slider();
			}


		},

		validate_login_form: function () {

			$('.thim-login form').each(function () {

				$(this).submit(function (event) {
					var elem = $(this),

						input_username = elem.find('#user_login'),
						input_userpass = elem.find('#user_pass'),
						input_email = elem.find('#user_email'),
						input_captcha = elem.find('.thim-login-captcha .captcha-result'),
						input_checkbox = elem.find('input[name="term"]'),
						input_pass = elem.find('#password'),
						input_rppass = elem.find('#repeat_password');

					var email_valid = /[A-Z0-9._%+-]+@[A-Z0-9.-]+.[A-Z]{2,4}/igm;

					if (input_captcha.length > 0) {

						var captcha_1 = parseInt(input_captcha.data('captcha1')),
							captcha_2 = parseInt(input_captcha.data('captcha2'));

						if (captcha_1 + captcha_2 != parseInt(input_captcha.val())) {
							input_captcha.addClass('invalid').val('');
							event.preventDefault();
						}
					}

					// if (input_checkbox.length > 0 && input_checkbox.val() === '') {
					if (input_checkbox.is(':checkbox') && !input_checkbox.is(':checked')) {
						input_checkbox.addClass('invalid');
						event.preventDefault();
					}

					if (input_username.length > 0 && input_username.val() === '') {
						input_username.addClass('invalid');
						event.preventDefault();
					}

					if (input_userpass.length > 0 && input_userpass.val() === '') {
						input_userpass.addClass('invalid');
						event.preventDefault();
					}

					if (input_email.length > 0 && (input_email.val() === '' || !email_valid.test(input_email.val()))) {
						input_email.addClass('invalid');
						event.preventDefault();
					}

					if (input_pass.length > 0 && input_rppass.length > 0) {
						if (input_pass.val() !== input_rppass.val() || input_pass.val() === '') {
							input_pass.addClass('invalid');
							input_rppass.addClass('invalid');
							event.preventDefault();
						}
					}

				});
			});


			$('.thim-login input.required').on('focus', function () {
				if ($(this).hasClass('invalid')) {
					$(this).removeClass('invalid');
				}
			});

		},

		thim_course_searching: function () {
			//Course archive search filter
			var search_time_out = null;
			$(document).on('keydown', 'body:not(.course-filter-active) .course-search-filter',
				function (event) {
					if (event.ctrlKey) {
						return;
					}

					if (event.keyCode === 13) {
						event.preventDefault();
						return false;
					}

					if ((event.keyCode >= 48 && event.keyCode <= 90) || event.keyCode === 8 || event.keyCode === 32) {
						var elem = $(this),
							keyword = event.keyCode === 8 ? elem.val() : elem.val() + event.key,
							$body = $('body');

						if (search_time_out != null) clearTimeout(search_time_out);

						search_time_out = setTimeout(function () {
							elem.attr('disabled', 'disabled');
							search_time_out = null;

							$('.archive-courses').addClass('loading');

							var archive = elem.parents('#lp-archive-courses'),
								cateArr = [];

							if ($body.hasClass('category')) {
								var bodyClass = $body.attr('class'),
									cateClass = bodyClass.match(/category\-\d+/gi)[0],
									cateID = cateClass.split('-').pop();

								cateArr.push(cateID);
							}

							if ($('.list-cate-filter').length > 0) {
								$('.list-cate-filter input.filtered').each(function () {
									console.log(typeof $(this).val());
									if ($(this).val() !== cateID) {
										cateArr.push($(this).val());
									}
								});
							}

							$.ajax({
								url     : $('#lp-archive-courses').data('allCoursesUrl'),
								type    : 'POST',
								dataType: 'html',
								data    : {
									s                 : keyword,
									ref               : 'course',
									post_type         : 'lp_course',
									course_orderby    : $('.thim-course-order > select').val(),
									course_cate_filter: cateArr,
									course_paged      : 1,
								},
								success : function (html) {
									var archive_html = $(html).find('#lp-archive-courses').html();
									archive.html(archive_html);

									$('.course-search-filter').val(keyword).trigger('focus');
									$body.removeClass('course-filter-active');
									$('.filter-loading').remove();
								},

								error: function () {
									$body.removeClass('course-filter-active');
									$('.filter-loading').remove();
								},
							});

						}, 1000);
					}

				});
		},

		header_search: function () {
			$('#masthead .search-form').on({
				'mouseenter': function () {
					$(this).addClass('active');
					$(this).find('input.search-field').focus();
				},
				'mouseleave': function () {
					$(this).removeClass('active');
				}
			});

			$('#masthead .search-submit').on('click', function (e) {
				var $form = $(this).parents('form');
				var s = $form.find('.search-field').val();
				if ($form.hasClass('active') && s) {
					//nothing
				} else {
					e.preventDefault();
					$form.find('.search-field').focus();
				}
			});
		},

		// CUSTOM FUNCTION IN BELOW
		post_gallery: function () {
			if (jQuery().flexslider) {
				$('.flexslider').flexslider({
					slideshow     : false,
					animation     : 'fade',
					pauseOnHover  : true,
					animationSpeed: 400,
					smoothHeight  : true,
					directionNav  : true,
					controlNav    : false,
					start         : function (slider) {
						slider.flexAnimate(1, true);
					},
				});
			};
		},

		/**
		 * Custom slider
		 */
		slider: function () {
			var rtl = false;
			if ($('body').hasClass('rtl')) {
				rtl = true;
			}

			$('.thim-slider .slides').owlCarousel({
				items: 1,
				nav  : true,
				dots : false,
				rtl  : rtl
			});

			// scroll icon
			$('.thim-slider .scroll-icon').on('click', function () {
				var offset = $(this).offset().top;
				$('html,body').animate({scrollTop: offset + 80}, 800);
				return false;
			});

		},

		/**
		 * Mobile menu
		 */
		header_menu_mobile: function () {
			$(document).on('click', '.menu-mobile-effect', function (e) {
				e.stopPropagation();
				$('.responsive #wrapper-container').toggleClass('mobile-menu-open');
			});

			$(document).on('click', '.mobile-menu-open .overlay-close-menu', function () {
				$('.responsive #wrapper-container').removeClass('mobile-menu-open');
			});

			$('.main-menu li.menu-item-has-children > a,.main-menu li.menu-item-has-children > span, .main-menu li.tc-menu-layout-builder > a,.main-menu li.tc-menu-layout-builder > span').after('<span class="icon-toggle"><i class="fa fa-caret-down"></i></span>');

			$('.responsive .mobile-menu-container .navbar-nav > li.menu-item-has-children > a, .responsive .mobile-menu-container .navbar-nav > li.tc-menu-layout-builder:not(.current-menu-parent) > a').after('<span class="icon-toggle"><i class="fa fa-caret-down"></i></span>');


			$('.responsive .mobile-menu-container .navbar-nav > li.menu-item-has-children .icon-toggle,' +
				'.responsive .mobile-menu-container .navbar-nav > li.tc-menu-layout-builder .icon-toggle ').on('click', function () {

				if ($(this).next('.sub-menu').is(':hidden')) {
					$(this).next('.sub-menu').slideDown(200, 'linear').parent().addClass('show-submenu');
					$(this).html('<i class="fa fa-caret-up"></i>');
				} else {
					$(this).next('.sub-menu').slideUp(200, 'linear').parent().removeClass('show-submenu');
					$(this).html('<i class="fa fa-caret-down"></i>');
				}
			});
		},

		/**
		 * Magic line header menu
		 */
		magic_line: function () {

			if ($(window).width() > 1024) {
				var $el, leftPos, newWidth,
					$mainNav = $("header.header-magic-line.affix-top .main-menu");

				$mainNav.append("<span id='magic-line'></span>");
				var $magicLine = $("#magic-line");
				var $current = $mainNav.find('.current-menu-item, .current-menu-parent'),
					$current_a = $current.find('> a');

				if ($current.length <= 0) {
					return;
				}


				$('body:not(.rtl)').each(function () {

					$magicLine
						.width($current_a.width())
						.css("left", $current.position().left + parseInt($current_a.css('padding-left')))
						.data("origLeft", $current.position().left + parseInt($current_a.css('padding-left')))
						.data("origWidth", $current_a.width());
				});


				$('body.rtl').each(function () {
					$magicLine
						.width($current_a.width())
						.css("left", $current.position().left + parseInt($current_a.css('padding-left')))
						.data("origLeft", $current.position().left + parseInt($current_a.css('padding-left')))
						.data("origWidth", $current_a.width());
				});


				$(".main-menu > .menu-item").hover(function () {
					$el = $(this);
					leftPos = $el.position().left + parseInt($el.find('> a').css('padding-left'));
					newWidth = $el.find('> a').width();
					$magicLine.stop().animate({
						left : leftPos,
						width: newWidth
					});
				}, function () {
					$magicLine.stop().animate({
						left : $magicLine.data("origLeft"),
						width: $magicLine.data("origWidth")
					});
				});
			}

		},

		show_password_form: function () {
			$(document).on('click', '#show_pass', function () {
				var el = $(this),
					thim_pass = el.parents('.login-password').find('>input');
				if (el.hasClass('active')) {
					thim_pass.attr('type', 'password');
				} else {
					thim_pass.attr('type', 'text');
				}
				el.toggleClass('active');
			});
		},

		/**
		 * Header menu sticky, scroll, v.v.
		 */
		thim_topbar: function () {
			var header = $('#masthead'),
				height_header = header.outerHeight(true),
				content_pusher = $('#wrapper-container'),
				top_site_main = $('#wrapper-container .page-title .main-top');

			if (header.hasClass('header-overlay')) {
				top_site_main.css({'padding-top': height_header + 'px'});
				$(window).resize(function () {
					// var height_header = header.outerHeight(true);
					top_site_main.css({'padding-top': height_header + 'px'});
				});
			} else {
				content_pusher.css({'padding-top': height_header + 'px'});
				$(window).resize(function () {
					// var height_header = header.outerHeight(true);
					content_pusher.css({'padding-top': height_header + 'px'});
				});

			}
		},


		header_menu: function () {
			var $header = $('#masthead'),
				$header_wrapper = $('#masthead .header-wrapper'),
				off_Top = 0,
				menuH = $header.outerHeight(),
				// $topbar = $('#thim-header-topbar'),
				latestScroll = 0,
				// startSticky = $header_wrapper.offset().top,
				main_Offset = 0;
			var $imgLogo = $('.site-header .thim-logo img'),
				srcLogo = $($imgLogo).attr('src'),
				dataRetina = $($imgLogo).data('retina'),
				dataSticky = $($imgLogo).data('sticky'),
				dataStickyRetina = $($imgLogo).data('sticky_retina'),
				dataMobile = $($imgLogo).data('mobile');

			if($(window).outerWidth() < 769) {
				if(dataMobile != null) {
					$($imgLogo).attr('src', dataMobile);
				}
			}else{
				if (window.devicePixelRatio > 1 && dataRetina != null) {
					$($imgLogo).attr('src', dataRetina);
				}
			}

			if ($header.hasClass('header-overlay')) {
				// single course
				if ($(window).width() >= 1024) {
					if ($('.header-course-bg').length) {
						$('.header-course-bg').css({
							'height': $('.header-course-bg').outerHeight() + menuH
						});
					}
				}
			}

			if ($header.hasClass('sticky-header')) {

				// if ($(window).scrollTop() > 2) {
				// 	$header.removeClass('affix-top').addClass('affix');
				// }


				$(window).scroll(function () {
					var current = $(this).scrollTop();

					if (current > 2) {
						$header.removeClass('affix-top').addClass('affix');
						if($(window).outerWidth() < 769) {
							if(dataMobile != null) {
								$($imgLogo).attr('src', dataMobile);
							}
						}else{
 							if (window.devicePixelRatio > 1 && dataStickyRetina != null) {
								$($imgLogo).attr('src', dataStickyRetina);
							}else if(dataSticky != null){
								$($imgLogo).attr('src', dataSticky);
							}
						}

					} else {
						$header.removeClass('affix').addClass('affix-top');
						if($(window).outerWidth() < 769) {
							if(dataMobile != null) {
								$($imgLogo).attr('src', dataMobile);
							}
						}else{
							if (window.devicePixelRatio > 1 && dataRetina != null) {
								$($imgLogo).attr('src', dataRetina);
							}else if(srcLogo != null) {
								$($imgLogo).attr('src', srcLogo);
							}
						}
					}

					if (current > latestScroll && current > menuH + off_Top) {
						if (!$header.hasClass('menu-hidden')) {
							$header.addClass('menu-hidden');
						}
					} else {
						if ($header.hasClass('menu-hidden')) {
							$header.removeClass('menu-hidden');
						}
					}

					latestScroll = current;
				});
			}


			$('#masthead.template-layout-2 .main-menu > .menu-item-has-children, #masthead.template-layout-2 .main-menu > .tc-menu-layout-builder, .template-layout-2 .main-menu > li ul li').hover(
				function () {
					$(this).children('.sub-menu').stop(true, false).slideDown(250);
				},
				function () {
					$(this).children('.sub-menu').stop(true, false).slideUp(250);
				}
			);

			$('#masthead.template-layout-2 .main-menu > .tc-menu-layout-builder').each(function () {
				var elem = $(this),
					sub_menu = elem.find('>.sub-menu');
				if (sub_menu.length > 0) {
					sub_menu.css('left', (elem.width() - sub_menu.width()) / 2);
				}

			});

			$('.main-menu >li.tc-menu-layout-builder').each(function () {
				$('.widget_nav_menu ul.menu >li.current-menu-item').parents('li.tc-menu-layout-builder').addClass('current-menu-item');
			});

		},

		off_canvas_menu: function () {
			var $off_canvas_menu = $('.mobile-menu-container'),
				$navbar = $off_canvas_menu.find('.navbar-nav');

			var menuH = 0;
			var toggleH = $off_canvas_menu.find('.navbar-toggle').outerHeight();
			var widgetH = $off_canvas_menu.find('.off-canvas-widgetarea').outerHeight();
			var innerH = $off_canvas_menu.innerHeight();

			menuH = innerH - toggleH - widgetH;

			$navbar.css({
				'height': menuH
			});
		},

		/**
		 * Back to top
		 */
		back_to_top: function () {
			var $element = $('#back-to-top');
			$(window).scroll(function () {
				if ($(this).scrollTop() > 100) {
					$element.addClass('scrolldown').removeClass('scrollup');
				} else {
					$element.addClass('scrollup').removeClass('scrolldown');
				}
			});

			$element.on('click', function () {
				$('html,body').animate({scrollTop: '0px'}, 800);
				return false;
			});
		},

		/**
		 * Sticky sidebar
		 */
		sticky_sidebar: function () {
			var offsetTop = 20;

			if ($("#wpadminbar").length) {
				offsetTop += $("#wpadminbar").outerHeight();
			}
			if ($("#masthead.sticky-header").length) {
				offsetTop += $("#masthead.sticky-header").outerHeight();
			}

			if ($('.sticky-sidebar').length > 0) {
				$(".sticky-sidebar").theiaStickySidebar({
					"containerSelector"     : "",
					"additionalMarginTop"   : offsetTop,
					"additionalMarginBottom": "0",
					"updateSidebarHeight"   : false,
					"minWidth"              : "768",
					"sidebarBehavior"       : "modern"
				});
			}
		},


		/**
		 * feature: Preloading
		 */

		feature_preloading: function () {
			var $preload = $('#thim-preloading');

			if ($preload.length > 0) {
				$preload.fadeOut(500, function () {
					$preload.remove();
				});
			}
		},


		/**
		 * add_loading_button
		 */

		add_loading_enroll_button: function () {

			$("body.no-single-popup  button.lp-button, body.logged-in form button.lp-button").on('click', function () {
				$(this).addClass('loading');
			});

		},

		/**
		 * Custom effect and UX for contact form.
		 */

		contactform7: function () {
			$(".wpcf7-submit").on('click', function () {
				$(this).css("opacity", 0.2);
				$(this).parents('.wpcf7-form').addClass('processing');
				$('input:not([type=submit]), textarea').attr('style', '');
			});

			$(document).on('spam.wpcf7', function () {
				$(".wpcf7-submit").css("opacity", 1);
				$('.wpcf7-form').removeClass('processing');
			});

			$(document).on('invalid.wpcf7', function () {
				$(".wpcf7-submit").css("opacity", 1);
				$('.wpcf7-form').removeClass('processing');
			});

			$(document).on('mailsent.wpcf7', function () {
				$(".wpcf7-submit").css("opacity", 1);
				$('.wpcf7-form').removeClass('processing');
			});

			$(document).on('mailfailed.wpcf7', function () {
				$(".wpcf7-submit").css("opacity", 1);
				$('.wpcf7-form').removeClass('processing');
			});

			$('body').on('click', 'input:not([type=submit]).wpcf7-not-valid, textarea.wpcf7-not-valid', function () {
				$(this).removeClass('wpcf7-not-valid');
			});
		},

		/**
		 * Blog auto height
		 */
		blog_auto_height: function () {
			var $blog = $('.archive .blog-content article'),
				maxHeight = 0,
				setH = true;

			// Get max height of all items.
			$blog.each(function () {
				setH = $(this).hasClass('column-1') ? false : true;
				if (maxHeight < $(this).find('.content-inner').height()) {
					maxHeight = $(this).find('.content-inner').height();
				}
			});

			// Set height for all items.
			if (maxHeight > 0 && setH) {
				$blog.each(function () {
					$(this).find('.content-inner').css('height', maxHeight);
				});
			}
		},

		/**
		 * Widget Masonry
		 */
		// widget_masonry: function () {
		// 	var originLeft = true;
		// 	if ($('body').hasClass('rtl')) {
		// 		originLeft = false;
		// 	}
		//
		// 	$('.masonry-items').imagesLoaded(function () {
		// 		var $grid = $('.masonry-items').isotope({
		// 			percentPosition: true,
		// 			itemSelector   : 'article',
		// 			masonry        : {
		// 				columnWidth: 'article'
		// 			},
		// 			originLeft     : originLeft,
		// 		});
		//
		// 		$('.masonry-filter').on('click', 'a', function () {
		// 			var filterValue = $(this).attr('data-filter');
		// 			$grid.isotope({filter: filterValue});
		// 		});
		// 	});
		// },

		// widget_brands: function () {
		// 	var rtl = false;
		// 	if ($('body').hasClass('rtl')) {
		// 		rtl = true;
		// 	}
		//
		// 	$(".thim-brands").each(function () {
		// 		var items = parseInt($(this).attr('data-items'));
		// 		$(this).owlCarousel({
		// 			nav       : false,
		// 			dots      : false,
		// 			rtl       : rtl,
		// 			responsive: {
		// 				0   : {
		// 					items: 2,
		// 				},
		// 				480 : {
		// 					items: 3,
		// 				},
		// 				768 : {
		// 					items: 4,
		// 				},
		// 				1024: {
		// 					items: items,
		// 				}
		// 			}
		// 		});
		// 	});
		// },

		//single courses carousel

		carousel: function () {
			var rtlval = false;
			if ($('body').hasClass('rtl')) {
				var rtlval = true;
			}
			$(".courses-carousel").each(function (index, element) {
				$('.courses-carousel').owlCarousel({
					rtl            : rtlval,
					nav            : true,
					dots           : false,
					margin         : 30,
					navText        : ['<i class="ion-chevron-left" aria-hidden="true"></i>', '<i class="ion-chevron-right"></i>'],
					responsiveClass: true,
					responsive     : {
						0  : {
							items: 1
						},
						481: {
							items: 2
						},
						769: {
							items: 3
						}
					}
				});
			});
		},

		//single course video thumbnail
		video_thumbnail: function () {
			if (jQuery().magnificPopup) {
				$(".video-thumbnail").magnificPopup({
					type: 'iframe',
				});
			}
		},

		//Grid and List
		// switch_layout: function () {
		// 	var cookie_name = $('.grid-list-switch').data('cookie');
		// 	var courses_layout = $('.grid-list-switch').data('layout');
		// 	var $list_grid = $('.grid-list-switch');
		//
		// 	if (cookie_name == 'product-switch') {
		// 		var gridClass = 'product-grid';
		// 		var listClass = 'product-list';
		// 	} else if (cookie_name == 'lpr_course-switch') {
		// 		var gridClass = 'course-grid';
		// 		var listClass = 'course-list';
		// 	} else {
		// 		var gridClass = 'blog-grid';
		// 		var listClass = 'blog-list';
		// 	}
		//
		// 	var check_view_mod = function () {
		// 		var activeClass = 'switcher-active';
		// 		if ($list_grid.hasClass('has-layout')) {
		// 			if (courses_layout == 'grid') {
		// 				$('.archive_switch').removeClass(listClass).addClass(gridClass);
		// 				$('.switchToGrid').addClass(activeClass);
		// 				$('.switchToList').removeClass(activeClass);
		// 			} else {
		// 				$('.archive_switch').removeClass(gridClass).addClass(listClass);
		// 				$('.switchToList').addClass(activeClass);
		// 				$('.switchToGrid').removeClass(activeClass);
		// 			}
		// 		} else {
		// 			// if ($.cookie(cookie_name) == 'grid') {
		// 			// 	$('.archive_switch').removeClass(listClass).addClass(gridClass);
		// 			// 	$('.switchToGrid').addClass(activeClass);
		// 			// 	$('.switchToList').removeClass(activeClass);
		// 			// } else if ($.cookie(cookie_name) == 'list') {
		// 			// 	$('.archive_switch').removeClass(gridClass).addClass(listClass);
		// 			// 	$('.switchToList').addClass(activeClass);
		// 			// 	$('.switchToGrid').removeClass(activeClass);
		// 			// }
		// 			// else {
		// 			if (courses_layout === 'grid') {
		// 				$('.switchToList').removeClass(activeClass);
		// 				$('.switchToGrid').addClass(activeClass);
		// 				$('.archive_switch').removeClass(listClass).addClass(gridClass);
		// 			} else {
		// 				$('.switchToList').addClass(activeClass);
		// 				$('.switchToGrid').removeClass(activeClass);
		// 				$('.archive_switch').removeClass(gridClass).addClass(listClass);
		// 			}
		// 			// }
		// 		}
		// 	};
		// 	check_view_mod();
		//
		// 	var listSwitcher = function () {
		// 		var activeClass = 'switcher-active';
		// 		if ($list_grid.hasClass('has-layout')) {
		// 			$('.switchToList').click(function () {
		// 				$('.switchToList').addClass(activeClass);
		// 				$('.switchToGrid').removeClass(activeClass);
		// 				$('.archive_switch').fadeOut(300, function () {
		// 					$(this).removeClass(gridClass).addClass(listClass).fadeIn(300);
		// 				});
		// 			});
		// 			$('.switchToGrid').click(function () {
		// 				$('.switchToGrid').addClass(activeClass);
		// 				$('.switchToList').removeClass(activeClass);
		// 				$('.archive_switch').fadeOut(300, function () {
		// 					$(this).removeClass(listClass).addClass(gridClass).fadeIn(300);
		// 				});
		// 			});
		// 		} else {
		//
		// 			$('.switchToList').click(function () {
		// 				if (!$.cookie(cookie_name) || $.cookie(cookie_name) == 'grid') {
		// 					switchToList();
		// 				}
		// 			});
		// 			$('.switchToGrid').click(function () {
		// 				if (!$.cookie(cookie_name) || $.cookie(cookie_name) == 'list') {
		// 					switchToGrid();
		// 				}
		// 			});
		// 		}
		//
		// 		function switchToList() {
		// 			$('.switchToList').addClass(activeClass);
		// 			$('.switchToGrid').removeClass(activeClass);
		// 			$('.archive_switch').fadeOut(300, function () {
		// 				$(this).removeClass(gridClass).addClass(listClass).fadeIn(300);
		// 				$.cookie(cookie_name, 'list', {expires: 3, path: '/'});
		// 			});
		// 		}
		//
		// 		function switchToGrid() {
		// 			$('.switchToGrid').addClass(activeClass);
		// 			$('.switchToList').removeClass(activeClass);
		// 			$('.archive_switch').fadeOut(300, function () {
		// 				$(this).removeClass(listClass).addClass(gridClass).fadeIn(300);
		// 				$.cookie(cookie_name, 'grid', {expires: 3, path: '/'});
		// 			});
		// 		}
		//
		// 		$(".product-filter").each(function () {
		// 			$('.switchToGrid').addClass(activeClass);
		// 			$('.archive_switch').removeClass('product-list').addClass('product-grid');
		// 		});
		// 	}
		//
		// 	listSwitcher();
		// },

		switch_layout: function () {
			var cookie_name = 'course_switch',
				archive = $('.archive-courses')
			if (archive.length > 0) {

				$(document).on('click', '.thim-course-switch-layout > a', function (event) {
					var elem = $(this),
						archive = $('.archive-courses')
					event.preventDefault()
					if (!elem.hasClass('switcher-active')) {
						$('.thim-course-switch-layout > a').removeClass('switcher-active')
						elem.addClass('switcher-active')
						if (elem.hasClass('switchToGrid')) {
							archive.fadeOut(300, function () {
								archive.removeClass('course-list').addClass(' course-grid').fadeIn(300)
								jQuery.cookie(cookie_name, 'grid-layout',
									{ expires: 3, path: '/' })
							})
						} else {
							archive.fadeOut(300, function () {
								archive.removeClass('course-grid').addClass('course-list').fadeIn(300)
								jQuery.cookie(cookie_name, 'list-layout',
									{ expires: 3, path: '/' })
							})
						}
					}
				})
			}
		},

		/**
		 * Related Post Carousel
		 * @author Khoapq
		 */
		single_post_related: function () {
			var rtlval = false;
			if ($('body').hasClass('rtl')) {
				var rtlval = true;
			}
			$('.related-carousel').owlCarousel({
				rtl            : rtlval,
				nav            : true,
				dots           : false,
				responsiveClass: true,
				margin         : 30,
				navText        : ['<i class="ion-chevron-left" aria-hidden="true"></i>', '<i class="ion-chevron-right"></i>'],
				responsive     : {
					0  : {
						items: 2
					},
					569: {
						items: 3
					}
				}
			});
		},

		// lp_single_course
		curriculum_single_course: function () {

			$(".search").find("input[type=search]").each(function () {
				$(".search-field").attr("placeholder", "Search...");
			});
			$("#commentform").each(function () {
				$(".comment-form-comment #comment").on("click", function () {
					$(this).css("transition", ".5s");
					$(this).css("min-height", "200px");
					$("p.form-submit").css("display", "block");
				});
			});

			//cookie
			var data_cookie = $(".learn-press-nav-tabs").data('cookie');
			var data_cookie2 = $(".learn-press-nav-tabs").data('cookie2');
			var data_tab = $('.learn-press-nav-tab.active a').data('key');
			var data_id = $(".learn-press-nav-tab.active a").data('id');

			$(".learn-press-nav-tab a").on('click', function () {
				var data_key = $(this).data('key');
				var data_id = $(this).data('id');
				$.cookie(data_cookie2, data_id, {expires: 3, path: '/'});
				$.cookie(data_cookie, data_key, {expires: 3, path: '/'});
			});
			if ($.cookie(data_cookie2) != data_id) {
				$.cookie(data_cookie, 'overview', {expires: 3, path: '/'});
			}

			if ($.cookie(data_cookie) == null) {
				$.cookie(data_cookie, 'overview', {expires: 3, path: '/'});
			}

			if ($.cookie(data_cookie) == data_tab) {
				var tab_class = $('.learn-press-nav-tab-' + $.cookie(data_cookie));
				var panel_class = $('.learn-press-tab-panel-' + $.cookie(data_cookie));
				$(".learn-press-nav-tab").removeClass("active");
				tab_class.addClass("active");
				$(".learn-press-tab-panel").removeClass("active");
				panel_class.addClass("active");
			}
		},

		/**
		 * Load more Profile
		 */
		loadmore_profile: function () {
			$('#load-more-button').on('click', '.loadmore', function (event) {
				event.preventDefault();

				var $sc = $('.profile-courses');

				var paged = parseInt($sc.attr('data-page')),
					limit = parseInt($sc.attr('data-limit')),
					count = parseInt($sc.attr('data-count')),
					userid = parseInt($sc.attr('data-user')),
					loading = false;

				if (!loading) {
					var $button = $(this);
					var rank = $sc.find('.course').length;
					loading = true;
					var current_page = paged + 1;

					var data = {
						action: 'thim_profile_loadmore',
						paged : current_page,
						limit : limit,
						rank  : rank,
						count : count,
						userid: userid
					};

					console.log(data);

					$.ajax({
						type: "POST",
						url : ajaxurl,
						data: data,

						beforeSend: function () {
							$('#load-more-button').addClass('loading');

						},
						success   : function (res) {
							$sc.append(res);
							$('#load-more-button').removeClass('loading');
							$sc.attr('data-page', current_page);
							if ((rank + limit) >= count) {
								$('#load-more-button').remove();
							}
							$(window).lazyLoadXT();
						}
					});
				}
			});
		},

		/*
		 * Update user info in profile page LearnPress v3
		 * */
		profile_update: function () {
			if (!$('body').hasClass('lp-profile')) {
				return;
			}


			var $form = $('form[name="lp-edit-profile"]'),
				data = $form.serialize(),
				timer = null;

			if ($form.hasClass('learnpress-v3-profile')) {
				$form.on('submit', function () {
					var data = $form.serializeJSON(),
						compvared = 0,
						$els = $('.lp-profile-section'),
						total = $els.length,
						$sections = $form.find('.lp-profile-section'),
						serialize = function ($el) {
							return $('<form />').append($el.clone()).serializeJSON();
						};

					$('#submit').css("color", "transparent");
					$form.find('#submit .sk-three-bounce').removeClass('hidden');

					$sections.each(function () {
						var $section = $(this),
							slug = $section.find('input[name="lp-profile-section"]').val();

						if (slug === 'avatar') {
							if ($section.find('input[name="lp-user-avatar-custom"]').last().val() !== 'yes') {
								compvared++;
								return;
							}
						}

						$.ajax({
							url    : window.location.href,
							data   : serialize($section),
							type   : 'post',
							success: function (res) {

								if (++compvared == total) {
									window.location.href = window.location.href;
								}
							}
						});
					});

					return false;
				});
			} else {
				$form.on('submit', function () {
					var data = $form.serializeJSON(),
						compvared = 0,
						$els = $('.lp-profile-section'),
						total = $els.length;

					$('#submit').css("color", "transparent");
					$form.find('#submit .sk-three-bounce').removeClass('hidden');
					$els.each(function () {
						data['lp-profile-section'] = $(this).find('input[name="lp-profile-section"]').val();
						if (data['lp-profile-section'] === 'avatar') {
							if ($(this).find('input[name="update-custom-avatar"]').last().val() !== 'yes') {
								compvared++;
								return;
							}
						}

						$.post({
							url    : window.location.href,
							data   : data,
							success: function (res) {
								compvared++;
								if (compvared === total) {
									window.location.href = window.location.href;
								}

							}
						})
					});
					return false;
				});
			}

		},

		/*
		 * Switch tab in profile page
		 * */
		get_tab_content: function (slug, current_tab) {
			$(".lp-profile .tabs-title .tab").removeClass("active");
			$(".lp-profile .tabs-title .tab[data-tab=" + current_tab + "]").addClass("active");

			$(".tabs-content .content").removeClass("active");
			$(slug).addClass("active");
		},

		profile_switch_tabs: function () {
			window.addEventListener('popstate', function (e) {
				var state = e.state;
				if (state == null) {
					thim_course_builder.get_tab_content('#tab-courses', 'courses_tab');
					return;
				}

				thim_course_builder.get_tab_content(state.slug, state.tab);
			});

			$(".tabs-title .tab > a").on('click', function (e) {
				e.preventDefault();
				var url = $(this).attr('href');
				var slug = $(this).attr('data-slug');
				var current_tab = $(this).parent().attr('data-tab');
				var tab_info = {slug: slug, tab: current_tab};

				thim_course_builder.get_tab_content(slug, current_tab);
				history.pushState(tab_info, null, url);
				if (current_tab == 'certificates_tab') {
					$(window).resize();
				}
			});
		},

		profile_slide_certificates: function () {
			var rtlval = false;
			if ($('body').hasClass('rtl')) {
				var rtlval = true;
			}
			$('#tab-settings .certificates-section .learn-press-user-profile-certs').owlCarousel({
				rtl       : rtlval,
				items     : 4,
				nav       : true,
				dots      : false,
				navText   : ['<i class="fa fa-angle-left" aria-hidden="true"></i>', '<i class="fa fa-angle-right" aria-hidden="true"></i>'],
				responsive: {
					0   : {
						items: 2
					},
					481 : {
						items: 4
					},
					1025: {
						items: 4
					}
				}
			});

			$('#tab-settings .certificates-section .learn-press-user-profile-certs .more-info').on('click', function (e) {
				e.preventDefault();
				var url = $(this).parent().attr('href');
				history.pushState(null, null, url);
				thim_course_builder.get_tab_content('#tab-certificates', 'certificates_tab');
			});
		},

		/**
		 * Product single slider
		 */
		product_slider: function () {
			$('#carousel').flexslider({
				animation    : "slide",
				direction    : "vertical",
				controlNav   : false,
				animationLoop: false,
				slideshow    : false,
				itemWidth    : 101,
				itemMargin   : 5,
				maxItems     : 3,
				directionNav : false,
				asNavFor     : '#slider'
			});

			$('#slider').flexslider({
				animation    : "slide",
				controlNav   : false,
				animationLoop: false,
				directionNav : false,
				slideshow    : false,
				sync         : "#carousel"
			});
		},
		/**
		 * Quickview product
		 */
		quick_view    : function () {
			$('.quick-view').on('click', function (e) {
				/* add loader  */
				$('.quick-view span').css('display', 'none');
				$(this).append('<span class="loading dark"></span>');
				var product_id = $(this).attr('data-prod');
				var data = {action: 'jck_quickview', product: product_id};
				$.post(ajaxurl, data, function (response) {
					$.magnificPopup.open({
						mainClass: 'my-mfp-zoom-in',
						items    : {
							src : response,
							type: 'inline'
						}
					});
					$('.quick-view span').css('display', 'inline-block');
					$('.loading').remove();
					$('.product-card .wrapper').removeClass('animate');
					setTimeout(function () {
						$('.product-lightbox form').wc_variation_form();
					}, 600);

					$('#slider').flexslider({
						animation    : "slide",
						controlNav   : false,
						animationLoop: false,
						directionNav : true,
						slideshow    : false
					});
				});
				e.preventDefault();
			});
		},

		coming_soon_hover_effect: function () {
			$(".thim-course-coming-soon .hover").mouseleave(
				function () {
					$(this).removeClass("hover");
				}
			)
		},

		login_popup_ajax: function () {

			$(document).on('click touch', '#thim-popup-login .close-popup', function (event) {
				event.preventDefault();
				$('body').removeClass('thim-popup-active');
				$('#thim-popup-login').removeClass('active');

			});

			$(document).on('click touch', 'body.auto-login .thim-login-popup.thim-link-login a, body.dis-auto-login .thim-login-popup.thim-link-login a', function (event) {
				//// if ($(window).width() > 767) {
				event.preventDefault();
				$('body').addClass('thim-popup-active');

				var $popup_container = $('#thim-popup-login'),
					$link_to_form = $popup_container.find('.link-to-form');

				if ($(this).hasClass('login')) {
					$link_to_form.removeClass('login').addClass('register');
					$popup_container.find('.login-form').addClass('active');
					$popup_container.find('.register-form').removeClass('active');
				}

				if ($(this).hasClass('register')) {
					$link_to_form.removeClass('register').addClass('login');
					$popup_container.find('.register-form').addClass('active');
					$popup_container.find('.login-form').removeClass('active');
				}

				$popup_container.addClass('active');
				// }

			});

			$(document).on('click touch', 'body.dis-auto-login .thim-login-popup.thim-link-login a', function (event) {
				// if ($(window).width() > 767) {

				event.preventDefault();
				$('body').addClass('thim-popup-active');

				var $popup_container = $('#thim-popup-login'),
					$link_to_form = $popup_container.find('.link-to-form');

				if ($(this).hasClass('login')) {
					$link_to_form.removeClass('login').addClass('register');
					$popup_container.find('.login-form').addClass('active');
					$popup_container.find('.register-form').removeClass('active');
				}

				if ($(this).hasClass('register')) {
					$link_to_form.removeClass('register').addClass('login');
					$popup_container.find('.register-form').addClass('active');
					$popup_container.find('.login-form').removeClass('active');
				}

				$popup_container.addClass('active');

				// }

			});

			$(document).on('click touch', '#thim-popup-login', function (e) {
				if ($(e.target).attr('id') === 'thim-popup-login') {
					$('body').removeClass('thim-popup-active');
					$('#thim-popup-login').removeClass();
				}
			});

			// Switch between 2 form
			$(document).on('click touch', 'body.auto-login #thim-popup-login .link-to-form a', function (event) {
				event.preventDefault();
				var $parent = $('#thim-popup-login').find('.link-to-form'),
					$popup_container = $('#thim-popup-login');

				if ($(this).hasClass('register-link')) {
					$parent.removeClass('register').addClass('login');
					$popup_container.find('.register-form').addClass('active');
					$popup_container.find('.login-form').removeClass('active');

				}

				if ($(this).hasClass('login-link')) {
					$parent.removeClass('login').addClass('register');
					$popup_container.find('.login-form').addClass('active');
					$popup_container.find('.register-form').removeClass('active');
				}

			});

			$(document).on('click touch', 'body.dis-auto-login #thim-popup-login .link-to-form a', function (event) {
				event.preventDefault();

				var $parent = $('#thim-popup-login').find('.link-to-form'),
					$popup_container = $('#thim-popup-login');
				if ($(this).hasClass('register-link')) {
					$parent.removeClass('register').addClass('login');
					$popup_container.find('.register-form').addClass('active');
					$popup_container.find('.login-form').removeClass('active');

				}

				if ($(this).hasClass('login-link')) {
					$parent.removeClass('login').addClass('register');
					$popup_container.find('.login-form').addClass('active');
					$popup_container.find('.register-form').removeClass('active');
				}

			});

			$('#popupLoginForm').submit(function (event) {
				var form = $(this),
					elem = $('#thim-popup-login .thim-login-container');

				if (!thim_course_builder.validate_popup_form($(this))) {
					return false;
				}

				elem.addClass('loading');

				var data = {
					action: 'thim_login_ajax',
					data  : form.serialize()
				};

				$.post(ajaxurl, data, function (response) {

					try {
						response = JSON.parse(response);
						form.find('.popup-message').html(response.message);
						if (response.code == '1') {
							if (response.redirect) {
								window.location.href = response.redirect;
							} else {
								location.reload();
							}
						}

					} catch (e) {
						return false;
					}
					elem.removeClass('loading');
				});

				return false;
			});

			$('#popupRegisterForm').submit(function (event) {
				event.preventDefault();

				var form = $(this),
					redirect_to = form.find("input[name=redirect_to]").val(),
					elem = $('#thim-popup-login .thim-login-container');

				if (!thim_course_builder.validate_popup_form($(this))) {
					return false;
				}

				elem.addClass('loading');
				elem.find('.message').slideDown().remove();

				var data = {
					action           : 'thim_register_ajax',
					data             : form.serialize() + '&wp-submit=' +
						form.find('input[type=submit]').val(),
					register_security: form.find('#register_security').val(),
				};

				$.ajax({
					type   : 'POST',
					url    : ajaxurl,
					data   : data,
					success: function (response) {
						elem.removeClass('loading');
						if (typeof response.data !== 'undefined') {
							form.find('.popup-message').html(response.data.message);
						}

						if (response.success === true) {
							if (form.hasClass('auto_login')) {
								window.location.href = redirect_to;
							}
						}
					},
				});

			});

			return false;
		},

		form_submission_validate: function () {
			// Form login
			$('.form-submission-login form[name=loginform]').on('submit', function (e) {
				if (!thim_course_builder.validate_popup_form($(this))) {
					e.preventDefault();
					return false;
				}
			});

			// Form register
			$('.form-submission-register form[name=registerform]').on('submit', function (e) {
				if (!thim_course_builder.validate_popup_form($(this))) {
					e.preventDefault();
					return false;
				}
			});

			$('form[name=registerform]').on('submit', function (e) {
				if (!thim_course_builder.validate_popup_form($(this))) {
					e.preventDefault();
					return false;
				}
			});

			// Form lost password
			$('.form-submission-lost-password form[name=lostpasswordform]').on('submit', function (e) {
				if (!thim_course_builder.validate_popup_form($(this))) {
					e.preventDefault();
					return false;
				}
			});
		},

		reset_password_ajax: function () {
			$("#resetpassform").submit(function () {
				var submit = $("#resetpass-button"),
					message = $(this).find(".message-notice"),
					loading = $(this).find(".sk-three-bounce"),
					contents = {
						action    : 'thim_reset_password_ajax',
						nonce     : this.rs_user_reset_password_nonce.value,
						pass1     : this.pass1.value,
						pass2     : this.pass2.value,
						user_key  : this.user_key.value,
						user_login: this.rp_user.value
					};

				// disable button onsubmit to avoid double submision
				submit.attr("disabled", "disabled").addClass('disabled');
				loading.removeClass("hidden");

				$.post(ajaxurl, contents, function (data) {
					var response = JSON.parse(data), status, content = "";
					submit.removeAttr("disabled").removeClass('disabled');
					loading.addClass("hidden");

					for (status in response) {
						if (status === 'password_reset') {
							content += "<p class='alert alert-success'>" + response[status][0] + "</p>";
							message.html(content);
							var newURL = window.location.protocol + "//" + window.location.host + "/" + window.location.pathname + "?result=changed";
							window.location.replace(newURL);
						} else {
							content += "<p class='alert alert-danger'>" + response[status][0] + "</p>";
						}
					}
					message.html(content);
				});

				return false;
			});

		},

		/*
		* Validate login form, register form, forgot password form
		**/

		validate_popup_form: function (form) {
			var valid = true,
				email_valid = /[A-Z0-9._%+-]+@[A-Z0-9.-]+.[A-Z]{2,4}/igm;

			form.find('input.required').each(function () {
				// Check empty value
				if (!$(this).val()) {
					$(this).addClass('invalid');
					valid = false;
				}


				// Uncheck
				if ($(this).is(':checkbox') && !$(this).is(':checked')) {
					$(this).addClass('invalid');
					valid = false;
				}

				// Check email format
				if ('email' === $(this).attr('type')) {
					if (!email_valid.test($(this).val())) {
						$(this).addClass('invalid');
						valid = false;
					}
				}

				// Check captcha
				if ($(this).hasClass('captcha-result')) {
					var captcha_1 = parseInt($(this).data('captcha1')),
						captcha_2 = parseInt($(this).data('captcha2'));

					if ((captcha_1 + captcha_2) !== parseInt($(this).val())) {
						$(this).addClass('invalid').val('');
						valid = false;
					}
				}
			});

			// Check repeat password
			if (form.hasClass('auto_login')) {

				var $pw = form.find('input[name=password]'),
					$repeat_pw = form.find('input[name=repeat_password]');

				if ($pw.val() !== $repeat_pw.val()) {
					$pw.addClass('invalid');
					$repeat_pw.addClass('invalid');
					valid = false;
				}
			}

			$('form input.required').on('focus', function () {
				$(this).removeClass('invalid');
			});

			return valid;

		},

		/*
		* WordPress Visual Composer full width row ( stretch row ) fix for RTL
		* */
		thim_fix_vc_full_width_row: function () {
			if ($('html').attr('dir') === 'rtl') {
				setTimeout(function () {
					$(window).trigger('resize');
				}, 1000);
				$(window).resize(function () {
					var get_padding1 = parseFloat($('body.rtl .vc_row-has-fill[data-vc-full-width="true"]').css('left')),
						get_padding2 = parseFloat($('body.rtl .vc_row-no-padding[data-vc-full-width="true"]').css('left'));
					if (get_padding1 != 'undefined') {
						$('body.rtl .vc_row-has-fill[data-vc-full-width="true"]').css({
							'right': get_padding1,
							'left' : ''
						});
					}
					if (get_padding2 != 'undefined') {
						$('body.rtl .vc_row-no-padding[data-vc-full-width="true"]').css({
							'right': get_padding2,
							'left' : ''
						});
					}
				});
			}
		},

 		/*
		* Learning course tab navigation
		* */
		learning_course_tab_nav: function () {

			if (!$("body").hasClass("lp-landing")) {
				return;
			}

			var $course_menu_tab = $("#thim-landing-course-menu-tab");

			if (!$course_menu_tab.length) {
				return;
			}

			var $course_content = $("#learn-press-course-curriculum"),
				course_content_position = $course_content.offset().top - 200;

			$(window).scroll(function () {
				if ($(window).scrollTop() > course_content_position) {
					$("body").addClass("course-tab-active");
				} else {
					$("body").removeClass("course-tab-active");
				}
			});

			var $tab = $course_menu_tab.find("li>a");

			$tab.on('click', function () {
				$(this).parent().addClass('active').siblings().removeClass('active');
			});
		},

		/*
		* Show current section in course curriculum and hide other ones
		* */
		show_current_curriculum_section: function () {

			//Add class for profile tab

			var $profile_list = $('.profile-tabs .nav-tabs>li ');
			if ($profile_list.length > 0) {
				$profile_list.addClass('thim-profile-list-' + $profile_list.length);
			}


			if (!$("body").hasClass("single-lp_course")) {
				return;
			}
			var $contain = $('.curriculum-sections'),
				$section = $contain.find("li.section"),
				$section_header = $section.find(".section-header");

			$contain.each(function () {
				$section_header.on("click", function () {
					if ($(this).parent('.section').hasClass("active")) {
						$(this).parent('.section').removeClass("active");
					} else {
						$(this).parent('.section').addClass("active");
					}
				});
			});
		},

		miniCartHover: function () {

			jQuery(document).on('mouseenter', '.minicart_hover', function () {
				jQuery(this).next('.widget_shopping_cart_content').slideDown();
			}).on('mouseleave', '.minicart_hover', function () {
				jQuery(this).next('.widget_shopping_cart_content').delay(100).stop(true, false).slideUp();
			});
			jQuery(document)
				.on('mouseenter', '.widget_shopping_cart_content', function () {
					jQuery(this).stop(true, false).show();
				})
				.on('mouseleave', '.widget_shopping_cart_content', function () {
					jQuery(this).delay(100).stop(true, false).slideUp();
				});

		},

		archive_wishlist_button: function () {

			$(".course-wishlist-box [class*='course-wishlist']").on('click', function (event) {
				event.preventDefault();
				var $this = $(this);
				if ($this.hasClass('loading')) return;
				$this.addClass('loading');
				$this.toggleClass('course-wishlist');
				$this.toggleClass('course-wishlisted');
				if ($this.hasClass('course-wishlisted')) {
					$.ajax({
						type   : "POST",
						url    : ajaxurl,
						data   : {
							//action   : 'learn_press_toggle_course_wishlist',
							'lp-ajax': 'toggle_course_wishlist',
							course_id: $this.data('id'),
							nonce    : $this.data('nonce')
						},
						success: function () {
							$this.removeClass('loading')
						},
						error  : function () {
							$this.removeClass('loading')
						}
					});
				}
				if ($this.hasClass('course-wishlist')) {
					$.ajax({
						type   : "POST",
						url    : ajaxurl,
						data   : {
							'lp-ajax': 'toggle_course_wishlist',
							course_id: $this.data('id'),
							nonce    : $this.data('nonce')
						},
						success: function () {
							$this.removeClass('loading')
						},
						error  : function () {
							$this.removeClass('loading')
						}
					});
				}
			});
		},

		landing_review_detail: function () {
			$('.landing-review').each(function () {

				$('button.review-details').on('click', function () {
					if ($(this).hasClass('thim-collapse')) {
						$(this).addClass('thim-expand');
						$("#course-reviews").show(300);
						$(this).removeClass('thim-collapse');
					} else {
						$(this).addClass('thim-collapse');
						$("#course-reviews").hide(300);
						$(this).removeClass('thim-expand');
					}
				});
			});
		},

		open_lesson: function () {
 			if ($(window).width() < 768) {
				$('body.course-item-popup').addClass('full-screen-content-item');
				$('body.ltr.course-item-popup #learn-press-course-curriculum').css('left', '-300px');
				$('body.ltr.course-item-popup #learn-press-content-item').css('left', '0');
				$('body.rtl.course-item-popup #learn-press-course-curriculum').css('right', 'auto');
				$('body.rtl.course-item-popup #learn-press-content-item').css('right', 'auto');
			}
		},

		thim_course_filter: function () {

			var $body = $('body');

			if (!$body.hasClass('learnpress') || !$body.hasClass('archive')) {
				return;
			}

			var ajaxCall = function (data) {
				return $.ajax({
					url       : $('#lp-archive-courses').data('allCoursesUrl'), //using for course category page
					type      : 'POST',
					data      : data,
					dataType  : 'html',
					beforeSend: function () {
						$('.archive-courses').addClass('loading');
					},
				}).fail(function () {
					$('.archive-courses').removeClass('loading');
				}).done(function (data) {
 					var $document = $($.parseHTML(data));
 					$('.archive-courses').replaceWith($document.find('.archive-courses'));
					$('.learn-press-pagination ul.page-numbers').replaceWith($document.find('.learn-press-pagination ul.page-numbers'));
					$('.thim-course-top .course-index span').replaceWith($document.find('.thim-course-top .course-index span'));
				});
			};

			var sendData = {
				s             : '',
				ref           : 'course',
				post_type     : 'lp_course',
				course_orderby: 'newly-published',
				course_paged  : 1,
			};

			/*
			* Handle courses sort ajax
			* */
			$(document).on('change', '.thim-course-order > select', function () {
				sendData.s = $('.courses-searching .course-search-filter').val();
				sendData.course_orderby = $(this).val();
				sendData.course_paged = 1;

				ajaxCall(sendData);
			});

			/*
			* Handle pagination ajax
			* */
			$(document).on('click', '#lp-archive-courses > .learn-press-pagination a.page-numbers', function (e) {
				e.preventDefault();

				$('html, body').animate({
					'scrollTop': $('.site-content').offset().top - 140,
				}, 1000);

				var url = $(this).attr('href'),
					arr = url.split('/'),
					pageNum = arr[arr.indexOf('page') + 1],
					paged = pageNum ? pageNum : 1,
					cateArr = [], instructorArr = [];

				$('form.thim-course-filter').find('input.filtered').each(function () {
					switch ($(this).attr('name')) {
						case 'course-cate-filter':
							cateArr.push($(this).val());
							break;
						case 'course-instructor-filter':
							instructorArr.push($(this).val());
							break;
						case 'course-price-filter':
							sendData.course_price_filter = $(this).val();
							break;
						default:
							break;
					}
				});

				if ($body.hasClass('category') && $('.list-cate-filter').length <= 0) {
					var bodyClass = $body.attr('class'),
						cateClass = bodyClass.match(/category\-\d+/gi)[0],
						cateID = cateClass.split('-').pop();

					cateArr.push(cateID);
				}

				sendData.course_cate_filter = cateArr;
				sendData.course_instructor_filter = instructorArr;

				sendData.s = $('.courses-searching .course-search-filter').val();
				sendData.course_orderby = $('.thim-course-order > select').val();
				sendData.course_paged = paged;

				ajaxCall(sendData);
			});

			/*
			* Handle filter form click ajax
			* */
			$('form.thim-course-filter').on('submit', function (e) {
				e.preventDefault();

				var formData = $(this).serializeArray(),
					cateArr = [], instructorArr = [];

				if (!formData.length) {
					return;
				}

				$('html, body').animate({
					'scrollTop': $('.site-content').offset().top - 140,
				}, 1000);

				$(this).find('input').each(function () {
					var form_input = $(this);
					form_input.removeClass('filtered');

					if (form_input.is(':checked')) {
						form_input.addClass('filtered');
					}
				});

				$.each(formData, function (index, filter) {
					switch (filter.name) {
						case 'course-cate-filter':
							cateArr.push(filter.value);
							break;
						case 'course-instructor-filter':
							instructorArr.push(filter.value);
							break;
						case 'course-price-filter':
							sendData.course_price_filter = filter.value;
							break;
						default:
							break;
					}
				});

				if ($body.hasClass('category') && $('.list-cate-filter').length <= 0) {
					var bodyClass = $body.attr('class'),
						cateClass = bodyClass.match(/category\-\d+/gi)[0],
						cateID = cateClass.split('-').pop();

					cateArr.push(cateID);
				}

				sendData.course_cate_filter = cateArr;
				sendData.course_instructor_filter = instructorArr;
				sendData.course_paged = 1;

				ajaxCall(sendData);
			});

		}


	};

})(jQuery);