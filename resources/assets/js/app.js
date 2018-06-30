/**
 * Created by jgmuchiri on 7/21/2017.
 */
require('./bootstrap.min');
require('./jquery.uniform');
require('./sweetalert.min');
require('./bootstrap-datepicker');
require('./jquery.autosize.min');
require('./jquery.scrollTo.min');
require('./jquery.validate');
require('./matrix.popover');
require('./matrix.form_validation');
let tokenElement = $('meta[name="csrf-token"]');
let _token = tokenElement.attr('content');
//fix youtube embedding
function youtube(url) {
    let regExp = /^.*(youtu\.be\/|v\/|u\/\w\/|embed\/|watch\?v=|\&v=)([^#\&\?]*).*/;
    let match = url.match(regExp);
    if (match && match[2].length === 11) {
        return 'https://www.youtube.com/embed/' + match[2];
    } else {
        return url;
    }
}


$(document).ready(function () {
    $('.btn-data').click(function (e) {
        let modal = $(this).attr('id');
        $(modal).modal('show');
    });

    let sidebar = $('#sidebar');
    $('.submenu > a').click(function (e) {
        e.preventDefault();
        let submenu = $(this).siblings('ul');
        let li = $(this).parents('li');
        let submenus = sidebar.find('li.submenu ul');
        let submenus_parents = sidebar.find('li.submenu');
        if (li.hasClass('open')) {
            if (($(window).width() > 768) || ($(window).width() < 479)) {
                submenu.slideUp();
            } else {
                submenu.fadeOut(250);
            }
            li.removeClass('open');
        } else {
            if (($(window).width() > 768) || ($(window).width() < 479)) {
                submenus.slideUp();
                submenu.slideDown();
            } else {
                submenus.fadeOut(250);
                submenu.fadeIn(250);
            }
            submenus_parents.removeClass('open');
            li.addClass('open');
        }
    });

    let ul = sidebar.find('> ul');
    sidebar.find('> a').click(function (e) {
        e.preventDefault();
        let sidebar = $('#sidebar');
        if (sidebar.hasClass('open')) {
            sidebar.removeClass('open');
            ul.slideUp(250);
        } else {
            sidebar.addClass('open');
            ul.slideDown(250);
        }
    });

    // === Resize window related === //
    $(window).resize(function () {
        if ($(window).width() > 479) {
            ul.css({'display': 'block'});
            $('#content-header').find('.btn-group').css({width: 'auto'});
        }
        if ($(window).width() < 479) {
            ul.css({'display': 'none'});
            fix_position();
        }
        if ($(window).width() > 768) {
            $('#user-nav').find('> ul').css({width: 'auto', margin: '0'});
            $('#content-header').find('.btn-group').css({width: 'auto'});
        }
    });

    if ($(window).width() < 468) {
        ul.css({'display': 'none'});
        fix_position();
    }

    if ($(window).width() > 479) {
        $('#content-header').find('.btn-group').css({width: 'auto'});
        ul.css({'display': 'block'});
    }

    // === Tooltips === //
    $('.tip').tooltip();
    $('.tip-left').tooltip({placement: 'left'});
    $('.tip-right').tooltip({placement: 'right'});
    $('.tip-top').tooltip({placement: 'top'});
    $('.tip-bottom').tooltip({placement: 'bottom'});

    // === Search input typeahead === //
    $('#search').find('input[type=text]').typeahead({
        source: ['Dashboard', 'Form elements', 'Common Elements', 'Validation', 'Wizard', 'Buttons', 'Icons', 'Interface elements', 'Support', 'Calendar', 'Gallery', 'Reports', 'Charts', 'Graphs', 'Widgets'],
        items: 4
    });

    // === Fixes the position of buttons group in content header and top user navigation === //
    function fix_position() {
        let uwidth = $('#user-nav').find('> ul')
            //.width()
            .css({width: uwidth, 'margin-left': '-' + uwidth / 2 + 'px'});

        let cwidth = $('#content-header').find('.btn-group')
            //.width()
            .css({width: cwidth, 'margin-left': '-' + uwidth / 2 + 'px'});
    }

    // === Style switcher === //
    let switcher = $('#style-switcher').find('i');
    switcher.click(function () {
        if ($(this).hasClass('open')) {
            $(this).parent().animate({marginRight: '-=190'});
            $(this).removeClass('open');
        } else {
            $(this).parent().animate({marginRight: '+=190'});
            $(this).addClass('open');
        }
        $(this).toggleClass('icon-arrow-left');
        $(this).toggleClass('icon-arrow-right');
    });

    switcher.click(function () {
        let style = $(this).attr('href').replace('#', '');
        $('.skin-color').attr('href', 'css/maruti.' + style + '.css');
        $(this).siblings('a').css({'border-color': 'transparent'});
        $(this).css({'border-color': '#aaaaaa'});
    });

    //toggle active class on sidebar
    $('.sideNav').find('a').each(function () {
        let link = $(this).attr('href');
        link = link.split("/")[1];
        if (link === curPage) {
            $(this).parent('li').addClass('active');
            $(this).closest('.submenu').addClass('open');
        }
    });
});