(function($){
    $.maCookieEu = function(el, options){
        // To avoid scope issues, use 'base' instead of 'this'
        // to reference this class from internal events and functions.

        var base = this;
        var elementPosition;
        var cookie_name;
        var boxElement = $(".cookie_notice")
        // Access to jQuery and DOM versions of element
        base.$el = $(el);
        base.el = el;

        // Add a reverse reference to the DOM object
        base.$el.data("maCookieEu", base);

        base.init = function(){
            base.options    = $.extend({},$.maCookieEu.defaultOptions, options);
            elementPosition = base.options.position
            cookie_name     = base.options.cookie_name
            boxElement.fadeIn("slow");

			$( "#cookie_close" ).click(function(e) {
				e.preventDefault();
				Cookies.set(cookie_name, '1', { expires: 1000 })
		        $(".cookie_notice").fadeOut("slow");
		    });

			boxElement.css(elementPosition,'0px');
			boxElement.css('background-color',base.options.background)
		    if( base.options.delete_cookie==true)  base.deleteCookie()
        };

        // Sample Function, Uncomment to use
        base.deleteCookie = function(){
        	Cookies.remove(cookie_name);
        	console.log("deleted")
        };

        // Run initializer
        base.init();
    };

    $.maCookieEu.defaultOptions = {
        position		: "bottom",
        background		: "#52565a",
        cookie_name		: "ma_eu",
        delete_cookie	: false,

    };

    $.fn.maCookieEu = function(options){
        return this.each(function(){
            (new $.maCookieEu(this, options));
        });
    };

    // This function breaks the chain, but returns
    // the maCookieEu if it has been attached to the object.
    $.fn.getmaCookieEu = function(){
        this.data("maCookieEu");
    };

})(jQuery);
