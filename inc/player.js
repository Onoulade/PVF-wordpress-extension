function displayMCSkin(player, div) {
	jQuery.getJSON("https://api.mojang.com/users/profiles/minecraft/" + player, function(data) {
		var uuid = data.id;
		jQuery.getJSON("https://sessionserver.mojang.com/session/minecraft/profile/" + uuid, function(skin) {
			console.log(skin.properties.value);
			jQuery(".mc-player-"+div).each(function() {
				jQuery(this).css("background-image", skin.properties.value);
			});
		});
	});
}
window.addEventListener('load', function () {
	var isDragging = false;
    var dragged
    jQuery('body').mousemove(function(event){
  	  if (!isDragging) {
  		  return;
  	  }
  	  cx=Math.ceil(jQuery('body').width());
  	  dx=event.pageX-cx;
  	  tilty=-(dx/cx);
  	  radius=Math.sqrt(Math.pow(tilty,2));
  	  degree=(radius*-525);
  	  jQuery(dragged).css('transform','rotateY('+degree+'deg)')
    }).mouseup(function(event) {
  	  isDragging = false;
    })

    jQuery(".mc-player").mousedown(function(event) {
  	  dragged = jQuery(this);
	  isDragging = true;
	  event.preventDefault();
    });
})
