/*!
 * jQuery Cookie Plugin v1.3.1
 * https://github.com/carhartl/jquery-cookie
 * Copyright 2013 Klaus Hartl
 * Released under the MIT license
 */
!function(a){"function"==typeof define&&define.amd?define(["jquery"],a):a(Zepto)}(function(a){function c(a){return a}function d(a){return decodeURIComponent(a.replace(b," "))}function e(a){0===a.indexOf('"')&&(a=a.slice(1,-1).replace(/\\"/g,'"').replace(/\\\\/g,"\\"));try{return f.json?JSON.parse(a):a}catch(b){}}var b=/\+/g,f=a.cookie=function(b,g,h){var i,j,k,l,m,n,o,p,q,r;if(void 0!==g)return h=a.extend({},f.defaults,h),"number"==typeof h.expires&&(i=h.expires,j=h.expires=new Date,j.setDate(j.getDate()+i)),g=f.json?JSON.stringify(g):String(g),document.cookie=[f.raw?b:encodeURIComponent(b),"=",f.raw?g:encodeURIComponent(g),h.expires?"; expires="+h.expires.toUTCString():"",h.path?"; path="+h.path:"",h.domain?"; domain="+h.domain:"",h.secure?"; secure":""].join("");for(k=f.raw?c:d,l=document.cookie.split("; "),m=b?void 0:{},n=0,o=l.length;o>n;n++){if(p=l[n].split("="),q=k(p.shift()),r=k(p.join("=")),b&&b===q){m=e(r);break}b||(m[q]=e(r))}return m};f.defaults={},a.removeCookie=function(b,c){return void 0!==a.cookie(b)?(a.cookie(b,"",a.extend({},c,{expires:-1})),!0):!1}});

/**
 * Set language.
 * 
 * @access public
 * @return void
 */
function selectLang(lang)
{
    $.cookie('lang', lang, {expires:config.cookieLife, path:config.webRoot});
    location.href = removeAnchor(location.href);
}

/**
 * Set theme.
 * 
 * @access public
 * @return void
 */
function selectTheme(theme)
{
    $.cookie('theme', theme, {expires:config.cookieLife, path:config.webRoot});
    location.href = removeAnchor(location.href);
}

/**
 * Remove anchor from the url.
 * 
 * @param  string $url 
 * @access public
 * @return string
 */
function removeAnchor(url)
{
    pos = url.indexOf('#');
    if(pos > 0) return url.substring(0, pos);
    return url;
}
