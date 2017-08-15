(function() {

	function overlay(image) {
		var canvas = document.getElementById("canvas1");
		canvas.getContext("2d").drawImage(image, 0, 0);
		image.setAttribute('crossOrigin', 'anonymous');
	}

	function addListeners() {
		var targetImages = document.getElementsByClassName("overlay-image");
		for (var i=0; i<targetImages.length; i++) {
			console.log("adding eventl listener");
			targetImages[i].addEventListener('click', function(item, tar) {
				overlay(item.target);
			});
		}
	}

	window.addEventListener("load", addListeners);
})();
