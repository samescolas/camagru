(function() {
	// The width and height of the captured photo. We will set the
	// width to the value defined here, but the height will be
	// calculated based on the aspect ratio of the input stream.

	var width = 320;
	var height = 0;

	var streaming = false;

	var video = null;
	var canvas = null;
	var photo = null;
	var target = null;
	var captureButton = null;
	var saveButton = null;
	var deleteButton = null;

	function startup() {
		video = document.getElementById('video');
		canvas = document.getElementById('canvas1');
		photo = document.getElementById('photo');
		target = document.getElementById('target');
		captureButton = document.getElementById('startbutton');
		saveButton = document.getElementById('savebutton');
		deleteButton = document.getElementById('deletebutton');

		navigator.getMedia = ( navigator.getUserMedia ||
			   navigator.webkitGetUserMedia ||
			   navigator.mozGetUserMedia ||
			   navigator.msGetUserMedia);

		navigator.getMedia(
		{
			video: true,
			audio: false
		},
		function (stream) {
			if (navigator.mozGetUserMedia) {
				video.mozSrcObject = stream;
		} else {
			var vendorURL = window.URL || window.webkitURL;
			video.src = vendorURL.createObjectURL(stream);
		}
		video.play();
		},
		function (err) {
			console.log("An error occured! " + err);
		}
		);

		video.addEventListener('canplay', function(ev){
		if (!streaming) {
			height = video.videoHeight / (video.videoWidth/width);

			if (isNaN(height)) {
				height = width / (4/3);
			}
	      
			video.setAttribute('width', width);
			video.setAttribute('height', height);
			canvas.setAttribute('width', width);
			canvas.setAttribute('height', height);
			streaming = true;
			requestAnimationFrame(updateCanvas);
		}
		}, false);

		captureButton.addEventListener('click', function(ev) {
			takepicture();
			ev.preventDefault();
		}, false);

		saveButton.addEventListener('click', function(ev) {
			removeActive();
			savePhoto();
			toggleStatus();
		}, false);

		deleteButton.addEventListener('click', function(ev) {
			removeActive();
			toggleStatus();
			clearphoto();
		}, false);
	}

	function removeActive() {
		var active = document.getElementsByClassName("active-overlay-image");

		for (var i=0; i<active.length; i++) {
			active[i].parentNode.style.backgroundColor = "inherit";
			active[i].classList.remove("active-overlay-image");
		}
	}

	function updateCanvas() {
		var images = document.getElementsByClassName('active-overlay-image');

		canvas.getContext('2d').drawImage(video, 0, 0, width, height);
		for (var i=0; i<images.length; i++) {
			if (images[i].id == 'wave') {
				canvas.getContext('2d').drawImage(
					images[i],
					0,
					0,
					canvas.width,
					canvas.height
				);
			} else if (images[i].id == 'cat') {
				canvas.getContext('2d').drawImage(
					images[i],
					canvas.width * 0.7,
					canvas.height * 0.7,
					150,
					150
				);
			} else if (images[i].id == 'cactus') {
				canvas.getContext('2d').drawImage(
					images[i],
					0,
					canvas.height * 0.4,
					150,
					150
				);
			} else if (images[i].id == 'alien') {
				canvas.getContext('2d').drawImage(
					images[i],
					canvas.width * 0.3,
					canvas.height * 0.6,
					images[i].width,
					images[i].height
				);
			} else if (images[i].id == 'grass') {
				canvas.getContext('2d').drawImage(
					images[i], 
					0,
					0,
					canvas.width,
					canvas.height
				);
			}
		}
		requestAnimationFrame(updateCanvas);
	}

	function savePhoto() {
		var data = canvas.toDataURL('image/png');
		sendpicture(data);
	}

	// Fill the photo with an indication that none has been
	// captured.

	function clearphoto() {
		var context = canvas.getContext('2d');
		context.fillStyle = "#AAA";
		context.fillRect(0, 0, canvas.width, canvas.height);

		var data = canvas.toDataURL('image/png');
		photo.setAttribute('src', data);
	}

	function b64ToUint6(nChr) {
		// convert base64 encoded character to 6-bit integer
		// developer.mozilla.org/en-US/docs/Web/JavaScript/Base64_encoding_and_decoding
		return (nChr > 64 && nChr < 91 ? nChr - 65
		: nChr > 96 && nChr < 123 ? nChr - 71
		: nChr > 47 && nChr < 58 ? nChr + 4
		: nChr === 43 ? 62 
		: nChr === 47 ? 63 
		: 0);
	}


	// Convert base64 encoded string to uIntArray
	// developer.mozilla.org/en-US/docs/Web/JavaScript/Base64_encoding_and_decoding
	function base64DecToArr(sBase64, nBlocksSize) {
		var sB64Enc = sBase64.replace(/[^A-Za-z0-9\+\/]/g, "");
		var nInLen = sB64Enc.length;
		var nOutLen = nBlocksSize ? 
			Math.ceil((nInLen * 3 + 1 >> 2) / nBlocksSize) * nBlocksSize : nInLen * 3 + 1 >> 2;
		var taBytes = new Uint8Array(nOutLen);

		for (var nMod3, nMod4, nUint24 = 0, nOutIdx = 0, nInIdx = 0; nInIdx < nInLen; nInIdx++) {
			nMod4 = nInIdx & 3;
			nUint24 |= b64ToUint6(sB64Enc.charCodeAt(nInIdx)) << 18 - 6 * nMod4;
			if (nMod4 === 3 || nInLen - nInIdx === 1) {
				for (nMod3 = 0; nMod3 < 3 && nOutIdx < nOutLen; nMod3++, nOutIdx++) {
					taBytes[nOutIdx] = nUint24 >>> (16 >>> nMod3 & 24) & 255;
				}
				nUint24 = 0;
			}
		}
		return taBytes;
	}

	function sendpicture(data) {
		var rawData = data.replace(/^data\:image\/\w+\;base64\,/, '');
		var xhttp = new XMLHttpRequest();
		var blob = new Blob( [base64DecToArr(rawData)], {type: 'image/png'} );
		var form = new FormData();

		xhttp.onreadystatechange = function() {
			if (this.readyState == 4 && this.status == 200) {
				var newEl = document.createElement("div");
				newEl.classList.add("user-image");
				newEl.innerHTML = this.responseText;
				document.getElementById("side-panel").append(newEl);

			}
		};

		xhttp.open("POST", "../capture", true);
		form.append("data", blob, 'testimage');
		xhttp.send(form);
	}

	function toggleStatus() {
		if (video.paused) {
			video.play();
			captureButton.style.display = "inherit";
			saveButton.style.display = "none";
			deleteButton.style.display = "none";
		} else {
			video.pause();
			captureButton.style.display = "none";
			saveButton.style.display = "inherit";
			deleteButton.style.display = "inherit";
		}
	}

	function overlay(image, x, y, width, height) {
		console.log("overlaying image...");
		console.log(image);
		canvas.getContext('2d').drawImage(image, x, y, width, height);
		image.setAttribute('crossOrigin', 'anonymous');
	}

	// Capture a photo by fetching the current contents of the video
	// and drawing it into a canvas, then converting that to a PNG
	// format data URL. By drawing it on an offscreen canvas and then
	// drawing that to the screen, we can change its size and overlay
	// other images before drawing it.
	
	function takepicture() {
		if (width && height) {
			toggleStatus();
			canvas.getContext('2d').drawImage(video, 0, 0, width, height);
		} else {
			clearphoto();
		}
	}

	// Set up our event listener to run the startup process
	// once loading is complete.
	window.addEventListener('load', startup, false);
})();
