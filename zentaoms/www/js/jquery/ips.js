/* ips lib */
+function($, window, document, Math)
{
    "use strict";

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
        windowHeadheight              : 30, // the height of window head bar
        bottomBarHeight               : 36, // the height of desk bottom bar
        defaultWinPosOffset           : 30,
        defaultWindowSize             : {width:700,height:538},
        windowidstrTemplate           : 'win-{0}',
        safeCloseTip                  : '确认要关闭　【{0}】 吗？',
        entryNotFindTip               : '应用没有找到！',
        busyTip                       : '应用正忙，请稍候...',
        reloadWindowText              : '刷新应用内容 (F5)',
        closeWindowText               : '关闭应用窗口',
        minWindowText                 : '隐藏窗口',
        showWindowText                : '显示窗口',
        windowHtmlTemplate            : "<div id='{idstr}' class='window {cssclass}' style='width:{width}px;height:{height}px;left:{left}px;top:{top}px;z-index:{zindex};' data-id='{id}'><div class='window-head'><img src='{icon}' alt=''><strong title='{desc}'>{title}</strong><ul><li><button class='reload-win'><i class='icon-repeat'></i></button></li><li><button class='min-win'><i class='icon-minus'></i></button></li><li><button class='max-win'><i class='icon-resize-full'></i></button></li><li><button class='close-win'><i class='icon-remove'></i></button></li></ul></div><div class='window-content'></div></div>",
        frameHtmlTemplate             : "<iframe id='iframe-{idstr}' name='iframe-{idstr}' src='{url}' frameborder='no' allowtransparency='true' scrolling='auto' hidefocus='' style='width: 100%; height: 100%; left: 0px;'></iframe>",
        leftBarShortcutHtmlTemplate   : '<li id="s-menu-{id}"><a data-toggle="tooltip" data-placement="right"  href="javascript:;" class="app-btn" title="{title}" data-id="{id}"><img src="{icon}" alt=""></a></li>',
        taskBarShortcutHtmlTemplate   : '<li id="s-task-{id}"><button class="app-btn" title="{desc}" data-id="{id}"><img src="{icon}" alt="">{title}</button><div class="actions"><button class="close-win"><i class="icon-remove"></i></button></div></li>',
        entryListShortcutHtmlTemplate : '<li id="s-applist-{id}"><a href="javascript:;" class="app-btn" title="{desc}" data-id="{id}"><img src="{icon}" alt="">{title}</a></li>',

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

            var et = new entry();
            et.init(config);

            entries[config.id] = et;
        }
    };

    /* entry 
     *
     * @return void
     */
    function entry()
    {
        this.init = function(options)
        {
            /* extend options from params */
            $.extend(this, this.getDefaults(options.id), options);
            this.idstr      = settings.windowidstrTemplate.format(this.id);
            this.cssclass   = 'window-movable';

            /* if no icon setting here, then load icon with the default rule */
            if(!this.icon) this.icon = settings.entryIconRoot + 'entry-' + this.id + '.png';

            /* window open type */
            switch(this.open)
            {
                case 'iframe':
                    this.cssclass += ' window-iframe';
                    break;
                case 'json':
                    this.cssclass += ' window-json';
                    break;
            }

            /* init size setting */
            if(this.size == 'default')
            {
                this.size = settings.defaultWindowSize;
            }
            else if(this.size.width != undefined && this.size.height != undefined)
            {
                this.size = 
                {
                    width:  Math.min(this.size.width, desktopSize.width),
                    height: Math.min(this.size.height, desktopSize.height)
                };
            }
            else
            {
                this.size       = desktopSize;
                this.position   = desktopPos;
                this.cssclass  += ' window-max';
            }

            this.width  = this.size.width;
            this.height = this.size.height;

            /* init position setting */
            if(this.position == 'center')
            {
                this.position = 
                {
                    x: Math.max(desktopPos.x, desktopPos.x + (desktopSize.width - this.width)/2),
                    y: Math.max(desktopPos.y, desktopPos.y + (desktopSize.height - this.width)/2)
                };
            }
            else if(this.position.x != undefined && this.position.y != undefined)
            {
                this.position = 
                {
                    x: Math.max(desktopPos.x, this.position.x),
                    y: Math.max(desktopPos.y, this.position.y)
                };
            }
            else
            {
                this.position = getNextDefaultWinPos();
            }

            this.left = this.position.x;
            this.top  = this.position.y;

            /* init display setting */
            if(this.display == 'fixed')
            {
                this.cssclass += ' window-fixed';
            }

            /* init control bar setting */
            switch(this.control)
            {
                case 'simple':
                    this.cssclass += ' window-control-simple';
                    break;
                case 'none':
                    this.cssclass += ' window-control-none';
                    break;
                case 'full':
                    this.cssclass += ' window-control-full';
                    break;
            }
        };

        this.getDefaults = function(entryId)
        {
            var d =
            {
                url           : '',
                control       : 'simple',
                id            : entryId || windowIdSeed++,
                zindex        : windowZIndexSeed++,
                title         : 'No name entry',
                open          : 'iframe',
                desc          : '',
                display       : 'fixed',
                size          : 'max',
                position      : 'default',
                icon          : null,
                cssclass      : '',
                menu          : true // wethear show in left menu bar
            };

            return d;
        }

        this.toWindowHtml   = function()
        {
            this.html = settings.windowHtmlTemplate.format(this);
            return this.html;
        };

        this.toLeftBarShortcutHtml = function()
        {
            if(this.menu)
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
    function bindWindowsEvents()
    {
        onWindowResize();

        handleWindowResize();

        onShowDeskClick();

        onF5Click();
    }

    function onF5Click()
    {
        $(document).keydown(function(event)
        {
            if(event.keyCode == 116)
            {
                reloadWindow();
                return false;
            }
        });
    }

    function onShowDeskClick()
    {
        $('#showDesk').click(function()
        {
           $('#deskContainer').toggleClass('hide-windows');
           $('#showDesk .icon-check-empty').toggleClass('icon-sign-blank');
        });
    }

    /* make the window movable with class '.movable' or '.window-movable'
     *
     * @return void
     */
    function initWindowMovable()
    {
        $(document).on('mousedown', '.movable,.window-movable .window-head', function(event)
        {
            var win = $(this).closest('.window:not(.window-max)');
            if(win.length<1)
            {
                return;
            }
            movingWindow = win;
            var mwPos = movingWindow.position();
            movingWindow.data('mouseOffset', {x: event.pageX-mwPos.left, y: event.pageY-mwPos.top}).addClass('window-moving');
            $(document).bind('mousemove',mouseMove).bind('mouseup',mouseUp)
            event.preventDefault();
        });

        function mouseUp()
        {
            $('.window.window-moving').removeClass('window-moving');
            movingWindow = null;
            $(document).unbind('mousemove', mouseMove).unbind('mouseup', mouseUp)
        }

        function mouseMove(event)
        {
            if(movingWindow && movingWindow.hasClass('window-moving'))
            {
                var offset = movingWindow.data('mouseOffset');
                movingWindow.css(
                {
                    left : event.pageX-offset.x,
                    top : event.pageY-offset.y
                });
            }
        }
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
            else if(winQuery.idStr != undefined)
            {
                return $('#' + winQuery.idStr);
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
        var offset = win.hasClass('window-control-full') ? settings.windowHeadheight : 0;
        win.find('.window-content').height(win.height() - offset);
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
        var entryWin = $('#' + entry.idstr);
        if(entryWin.length < 1)
        {
            if(entry.open == 'blank')
            {
                window.open(entry.url);
                return;
            }

            createWindow(entry);
            handleWinResized(entry.idstr);
            reloadWindow(entry.idstr);
            activeWindow(entry.idstr);
        }
        else if(entryWin.hasClass('window-active') && (!$('#deskContainer').hasClass('hide-windows')))
        {
            toggleShowWindow(entryWin);
        }
        else
        {
            showWindow(entryWin);
        }

        $('#deskContainer').removeClass('hide-windows');
        $('#showDesk .icon-check-empty').removeClass('icon-sign-blank');
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
        }).on('dblclick', '.window-head', function(event) // double click for max-win
        {
            toggleMaxSizeWindow($(this).closest('.window'));
            event.preventDefault();
            event.stopPropagation();
        }).on('click', '.close-win', function(event) // close-win
        {
            var win = $(this).closest('.window');
            if(!win.length) win = $(this).closest('.app-btn').attr('data-id');
            closeWindow(win);
            event.preventDefault();
            event.stopPropagation();
        }).on('click', '.min-win', function(event) // min-win
        {
            toggleShowWindow($(this).closest('.window'));
            event.preventDefault();
            event.stopPropagation();
        }).on('click', '.reload-win', function(event) // reload window content
        {
            var win = $(this).closest('.window');
            if(!win.length) win = $(this).closest('.app-btn').attr('data-id');
            reloadWindow(win);
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
            switch(entry.open)
            {
                case 'iframe':
                    result = loadIframeWindow(win, entry);
                    break;
                case 'html':
                    result = loadHtmlWindow(win, entry);
                    break;
            }

            $('#deskContainer').removeClass('hide-windows');
            $('#showDesk .icon-check-empty').removeClass('icon-sign-blank');
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

        $('#' + fName).load(function()
        {
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

        var id       = win.attr('data-id');

        /* save the last position and size */
        var entry    = entries[id];
        entry.left   = win.position().left;
        entry.top    = win.position().top;
        entry.width  = win.width();
        entry.height = win.height();

        win.fadeOut(settings.animateSpeed, function(){
            $('.app-btn[data-id="' + id + '"]').removeClass('open').removeClass('active');
            $('#s-task-' + id).remove();
            win.remove();
        });

        $('.tooltip').remove();
        activeWindow(lastActiveWindow);
    }

    function toggleMaxSizeWindow(winQuery)
    {
        var win = getWinObj(winQuery);
        if(win.hasClass('window-fixed') || win.hasClass('window-maxfixed')) return;

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
                left:   win.css('left'),
                top:    win.css('top'),
                width:  win.css('width'),
                height: win.css('height')
            }).addClass('window-max').css(
            {
                left:   desktopPos.x,
                top:    desktopPos.y,
                width:  dSize.width,
                height: dSize.height
            }).find('.icon-resize-full').removeClass('icon-resize-full').addClass('icon-resize-small');
        }
        handleWinResized(win);
    }

    function activeWindow(query)
    {
        var win = getWinObj(query);

        if(win.hasClass('window-active')) return;
        if($('.window[data-id="' + win.attr('data-id') + '"]').length < 1) return;
 
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
            activedWindow.removeClass('window-active').css('z-index', parseInt(activedWindow.css('z-index')) % 10000);
        }

        activedWindow = win.addClass('window-active').css('z-index',parseInt(win.css('z-index')) + 10000);

        $('.app-btn').removeClass('active');
        $('.app-btn[data-id="' + win.attr('data-id') + '"]').addClass('active');

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
        bindWindowsEvents();

        initEntries(entriesOptions);

        /* show content */
        showShortcuts();
        bindShortcutsEvents();

        initWindowActions();
        initWindowMovable();
    }

    /* make jquery object call the ips interface manager */
    $.extend({ipsStart: start});

}(jQuery,window,document,Math);

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
