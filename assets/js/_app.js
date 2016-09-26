$(function($){

  'use strict';

  var _dg = window._dg || {};

_dg.scrolls = function() {

  // NEXT OR FIRST
  $.fn.nextOrFirst = function(selector) {
    var next = this.next(selector);
    return (next.length) ? next : this.prevAll(selector).last();
  };

  // SCROLL TO NEXT
  $('[data-scroll="next"]').on('click', function (e) {
    e.preventDefault();
    $.scrollTo($(this).closest('section').next(), {
      axis : 'y',
      offset : 0,
      duration : 600
    });
  });

  // SCROLL TO HASH
  $('[data-scroll="hash"]').on('click', function (e) {
    e.preventDefault();

    if ($(this).attr("data-offset")) {
      var offset = $(this).data('offset');
    } else {
      var offset = 0;
    }

    $.scrollTo(this.hash, {
      axis : 'y',
      offset : offset,
      duration : 600
    });
  });

  // SCROLL TO TOP
  $('[data-scroll="top"]').click(function() {
    $("html, body").animate({ scrollTop: 0 });
    return false;
  });


  $(window).on("load scroll",function(e){
    var $this = $(this);
    var main = $('main');
    var totalHeight = $(document).height();
    var mainHeight = main.outerHeight();
    var aspotHeight = $('#aspot').outerHeight();

    if ($this.scrollTop() > aspotHeight) {
      $("body").addClass('in-main');
    } else {
      $("body").removeClass('in-main');
    }
    if ($this.scrollTop() > totalHeight/2) {
      $("body").addClass('in-mid');
    } else {
      $("body").removeClass('in-mid');
    }
    if ($this.scrollTop() > 0) {
      $("body").addClass('has-scrolled');
    } else {
      $("body").removeClass('has-scrolled');
    }
  });

};

_dg.toggleNav = function(){

  $('[data-toggle="menu"]').on('click', function (e) {
    e.preventDefault();
    $('nav.main-menu').toggleClass('show-menu');
    $('body').toggleClass('js-no-scroll');
  });

  var prevScroll = 0,
      curDir = 'down',
      prevDir = 'up';

  $(window).scroll(function(){
    if($(this).scrollTop() > prevScroll){
      curDir = 'down';
      if(curDir != prevDir){
        $('.is-default .main-menu').addClass('going-up');
        $('.main-menu').removeClass('going-up').removeClass('at-top');
        $('.main-menu').addClass('going-down');
        prevDir = curDir;
      }
    } else {
      curDir = 'up';
      if(curDir != prevDir){
        $('.main-menu').removeClass('going-down');
        $('.main-menu').addClass('going-up');
        prevDir = curDir;
      }
    }
    prevScroll = $(this).scrollTop();

    if($(this).scrollTop() <= 0){
      $('.main-menu').removeClass('going-up').removeClass('going-down').addClass('at-top');
    }

  });

};

_dg.preloadBgs = function(){

  $('.set-bg').each(function(index) {
    $(this).css({ 'background-image':'url(' + $(this).data('bg') + ')' });
  });

  preloadBg();

  function preloadBg() {

    // check to see if hero-bg exists
    if(!$('.set-bg')[0]) return false;

    // create blank image object
    var imgLoad = new Image();

    // load image + fade in container
    $(imgLoad).load(function() {

      $('.set-bg').addClass('bg-loaded');

    }).attr('src', $('.set-bg').data('bg'));

  }

};

_dg.aSpots = function(){

  // SET ASPOT HEIGHTS IN PX
  var windowHeight = $(window).height();
  var aspotHeight = $('#aspot').height();

  $('#aspot[data-height="half"]').css('height', aspotHeight+'px');
  $('#aspot[data-height="full"]').css('height', windowHeight+'px');

  // NO HEIGHT RESIZE ON MOBILE
  var windowHeight = $(window).height();
  var windowWidth = $(window).width();
  if ( windowWidth >= 840 ) {
    $(window).bind('resize', function(){
      windowHeight = $(window).height();
      $('#aspot[data-height="full"]').css('height', windowHeight+'px');
    });
  }

};

_dg.slick = function(){

  $('[data-slick]').slick({
    lazyLoad: 'progressive',
    fade: true,
    speed: 400,
    cssEase: 'linear',
    responsive: [
      {
        breakpoint: 768,
        settings: {
          // arrows: false,
          fade: false,
          speed: 300,
        }
      }
    ]
  });

};

_dg.fluidbox = function(){

  $("a[href$='.jpg']").each(function(){
    if($(this).find("img").length > 0) {
      $(this).addClass('isfluid');
    }
  });

  $('.isfluid').fluidbox({
    closeTrigger: [
      { selector: 'window', event: 'scroll'}
    ]
  });

};

var bLazy = new Blazy({
  offset: 600,
  breakpoints: [{
    width: 600,
    src: 'data-src-small'
  },{
    width: 1200,
    src: 'data-src-medium'
  }]
});

// INITIALIZE
$(function() {
  _dg.scrolls();
  _dg.toggleNav();
  _dg.preloadBgs();
  _dg.aSpots();
  _dg.slick();
  _dg.fluidbox();
});

});