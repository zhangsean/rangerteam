/* ips lib */
+function($, window, document, Math)
{
    "use strict";
    var debug            = true;

    /* variables */
    var movingWindow     = null;
    var activedWindow    = null;
    var lastActiveWindow = null;
    var desktopPos       = {x: 60, y: 0};
    var desktopSize      = null;
    var fullscreenMode   = false;
    var windowIdSeed     = 0;
    var windowZIndexSeed = 100;
    var defaultWindowPos = {x: 110, y: 20};
    var entriesConfigs   = null;
    var entries          = null;
    var entryCount       = 0;

    /* the default configs */
    var defaults = 
    {
        webRoot                       : '/',
        animateSpeed                  : 200,
        entryIconRoot                 : 'theme/default/images/ips/',
        windowHeadheight              : 36, // the height of window head bar
        bottomBarHeight               : 42, // the height of desk bottom bar
        defaultWinPosOffset           : 30,
        defaultWindowSize             : {width:700,height:538},
        windowidstrTemplate           : 'win-{0}',
        safeCloseTip                  : '确认要关闭　【{0}】 吗？',
        entryNotFindTip               : '应用没有找到！',
        busyTip                       : '应用正忙，请稍候...',
        windowHtmlTemplate            : "<div id='{idstr}' class='window {cssclass}' style='width:{width}px;height:{height}px;left:{left}px;top:{top}px;z-index:{zindex};' data-id='{id}'><div class='window-head'><img src='{iconimg}' alt=''><strong title='{description}'>{title}</strong><ul><li><button class='reload-win'><i class='icon-repeat'></i></button></li><li><button class='min-win'><i class='icon-minus'></i></button></li><li><button class='max-win'><i class='icon-resize-full'></i></button></li><li><button class='close-win'><i class='icon-remove'></i></button></li></ul></div><div class='window-content'></div></div>",
        frameHtmlTemplate             : "<iframe id='iframe-{idstr}' name='iframe-{idstr}' src='{url}' frameborder='no' allowtransparency='true' scrolling='auto' hidefocus='' style='width: 100%; height: 100%; left: 0px;'></iframe>",
        leftBarShortcutHtmlTemplate   : '<li id="s-menu-{id}"><a href="javascript:;" class="app-btn" title="{title}" data-id="{id}"><img src="{iconimg}" alt=""></a></li>',
        taskBarShortcutHtmlTemplate   : '<li id="s-task-{id}"><a href="javascript:;" class="app-btn" title="{description}" data-id="{id}"><img src="{iconimg}" alt="">{title}</a></li>',
        entryListShortcutHtmlTemplate : '<li id="s-applist-{id}"><a href="javascript:;" class="app-btn" title="{description}" data-id="{id}"><img src="{iconimg}" alt="">{title}</a></li>',

        init                          : function() // init the default
        {
            this.entryIconRoot = this.webRoot + this.entryIconRoot;
        }
    };

    /* global setting */
    var settings = {};

    /*
     * Ips function: caculate the default position of the next new window
     *  
     * @return object:{x,y}
     */
    function getNextDefaultWinPos()
    {
        defaultWindowPos = {x: defaultWindowPos.x + settings.defaultWinPosOffset, y: defaultWindowPos.y + settings.defaultWinPosOffset};
        // console.log('x:' +defaultWindowPos.x+',y:'+defaultWindowPos.y);
        return defaultWindowPos;
    }

    /* Ips function: Init Settings
     *
     * @retrun void
     */
    function initSettings(options)
    {
        defaults.init(); // init default settings

        $.extend(settings, defaults, options);

        /* test: print settings */
        // if(debug)
        // {
        //     console.log('> settings | length:' + Object.getOwnPropertyNames(settings).length);
        //     for (var key in settings)
        //     {
        //         console.log('  * ' + key + ': ' + settings[key]);
        //     }
        // }
    };

    /*
     * Ips function: Init Entries objects
     *
     * @return void
     */
    function initEntries(entriesOptions)
    {
        entriesConfigs = entriesOptions;
        entries = new Array();
        for(var i in entriesConfigs)
        {
            var config = entriesConfigs[i];

            var et  =  new entry();
            et.init(config);

            entries[config.id] = et;
        }

        /* test print entrys config */
        // if(debug)
        // {
        //     console.log('> entries | length:' + Object.getOwnPropertyNames(entries).length);
        //     for (var key in entries)
        //     {
        //         var e = entries[key];
        //         console.log('  * > ' + key + ':');
        //         for(var ikey in e)
        //         {
        //             if(!$.isFunction(e[ikey]))
        //                 console.log('        * ' + ikey + ': ' + e[ikey]);
        //         }
        //     }
        // }
    };

    /* entry 
     *
     * @return void
     */
    function entry()
    {
        this.init = function(options)
        {
            this.initOptions(options);
        };

        this.initOptions = function(options)
        {
            $.extend(this, this.getDefaults(options.id), options);
            this.idstr      = settings.windowidstrTemplate.format(this.id);
            this.cssclass   = 'window-movable';

            switch(this.type)
            {
                case 'iframe':
                    this.cssclass += ' window-iframe';
                    break;
                case 'json':
                    this.cssclass += ' window-json';
                    break;
            }

            switch(this.display)
            {
                case 'normal':
                    if(!this.position) this.position = getNextDefaultWinPos();
                    break;
                case 'fixed':
                    this.cssclass += ' window-fixed';
                    if(!this.position) this.position = getNextDefaultWinPos();
                    break;
                case 'fullscreen':
                    this.cssclass += ' window-fullscreen window-active';
                    this.zindex = this.zindex + 20000;
                    this.position = desktopPos;
                    this.size = desktopSize;
                    break;
                case 'max':
                    this.cssclass += ' window-max';
                    // if(!this.position) this.position = getNextDefaultWinPos();
                    this.position = desktopPos;
                    this.size = desktopSize;
                    console.log('desktopSize.width:' + desktopSize.width + ',height:'+desktopSize.height);
                    break;
            }

            if(this.position)
            {
                this.left     = this.position.x;
                this.top      = this.position.y;
            }
            if(this.size)
            {
                this.width    = this.size.width;
                this.height   = this.size.height;
            }
        };

        this.getDefaults = function(entryId)
        {
            var d =
            {
                url           : '',
                id            : entryId || windowIdSeed++,
                zindex        : windowZIndexSeed++,
                title         : 'No name entry',
                type          : 'iframe',
                description   : '',
                display       : 'normal',
                size          : settings.defaultWindowSize,
                position      : null,
                iconimg       : settings.entryIconRoot + 'app-' + this.id + '.png',
                systemapp     : false,
                cssclass      : '',
                menu          : true // wethear show in left menu bar
            };

            return d;
        }

        this.toWindowHtml   = function()
        {
            return settings.windowHtmlTemplate.format(this);
        };

        this.toLeftBarShortcutHtml = function()
        {
            if(!this.systemapp)
                return settings.leftBarShortcutHtmlTemplate.format(this);
        };

        this.toTaskBarShortcutHtml = function()
        {
            return settings.taskBarShortcutHtmlTemplate.format(this);
        };

        this.toEntryListShortcutHtml = function()
        {
            return settings.entryListShortcutHtmlTemplate.format(this);
        }
    }

    /* bind windows events
     *
     * @return void
     */
    function bindEvents()
    {
        onWindowResize();
        handleWindowResize();
    }

    /* event: handle varables when window size changed
     *
     * @return void
     */
    function handleWindowResize()
    {
        /* refresh desktop size */
        var desktop = $('#desktop');
        desktopSize = {width: desktop.width() - desktopPos.x, height: desktop.height() - desktopPos.y - settings.bottomBarHeight};
        if(debug) console.log('> desktopSize:' + desktopSize.width + "," + desktopSize.height);
        
        /* refresh app menu size */
        var menu = $('#apps-menu');
        var iconHeight = menu.find('li').height();
        var menuHeight = desktopSize.height - $('#leftBar .dock-bottom').height();
        if(iconHeight > 0)
        {
            while(menuHeight % iconHeight != 0)
            {
                menuHeight--;
            }
        }
        menu.height(menuHeight);

        /* refresh entry window size */
        $('.window-fullscreen, .window-max').each(function()
        {
            var win = $(this);
            win.width(desktopSize.width);
            win.height(desktopSize.height);
            handleWinResized(win);
        });
    }


    function onWindowResize()
    {
        $(window).resize(handleWindowResize);
    }

    function getWinObj(winQuery)
    {
        if(winQuery)
        {
            if(winQuery instanceof jQuery)
            {
                return winQuery;
            }
            else
            {
                return (winQuery.constructor == Number) ? $('#' + settings.windowidstrTemplate.format(winQuery)) : ((winQuery.constructor == String) ? $('#' + winQuery) : $(winQuery));
            }
        }
        else
        {
            return activedWindow;
        }
    }

    function handleWinResized(winQuery)
    {
        var win  = getWinObj(winQuery);
        win.find('.window-content').height(win.height() - settings.windowHeadheight);
    }

    /* show shortcuts of entries
     *
     * @return void
     */
    function showShortcuts()
    {
        var leftMenu = $('#apps-menu .bar-menu');
        var allEntriesList = $("#allAppsList .bar-menu");
        for(var index in entries)
        {
            var entry = entries[index];
            if(entry.menu) leftMenu.append(entry.toLeftBarShortcutHtml());
            if(!isNaN(entry.id))
            {
              entryCount++;
              allEntriesList.append(entry.toEntryListShortcutHtml());
            }
        }
    }

    function bindShortcutsEvents()
    {
        $(document).on('click', '.app-btn', function(event)
        {
            var entry = entries[$(this).attr('data-id')];
            if(entry)
            {
                openWindow(entry);
            }
            else
            {
                alert(settings.entryNotFindTip);
            }

            var fullWindow = $(this).closest('.window-fullscreen.window-active');

            if(fullWindow.length > 0)
            {
                hideWindow(fullWindow);
            }

            event.preventDefault();
        });
    }

    function openWindow(entry)
    {
        if(debug) console.log('open window：' + entry.title + "," + entry.id);

        var entryWin = $('#' + entry.idstr);

        if(entryWin.length < 1)
        {
            if(entry.type == 'blank')
            {
                window.open(entry.url);
                return;
            }

            createWindow(entry);
            handleWinResized(entry.idstr);
            reloadWindow(entry.idstr);
            activeWindow(entry.idstr);
        }
        else if(entryWin.hasClass('window-active'))
        {
            toggleShowWindow(entryWin);
        }
        else
        {
            showWindow(entryWin);
        }
    }

    function createWindow(entry)
    {
        $('#deskContainer').append(entry.toWindowHtml());
        $('#taskbar .bar-menu').append(entry.toTaskBarShortcutHtml());
        $('.app-btn[data-id="'+entry.id+'"]').addClass('open');
    }

    function initWindowActions()
    {
        $(document).on('click', '.max-win', function(event) // max-win
        {
            toggleMaxSizeWindow($(this).closest('.window'));
            event.preventDefault();
            event.stopPropagation();
        // }).on('dblclick', '.window-head', function(event) // double click for max-win
        // {
        //     toggleMaxSizeWindow($(this).closest('.window'));
        //     event.preventDefault();
            // event.stopPropagation();
        }).on('click', '.close-win', function(event) // close-win
        {
            closeWindow($(this).closest('.window'));
            event.preventDefault();
            event.stopPropagation();
        }).on('click', '.min-win', function(event) // min-win
        {
            toggleShowWindow($(this).closest('.window'));
            event.preventDefault();
            event.stopPropagation();
        }).on('click', '.reload-win', function(event)
        {
            reloadWindow($(this).closest('.window'));
            event.preventDefault();
            event.stopPropagation();
        });
    }

    function toggleShowWindow(winQuery)
    {
        var win = getWinObj(winQuery);
        if(win.hasClass('window-min'))
        {
            showWindow(win);
        }
        else
        {
            hideWindow(win);
        }
    }

    function hideWindow(winQuery, silence)
    {
        var win = getWinObj(winQuery);
        if(!win.hasClass('window-min'))
        {
            win.fadeOut(settings.animateSpeed).addClass('window-min');
            if(!silence)
                activeWindow(lastActiveWindow);
        }
    }

    function showWindow(winQuery)
    {
        var win = getWinObj(winQuery);
        console.log('showWindow：'+win.attr('data-id'));
        if(win.hasClass('window-min'))
        {
            win.fadeIn(settings.animateSpeed).removeClass('window-min');
        }
        activeWindow(win);
    }

    function reloadWindow(winQuery)
    {
        var win = getWinObj(winQuery);
        if(!win.hasClass('window-loading'))
        {
            win.addClass('window-loading').removeClass('window-error').find('.reload-win i').addClass('icon-spin');
            var entry = entries[win.attr('data-id')];

            var result = true;
            switch(entry.type)
            {
                case 'iframe':
                    result = loadIframeWindow(win, entry);
                    break;
                case 'html':
                    result = loadHtmlWindow(win, entry);
                    break;
            }
        }
        else
        {
            alert(settings.busyTip);
        }
    }

    function loadHtmlWindow(win, entry)
    {
        var result = true;
        var content = win.find('.window-content').html('');
        $.ajax(
        {
            url: entry.url,
            dataType: 'html',
        })
        .done(function(data)
        {
            content.html(data);
        })
        .fail(function()
        {
            win.addClass('window-error');
            result = false;
        })
        .always(function()
        {
            win.removeClass('window-loading');
            win.find('.reload-win i').removeClass('icon-spin');
        });
        return result;
    }

    function loadIframeWindow(win, entry)
    {
        var fName = 'iframe-' + entry.idstr;
        var frame = $('#' + fName);
        if(frame.length > 0)
        {
            document.getElementById(fName).src = entry.url; 
        }
        else
        {
            win.find('.window-content').html(settings.frameHtmlTemplate.format(entry));
        }
        $('#' + fName).load(function(){
            win.removeClass('window-loading');
            win.find('.reload-win i').removeClass('icon-spin');
        });
        return true;
    }

    function closeWindow(winQuery)
    {
        var win = getWinObj(winQuery);
        if(win.hasClass('window-safeclose') && (!confirm(settings.safeCloseTip.format(win.find('.window-head strong').text()))))
            return;

        win.fadeOut(settings.animateSpeed, function(){
            var id = win.attr('data-id');
            $('.app-btn[data-id="' + id + '"]').removeClass('open').removeClass('active');
            $('#s-task-' + id).remove();
            win.remove(); 
        });
        activeWindow(lastActiveWindow);
        // todo: 此处加入销毁应用窗口的其他操作
    }

    function toggleMaxSizeWindow(winQuery)
    {
        var win = getWinObj(winQuery);
        if(win.hasClass('window-fixed')) return;

        if(win.hasClass('window-max'))
        {
            var orginLoc = win.data('orginLoc');
            win.removeClass('window-max').css(
            {
                left: orginLoc.left,
                top: orginLoc.top,
                width: orginLoc.width,
                height: orginLoc.height
            }).find('.icon-resize-small').removeClass('icon-resize-small').addClass('icon-resize-full');
        }
        else
        {
            var dSize = desktopSize;
            win.data('orginLoc', 
            {
                left: win.css('left'),
                top: win.css('top'),
                width: win.css('width'),
                height: win.css('height')
            }).addClass('window-max').css(
            {
                left: desktopPos.x,
                top: desktopPos.y,
                width: dSize.width,
                height: dSize.height
            }).find('.icon-resize-full').removeClass('icon-resize-full').addClass('icon-resize-small');
        }
        handleWinResized(win);
    }

    function activeWindow(query)
    {
        var win = getWinObj(query);

        if(win.hasClass('window-active')) return;
        if($('.window[data-id="'+win.attr('data-id')+'"]').length<1) return;

        if(activedWindow)
        {
            if(activedWindow.hasClass('window-fullscreen'))
            {
                hideWindow(activedWindow,true);
            }
            else
            {
                lastActiveWindow = activedWindow;
            }
            activedWindow.removeClass('window-active').css('z-index', parseInt(activedWindow.css('z-index'))%10000);
            
        }

        activedWindow = win.addClass('window-active').css('z-index',parseInt(win.css('z-index'))+10000);

        $('.app-btn').removeClass('active');
        $('.app-btn[data-id="'+win.attr('data-id')+'"]').addClass('active');

        handleFullscreenMode(win);
    }

    function handleFullscreenMode(win)
    {
        var id = win.attr('data-id');
        if(win.hasClass('window-fullscreen'))
        {
            $("#desktop").addClass('fullscreen-mode');
            fullscreenMode = true;
        }
        else
        {
            fullscreenMode = false;
            $("#desktop").removeClass('fullscreen-mode');
        }
    }


    /* start ips
     *
     * @return void
     */
    function start(entriesOptions, options)
    {
        initSettings(options);

        /* bind window events */
        bindEvents();

        initEntries(entriesOptions);

        /* show content */
        showShortcuts();
        bindShortcutsEvents();

        initWindowActions();
    }

    /* make jquery object call the ips interface manager */
    $.extend({ipsStart: start});

}(jQuery,window,document,Math);

$(function()
{
    /* start ips */
    $.ipsStart(entries, config);
});

/**
 * Format string
 *  
 * @param  object|array args
 * @return string
 */
String.prototype.format = function(args) 
{
    var result = this;
    if (arguments.length > 0)
    {
        var reg;
        if (arguments.length == 1 && typeof(args) == "object")
        {
            for (var key in args)
            {
                if (args[key] != undefined)
                {
                    reg = new RegExp("({" + key + "})", "g");
                    result = result.replace(reg, args[key]);
                }
            }
        }
        else
        {
            for (var i = 0; i < arguments.length; i++)
            {
                if (arguments[i] != undefined)
                {
                    reg = new RegExp("({[" + i + "]})", "g");
                    result = result.replace(reg, arguments[i]);
                }
            }
        }
    }
    return result;
};
