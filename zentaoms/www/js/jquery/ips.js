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

    /* record the index url */
    var indexUrl         = window.location.href;

    /* the default configs */
    var defaults =
    {
        autoHideMenu                  : false,
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
        reloadWindowText              : '重新载入应用',
        closeWindowText               : '关闭应用',
        minWindowText                 : '隐藏窗口',
        showWindowText                : '显示窗口',
        windowHtmlTemplate            : "<div id='{idstr}' class='window {cssclass}' style='width:{width}px;height:{height}px;left:{left}px;top:{top}px;z-index:{zindex};' data-id='{id}'><div class='window-head'>{iconhtml}<strong title='{desc}'>{name}</strong><ul><li><button class='reload-win'><i class='icon-repeat'></i></button></li><li><button class='min-win'><i class='icon-minus'></i></button></li><li><button class='max-win'><i class='icon-resize-full'></i></button></li><li><button class='close-win'><i class='icon-remove'></i></button></li></ul></div><div class='window-cover'></div><div class='window-content'></div></div>",
        frameHtmlTemplate             : "<iframe id='iframe-{idstr}' name='iframe-{idstr}' src='{url}' frameborder='no' allowtransparency='true' scrolling='auto' hidefocus='' style='width: 100%; height: 100%; left: 0px;'></iframe>",
        leftBarShortcutHtmlTemplate   : '<li id="s-menu-{id}"><a data-toggle="tooltip" data-placement="right"  href="javascript:;" class="app-btn s-menu-btn" title="{name}" data-id="{id}">{iconhtml}</a></li>',
        taskBarShortcutHtmlTemplate   : '<li id="s-task-{id}"><button class="app-btn s-task-btn" title="{desc}" data-id="{id}">{iconhtml}{name}</button></li>',
        taskBarMenuHtmlTemplate       : "<ul class='dropdown-menu' id='taskMenu'><li><a href='###' class='reload-win'><i class='icon-repeat'></i> {reloadWindowText}</a></li><li><a href='###' class='close-win'><i class='icon-remove'></i> {closeWindowText}</a></li></ul>",
        entryListShortcutHtmlTemplate : '<li id="s-applist-{id}"><a href="javascript:;" class="app-btn" title="{desc}" data-id="{id}">{iconhtml}{name}</a></li>',

        init                          : function() // init the default
        {
            this.entryIconRoot = this.webRoot + this.entryIconRoot;
            this.taskBarMenuHtmlTemplate = this.taskBarMenuHtmlTemplate.format(this);
        }
    };

    /* global setting */
    var settings = {};

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
            this.cssclass   = '';

            /* if no icon setting here, then load icon with the default rule */
            if(!this.icon) this.icon = settings.entryIconRoot + 'entry-' + this.id + '.png';
            if(this.icon.indexOf('icon-') == 0) this.iconhtml = '<i class="icon ' + this.icon + '"></i>';
            else this.iconhtml = '<img src="' + this.icon + '" alt="" />';

            /* mark modal with css class */
            if(this.display == 'modal')
            {
                this.cssclass += ' window-modal';
                this.zindex   += 50000;
                this.position  = 'center';
            }

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

            /* init display setting */
            if(this.display == 'fixed' || this.display == 'modal')
            {
                this.cssclass += ' window-fixed';
            }

            /* init control bar setting */
            switch(this.control)
            {
                case '':
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

            this.resetPosSize();
        };

        this.getDefaults = function(entryId)
        {
            var d =
            {
                url           : '',
                control       : 'simple',
                id            : entryId || windowIdSeed++,
                zindex        : windowZIndexSeed++,
                name          : 'No name entry',
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

        this.resetPosSize = function()
        {
            /* init size setting */
            if(this.size == 'default')
            {
                this.width  = settings.defaultWindowSize.width;
                this.height = settings.defaultWindowSize.height;
            }
            else if(this.size.width != undefined && this.size.height != undefined)
            {
                this.width  = Math.min(this.size.width, desktopSize.width);
                this.height = Math.min(this.size.height, desktopSize.height);
            }
            else
            {
                this.width  = desktopSize.width;
                this.height = desktopSize.height;
                this.size = 'max';
                this.position  = desktopPos;
                if(this.cssclass.indexOf(' window-max') < 0) this.cssclass += ' window-max';
            }

            /* init position setting */
            if(this.position == 'center')
            {
                this.left = Math.max(desktopPos.x, desktopPos.x + (desktopSize.width - this.width)/2);
                this.top  = Math.max(desktopPos.y, desktopPos.y + (desktopSize.height - this.height)/2);
            }
            else if(this.position.x != undefined && this.position.y != undefined)
            {
                this.left = Math.max(desktopPos.x, this.position.x);
                this.top  = Math.max(desktopPos.y, this.position.y);
            }
            else
            {
                defaultWindowPos = {x: defaultWindowPos.x + settings.defaultWinPosOffset, y: defaultWindowPos.y + settings.defaultWinPosOffset};
                this.left = defaultWindowPos.x;
                this.top  = defaultWindowPos.y;
            }

            /* decide the window can be movable */
            if(this.display != 'fixed' && this.size != 'max' && this.cssclass.indexOf(' window-movable') < 0) this.cssclass += ' window-movable';
        }

        this.reCalPosSize = function()
        {
            if(this.size.width != undefined && this.size.height != undefined)
            {
                this.width  = Math.min(this.size.width, desktopSize.width);
                this.height = Math.min(this.size.height, desktopSize.height);
            }
            else if(this.size == 'max')
            {
                this.width  = desktopSize.width;
                this.height = desktopSize.height;
                this.position  = desktopPos;
            }

            if(this.position == 'center')
            {
                this.left = Math.max(desktopPos.x, desktopPos.x + (desktopSize.width - this.width)/2);
                this.top  = Math.max(desktopPos.y, desktopPos.y + (desktopSize.height - this.height)/2);
            }
        }

        this.toWindowHtml = function()
        {
            this.reCalPosSize();
            this.html = settings.windowHtmlTemplate.format(this);
            return this.html;
        };

        this.toLeftBarShortcutHtml = function()
        {
            if(this.menu) return settings.leftBarShortcutHtmlTemplate.format(this);
        };

        this.toTaskBarShortcutHtml = function()
        {
            if(this.display != 'modal') return settings.taskBarShortcutHtmlTemplate.format(this);
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

        handleFullscreenBtn();

        onWindowKeydown();

        initWindowActivable();

        handleToggleClass();

        handleHomeBlocks();

        handleAllApps();

        haddleStartMenu();
    }

    function haddleStartMenu()
    {
        $(document).click(function()
        {
            $('#startMenu').removeClass('show');
        });

        $('#start').click(function(e)
        {
            $('#startMenu').toggleClass('show');
            e.stopPropagation();
        });
    }

    function handleAllApps()
    {
        $('#search').keyup(function(e)
        {
            if(e.which == 27) // pressed esc
            {
                clearInput();
            }
            else if(e.which == 13) // pressed enter
            {
                $('#allAppsList .app-btn.search-selected').click();
            }

            $('.search-selected').removeClass('search-selected');

            var val = $(this).val();

            if(val.length > 0)
            {
                var keys = val.split(' ');
                var first = true;
                $('#allAppsList .app-btn').each(function()
                {
                    var btn = $(this);
                    var r = true, et = entries[btn.attr('data-id')];
                    for(var ki in keys)
                    {
                        var k = keys[ki];
                        r = r && (k=='' || (et.name.indexOf(k) > -1) || (et.desc.indexOf(k) > -1) || et.id == k);
                        if(!r) break;
                    }

                    btn.closest('li').toggleClass('search-hide', !r);

                    if(r && first)
                    {
                        first = false;
                        btn.addClass('search-selected');
                    }
                });

                $('#cancelSearch').fadeIn('fast');
            }
            else
            {
                $('.search-hide').removeClass('search-hide');
                $('#cancelSearch').fadeOut('fast');
            }
        });

        $('#cancelSearch').click(clearInput);

        function clearInput()
        {
            $('#search').val('').keyup();
        }
    }

    function handleHomeBlocks()
    {
        $(document).on('mouseover', '#home.custom-mode:not(.dragging) .panel:not(#draggingPanel)', function()
        {
            $(this).addClass('hover');
            $('#home.custom-mode').addClass('hover');
        }).on('mouseout', '#home.custom-mode:not(.dragging) .panel', function()
        {
            $(this).removeClass('hover');
            $('#home.custom-mode').removeClass('hover');
        }).on('mousedown', '#home.custom-mode .panel.hover:not(#draggingPanel)', function(event)
        {
            var panel = $(this);
            var dPanel = panel.clone().attr('id', 'draggingPanel');
            var pos   = panel.offset();

            panel.addClass('dragging');
            panel.parent().addClass('dragging-col');
            
            dPanel.css(
            {
                left    : pos.left - desktopPos.x,
                top     : pos.top,
                width   : panel.width(),
                height  : panel.height()
            }).appendTo('#home').data('mouseOffset', {x: event.pageX - pos.left + desktopPos.x, y: event.pageY - pos.top});

            $(document).bind('mousemove',mouseMove).bind('mouseup',mouseUp);
            event.preventDefault();
            $('#home').addClass('dragging');

            function mouseMove(event)
            {
                var offset = dPanel.data('mouseOffset');
                dPanel.css(
                {
                    left : event.pageX-offset.x,
                    top  : event.pageY-offset.y
                });

                $('#home.custom-mode .panel:not(#draggingPanel)').each(function()
                {
                    $('.dragging-in').removeClass('dragging-in');

                    var p = $(this);
                    var pP = p.offset(), pW = p.width(), pH = p.height();
                    var pX = pP.left - pW / 2, pY = pP.top;
                    var mX = event.pageX - desktopPos.x, mY = event.pageY;

                    if(mX > pX && mY > pY && mX < (pX + pW) && mY < (pY + pH))
                    {
                        p.parent().addClass('dragging-in');
                        return false;
                    }
                });
                event.preventDefault();
            }

            function mouseUp(event)
            {
                if(panel.attr('id') != $('.dragging-in').attr('id'))
                {
                    panel.parent().insertBefore('.dragging-in');
                    var newOrder = 1;
                    var newOrders = {};
                    $('#home .panel:not(#draggingPanel)').each(function()
                    {
                        $(this).attr('data-order', newOrder++);
                        newOrders[$(this).attr('id')] = $(this).attr('data-order');
                    });

                    if(settings.onBlocksOrdered && $.isFunction(settings.onBlocksOrdered)) settings.onBlocksOrdered(newOrders);
                }
                $('#draggingPanel').remove();
                $('.dragging-col').removeClass('dragging-col');
                $('.dragging').removeClass('dragging');
                $('.dragging-in').removeClass('dragging-in');
                $('#home').removeClass('dragging');
                $(document).unbind('mousemove', mouseMove).unbind('mouseup', mouseUp);
                event.preventDefault();
            }
        });

        $('#home .panel .custom-actions').mousedown(function(event)
        {
            event.preventDefault();
            event.stopPropagation();
        });
    }

    function handleToggleClass()
    {
        $(document).on('click', '[data-toggle-class]', function()
        {
            var $e = $(this);
            var target = $e.attr('data-target');
            if(target != undefined) target = $(target); else target = $e;
            target.toggleClass($e.attr('data-toggle-class'));
        });
    }

    function initWindowActivable()
    {
        activedWindow = $('.window-active');
        $(document).on('mousedown', '.window', function()
        {
            activeWindow($(this));
        });
    }

    function onWindowKeydown()
    {
        $(document).keydown(handleWindowKeydown);
    }

    function handleWindowKeydown(event)
    {
        if(event.keyCode == 116)
        {
            reloadWindow();
            return false;
        }
    }

    function handleFullscreenBtn()
    {
        $('.fullscreen-btn').click(function()
        {
            toggleFullscreen($(this).attr('data-id'));
        });
    }

    function toggleFullscreen(id)
    {
        var win = $('#' + id);
        if(win.hasClass('fullscreen-active'))
        {
            $('#desktop').removeClass('fullscreen-mode');
            win.removeClass('fullscreen-active');
            $('.fullscreen-btn[data-id="' + id + '"],.app-btn[data-id="' + id + '"]').removeClass('active');

            if(activedWindow) $('.app-btn[data-id="' + activedWindow.attr('data-id') + '"]').addClass('active');
        }
        else
        {
            $('.fullscreen-active').removeClass('fullscreen-active');
            win.addClass('fullscreen-active');
            $('#desktop').addClass('fullscreen-mode');
            fullscreenMode = true;
            $('.fullscreen-btn, .app-btn').each(function(){$(this).removeClass($(this).attr('data-toggle-class')).removeClass('active')});
            $('.fullscreen-btn[data-id="' + id + '"],.app-btn[data-id="' + id + '"]').addClass('active');

            if(id == 'allapps') $('#search').focus();
        }
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
            movingWindow.data('mouseOffset', {x: event.pageX - mwPos.left, y: event.pageY - mwPos.top}).addClass('window-moving');
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
        $('.fullscreen, .window-max').each(function()
        {
            var win = $(this);
            win.width(desktopSize.width);
            win.height(desktopSize.height);
            win.css(
            {
                left : desktopPos.x,
                right: desktopPos.y
            });
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

    function initMenu()
    {
        if(settings.autoHideMenu)
        {
            $('#leftBar').addClass('menu-auto');
            desktopPos.x = 2;
            setTimeout(hideMenu, 2000);

            $('#leftBar').addClass('menu-auto').mouseover(showMenu).mouseout(hideMenu);;

        }

        function hideMenu()
        {
            $('#leftBar').removeClass('menu-show');
            setTimeout(function()
            {
                if(!$('#leftBar').hasClass('menu-show'))
                {
                    $('#leftBar').addClass('menu-hide');
                    $('#apps-menu .app-btn[data-toggle="tooltip"]').removeAttr('data-toggle');
                }
            }, 1000);
        }

        function showMenu()
        {
            $('#leftBar').removeClass('menu-hide').addClass('menu-show');
            setTimeout(function(){$('#apps-menu .app-btn').attr('data-toggle', 'tooltip');}, 500);
        }
    }

    function bindShortcutsEvents()
    {
        $(document).on('click', '.app-btn', function(event)
        {
            var entry = entries[$(this).attr('data-id')];
            if(entry)
            {
                if(entry.display == 'fullscreen') toggleFullscreen(entry.id);
                else openWindow(entry);
            }
            else
            {
                alert(settings.entryNotFindTip);
            }

            event.preventDefault();
        });

        /* disable the browser's contextmenu */
        document.oncontextmenu = nocontextmenu;  // for IE5+
        document.onmousedown = norightclick;  // for all others

        $(document).on('mousedown', '.app-btn.open', function(e)
        {
            if(e.which == 3)
            {
                var btn = $(this),menu = $('#taskMenu'), offset = btn.offset();
                if(!menu.length) menu = $(settings.taskBarMenuHtmlTemplate).appendTo('#desktop');
                menu.toggleClass('show');

                if(menu.hasClass('show'))
                {
                    if(btn.hasClass('s-menu-btn')) menu.css({left: 62, top: offset.top, bottom: 'inherit'});
                    else if(btn.hasClass('s-task-btn')) menu.css({left: offset.left, top: 'inherit', bottom: 38});
                }
            }

            e.stopPropagation();
        });

        $(document).click(function(){$('#taskMenu').removeClass('show')});

        function nocontextmenu()
        {
            event.cancelBubble = true
            event.returnValue = false;

            return false;
        }

        function norightclick(e) 
        {
            if (window.Event) 
            {
                if (e.which == 2 || e.which == 3)
                return false;
            }
            else
            if (event.button == 2 || event.button == 3)
            {
                event.cancelBubble = true
                event.returnValue = false;
                return false;
            }
        }
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
        else if(entryWin.hasClass('window-active'))
        {
            if($('#desktop').hasClass('fullscreen-mode'))
            {
                $('#desktop').removeClass('fullscreen-mode');
                $('.fullscreen-btn.active,.app-btn.active').removeClass('active');
                $('.app-btn[data-id="'+entry.id+'"]').addClass('active');
            }
            else toggleShowWindow(entryWin);
        }
        else
        {
            showWindow(entryWin);
        }

        if(entry.display != 'modal') handleFullscreenMode();
        else handleModalMode(entry);
    }

    function handleModalMode(entry)
    {
        if(entry.display == 'modal')
        {
            $('#desktop').addClass('modal-mode');
        }
    }

    function createWindow(entry)
    {
        if(entry.display == 'modal') $('#modalContainer').append(entry.toWindowHtml());
        else $('#deskContainer').append(entry.toWindowHtml());
        $('#taskbar .bar-menu').append(entry.toTaskBarShortcutHtml());
        $('.app-btn[data-id="'+entry.id+'"]').addClass('open');
    }

    function initWindowActions()
    {
        $(document).on('click', '.max-win', function(event) // max-win
        {
            toggleMaxSizeWindow($(this).closest('.window'));
            stopEvent(event);
        }).on('dblclick', '.window-head', function(event) // double click for max-win
        {
            toggleMaxSizeWindow($(this).closest('.window'));
            stopEvent(event);
        }).on('click', '.close-win', function(event) // close-win
        {
            var win = $(this).closest('.window');
            if(!win.length) win = $(this).closest('.app-btn').attr('data-id');
            closeWindow(win);
        }).on('click', '.min-win', function(event) // min-win
        {
            toggleShowWindow($(this).closest('.window'));
            stopEvent(event);
        }).on('click', '.reload-win', function(event) // reload window content
        {
            var win = $(this).closest('.window');
            if(!win.length) win = $(this).closest('.app-btn').attr('data-id');
            reloadWindow(win);
        });

        function stopEvent(event)
        {
            event.preventDefault();
            event.stopPropagation();
        }
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
            try
            {
                document.getElementById(fName).src = $(window.frames[fName].document).context.URL;
            }
            catch(e)
            {
                document.getElementById(fName).src = entry.url;
            }
            
        }
        else
        {
            win.find('.window-content').html(settings.frameHtmlTemplate.format(entry));
        }

        $('#' + fName).load(function()
        {
            win.removeClass('window-loading');
            win.find('.reload-win i').removeClass('icon-spin');

            try
            {
                var $frame = $(window.frames[fName].document);
                updateEntryUlr(win, $frame, entry);
                $frame.unbind('keydown', handleWindowKeydown).keydown(handleWindowKeydown).data('data-id', entry.idStr);
            }
            catch(e){}
        });
        return true;
    }

    function updateEntryUlr(win, frame, entry)
    {
        if(frame)
        {
            entry.currentUrl = frame.context.URL;
            win.attr('data-reffer-url', entry.currentUrl);
        }
        var url = win.attr('data-reffer-url');
        if(url == undefined) url = indexUrl;
        try{window.history.pushState({}, 0, url);}catch(e){}
    }

    function closeWindow(winQuery)
    {
        var win = getWinObj(winQuery);
        if(win.hasClass('window-safeclose') && (!confirm(settings.safeCloseTip.format(win.find('.window-head strong').text()))))
            return;

        var id       = win.attr('data-id');
        var isModal  = win.hasClass('window-modal');

        /* save the last position and size */
        var entry    = entries[id];
        entry.left   = win.position().left;
        entry.top    = win.position().top;
        entry.width  = win.width();
        entry.height = win.height();

        win.fadeOut(settings.animateSpeed, function()
        {
            $('.app-btn[data-id="' + id + '"]').removeClass('open').removeClass('active');
            $('#s-task-' + id).remove();
            win.remove();
            if(isModal) $('#desktop').removeClass('modal-mode');

            if((!$('#desktop').hasClass('fullscreen-mode')) && $('#taskbar .bar-menu li').length < 1) $('#showDesk').click();
        });

        $('.tooltip').remove();
        if(!isModal) activeWindow(lastActiveWindow);
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

        $('.app-btn.active, .fullscreen-btn.active').removeClass('active');
        $('.app-btn[data-id="' + win.attr('data-id') + '"]').addClass('active');

        updateEntryUlr(win);
    }

    function handleFullscreenMode()
    {
         $('#desktop').removeClass('fullscreen-mode');
         $('.fullscreen-active').removeClass('fullscreen-active');
         fullscreenMode = false;
         $('.fullscreen-btn').each(function(){$(this).removeClass($(this).attr('data-toggle-class'))});
    }

    /* start ips
     *
     * @return void
     */
    function start(entriesOptions, options)
    {
        initSettings(options);

        initMenu();

        /* bind window events */
        bindWindowsEvents();

        initEntries(entriesOptions);

        /* show content */
        showShortcuts();
        bindShortcutsEvents();

        initWindowActions();
        initWindowMovable();
    }

    function closeModal()
    {
        closeWindow($('#modalContainer .window').attr('id'));
    }

    /* make jquery object call the ips interface manager */
    $.extend({ipsStart: start, closeModal: closeModal});

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
