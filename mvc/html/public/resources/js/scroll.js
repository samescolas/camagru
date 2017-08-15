var sideScroll = function() {
	
	var sidePanel = document.getElementById("side-panel");
	sidePanel.addEventListener("scroll", function(event) {
		var newPic = document.createElement("div");
		newPic.innerHTML = "<img src=\"\">";
		newPic.className = "sp-image";
		sidePanel.appendChild(newPic);
	});

	var checkForNewPic = function() {
		var lastDiv = document.querySelector("#side-panel > div:last-child")
		var maindiv = document.querySelector("#side-panel");
		var lastDivOffset = lastDiv.offsetTop + lastDiv.clientHeight;
		var pageOffset = maindiv.offsetTop + mainDiv.clientHeight;
		if (pageOffset > lastDivOffset - 10) {
			var newDiv = document.createElement("div");
			sidePanel.appendChild(newDiv);
			checkForNewPic();
		}
	}

	window.addEventListener("load", addListeners);
	checkForNewPic();
};
