const texts = ["ابحث عن الاجهزه التى تريدها", "قم بالبحث المناسب ", "ابحث مره اخرى"];
const input = document.querySelector("#searchbox");
const animationWorker = function (input, texts) {
    this.input = input;
    this.defaultPlaceholder = this.input.getAttribute("placeholder");
    this.texts = texts;
    this.curTextNum = 0;
    this.curPlaceholder = "";
    this.blinkCounter = 0;
    this.animationFrameId = 0;
    this.animationActive = false;
    this.input.setAttribute("placeholder", this.curPlaceholder);

    this.switch = (timeout) => {
        this.input.classList.add("imitatefocus");
        setTimeout(() => {
            this.input.classList.remove("imitatefocus");
            if (this.curTextNum == 0)
                this.input.setAttribute("placeholder", this.defaultPlaceholder);
            else this.input.setAttribute("placeholder", this.curPlaceholder);

            setTimeout(() => {
                this.input.setAttribute("placeholder", this.curPlaceholder);
                if (this.animationActive)
                    this.animationFrameId = window.requestAnimationFrame(this.animate);
            }, timeout);
        }, timeout);
    };

    this.animate = () => {
        if (!this.animationActive) return;
        let curPlaceholderFullText = this.texts[this.curTextNum];
        let timeout = 900;
        if (
            this.curPlaceholder == curPlaceholderFullText + "|" &&
            this.blinkCounter == 3
        ) {
            this.blinkCounter = 0;
            this.curTextNum =
                this.curTextNum >= this.texts.length - 1 ? 0 : this.curTextNum + 1;
            this.curPlaceholder = "|";
            this.switch(1000);
            return;
        } else if (
            this.curPlaceholder == curPlaceholderFullText + "|" &&
            this.blinkCounter < 3
        ) {
            this.curPlaceholder = curPlaceholderFullText;
            this.blinkCounter++;
        } else if (
            this.curPlaceholder == curPlaceholderFullText &&
            this.blinkCounter < 3
        ) {
            this.curPlaceholder = this.curPlaceholder + "|";
        } else {
            this.curPlaceholder =
                curPlaceholderFullText
                    .split("")
                    .slice(0, this.curPlaceholder.length + 1)
                    .join("") + "|";
            timeout = 150;
        }
        this.input.setAttribute("placeholder", this.curPlaceholder);
        setTimeout(() => {
            if (this.animationActive)
                this.animationFrameId = window.requestAnimationFrame(this.animate);
        }, timeout);
    };

    this.stop = () => {
        this.animationActive = false;
        window.cancelAnimationFrame(this.animationFrameId);
    };

    this.start = () => {
        this.animationActive = true;
        this.animationFrameId = window.requestAnimationFrame(this.animate);
        return this;
    };
};

document.addEventListener("DOMContentLoaded", () => {
    let aw = new animationWorker(input, texts).start();
    input.addEventListener("focus", (e) => aw.stop());
    input.addEventListener("blur", (e) => {
        aw = new animationWorker(input, texts);
        if (e.target.value == "") setTimeout(aw.start, 2000);
    });
});





$(document).ready(function () {
    "use strict";
    $('.menu > ul > li:has( > ul)').addClass('menu-dropdown-icon');
    $('.menu > ul > li > ul:not(:has(ul))').addClass('normal-sub');
    $(".menu > ul").before("<a href=\"#\" class=\"menu-mobile\"><i class=\"fas fa-home\"></i>الاقسام</a>");
    $(".menu > ul > li").hover(function (e) {
        if ($(window).width() > 767) {
            $(this).children("ul").stop(true, false).fadeToggle(150);
            e.preventDefault();
        }
    });
    $(".menu > ul > li").click(function () {
        if ($(window).width() <= 767) {
            $(this).children("ul").fadeToggle(150);
        }
    });
    $(".menu-mobile").click(function (e) {
        $(".menu > ul").toggleClass('show-on-mobile');
        e.preventDefault();
    });
});


$(window).resize(function () {
    $(".menu > ul > li").children("ul").hide();
    $(".menu > ul").removeClass('show-on-mobile');
});

var tabsActions = function (element) {
    this.element = $(element);

    this.setup = function () {
        if (this.element.length <= 0) {
            return;
        }
        this.init();
        // Update after resize window.
        var resizeId = null;
        $(window).resize(function () {
            clearTimeout(resizeId);
            resizeId = setTimeout(() => { this.init() }, 50);
        }.bind(this));
    };



    this.init = function () {

        // Add class to overflow items.
        this.actionOverflowItems();
        var tabs_overflow = this.element.find('.overflow-tab');

        // Build overflow action tab element.
        if (tabs_overflow.length > 0) {
            if (!this.element.find('.overflow-tab-action').length) {
                var tab_link = $('<a>')
                    .addClass('nav-link')
                    .attr('href', '#')
                    .attr('data-toggle', 'dropdown')
                    .text('...')
                    .on('click', function (e) {
                        e.preventDefault();
                        $(this).parents('.nav.nav-tabs').children('.nav-item.overflow-tab').toggle();
                    });

                var overflow_tab_action = $('<li>')
                    .addClass('nav-item')
                    .addClass('overflow-tab-action')
                    .append(tab_link);

                // Add hide to overflow tabs when click on any tab.
                this.element.find('.nav-link').on('click', function (e) {
                    $(this).parents('.nav.nav-tabs').children('.nav-item.overflow-tab').hide();
                });
                this.element.append(overflow_tab_action);
            }

            this.openOverflowDropdown();
        } else {
            this.element.find('.overflow-tab-action').remove();
        }
    };

    this.openOverflowDropdown = function () {
        var overflow_sum_height = 0;
        var overflow_first_top = 41;

        this.element.find('.overflow-tab').hide();
        // Calc top position of overflow tabs.
        this.element.find('.overflow-tab').each(function () {
            var overflow_item_height = $(this).height() - 1;
            if (overflow_sum_height === 0) {
                $(this).css('top', overflow_first_top + 'px');
                overflow_sum_height += overflow_first_top + overflow_item_height;
            } else {
                $(this).css('top', overflow_sum_height + 'px');
                overflow_sum_height += overflow_item_height;
            }

        });
    };

    // this.actionOverflowItems = function() {
    //     var tabs_limit = this.element.width() - 100;
    //     var count = 0;

    //     // Calc tans width and add class to any tab that is overflow.
    //     for (var i = 0; i < this.element.children().length; i += 1) {
    //         var item = $(this.element.children()[i]);
    //         if (item.hasClass('overflow-tab-action')) {
    //             continue;
    //         }

    //         count += item.width();
    //         if (count > tabs_limit) {
    //             item.addClass('overflow-tab');
    //         } else if (count < tabs_limit) {
    //             item.removeClass('overflow-tab');
    //             item.show();
    //         }
    //     }
    // };
};
$('.owl-carousel').owlCarousel({
    items: 3,
    rewind: true,
    loop: false,
    autoplay: true,
    autoplayTimeout: 1500,
    margin: 10,
    nav: true,
    dots: false,
    navText: ['<span class="fas fa-chevron-left fa-2x"></span>',
        '<span class="fas fa-chevron-right fa-2x"></span>'],
    //  nav: true,
    responsive: {
        0: {
            items: 1
        },
        600: {
            items: 3
        },
        1000: {
            items: 5
        }
    }
})

$(document).ready(function () {

    $("#owl-example").owlCarousel({
        itemsDesktop: [1499, 4],
        itemsDesktopSmall: [1199, 3],
        itemsTablet: [899, 2],
        itemsMobile: [599, 1],
        navigation: true,
        dots: true,
    });

});


(function () {
    $(document).click(function () {
        var $item = $(".shopping-cart");
        if ($item.hasClass("active")) {
            $item.removeClass("active");
        }
    });

    $('.shopping-cart').each(function () {
        var delay = $(this).index() * 50 + 'ms';
        $(this).css({
            '-webkit-transition-delay': delay,
            '-moz-transition-delay': delay,
            '-o-transition-delay': delay,
            'transition-delay': delay
        });
    });
    $('#cart').click(function (e) {
        e.stopPropagation();
        $(".shopping-cart").toggleClass("active");
    });
    $('#customer').click(function (e) {
        e.stopPropagation();
        $(".customer-list").toggleClass("active");
    });

    $('#addtocart').click(function (e) {
        e.stopPropagation();
        $(".shopping-cart").toggleClass("active");
    });



})();
$(document).ready(function () {
    var slider = $("#slider");
    var thumb = $("#thumb");
    var slidesPerPage = 4; //globaly define number of elements per page
    var syncedSecondary = true;
    slider.owlCarousel({
        items: 1,
        slideSpeed: 2000,
        nav: false,
        autoplay: false,
        dots: false,
        loop: true,
        responsiveRefreshRate: 200
    }).on('changed.owl.carousel', syncPosition);
    thumb
        .on('initialized.owl.carousel', function () {
            thumb.find(".owl-item").eq(0).addClass("current");
        })
        .owlCarousel({
            items: slidesPerPage,
            dots: false,
            nav: true,
            item: 4,
            smartSpeed: 200,
            slideSpeed: 500,
            slideBy: slidesPerPage,
            navText: ['<svg width="18px" height="18px" viewBox="0 0 11 20"><path style="fill:none;stroke-width: 1px;stroke: #000;" d="M9.554,1.001l-8.607,8.607l8.607,8.606"/></svg>', '<svg width="25px" height="25px" viewBox="0 0 11 20" version="1.1"><path style="fill:none;stroke-width: 1px;stroke: #000;" d="M1.054,18.214l8.606,-8.606l-8.606,-8.607"/></svg>'],
            responsiveRefreshRate: 100
        }).on('changed.owl.carousel', syncPosition2);
    function syncPosition(el) {
        var count = el.item.count - 1;
        var current = Math.round(el.item.index - (el.item.count / 2) - .5);
        if (current < 0) {
            current = count;
        }
        if (current > count) {
            current = 0;
        }
        thumb
            .find(".owl-item")
            .removeClass("current")
            .eq(current)
            .addClass("current");
        var onscreen = thumb.find('.owl-item.active').length - 1;
        var start = thumb.find('.owl-item.active').first().index();
        var end = thumb.find('.owl-item.active').last().index();
        if (current > end) {
            thumb.data('owl.carousel').to(current, 100, true);
        }
        if (current < start) {
            thumb.data('owl.carousel').to(current - onscreen, 100, true);
        }
    }
    function syncPosition2(el) {
        if (syncedSecondary) {
            var number = el.item.index;
            slider.data('owl.carousel').to(number, 100, true);
        }
    }
    thumb.on("click", ".owl-item", function (e) {
        e.preventDefault();
        var number = $(this).index();
        slider.data('owl.carousel').to(number, 300, true);
    });


    $(".qtyminus").on("click", function () {
        var now = $(".qty").val();
        if ($.isNumeric(now)) {
            if (parseInt(now) - 1 > 0) { now--; }
            $(".qty").val(now);
        }
    })
    $(".qtyplus").on("click", function () {
        var now = $(".qty").val();
        if ($.isNumeric(now)) {
            $(".qty").val(parseInt(now) + 1);
        }
    });
});