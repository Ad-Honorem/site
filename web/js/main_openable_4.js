$(function() {
	$(".popup-background").click(function(event) {
		$(".openable").removeClass("opened");
		$(this).removeClass("opened");
		event.preventDefault();
	});
	
	$(".openable .open").click(function(event) {
		$this = $(this).parents(".openable");
		
		if (!$this.hasClass("opened")) {
			$this.addClass("opened");
			
			$background = $(".popup-background");
			if (!$background.hasClass("opened")) {
				$background.addClass("opened");
			}
			
			$(".openable").css("z-index", $background.css("z-index") - 1);
			$this.css("z-index", $background.css("z-index") + 1);
			event.preventDefault();
		}
	});
	
	$(".openable .close").click(function(event){
		$(".openable").removeClass("opened");
		$(".popup-background").removeClass("opened");
		event.preventDefault();
	});
});