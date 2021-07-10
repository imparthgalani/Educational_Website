/* --------------------------------------
  _____ _                                         
 |_   _| |__   ___ _ __ ___   ___ _   _ _ __ ___  
   | | | '_ \ / _ \ '_ ` _ \ / _ \ | | | '_ ` _ \ 
   | | | | | |  __/ | | | | |  __/ |_| | | | | | |
   |_| |_| |_|\___|_| |_| |_|\___|\__,_|_| |_| |_|

*  --------------------------------------
*         Table of Content
*  --------------------------------------
*  1. Sticky Nav
*  2. Pagination JS
*  3. Scrolling Progress Bar 
*  4. Menu Navigation with keyboard 
*  -------------------------------------- 
*  -------------------------------------- */

jQuery(document).ready(function($){'use strict';

    /* --------------------------------------
    *       1. Sticky Nav
    *  -------------------------------------- */
    const winWidth = jQuery(window).width();
    if(winWidth > 992){
        jQuery(window).on('scroll', function(){'use strict';
            if ( jQuery(window).scrollTop() > 0 ) {
                jQuery('#masthead.enable-sticky').addClass('sticky');
            } else {
                jQuery('#masthead.enable-sticky').removeClass('sticky');
            }
        });
    }

    /*----------------------------------
    *       2. Pagination JS           
    ------------------------------------ */
    if( $('.docent-pagination').length > 0 ){
        if( !$(".docent-pagination ul li:first-child a").hasClass('prev') ){ 
            $(".docent-pagination ul").prepend('<li class="p-2 first"><span class="'+ $(".docent-pagination").data("preview") +'"></span></li>');
        }
        if( !$(".docent-pagination ul li:last-child a").hasClass('next') ){ 
            $(".docent-pagination ul").append('<li class="p-2 first"><span class="'+$(".docent-pagination").data("nextview")+'"></span></li>');
        }
        $(".docent-pagination ul li:last-child").addClass("ml-auto");
        $(".docent-pagination ul").addClass("justify-content-start").find('li').addClass('p-2').addClass('ml-auto');
    }

    /*------------------------------------------
    *         3. Scrolling Progress Bar 
    -------------------------------------------- */ 
    var getMax = function() {
        return $(document).height() - $(window).height();
    }
    var getValue = function() {
        return $(window).scrollTop();
    }
    if ('max' in document.createElement('progress')) {
        var progressBar = $('progress');
        progressBar.attr({
            max: getMax()
        });
        $(document).on('scroll', function() {
            progressBar.attr({
                value: getValue()
            });
        });
        $(window).resize(function() {  
            progressBar.attr({
                max: getMax(),
                value: getValue()
            });
        });
    } else {
        var progressBar = $('.progress-bar'),
            max = getMax(),
            value, width;
        var getWidth = function() {
            value = getValue();
            width = (value / max) * 100;
            width = width + '%';
            return width;
        }
        var setWidth = function() {
            progressBar.css({
                width: getWidth()
            });
        }
        $(document).on('scroll', setWidth);
        $(window).on('resize', function() { 
            max = getMax();
            setWidth();
        });
    }
    // End 

    //Menu Close Button
    if ($('#hamburger-menu').length > 0) {
        var button = document.getElementById('hamburger-menu');
        var span = button.getElementsByTagName('span')[0];

        button.onclick =  function() {
            span.classList.toggle('hamburger-menu-button-close');
        };

        $('#hamburger-menu').on('click', toggleOnClass);
        function toggleOnClass(event) {
            var toggleElementId = '#' + $(this).data('toggle'),
            element = $(toggleElementId);
            element.toggleClass('on');
        }

        // close hamburger menu after click a
        $( '.menu li a' ).on("click", function(){
            $('#hamburger-menu').click();
        });

        // Menu Toggler Rotate
        $('#mobile-menu ul li span.menu-toggler').click(function(){
            $(this).toggleClass('toggler-rotate');
        })
    }
    
    /*------------------------------------------
    *         4. Menu Navigation with keyboard
    -------------------------------------------- */ 
    function focusMenuWithChildren() {
        // Get all the link elements within the primary menu.
        var links, i, len,
            menu = document.querySelector( '.primary-menu' );

        if ( ! menu ) {
            return false;
        }
        links = menu.getElementsByTagName( 'a' );
        // Each time a menu link is focused or blurred, toggle focus.
        for ( i = 0, len = links.length; i < len; i++ ) {
            links[i].addEventListener( 'focus', toggleFocus, true );
            links[i].addEventListener( 'blur', toggleFocus, true );
        }

        //Sets or removes the .focus class on an element.
        function toggleFocus() {
            var self = this;

            // Move up through the ancestors of the current link until we hit .primary-menu.
            while ( -1 === self.className.indexOf( 'nav' ) ) {
                // On li elements toggle the class .focus.
                if ( 'li' === self.tagName.toLowerCase() ) {
                    if ( -1 !== self.className.indexOf( 'focus' ) ) {
                        self.className = self.className.replace( ' focus', '' );
                    } else {
                        self.className += ' focus';
                    }
                }
                self = self.parentElement;
            }

            //Detect mobile menu li has focus class
            if($('#mobile-menu ul li').hasClass('focus')){
                $('#mobile-menu ul ul').show();
            }
            
        }

    }
    focusMenuWithChildren();

});




