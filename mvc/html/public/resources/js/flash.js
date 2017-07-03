
(function() {

	function addListeners() {
		var errors = document.getElementsByClassName("error");
		for (var i=0; i<errors.length; i++) {
			console.log("Adding listener to " + errors[i]);
			errors[i].parentNode.addEventListener("click", function() {
				this.remove();
			});
		}
	}

	window.addEventListener("load", addListeners);
})();
