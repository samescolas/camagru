(function() {

/*	function overlay(image, x, y, width, height) {
		var canvas = document.getElementById("canvas1");
		canvas.getContext("2d").drawImage(image, x, y, width, height);
		image.setAttribute('crossOrigin', 'anonymous');
	}
*/

	function addListeners() {
		var targetImages = document.getElementsByClassName("overlay-image");
		var canvas = document.getElementById("canvas1");
		for (var i=0; i<targetImages.length; i++) {
			targetImages[i].addEventListener('click', function(item) {
				if (item.target.classList.contains("active-overlay-image")) {
					item.target.parentNode.style.backgroundColor = 'inherit';
				} else {
					item.target.parentNode.style.backgroundColor = '#4242DD';
				}
				item.target.classList.toggle("active-overlay-image");
			});
		}
	}

	window.addEventListener("load", addListeners);
})();
