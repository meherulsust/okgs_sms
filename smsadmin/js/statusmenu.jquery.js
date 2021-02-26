/**
 *  Grid status change menu plugin
 *  @requires jQuery v1.3 or 1.4 higher
 *  
 *
 *  Copyright (c)  Reza Ahmed (coder.reza@gmail.com)
 *  Licensed under GPL licenses:
 *  http://www.gnu.org/licenses/gpl.html
 *
 *  Version: 1.0
 *  Dated : 15th September, 2012
 *  
 *    
 */
 
(function($){
    jQuery.fn.statusMenu = function(options){
        var defaults = {
            menuBlock: null,
            offsetX : -3,
            offsetY : 12,
            speed : 'fast'
        };
        var options = $.extend(defaults, options);
        var menu_item = '.' + options.menuBlock;
        return this.each(function(){
            	$(this).bind("click",function(e){
            	   e.preventDefault();
	           	});
              $(this).mousedown(function(e){
                       var offset = $(this).offset();
                       var offsetX = offset.left  + options.offsetX;
                       var offsetY = offset.top + options.offsetY;
        			         if(e.button == 0)
                       {  
                          $(menu_item).show(options.speed);
                          $(menu_item).css('display','block');
                          $(menu_item).css('top',offsetY);
                          $(menu_item).css('left',offsetX);
                          var url = $(this).attr('href');
                          $(menu_item).find('a').each(function(){
                              var actn = $(this).attr('id');
                              $(this).attr('href',url+'/'+actn);
                          });
        			         }
                       else 
                       {
                            $(menu_item).hide(options.speed);
                       }
                       
	    	});
	    	
     $(menu_item).hover(function(){}, function(){$(menu_item).hide(options.speed);})           
    });
    };
})(jQuery);
