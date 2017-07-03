
(function() {

	var errors = document.getElementsByClassName("error");

	function addListeners() {
		for (var i=0; i<errors.length; i++) {
			console.log("Adding listener to " + errors[i]);
			errors[i].parentNode.addEventListener("click", function() {
				this.remove();
			});
		}
	}

	function fadeOut() {
		var container = document.getElementById("error-container");
		if (!container) { 
			return ;
		}
		el = container.lastChild;
		if (!el) {
			return ;
		}
		var curr = parseFloat(window.getComputedStyle(el).getPropertyValue("opacity"));
		if (curr > 0.1) {
			el.style.opacity = (curr - 0.1);
		} else  {
			el.remove();
		}
	}

	setInterval(function() { fadeOut(); }, 500);

	window.addEventListener("load", addListeners);
})();
