$(function() {
	window.DOMObservers = window.DOMObservers || {};
	
	window.DOMObservers.readMore = {
		init: function() {
			$("a.read-more-link:not(.read-more-link-init)").each(function() {
				$this = $(this);
				
				$this.addClass("read-more-link-init");
				$this.click(function(event) {
					$($(this).attr("read-more-target")).toggleClass("read-more-opened");
					event.preventDefault();
				});
			});
		}
	};
});