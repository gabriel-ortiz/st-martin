/**
 *
 * JP List Filters
 * 
 * Controller script that initiates the filtering functions for the images
 */

( function( window, $ ) {
	//var doc = window.document;

    var ImageFilters = function(el, document ){
        
        this.$el                = $( el );
        this.$body              = $(document).find( 'body' ); 
        this.$reveal            = this.$body.find( '#stm-c-reveal' );
        this.$revealContainer   = this.$body.find( '.stm-c-img__slider' );
        
        
        //global variables
        this.imgMetadata = [];
        

        this.init();
    };

    ImageFilters.prototype.init = function(){
        // do something
        this.triggerModal();
        this.openCloseModal();
        
        var that = this;
        this.$el.jplist({
            itemsBox        : '.stm-c-img__grid',
            itemPath        : '.stm-c-img__block', 
            panelPath       : '.stm-c-img__control-panel',
            redrawCallback  : function( collection, $dataview, statuses ){
                //console.log( collection );
                //console.log( 'JPlist Data', $dataview );
                //console.log( statuses );
    
                //clear all the data to make way for the new data
                $(that.$revealContainer).html('');
                that.imgMetadata = [];                
                
                //get all the metadata from each attr after filters are applied
                that.getMetadata($dataview);
                
                //append this data to the reveal container
                that.insertFilteredImages();
            }
        });
        

    };
    
    ImageFilters.prototype.triggerModal = function(){
        var that = this;
        $('.stm-c-img__preview').on( 'click', function(event){
        
            $('#stm-c-reveal').foundation('open');
        } ); 
    };
    
    ImageFilters.prototype.openCloseModal = function(){
        var that = this,
            timeout;
        
        $(document).on( 'open.zf.reveal', function(event){
            
            clearTimeout(timeout);
            timeout = setTimeout(function() {
                that.$revealContainer.slick();
            }, 100);
      
           
        } );
        
        
         $(document).on('closed.zf.reveal', function(event){
            that.$revealContainer.slick('unslick');
            console.log(  'slick unslicked');
         });
    };
    
    ImageFilters.prototype.getMetadata = function( $dataview ){
        var imgAttr,
            that = this;
        
        $.each( $dataview, function( i, data ){
            imgAttr = $( data ).attr( 'data-img' );
            
            imgAttr = JSON.parse(  imgAttr  );
            
            that.imgMetadata.push( imgAttr );
        } );
        
        //console.log( that.imgMetadata );
    };
    
    ImageFilters.prototype.insertFilteredImages = function(){
        //with the filtered object, append each image to the revealbox
        var that = this,
            tempEl = [];
        //if nothing is in this, then return
        if( !that.imgMetadata.length ){
            return;
        }
        
        //clear the container
        $(that.$revealContainer).html('');
        
        //iterate through each item and append to reveal
        $.each( that.imgMetadata, function( i, data ){
            //create each object
            var imgSlide = that.createImgObj( data );
            
            tempEl.push( imgSlide );
        } );
        
        //append all the data to the container
        that.$revealContainer.append( tempEl );
        
    };

    ImageFilters.prototype.createImgObj = function( imgObj ){
        var slideMeta,
            slideImg;
            
        slideMeta = $('<div />').addClass('stm-c-img__metadata cell small-6')
            .append(
                $('<div />').addClass('stm-c-img__name').text(imgObj.img_title),
                $('<div />').addClass('stm-c-img__auth-year').text( `${imgObj.img_owner} | ${imgObj.img_year}` ),
                $('<div />').addClass('stm_c-img__content').text( imgObj.img_content )
                );
                
        slideImg = $('<div />').addClass('stm-c-img__img-container cell small-6')
            .append(
                    $('<img />').attr({
                        'class' : 'stm-c-img__img',
                        'alt'   : imgObj.img_title,
                        'src'   : imgObj.img_url[0]
                    })
                );
        
        
        var slide = $('<div />').addClass('stm-c-img__slide-container grid-x')
            .append( slideMeta, slideImg );
        
        return slide;
    };

    $(document).ready(function(){
        $('.stm-c-img').each(function(){
            new ImageFilters(this, document);           
        });

    });

} )( this, jQuery );