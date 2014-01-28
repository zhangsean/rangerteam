/* ips lib */
+function($, window, document, Math)
{
    "use strict";

    var debug = true;

    /* global variables */
    var desktopPos       = {x: 60, y: 0};
    var fullscreenMode   = false;
    var windowIdSeed     = 0;
    var windowZIndexSeed = 100;
    var defaultWindowPos = {x: 110, y: 20};
    var entriesConfigs   = null;
    var entries          = null;
    var desktop          = null;
    var windows          = null;
    var windowIdPrefix   = 'win-';

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
        safeRemoveBlock               : '确定要移除区块 【{0}】 吗？',
        removedBlock                  : '区块已删除',
        orderdBlocksSaved             : '排序已保存',
        blocksEditTip                 : '开始编辑您的区块：拖动区块来排序，点击删除和编辑按钮来操作。',
        windowHtmlTemplate            : "<div id='{idstr}' class='window{cssclass}' style='width:{width}px;height:{height}px;left:{left}px;top:{top}px;z-index:{zindex};' data-id='{id}'><div class='window-head'>{iconhtml}<strong title='{desc}'>{name}</strong><ul><li><button class='reload-win'><i class='icon-repeat'></i></button></li><li><button class='min-win'><i class='icon-minus'></i></button></li><li><button class='max-win'><i class='icon-resize-full'></i></button></li><li><button class='close-win'><i class='icon-remove'></i></button></li></ul></div><div class='window-cover'></div><div class='window-content'></div></div>",
        frameHtmlTemplate             : "<iframe id='iframe-{id}' name='iframe-{idstr}' src='{url}' frameborder='no' allowtransparency='true' scrolling='auto' hidefocus='' style='width: 100%; height: 100%; left: 0px;'></iframe>",
        leftBarShortcutHtmlTemplate   : '<li id="s-menu-{id}"><a data-toggle="tooltip" data-placement="right"  href="javascript:;" class="app-btn s-menu-btn" title="{name}" data-id="{id}">{iconhtml}</a></li>',
        taskBarShortcutHtmlTemplate   : '<li id="s-task-{id}"><button class="app-btn s-task-btn" title="{desc}" data-id="{id}">{iconhtml}{name}</button></li>',
        taskBarMenuHtmlTemplate       : "<ul class='dropdown-menu' id='taskMenu'><li><a href='###' class='reload-win'><i class='icon-repeat'></i> &nbsp;{reloadWindowText}</a></li><li><a href='###' class='close-win'><i class='icon-remove'></i> &nbsp;{closeWindowText}</a></li></ul>",
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
        entries        = new Array();
        for(var i in entriesConfigs)
        {
            var config = entriesConfigs[i];
            entries[config.id] = new Entry(config);
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
        //             {
        //                 var value = e[ikey];
        //                 if(ikey == 'size')
        //                 {
        //                     value = '{width: ' + value.width + ', height:' + value.height + '}';
        //                 }
        //                 else if(ikey == 'position' && value && value.hasOwnProperty('x'))
        //                 {
        //                     value = '{x: ' + value.x + ', y:' + value.y + '}';
        //                 }
        //                 console.log('        * ' + ikey + ': ' + value);
        //             }
        //         }
        //     }
        // }
    };

    /* entry 
     *
     * @return void
     */
    function Entry(options)
    {
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
                this.width  = Math.min(this.size.width, desktop.width);
                this.height = Math.min(this.size.height, desktop.height);
            }
            else
            {
                this.width  = desktop.width;
                this.height = desktop.height;
                this.size = 'max';
                this.position  = {x: desktop.x, y: desktop.y};
                if(this.cssclass.indexOf(' window-max') < 0) this.cssclass += ' window-max';
            }

            /* init position setting */
            if(this.position == 'center')
            {
                this.left = Math.max(desktop.x, desktop.x + (desktop.width - this.width)/2);
                this.top  = Math.max(desktop.y, desktop.y + (desktop.height - this.height)/2);
            }
            else if(this.position.x != undefined && this.position.y != undefined)
            {
                this.left = Math.max(desktop.x, this.position.x);
                this.top  = Math.max(desktop.y, this.position.y);
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
                this.width  = Math.min(this.size.width, desktop.width);
                this.height = Math.min(this.size.height, desktop.height);
            }
            else if(this.size == 'max')
            {
                this.width  = desktop.width;
                this.height = desktop.height;
                this.position  = desktop.position;
            }

            if(this.position == 'center')
            {
                this.left = Math.max(desktop.x, desktop.x + (desktop.width - this.width)/2);
                this.top  = Math.max(desktop.y, desktop.y + (desktop.height - this.height)/2);
            }
        }

        this.toWindowHtml = function()
        {
            this.reCalPosSize();
            return settings.windowHtmlTemplate.format(this);
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

        this.createWindow = function()
        {
            if(this.display == 'modal') $('#modalContainer').append(this.toWindowHtml());
            else $('#deskContainer').append(this.toWindowHtml());
            $('#taskbar .bar-menu').append(this.toTaskBarShortcutHtml());
            $('.app-btn[data-id="'+this.id+'"]').addClass('open');

            return new Window(this.idstr);
        }

        this.init = function(options)
        {
            if(!desktop)
            {
                var w = $(window);
                desktop = {x: desktopPos.x, y: desktopPos.y, width: w.width(), height: w.height()};
            }

            /* extend options from params */
            $.extend(this, this.getDefaults(options.id), options);
            this.idstr      = settings.windowidstrTemplate.format(this.id);
            this.cssclass   = '';

            /* if no icon setting here, then load icon with the default rule */
            if(!this.icon) this.icon = settings.entryIconRoot + 'entry-' + this.id + '.png';

            /* you can use icon font name or an image url */
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

        this.init(options);
    }

    function Desktop()
    {
        this.cancelFullscreenMode = function()
        {
            this.$.removeClass('fullscreen-mode');
            $('.fullscreen-active').removeClass('fullscreen-active');
            this.isFullscreenMode = false;
            $('.fullscreen-btn').each(function(){$(this).removeClass($(this).attr('data-toggle-class'))});
        }

        this.turnOnFullscreenMode = function()
        {
            this.$.addClass('fullscreen-mode');
            this.isFullscreenMode = true;
            $('.fullscreen-active').removeClass('fullscreen-active');
            $('.fullscreen-btn, .app-btn').each(function(){$(this).removeClass($(this).attr('data-toggle-class')).removeClass('active')});
        }

        this.turnOnModalMode = function()
        {
            this.$.addClass('modal-mode');
        }

        this.init = function()
        {
            this.position       = desktopPos;
            this.x              = desktopPos.x;
            this.y              = desktopPos.y;

            this.$          = $('#desktop');
            this.$menu      = $('#apps-menu');
            this.$bottombar = $('#bottomBar');

            this.isFullscreenMode = this.$.hasClass('fullscreen-mode');
            
            this.menu           = new Menu();
            this.shortcuts      = new Shortcuts();
            this.startMenu      = new StartMenu();
            this.fullScreenApps = new FullScreenApps();
            windows             = new Windows();
        }

        this.bindEvents = function()
        {
            $(window).resize($.proxy(function() // handle varables when window size changed
            {
                /* refresh desktop size */
                this.size   = {width: this.$.width() - this.x, height: this.$.height() - this.y - settings.bottomBarHeight};
                this.width  = this.size.width;
                this.height = this.size.height;

                /* refresh app menu size */
                var menu = this.$menu;
                var iconHeight = menu.find('li').height();
                var menuHeight = this.height - this.$bottombar.height();
                if(iconHeight > 0)
                {
                    while(menuHeight % iconHeight != 0)
                    {
                        menuHeight--;
                    }
                }
                menu.height(menuHeight);

                /* refresh entry window size */
                windows.afterBrowserResized();
            }, this)).resize();

            $(document).on('click', '[data-toggle-class]', function()
            {
                var $e = $(this);
                var target = $e.attr('data-target');
                if(target != undefined) target = $(target); else target = $e;
                target.toggleClass($e.attr('data-toggle-class'));
                $e.toggleClass('toggle-on');
            });
        }

        this.init();
        this.bindEvents();
    }

    function Windows()
    {
        this.init = function()
        {
            this.movingWindow     = null;
            this.activedWindow    = null;
            this.lastActiveWindow = null;
            this.set              = new Array();
        }

        this.query = function(q)
        {
            return this.set[q] || this.set[settings.windowidstrTemplate.format(q)] || this.activedWindow;
        }

        this.active = function(q)
        {
            var win = this.query(q);
            if(win == undefined) return;

            win.active();
        }

        this.activeLastWindow = function()
        {
            if(this.lastActiveWindow) this.lastActiveWindow.active();
        }

        this.close = function(q)
        {
            var win = this.query(q);
            if(win == undefined) return;
            win.close();
            delete this.set[win.idstr];

            if(this.lastActiveWindow)
            {
                this.activedWindow = this.lastActiveWindow;
                this.lastActiveWindow = null;
            }
        }

        this.reload = function()
        {
            if(this.activedWindow) this.activedWindow.reload();
        }

        this.openEntry = function(entry)
        {
            if(!entry)
            {
                alert(settings.entryNotFindTip);
                return;
            }

            var win = this.set[entry.idstr];

            if(!win)
            {
                if(entry.open == 'blank')
                {
                    window.open(entry.url);
                    return;
                }

                win = entry.createWindow();
                this.set[entry.idstr] = win;
                win.reload();
                win.active();
            }
            else if(win.isActive())
            {
                if(desktop.isFullscreenMode) win.active();
                else win.toggle();
            }
            else win.show();


            if(entry.display != 'modal') desktop.cancelFullscreenMode();
            else desktop.turnOnModalMode();
        }

        this.beforeActive = function()
        {
            if(this.activedWindow)
            {
                if(this.activedWindow.isFullscreen)
                {
                    this.activedWindow.hide(true);
                }
                else
                {
                    this.lastActiveWindow = this.activedWindow;
                }

                this.activedWindow.$.removeClass('window-active').css('z-index', parseInt(this.activedWindow.$.css('z-index')) % 10000);
            }
        }

        this.bindEvents = function()
        {
            $(document).on('click', '.window', function() // active by click a non actived window
            {
                windows.active($(this).attr('id'));
            }).on('mousedown', '.movable,.window-movable .window-head', function(e) // make the window movable with class '.movable' or '.window-movable'
            {
                var win = $(this).closest('.window:not(.window-max)');
                if(win.length < 1) return;

                windows.movingWindow = windows.set[win.attr('id')];

                var mwPos = win.position();
                win.data('mouseOffset', {x: e.pageX - mwPos.left, y: e.pageY - mwPos.top}).addClass('window-moving');
                $(document).bind('mousemove',mouseMove).bind('mouseup',mouseUp)
                e.preventDefault();

                function mouseUp()
                {
                    $('.window.window-moving').removeClass('window-moving');
                    windows.movingWindow = null;
                    $(document).unbind('mousemove', mouseMove).unbind('mouseup', mouseUp)
                }

                function mouseMove(event)
                {
                    if(windows.movingWindow && windows.movingWindow.hasClass('window-moving'))
                    {
                        var offset = windows.movingWindow.$.data('mouseOffset');
                        windows.movingWindow.$.css(
                        {
                            left : event.pageX-offset.x,
                            top : event.pageY-offset.y
                        });
                    }
                }
            }).keydown(this.handleWindowKeydown) // listen the keydown events
            .on('click', '.max-win', function(event) // max-win
            {
                windows.set[$(this).closest('.window').attr('id')].toggle();
                stopEvent(event);
            }).on('dblclick', '.window-head', function(event) // double click for max-win
            {
                windows.set[$(this).closest('.window').attr('id')].toggleSize();
                stopEvent(event);
            }).on('click', '.close-win', function(event) // close-win
            {
                var q = $(this).closest('.window').attr('data-id');
                if(!q) q = $(this).closest('.app-btn').attr('data-id');
                if(!q) q = $('#taskMenu.show').attr('data-id');
                windows.close(q);
            }).on('click', '.min-win', function(event) // min-win
            {
                windows.set[$(this).closest('.window').attr('id')].hide();
                stopEvent(event);
            }).on('click', '.reload-win', function(event) // reload window content
            {
                var q = $(this).closest('.window').attr('data-id');
                if(!q) q = $(this).closest('.app-btn').attr('data-id');
                if(!q) q = $('#taskMenu.show').attr('data-id');

                windows.query(q).reload();
            });
        }

        this.handleWindowKeydown = function(event)
        {
            if(event.keyCode == 116)
            {
                windows.reload();
                return false;
            }
        }

        this.afterBrowserResized = function()
        {
            for(var i in this.set)
            {
                this.set[i].afterResized();
            }
        }

        this.init();
        this.bindEvents();
    }

    function Window(idStr)
    {
        this.init = function(idStr)
        {
            this.$ = $('#' + idStr);

            if(this.$.length < 1) throw new Error('Can not find the window: ' + idStr + ' when init it.');

            this.idstr   = this.$.attr('id');
            this.id      = this.$.attr('data-id');
            this.isModal = this.$.hasClass('window-modal');
            this.entry   = entries[this.$.attr('data-id')];
            this.getUrl();

            this.afterResized(true);
        }

        this.hasClass = function(c)
        {
            return this.$.hasClass(c);
        }

        this.isHide = function()
        {
            return this.hasClass('window-min');
        }

        this.isLoading = function()
        {
            return this.hasClass('window-loading');
        }

        this.isFullscreen = function()
        {
            return this.hasClass('window-fullscreen');
        }

        this.isMax = function()
        {
            return this.hasClass('window-max');
        }

        this.isFixed = function()
        {
            return this.hasClass('window-fixed');
        }

        this.isActive = function()
        {
            return this.hasClass('window-active');
        }

        this.getUrl = function()
        {
            this.url = this.$.attr('data-url') || this.entry.url;
            return this.url;
        }

        this.toggle = function()
        {
            if(this.isHide()) this.show();
            else this.hide();
        }

        this.hide = function(silence)
        {
            if(!this.isHide())
            {
                this.$.fadeOut(settings.animateSpeed).addClass('window-min');
                if(!silence)
                    windows.activeLastWindow();
            }
        }

        this.show = function()
        {
            if(this.isHide())
            {
                this.$.fadeIn(settings.animateSpeed).removeClass('window-min');
            }
            this.active();
        }

        this.reload = function()
        {
            if(!this.isLoading())
            {
                this.$.addClass('window-loading').removeClass('window-error').find('.reload-win i').addClass('icon-spin');

                switch(this.entry.open)
                {
                    case 'iframe':
                        this.loadIframe();
                        break;
                    case 'html':
                        this.loadHtml();
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

        this.loadHtml = function()
        {
            var content = this.$.find('.window-content').html('');
            $.ajax(
            {
                url: this.getUrl(),
                dataType: 'html',
            })
            .done(function(data)
            {
                content.html(data);
            })
            .fail(function()
            {
                this.$.addClass('window-error');
            })
            .always(function()
            {
                this.$.removeClass('window-loading');
                this.$.find('.reload-win i').removeClass('icon-spin');
            });
        }

        this.loadIframe = function()
        {
            var fName = 'iframe-' + this.id;
            var frame = $('#' + fName);
            if(frame.length > 0)
            {
                try
                {
                    document.getElementById(fName).src = $(window.frames[fName].document).context.URL;
                }
                catch(e)
                {
                    document.getElementById(fName).src = this.getUrl();
                }
            }
            else
            {
                this.$.find('.window-content').html(settings.frameHtmlTemplate.format(this));
            }

            $('#' + fName).load($.proxy(function()
            {
                this.$.removeClass('window-loading').find('.reload-win i').removeClass('icon-spin');

                try
                {
                    var $frame = $(window.frames[fName].document);
                    
                    if($frame)
                    {
                        this.url = $frame.context.URL;
                        this.$.attr('data-url', this.url);
                        if(this.entry) entry.currentUrl = this.url;
                    }

                    if(this.url == undefined) this.url = indexUrl;
                    try{window.history.pushState({}, 0, this.url);}catch(e){}

                    // $frame.unbind('keydown', handleWindowKeydown).keydown(handleWindowKeydown).data('data-id', this.idStr);
                }
                catch(e){}
            }, this));
            return true;
        }

        this.close = function()
        {
            var win = this.$;
            if(win.hasClass('window-safeclose') && (!confirm(settings.safeCloseTip.format(win.find('.window-head strong').text()))))
                return;

            /* save the last position and size */
            if(this.entry)
            {
                this.entry.left   = win.position().left;
                this.entry.top    = win.position().top;
                this.entry.width  = win.width();
                this.entry.height = win.height();
            }

            win.fadeOut(settings.animateSpeed, $.proxy(function()
            {
                $('.app-btn[data-id="' + this.id + '"]').removeClass('open').removeClass('active');
                $('#s-task-' + this.id).remove();
                win.remove();
                if(this.isModal) $('#desktop').removeClass('modal-mode');

                if((!desktop.$.hasClass('fullscreen-mode')) && $('#taskbar .bar-menu li').length < 1) $('#showDesk').click();
            }, this));

            $('.tooltip').remove();
            if(!this.isModal) windows.activeLastWindow();
        }

        this.toggleSize = function()
        {
            var win = this.$;
            if(this.isFixed) return;

            if(this.isMax)
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
                var dSize = desktop.size;
                win.data('orginLoc', 
                {
                    left:   win.css('left'),
                    top:    win.css('top'),
                    width:  win.css('width'),
                    height: win.css('height')
                }).addClass('window-max').css(
                {
                    left:   desktop.position.x,
                    top:    desktop.position.y,
                    width:  dSize.width,
                    height: dSize.height
                }).find('.icon-resize-full').removeClass('icon-resize-full').addClass('icon-resize-small');
            }
            this.afterResized(true);
        }

        this.afterResized = function(onlyAppSize)
        {
            if(!onlyAppSize)
            {
                if(this.isMax())
                {
                    this.$.width(desktop.width)
                        .height(desktop.height)
                        .css(
                        {
                            left : desktop.x,
                            right: desktop.y
                        });
                }
            }

            var offset = this.$.hasClass('window-control-full') ? settings.windowHeadheight : 0;
            this.$.find('.window-content').height(this.$.height() - offset);
        }

        this.active = function()
        {
            $('.app-btn.active, .fullscreen-btn.active').removeClass('active');
            $('.app-btn[data-id="' + this.id + '"]').addClass('active');

            if(this.isActive()) return;

            windows.beforeActive();
            this.$.addClass('window-active').css('z-index',parseInt(this.$.css('z-index')) + 10000);
            windows.activedWindow = this;
            // updateEntryUlr(win);
        }

        this.init(idStr);
    }

    function StartMenu()
    {
        this.init = function()
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

        this.init();
    }

    function FullScreenApps()
    {
        this.init = function()
        {
            this.handleAllApps();
            this.handleHomeBlocks();
        }

        this.bindEvents = function()
        {
            $('.fullscreen-btn').click(function()
            {
                desktop.fullScreenApps.toggle($(this).attr('data-id'));
            });
        }

        this.handleAllApps = function()
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

                var val = $(this).val().toLowerCase();

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
                            r = r && (k=='' || (et.name.toLowerCase().indexOf(k) > -1) || (et.desc.toLowerCase().indexOf(k) > -1) || et.id.toLowerCase() == k);
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

        this.handleHomeBlocks = function()
        {
            var msg = null;
            $('#customHome').click(function()
            {
                if(!$('#home').hasClass('custom-mode')) msg = messager.info(settings.blocksEditTip, 'top', 6000); 
                else if(msg != null) msg.hide();
            });

            $(document).on('click', '#home.custom-mode .remove-block', function()
            {
                var panel = $(this).closest('.panel');
                var index = panel.attr('data-id');
                var name = panel.find('.panel-heading').text().replace('\n', '').replace(/(^\s*)|(\s*$)/g, "");
                if(confirm(settings.safeRemoveBlock.format(name)))
                {
                    if(settings.onDeleteBlock && $.isFunction(settings.onDeleteBlock))
                    {
                        settings.onDeleteBlock(index);
                        messager.info(settings.removedBlock);
                    }
                    $('#block' + index).parent().remove();
                }
            }).on('mouseover', '#home.custom-mode:not(.dragging) .panel:not(#draggingPanel)', function()
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
                    left    : pos.left - desktop.position.x,
                    top     : pos.top,
                    width   : panel.width(),
                    height  : panel.height()
                }).appendTo('#home').data('mouseOffset', {x: event.pageX - pos.left + desktop.position.x, y: event.pageY - pos.top});

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
                        var mX = event.pageX - desktop.position.x, mY = event.pageY;

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

                        if(settings.onBlocksOrdered && $.isFunction(settings.onBlocksOrdered))
                        {
                            settings.onBlocksOrdered(newOrders);
                            messager.success(settings.orderdBlocksSaved);
                        }
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

        this.show = function(id)
        {
            desktop.turnOnFullscreenMode();

            $('#' + id).addClass('fullscreen-active');
            $('.fullscreen-btn[data-id="' + id + '"],.app-btn[data-id="' + id + '"]').addClass('active');

            if(id == 'allapps') $('#search').focus();
        }

        this.hide = function(id)
        {

            $('.fullscreen-btn[data-id="' + id + '"],.app-btn[data-id="' + id + '"]').removeClass('active');

            windows.active();
        }

        this.toggle = function(id)
        {
            if($('#' + id).hasClass('fullscreen-active')) this.hide(id);
            else this.show(id);
        }

        this.init();
        this.bindEvents();
    }

    function Shortcuts()
    {
        this.init = function()
        {
            this.$leftBar     = $('#leftBar');
            this.$appsMenu    = $('#apps-menu .bar-menu');
            this.$allAppsList = $("#allAppsList .bar-menu");
            this.$taskMenu    = $('#taskMenu');

            this.showShortcuts();
            this.bindEvents();
        }

        this.showShortcuts = function()
        {
            for(var index in entries)
            {
                var entry = entries[index];
                if(entry.menu) this.$appsMenu.append(entry.toLeftBarShortcutHtml());
                this.$allAppsList.append(entry.toEntryListShortcutHtml());
            }
        }

        this.bindEvents = function()
        {
            $(document).on('click', '.app-btn', function(event)
            {
                var entry = entries[$(this).attr('data-id')];
                if(entry)
                {
                    if(entry.display == 'fullscreen') desktop.fullScreenApps.toggle(entry.id);
                    else windows.openEntry(entry);
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

            this.$leftBar.bind('oncontextmenu', nocontextmenu);

            $(document).on('mousedown', '.app-btn.open', function(e)
            {
                if(e.which == 3)
                {
                    var btn = $(this),menu = desktop.shortcuts.$taskMenu, offset = btn.offset();
                    if(!menu.length) menu = $(settings.taskBarMenuHtmlTemplate).appendTo('#desktop');
                    menu.toggleClass('show');

                    if(menu.hasClass('show'))
                    {
                        menu.attr('data-id', btn.attr('data-id'));
                        if(btn.hasClass('s-menu-btn')) menu.css({left: 62, top: offset.top, bottom: 'inherit'});
                        else if(btn.hasClass('s-task-btn')) menu.css({left: offset.left, top: 'inherit', bottom: 38});
                    }
                }

                e.stopPropagation();
            });

            $(document).click(function(){desktop.shortcuts.$taskMenu.removeClass('show')});

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

        this.init();
    }

    function Menu()
    {
        this.init = function()
        {
            this.$leftBar = $('#leftBar');

            if(settings.autoHideMenu)
            {
                this.$leftBar.addClass('menu-auto');
                desktop.position.x = 2;
                setTimeout(this.hideMenu, 2000);

                this.$leftBar.addClass('menu-auto').mouseover(this.showMenu).mouseout(this.hideMenu);;
            }
        }

        this.hideMenu = function()
        {
            var $leftBar = desktop.menu.$leftBar;
            $leftBar.removeClass('menu-show');
            setTimeout(function()
            {
                if(!$leftBar.hasClass('menu-show'))
                {
                    $leftBar.addClass('menu-hide');
                    $('#apps-menu .app-btn[data-toggle="tooltip"]').removeAttr('data-toggle');
                }
            }, 1000);
        }

        this.showMenu = function()
        {
            desktop.menu.$leftBar.removeClass('menu-hide').addClass('menu-show');
            setTimeout(function(){$('#apps-menu .app-btn').attr('data-toggle', 'tooltip');}, 500);
        }

        this.init();
    }

    function stopEvent(event)
    {
        event.preventDefault();
        event.stopPropagation();
    }

    /* start ips
     *
     * @return void
     */
    function start(entriesOptions, options)
    {
        initSettings(options);
        initEntries(entriesOptions);

        desktop = new Desktop();
    }

    // function closeModal()
    // {
    //     closeWindow($('#modalContainer .window').attr('id'));
    // }

    /* make jquery object call the ips interface manager */
    $.extend({ipsStart: start});

}(jQuery,window,document,Math);
