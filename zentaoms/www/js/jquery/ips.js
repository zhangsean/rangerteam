var config = 
{
    animateSpeed         : 200,  // 动画速度
    movingWindow         : null,    // 当前正在移动的窗口
    activeWindow         : null,    // 当前激活的窗口
    lastActiveWindow     : null,    //　上次激活的窗口
    entryIconRoot        : 'theme/default/images/ips/',  // 应用图标库目录地址
    windowHeadheight     : 36,      　// 桌面任务栏栏高度
    bottomBarHeight      : 42,      // 应用窗口底栏高度
    desktopSize          : null,    // 当前桌面区域尺寸
    desktopPos           : {x: 96, y: 0},
    defaultWindowPos     : {x: 110, y: 20},
    defaultWindowSize    : {width:700,height:538},
    windowidstrTemplate  : 'win-{0}',
    safeCloseTip         : '确认要关闭　【{0}】 吗？',
    entryNotFindTip      : '应用没有找到！',
    busyTip              : '应用正忙，请稍候...',
    fullscreenMode       : false,   // 是否正处于全屏状态
    getNextDefaultWinPos : function() 
    {
        this.defaultWindowPos = {x: this.defaultWindowPos.x + 30, y: this.defaultWindowPos.y + 30};
        return this.defaultWindowPos;
    },
    windowIdSeed     : 0,
    // 获取下一个新建窗口编号
    getNewWindowId   : function() { return this.windowIdSeed++; },
    windowZIndexSeed : 100,
    // 获取下一个新建窗口z-index
    getNewZIndex     : function() { return this.windowZIndexSeed++; },

    // window模版
    windowHtmlTemplate            : "<div id='{idstr}' class='window {cssclass}' style='width:{width}px;height:{height}px;left:{left}px;top:{top}px;z-index:{zindex};' data-id='{id}'><div class='window-head'><img src='{iconimg}' alt=''><strong title='{description}'>{title}</strong><ul><li><button class='reload-win'><i class='icon-repeat'></i></button></li><li><button class='min-win'><i class='icon-minus'></i></button></li><li><button class='max-win'><i class='icon-resize-full'></i></button></li><li><button class='close-win'><i class='icon-remove'></i></button></li></ul></div><div class='window-content'></div></div>",
    frameHtmlTemplate             : "<iframe id='iframe-{idstr}' name='iframe-{idstr}' src='{url}' frameborder='no' allowtransparency='true' scrolling='auto' hidefocus='' style='width: 100%; height: 100%; left: 0px;'></iframe>",
    leftBarShortcutHtmlTemplate   : '<li id="s-menu-{id}"><a href="javascript:;" class="app-btn" title="{title}:{description}" data-id="{id}"><img src="{iconimg}" alt=""></a></li>',
    taskBarShortcutHtmlTemplate   : '<li id="s-task-{id}"><a href="javascript:;" class="app-btn" title="{description}" data-id="{id}"><img src="{iconimg}" alt="">{title}</a></li>',
    entryListShortcutHtmlTemplate : '<li id="s-applist-{id}"><a href="javascript:;" class="app-btn" title="{description}" data-id="{id}"><img src="{iconimg}" alt="">{title}</a></li>',
    // taskBarShortcutHtmlTemplate : '<li id="s-task-{id}"><a href="javascript:;" class="app-btn" title="{title}:{description}" data-id="{id}"><i class="icon-list-alt"></i> {title}</a></li>',

    entries : null
};

var entryCount = 0;

$(function()
{
    initEntries();
    initShortcuts();
    initShortcusEvents();

    initWindowMovable();
    initWindowActivable();
    initWindowActions();

    initWindowResize();
    initOther();
});

function initEntries()
{
    config.entries = entries;
}

function initShortcuts()
{
    var entries = config.entries;
    var leftMenu = $('#apps-menu .bar-menu');
    var allEntriesList = $("#allAppsList .bar-menu");
    for(var index in entries)
    {
        var entry = entries[index];
        if(leftBarEntry.indexOf(entry.id) >= 0) leftMenu.append(entry.toLeftBarShortcutHtml());
        if(!isNaN(entry.id))
        {
          entryCount++;
          allEntriesList.append(entry.toEntryListShortcutHtml());
        }
    }
}

function initShortcusEvents()
{
    $(document).on('click', '.app-btn', function(event)
    {
        var entry = config.entries[$(this).attr('data-id')];
        if(entry)
        {
            openWindow(entry);
        }
        else
        {
            alert(config.entryNotFindTip);
        }

        var fullWindow = $(this).closest('.window-fullscreen.window-active');
        if(fullWindow.length>0)
        {
            hideWindow(fullWindow);
        }

        event.preventDefault();
    });
}

function initOther()
{
}

function entry(id, url, title, type,　description, display, size, position, imgicon, systemapp)
{
    this.id       = id;
    this.idstr    = config.windowidstrTemplate.format(this.id);
    this.url      = url;
    this.title    = title ? title : '';
    this.type     = type ? type : 'iframe';
    this.description = description ? description : '';
    this.display  = display ? display: 'normal';
    this.size     = size ? size : config.defaultWindowSize;
    this.position = position ? position : null;
    this.iconimg  = imgicon ? imgicon : config.entryIconRoot + 'app-' + this.id + '.png';
    this.systemapp= systemapp ? systemapp : false;
    this.cssclass = 'window-movable';

    this.toWindowHtml   = function()
    {
        this.init();

        return config.windowHtmlTemplate.format(this);
    };

    this.toLeftBarShortcutHtml = function()
    {
        if(!this.systemapp)
            return config.leftBarShortcutHtmlTemplate.format(this);
    };

    this.toTaskBarShortcutHtml = function()
    {
        return config.taskBarShortcutHtmlTemplate.format(this);
    };

    this.toEntryListShortcutHtml = function()
    {
        return config.entryListShortcutHtmlTemplate.format(this);
    }

    this.init = function()
    {
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
                this.zindex = config.getNewZIndex();
                if(!this.position) this.position = config.getNextDefaultWinPos();
                break;
            case 'fixed':
                this.cssclass += ' window-fixed';
                this.zindex = config.getNewZIndex();
                if(!this.position) this.position = config.getNextDefaultWinPos();
                break;
            case 'fullscreen':
                this.cssclass += ' window-fullscreen window-active';
                this.zindex = config.getNewZIndex() + 20000;
                this.position = config.desktopPos;
                this.size = config.desktopSize;
                break;
            case 'max':
                this.cssclass += ' window-max';
                this.zindex = config.getNewZIndex();
                this.position = config.desktopPos;
                this.size = config.desktopSize;
                break;
        }

        this.left     = this.position.x;
        this.top      = this.position.y;
        this.width    = this.size.width;
        this.height   = this.size.height;
    }
}

function openWindow(entry)
{
    console.log('open window：'+entry.title+","+entry.id);
    var entryWin = $('#' + entry.idstr);
    if(entryWin.length<1)
    {
        if(entry.type == 'blank')
        {
            window.open(entry.url);
            return;
        }

        createEntryWindow(entry);
        handleWinResized(entry.idstr);
        activeWindow(entry.idstr);
        reloadWindow(entry.idstr);
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


function createEntryWindow(entry)
{
    $('#deskContainer').append(entry.toWindowHtml());
    $('#taskbar .bar-menu').append(entry.toTaskBarShortcutHtml());
    $('.app-btn[data-id="'+entry.id+'"]').addClass('open');
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
            return (winQuery.constructor == Number) ? $('#' + config.windowidstrTemplate.format(winQuery)) : ((winQuery.constructor == String) ? $('#' + winQuery) : $(winQuery));
        }
    }
    else
    {
        return config.activeWindow;
    }

}

function getDesktopSize()
{
    var desk = $("#deskContainer");
    return {width: desk.width() - config.desktopPos.x, height: desk.height() - config.desktopPos.y - config.bottomBarHeight};
}

function initWindowActions()
{
    // max-win
    $(document).on('click', '.max-win', function(event)
    {
        toggleMaxSizeWindow($(this).closest('.window'));
        event.preventDefault();
        event.stopPropagation()
    }).on('dblclick', '.window-head', function(event) // double click for max-win
    {
        toggleMaxSizeWindow($(this).closest('.window'));
        event.preventDefault();
        event.stopPropagation()
    }).on('click', '.close-win', function(event) // close-win
    {
        closeWindow($(this).closest('.window'));
        event.preventDefault();
        event.stopPropagation()
    }).on('click', '.min-win', function(event) // min-win
    {
        toggleShowWindow($(this).closest('.window'));
        event.preventDefault();
        event.stopPropagation()
    }).on('click', '.reload-win', function(event)
    {
        reloadWindow($(this).closest('.window'));
        event.preventDefault();
        event.stopPropagation()
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
        win.fadeOut(config.animateSpeed).addClass('window-min');
        if(!silence)
            activeWindow(config.lastActiveWindow);
    }
}

function showWindow(winQuery)
{
    var win = getWinObj(winQuery);
    console.log('showWindow：'+win.attr('data-id'));
    if(win.hasClass('window-min'))
    {
        win.fadeIn(config.animateSpeed).removeClass('window-min');
    }
    activeWindow(win);
}

function reloadWindow(winQuery)
{
    var win = getWinObj(winQuery);
    if(!win.hasClass('window-loading'))
    {
        win.addClass('window-loading').removeClass('window-error').find('.reload-win i').addClass('icon-spin');
        var entry = config.entries[win.attr('data-id')];

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
        alert(config.busyTip);
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
        win.find('.window-content').html(config.frameHtmlTemplate.format(entry));
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
    if(win.hasClass('window-safeclose') && (!confirm(config.safeCloseTip.format(win.find('.window-head strong').text()))))
        return;

    win.fadeOut(config.animateSpeed, function(){
        var id = win.attr('data-id');
        $('.app-btn[data-id="' + id + '"]').removeClass('open').removeClass('active');
        $('#s-task-' + id).remove();
        win.remove(); 
    });
    activeWindow(config.lastActiveWindow);
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
        var dSize = getDesktopSize();
        win.data('orginLoc', 
        {
            left: win.css('left'),
            top: win.css('top'),
            width: win.css('width'),
            height: win.css('height')
        }).addClass('window-max').css(
        {
            left: config.desktopPos.x,
            top: config.desktopPos.y,
            width: dSize.width,
            height: dSize.height
        }).find('.icon-resize-full').removeClass('icon-resize-full').addClass('icon-resize-small');
    }
    handleWinResized(win);
}

function handleWinResized(winQuery)
{
    var win  = getWinObj(winQuery);
    win.find('.window-content').height(win.height() - config.windowHeadheight);
}

function initWindowMovable()
{
    $(document).on('mousedown', '.movable,.window-movable .window-head', function(event)
    {
        var win = $(this).closest('.window:not(.window-max)');
        if(win.length<1)
        {
            return;
        }
        config.movingWindow = win;
        var mwPos = config.movingWindow.position();
        config.movingWindow.data('mouseOffset', {x: event.pageX-mwPos.left, y: event.pageY-mwPos.top}).addClass('window-moving');
        $(document).bind('mousemove',mouseMove).bind('mouseup',mouseUp)
        event.preventDefault();
    });

    function mouseUp()
    {
        $('.window.window-moving').removeClass('window-moving');
        config.movingWindow = null;
        $(document).unbind('mousemove', mouseMove).unbind('mouseup', mouseUp)
    }

    function mouseMove(event)
    {
        if(config.movingWindow && config.movingWindow.hasClass('window-moving'))
        {
            var offset = config.movingWindow.data('mouseOffset');
            config.movingWindow.css(
            {
                left : event.pageX-offset.x,
                top : event.pageY-offset.y
            });
        }
    }
}

function initWindowActivable()
{
    config.activeWindow = $('.window-active');
    $(document).on('mousedown', '.window', function()
    {
        activeWindow($(this));
    });
}

function activeWindow(query)
{
    var win = getWinObj(query);

    if(win.hasClass('window-active')) return;
    if($('.window[data-id="'+win.attr('data-id')+'"]').length<1) return;

    if(config.activeWindow)
    {
        if(config.activeWindow.hasClass('window-fullscreen'))
        {
            hideWindow(config.activeWindow,true);
        }
        else
        {
            config.lastActiveWindow = config.activeWindow;
        }
        config.activeWindow.removeClass('window-active').css('z-index', parseInt(config.activeWindow.css('z-index'))%10000);
        
    }

    config.activeWindow = win.addClass('window-active').css('z-index',parseInt(win.css('z-index'))+10000);

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
        config.fullscreenMode = true;
    }
    else
    {
        config.fullscreenMode = false;
        $("#desktop").removeClass('fullscreen-mode');
    }
}

function initWindowResize()
{
    refreshSize();
    $(window).resize(refreshSize);
}

function refreshSize()
{
    refreshDesktopSize();
    resizeEntriesMenu();
    refreshWindowSize();
}

function refreshDesktopSize()
{
    var desktop = $('#desktop');
    config.desktopSize = {width: desktop.width() - config.desktopPos.x, height: desktop.height() - config.desktopPos.y - config.bottomBarHeight};
    console.log('desktopSize:'+config.desktopSize.width+","+config.desktopSize.height);
}

function refreshWindowSize()
{
    $('.window-fullscreen,.window-max').each(function()
    {
        var win = $(this);
        win.width(config.desktopSize.width);
        win.height(config.desktopSize.height);
        handleWinResized(win);
    });
}

function resizeEntriesMenu()
{
    var menu = $('#apps-menu');
    var iconHeight = menu.find('li').height();
    var menuHeight = config.desktopSize.height - $('#leftBar .dock-bottom').height();
    if(iconHeight>0)
    {
        while(menuHeight%iconHeight!=0)
        {
            menuHeight--;
        }
    }
    menu.height(menuHeight);
}

/**
 *  Format string 
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
