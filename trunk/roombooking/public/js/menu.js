// JavaScript Document

(function($) {

$.fn.orphans = function(){
    var txt = [];
    this.each(function(){$.each(this.childNodes, function() {
        if (this.nodeType == 2 && $.trim(this.nodeValue)) txt.push(this)
    })}); 
    return $(txt);
};

$.fn.fadeToggle = function(speed, easing, callback) {
    return this.animate({opacity: 'toggle'}, speed, easing, callback);
};
$.fn.slideFadeToggle = function(speed, easing, callback) {
    return this.animate({opacity: 'toggle', height: 'toggle'}, speed, easing, callback);
};
})(jQuery);
////////////////////////////
$(function() {
    $('div#Menu .collapse').hide(); 
    $('div#Menu .expand').orphans().wrap('<a href="#" title="expand/collapse"></a>');

    
    //demo 2 - div.demo:eq(1) - show/hide (slow) effects:
    $('div#Menu:eq(0) .expand').click(function() {
        $(this).toggleClass('open').siblings().removeClass('open').end()
        .next('.collapse').toggle('fast').siblings('.collapse:visible').toggle('Fast');
        return false;
    });
    

});