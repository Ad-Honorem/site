$(function() {
	window.DOMObservers = window.DOMObservers || {};
	
	window.async = {
		enable: true,
		getData: function($container, url, method, data) {
			var async = this;
			
			if ($container !== undefined) {
				$.ajax({
					url: url,
					data: data,
					method: method,
					beforeSend: function() {
						async.enable = false;
						if ((load = $container.attr("data-load")) !== undefined) {
							$container.append(load);
						}
					},
					success: function(data) {
						async.enable = true;
						$container.html(data);
						async.initAsync($container);
					},
					error: function() {
						async.enable = true;
						if ((fail = $container.attr("data-fail")) !== undefined) {
							$container.html(fail);
						}
					}
				});
			}
		},
		initAsync: function($container) {
			var async = this;
			var isContainerDefined = ($container === undefined);
			var $asyncData = (isContainerDefined) ? ($(".async-data")) : ($container.find(".async-data"));
			var $asyncLink = (isContainerDefined) ? ($("a.async-link")) : ($container.find("a.async-link"));
			var $asyncForm = (isContainerDefined) ? ($("form.async-form")) : ($container.find("form.async-form"));
			
			$asyncData.each(function() {
				async.initAsyncData($(this));
			});		
			$asyncLink.each(function() {
				var $link = $(this);
				var $target = $container;
				var $target = (target !== undefined) ? ($(target)) : ($container);
				
				async.initAsyncLink($target, $link);
			});
			$asyncForm.each(function() {
				var $form = $(this);
				var target = $link.attr("data-target");
				var $target = (target !== undefined) ? ($(target)) : ($container);
				
				async.initAsyncForm($target, $form);
			});
			
			for (var DOMObserver in window.DOMObservers) {
				window.DOMObservers[DOMObserver].init();
			}
		},
		initAsyncData: function($container) {
			var async = this;
			var wait = $container.attr("data-wait");
			
			if (wait === undefined) {
				async.getData($container, $container.attr("data-url"), "GET", {});
			}
		},
		initAsyncLink: function($container, $link) {
			var async = this;
			
			$link.click(function(event) {
				event.preventDefault();
				
				if (async.enable) {
					async.getData($container, $link.attr("href"), "GET", {});
				}
			});
		},
		initAsyncForm: function($container, $form) {
			var async = this;
			
			$form.submit(function(event) {
				event.preventDefault();
				
				if (async.enable) {
					async.getData($container, $form.attr("action"), $form.attr("method"), $form.serialize());
				}
			});
		},
		loadAsyncData: function($container) {
			var async = this;
			
			async.getData($container, $container.attr("data-url"), "GET", {});
		}
	};
	window.async.initAsync();
});