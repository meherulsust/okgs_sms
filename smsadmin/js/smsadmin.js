$(document).ready(function(){
    
});

var flashMessage = {
    container:'',
    success: function(msg){
        flashMessage._initMsg(msg, 'green');
    },
    error: function(msg){
        flashMessage._initMsg(msg, 'red');
    },
    info: function(msg){
        flashMessage._initMsg(msg, 'blue');
    },
    warning: function(msg){
        flashMessage._initMsg(msg, 'yellow');
    },
    _initMsg: function(msg,cls){
        var elem = $('<li class="'+cls+'"></li>').append('<span class="ico"></span>').append('<strong class="system_title">'+msg+'<span>');
       $(flashMessage.container+" ul.system_messages").html(elem);
    }
}