(function() {

	function overlay(image, x, y, width, height) {
		var canvas = document.getElementById("canvas1");
		canvas.getContext("2d").drawImage(image, x, y, width, height);
		image.setAttribute('crossOrigin', 'anonymous');
	}

	function addListeners() {
		var targetImages = document.getElementsByClassName("overlay-image");
		var canvas = document.getElementById("canvas1");
		for (var i=0; i<targetImages.length; i++) {
			console.log("adding eventl listener");
			targetImages[i].addEventListener('click', function(item, tar) {
				if (item.target.id == "wave") {
					overlay(
						item.target,
						0,
						0,
						canvas.width,
						canvas.height
					);
				} else if (item.target.id == "cat") {
					overlay(
						item.target,
						canvas.width * 0.7,
						canvas.height * 0.7,
						150,
						150
					);
				} else if (item.target.id == "cactus") {
					overlay(
						item.target,
						0,
						canvas.height * 0.4,
						150,
						150
					);
				} else if (item.target.id == "alien") {
					overlay(
						item.target,
						canvas.width * 0.3,
						canvas.height * 0.6,
						item.target.width,
						item.target.height
					);
				} else if (item.target.id == "grass") {
					overlay(
						item.target,
						0,
						0,
						canvas.width,
						canvas.height
					);
				}
				item.target.parentNode.style.backgroundColor = 'blue';
			});
		}
	}

	window.addEventListener("load", addListeners);
})();
