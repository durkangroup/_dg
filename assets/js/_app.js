$(function($){

  'use strict';

  var _pc = window._pc || {};

_pc.set = function() {

  $('[data-mh]').matchHeight();

  $('[data-mhnr]').matchHeight({
    byRow: false,
  });

  // NO HEIGHT RESIZE ON MOBILE
  if ($('html').is('.touchevents, .mobile, .tablet') ) {
    $('[data-pxht]').each(function(index) {
      var pxHeight =  $(this).height();
      $(this).css('height', pxHeight+'px');
    });
  } else {
    $(window).bind('load resize', function(){
      $('[data-pxht]').each(function(index) {
        $(this).css('height', 'auto');
        var pxHeight =  $(this).height();
        $(this).css('height', pxHeight+'px');
      });
    });
  }

};

_pc.header = function() {

  window.setTimeout(function () {
    $(".site-header").addClass('is-ready');
  }, 600);

  $(window).on("load scroll resize",function(e){
    var $this = $(this);
    var siteHeader = $('.site-header');
    var aH = $('.site-header + * > *:first-child').outerHeight();

    if ($this.scrollTop() > aH/2) {
      siteHeader.addClass('has-scrolled');
    } else {
      siteHeader.removeClass('has-scrolled');
    }

    if ($this.scrollTop() > aH) {
      siteHeader.addClass('show-sticky');
    } else {
      siteHeader.removeClass('show-sticky');
    }

  });

  var prevScroll = 0,
      curDir = 'down',
      prevDir = 'up';

  $(window).scroll(function(){
    if($(this).scrollTop() >= prevScroll){
      curDir = 'down';
      if(curDir != prevDir){
        $('.site-header').removeClass('going-up', 'at-top');
        $('.site-header').addClass('going-down');
        prevDir = curDir;
      }
    } else {
      curDir = 'up';
      if(curDir != prevDir){
        $('.site-header').removeClass('going-down', 'at-top');
        $('.site-header').addClass('going-up');
        prevDir = curDir;
      }
    }
    prevScroll = $(this).scrollTop();

    if($(this).scrollTop() == 0){
      $('.site-header').removeClass('going-up').addClass('at-top');
    }

  });

};

_pc.scrolls = function() {

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

_pc.toggleNav = function(){

  $('[data-toggle="main-navigation"]').on('click', function (e) {
    e.preventDefault();
    $('.main-navigation').toggleClass('is-visible');
    $('body').toggleClass('show-nav');
    $('body').toggleClass('js-no-scroll');
  });

};

_pc.preloadBgs = function(){

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

_pc.aSpots = function(){

  if ($('html').is('.touchevents, .mobile, .tablet') ) {
    var windowHeight = $(window).height();
    var aspotHeight = windowHeight;
    var aspotHalf = aspotHeight / 2;

    $('#aspot[data-height="half"]').css('height', aspotHalf+'px');
    $('#aspot[data-height="full"]').css('height', aspotHeight+'px');
    $('#aspot[data-height="min-full"]').css('height', aspotHeight+'px');
  } else {
    $(window).bind('load resize', function(){
      var windowHeight = $(window).height();
      var aspotHeight = windowHeight;
      var aspotHalf = aspotHeight / 2;
      $('#aspot[data-height="half"]').css('height', aspotHalf+'px');
      $('#aspot[data-height="full"]').css('height', aspotHeight+'px');
      $('#aspot[data-height="min-full"]').css('height', aspotHeight+'px');
    });
  }

};

_pc.slick = function(){

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

_pc.fluidbox = function(){

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

_pc.gravityForms = function(){

  // $('button.btn--submit').click(function() {
  //   var orig = $(this).children('span').text();
  //   if($('.gform_ajax_spinner').length) {
  //   } else {
  //     $(this).children('span').text('Sending');
  //   }
  // });

  function gformButtons() {

    $('button.btn--submit.text-change').click(function(e) {
      var orig = $(this).children('span').text();
      $(this).addClass('form-sending');
      $(this).children('span').text('Sending');
    });

    $('button.btn--submit.icon-change').click(function(e) {
      if($('.gform_ajax_spinner').length) {
      } else {
        $(this).addClass('form-sending');
        $(this).children('i').removeClass('_pcicon-arrow-right').addClass('_pcicon-loading');
      }
    });

  }

  gformButtons();

  $(document).bind('gform_post_render', function(){
    gformButtons();
  });

  $(document).bind('gform_confirmation_loaded', function(event, formId){
    if(formId == 1) {
    }
    if(formId == 3) {
    }
  });

};

var bLazy = new Blazy({
  offset: 600,
  loadInvisible: true,
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
  _pc.set();
  _pc.header();
  _pc.scrolls();
  _pc.toggleNav();
  _pc.preloadBgs();
  _pc.aSpots();
  _pc.slick();
  _pc.fluidbox();
  _pc.gravityForms();
});

});