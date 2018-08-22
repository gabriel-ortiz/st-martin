/**
 *
 * Showmore -hidemore
 * 
 * UI for shortcode that allows uers to insert a show/hide more button to toggle long pieces of text
 */

( function( window, $ ) {
	//'use strict';
	
	var document = this.document;

    var ShowMore = function( el ){
        
        this.$el                = $(el);
        this.$followingContent  = null;
        this.$showLess          = $('<a />').addClass('stm-c-how-hide__toggle').text('Show Less').attr( 'href', '#' );
        
        this.init();
    };

    ShowMore.prototype.init = function(){
        
        //events
        this.$el.on( 'click', {that : this}, this.handleShowMore );
        this.$showLess.on( 'click', {that : this}, this.handleShowLess );
        
        //logic
        this.hideFollowingContent();

    };
    
    ShowMore.prototype.handleShowMore = function(event){
        event.preventDefault(); 

  		var that = event.data.that, //caching the protoype scope
  		    $this = $(this); //cachiing the click event scope
        
        $this.toggle();
        
        that.$followingContent.slideDown();
        that.$showLess.toggle();
 
        
    };
    
    ShowMore.prototype.handleShowLess = function(event){
        event.preventDefault();
        
  		var that = event.data.that, //caching the protoype scope
  		    $this = $(this); //cachiing the click event scope
  		    
  	    that.$followingContent.slideUp();
  	    $this.toggle();
  	    that.$el.toggle();
  	    
  	    
        
    };
    
    ShowMore.prototype.hideFollowingContent = function(){
        //if we have traversed to content container then this isn't in a nested paragraph tag
        if( this.$el.parent().hasClass('cell') || this.$el.parent().hasClass('entry-content') ){
            this.$el
                .nextAll()
                .wrapAll('<div class="stm-c-show-hide--hidden"/>');
        }else{
            this.$el
                .parent()
                .nextAll()
                .wrapAll('<div class="stm-c-show-hide--hidden"/>');
        }
        
        //cache this element now that it's been added to the DOM
        this.$followingContent = $('.stm-c-show-hide--hidden');
        this.$followingContent .after( this.$showLess );

        
    };

    $(document).ready(function(){
        $('.stm-c-show-hide').each( function(){
            new ShowMore(this);
        } );

    });

} )( this, jQuery );