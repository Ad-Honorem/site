$(function() {
	window.popup = {
		createPopup: function(body, title, subtitle, type) {
			var $popup = $("<section/>", {"class": "popup popup-background"}).click(function() {
				var $this = $(this);
				
				$this.fadeOut(400, function() {
					$this.remove();
				});
			});
			var $container = $("<article/>", {"class": "popup popup-container"}).appendTo($popup);
			var $header = $("<header/>", {"class": "popup popup-header"}).appendTo($container);
			
			$("<h3/>", {"class": "popup popup-title"}).html(title).appendTo($header);
			if (subtitle !== undefined) {
				$("<p/>", {"class": "popup popup-subtitle"}).html(subtitle).appendTo($header);
			}
			$("<p>", {"class": "popup popup-title"}).html(body).appendTo($container);
			$("body").append($popup);
		},
		createInfoPopup: function(body, title, subtitle) {
			return (this.createPopup(body, ((title == undefined) ? ("Information") : (title)), subtitle, "info"));
		},
		createConfirmPopup: function(body, title, subtitle) {
			return (this.createPopup(body, ((title == undefined) ? ("Confirmation") : (title)), subtitle, "confirm"));
		},
		createWarningPopup: function(body, title, subtitle) {
			return (this.createPopup(body, ((title == undefined) ? ("Attention") : (title)), subtitle, "warning"));
		},
		createErrorPopup: function(body, title, subtitle) {
			return (this.createPopup(body, ((title == undefined) ? ("Erreur") : (title)), subtitle, "error"));
		},
		createPopupFromUrl: function(url) {
			$.ajax({
				url: url,
				dataType: "json",
				success: function(data) {
					window.async.initAsync(this.createPopup());
				},
				error: function() {
					this.createErrorPopup("Error");
				}
			});
		},
		initPopup: function() {
			$("a.popup-link").click(function(event) {
				event.preventDefault();
				
				this.createPopup($(this).attr("href"));
			});
		}
	};
	window.async.initAsync();
});