jQuery(window).ready(function() {
	
	jQuery(".menuP").click(function(e){
		jQuery(".menu").toggleClass("menu-abierto"); 
		jQuery("body").toggleClass("correr-izquierda"); 
		jQuery(".logo").toggleClass("esconder");
	  	e.preventDefault();
	});
	jQuery(".boton-buscar").click(function(){
		jQuery(".buscar").toggleClass("mostrar");
	});
	
	jQuery(window).scroll(function() {
		if (jQuery(this).scrollTop() > 1){  
			jQuery('header').addClass("sticky");
		}
		else{
			jQuery('header').removeClass("sticky");
	  }
		if(jQuery(window).scrollTop() + jQuery(window).height() == jQuery(document).height()) {
			jQuery('.arrow').addClass("up");
		}
		else{
			jQuery('.arrow').removeClass("up");
	  }
	});
	
	(function() {

  "use strict";

  var toggles = document.querySelectorAll(".menuP");

  for (var i = toggles.length - 1; i >= 0; i--) {
    var toggle = toggles[i];
    toggleHandler(toggle);
  }

  function toggleHandler(toggle) {
    toggle.addEventListener( "click", function(e) {
      e.preventDefault();
      (this.classList.contains("activo") === true) ? this.classList.remove("activo") : this.classList.add("activo");
    });
  }

})();

});
