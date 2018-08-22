/**
 * Global Variables. 
 */


(function ( window, $ ) {
    //'use strict';
    //var document = window.document;
    var windowObj = this;
    
    if (!windowObj.STM) {
        windowObj.STM = {};
    }

    windowObj.STM.DURATION = 300;

    windowObj.STM.BREAKPOINT_SM = 0;
    windowObj.STM.BREAKPOINT_MD = 640;
    windowObj.STM.BREAKPOINT_LG = 1024;
    windowObj.STM.BREAKPOINT_XL = 1200;

    $(document).ready(function(){
        $('html').toggleClass('no-js js');
    });

})(this, jQuery);