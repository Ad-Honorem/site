$(function() {
	window.DOMObservers = window.DOMObservers || {};
	
	window.DOMObservers.wysiwyg = {
		init: function() {
			$wysiwyg = $(".wysiwyg-editor:not(.wysiwyg-editor-init)");
			
			$wysiwyg.addClass("wysiwyg-editor-init");
			$wysiwyg.on("mouseup", function(event) {
				$(this).sync()
			});
			$wysiwyg.wysibb({
				"traceTextarea": true
			});
		}
	};
	
	window.DOMObservers.wysiwyg.init();
});