(function() {

  var streaming = false;
  
		
	var width = 320;    // We will scale the photo width to this
  	var height = 0;     // This will be computed based on the input stream

  	var video = null;
  	var canvas = null;
  	var photo = null;
  	var target = null;
  	var startbutton = null;
	
  	function startup() {
    	video = document.getElementById('video');
    	canvas = document.getElementById('canvas');
    	photo = document.getElementById('photo');
		target = document.getElementById('target');
    	startbutton = document.getElementById('startbutton');
	
    	navigator.getMedia = ( navigator.getUserMedia ||
                           	navigator.webkitGetUserMedia ||
                           	navigator.mozGetUserMedia ||
                           	navigator.msGetUserMedia);
	
    	navigator.getMedia( { video: true, audio: false }, function(stream) {
        	if (navigator.mozGetUserMedia) {
          	video.mozSrcObject = stream;
        	} else {
          	var vendorURL = window.URL || window.webkitURL;
          	//video.src = vendorURL.createObjectURL(stream);
			video.srcObject = stream;
        	}
        	video.play();
      	},
      	function(err) {
        	console.log("An error occured! " + err);
      	}
    	);
	
    	video.addEventListener('canplay', function(ev){
      	if (!streaming) {
        	height = video.videoHeight / (video.videoWidth/width);
      	
        	// Firefox currently has a bug where the height can't be read from
        	// the video, so we will make assumptions if this happens.
      	
        	if (isNaN(height)) {
          	height = width / (4/3);
        	}
      	
        	video.setAttribute('width', width);
        	video.setAttribute('height', height);
        	canvas.setAttribute('width', width);
        	canvas.setAttribute('height', height);
        	streaming = true;
      	}
    	}, false);
	
    	startbutton.addEventListener('click', function(ev){
      	takepicture();
      	ev.preventDefault();
    	}, false);
    	
    	clearphoto();
  	}
	
  	function clearphoto() {
    	var context = canvas.getContext('2d');
    	context.fillStyle = "#AAA";
    	context.fillRect(0, 0, canvas.width, canvas.height);
	
    	var data = canvas.toDataURL('image/png');
    	photo.setAttribute('src', data);
  	}
	
  	function sendpicture(data) {
			var rawData = data.replace(/^data\:image\/\w+\;base64\,/, '');
			var xhttp = new XMLHttpRequest();
			xhttp.onreadystatechange = function() {
				if (this.readyState == 4 && this.status == 200) {
					document.getElementById("target").innerHTML = this.responseText;
				}
			};
			xhttp.open("POST", "../capture", true);
			/* new stuff */
			var blob = new Blob( [base64DecToArr
			var form = new FormData();
			form.append("data", blob, 'testimage');
			/* end new */

			//xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
			xhttp.send(form);
  	}
	
  	
  	function takepicture() {
    	var context = canvas.getContext('2d');
    	if (width && height) {
      	canvas.width = width;
      	canvas.height = height;
      	context.drawImage(video, 0, 0, width, height);
    	
      	var data = canvas.toDataURL('image/png');
      	photo.setAttribute('src', data);
	  	sendpicture(data);
    	} else {
      	clearphoto();
    	}
  	}
	
  	window.addEventListener('load', startup, false);
})();
