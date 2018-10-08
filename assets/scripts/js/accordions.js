/**
 * Accordions
 * 
 * Behavior for accordion components
 */

( function( window, $ ) {
	var document = this.document;

    var Accordion = function(el){
        this.$el = $(el);
        this.$toggle = this.$el.children('.stm-c-accordion__toggle');
        this.$content = this.$el.children('.stm-c-accordion__content');
        this.init();
    };

    Accordion.prototype.init = function(){
        var _this = this;

        this.$toggle.on('click', function(e){
            e.preventDefault();
            _this.$content.slideToggle();
            _this.$el.toggleClass('stm-is-open');
        });

    };

    $(document).ready(function(){
        $('.stm-c-accordion').each(function(){
            new Accordion(this);
        });
    });

} )( this, jQuery );