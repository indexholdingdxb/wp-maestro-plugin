/*Pagination*/
!(function($){
	"use strict";
	jQuery(document).ready(function($) {

				$(".paginate").paginga({
					// use default options
				});
			  
				$(".paginate-page-2").paginga({
					page: 2
				});

				$(".paginate-no-scroll").paginga({
					scrollToTop: false
				});
		
		});
			
		})(jQuery);
	
	
