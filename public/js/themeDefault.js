
$(document).ready(function(){$(".left-sidebar-toggle").click(function(){$(this).toggleClass("open"),$(".left-sidebar-spacer").toggleClass("open")}),$(".nav-setting-sp").on("click",":not(#nav-header)",function(e){e.stopPropagation(),$("*").removeClass("show"),$("body").toggleClass("open-right-sidebar be-animate")}),$("#nav-header").click(function(){$("body").removeClass("open-right-sidebar be-animate")}),$(".left-sidebar-content").click(function(){$("body").removeClass("open-right-sidebar be-animate")}),$(".main-content.container-fluid").click(function(){$("body").removeClass("open-right-sidebar be-animate")}),$(".main-content.container-fluid,.be-left-sidebar:before").click(function(){$("body").removeClass("open-right-sidebar be-animate")}),$(".nav-item.dropdown .nav-link.be-toggle-right-sidebar").click(function(){$(".be-right-sidebar").show()}),$(".icon.mdi.mdi-notifications,.icon.mdi.mdi-apps").click(function(){$("body").removeClass("open-right-sidebar be-animate")}),$(".be-toggle-left-sidebar").click(function(){0==$("#app").hasClass("be-wrapper be-collapsible-sidebar be-collapsible-sidebar-hide-logo be-collapsible-sidebar-collapsed")?($(".be-left-sidebar .sidebar-elements > li ul li > a").css({padding:"8px 15px 8px 25px"}),$(".parent").mouseenter(function(){$(this).addClass("open"),$(this).find(".sub-menu").addClass("visible")}),$(".parent").mouseleave(function(){$(this).removeClass("open"),$(this).find(".sub-menu").removeClass("visible")})):($(".parent").off("mouseenter"),$(".parent").off("mouseleave"))})});


   $(document).ready(function(){

    $(".nav-link.dropdown-toggle").click(function(){
        $("body").removeClass('open-right-sidebar be-animate');
    });

    $(window).resize(function() {
        var width = $(window).innerWidth();
            if (width < 525) {
                $('.sub-menu li,.scrollable').click(function () {
                    $('.left-sidebar-toggle,.left-sidebar-spacer').removeClass('open');
                    // $("html, body").animate({scrollTop: 900}, 600);
                    // return false;
                });
            }
            else {  }
    });

               $( ".parent" ).mouseover(function() {
                     $('.be-content').css({'z-index':'-1'});
               });
               $( ".parent" ).mouseout(function() {
                     $('.be-content').css({'z-index':0});
               });

               $(".icon.mdi.mdi-menu").click(function(){
                    $('.progress-widget').toggleClass('removable_brand');
                    $('.progress-widget').removeClass(' opacityEnable');
                    $('.progress-widget').toggleClass('no_display');
               });


             //  --------------------- step form 1 ------------------

                   $("#stepOne").click(function(){
                       $(this).attr('disabled', true);
                     $('.step-pane:nth-child(2)').addClass('active');
                     $('.step-pane:nth-child(1)').removeClass('active');
                     $('.step-pane:nth-child(3)').removeClass('active');

                     // for step active

                     $('.steps li:nth-child(1)').addClass('complete');
                     $('.steps li:nth-child(2)').addClass('active');
                   });

               // --------------------- step form 2 ------------------

                   $("#stepTwo").click(function(){
                       $(this).attr('disabled', true);
                       $('.step-pane:nth-child(3)').addClass('active');
                       $('.step-pane:nth-child(1)').removeClass('active');
                       $('.step-pane:nth-child(2)').removeClass('active');

                       // for step active

                       $('.steps li:nth-child(2)').addClass('complete');
                       $('.steps li:nth-child(3)').addClass('active');
                   });

              // --------------------- step form for previous ------------------

                   $("#previousTwo").click(function(){
                       $(this).attr('disabled', true);
                       $('.step-pane:nth-child(2)').addClass('active');
                       $('.step-pane:nth-child(1)').removeClass('active');
                       $('.step-pane:nth-child(3)').removeClass('active');

                       // for step active

                       $('.steps li:nth-child(1)').addClass('complete');
                       $('.steps li:nth-child(2)').addClass('active');

                   });


});




