$(document).ready(function(){
	jQuery.fn.marquee = function (options) {
		var marq=this;
		var B_star=options.star; //  ‘€Ì· «·‘—Ìÿ 
		var B_stop=options.stop; // ≈Ìﬁ«› «·‘—Ìÿ 
		$(B_star).hide();
		var B_left=options.left; // «·‘—Ìÿ ··Ì”«—
		var B_right=options.right; // «·‘—Ìÿ ··Ì„Ì‰ 
		var B_up=options.up; // «·‘—Ìÿ ·√⁄·Ï
		var B_down=options.down; // «·‘—Ìÿ ·√”›·
		var speed=options.speed; // «·”—⁄…
		var direction=options.direction; // «·√ Ã«Â
		if(!speed){
			var speed=3;
		}
		if(!direction){
			var direction="left";
		}
		$(marq).hover(function () { 
			$(this).attr("scrollamount","0");
			$(B_star).show();
			$(B_stop).hide();
			//this.stop();
		}, function () {
			$(this).attr("scrollamount",speed);
			$(B_stop).show();
			$(B_star).hide();
			//this.start();
		});


		$(B_stop).show();
		$(B_star).hide();
		$(marq).attr("scrollamount",speed);
		
		$(B_star).click(function() {
			$(marq).attr("scrollamount",speed);
			//$(this).start();
			$(B_stop).show();
			$(this).hide();
		});
		$(B_stop).click(function() {
			$(marq).attr("scrollamount","0");
			//$(this).stop();
			$(B_star).show();
			$(this).hide();
		});
		$(B_left).click(function() {
			$(marq).attr("direction","left");
			$(marq).attr("scrollamount",speed);
			$(B_stop).show();
			$(B_star).hide();
		});
		$(B_right).click(function() {
			$(marq).attr("direction","right");
			$(marq).attr("scrollamount",speed);
			$(B_stop).show();
			$(B_star).hide();
		});
		
		$(B_up).click(function() {
			$(marq).attr("direction","up");
			$(marq).attr("scrollamount",speed);
			$(B_stop).show();
			$(B_star).hide();
		});
		$(B_down).click(function() {
			$(marq).attr("direction","down");
			$(marq).attr("scrollamount",speed);
			$(B_stop).show();
			$(B_star).hide();
		});
		
		$( window ).load(function() {
			setTimeout(function () {
				$(marq).attr("direction",direction);
			}, 200);
		});
	}
});