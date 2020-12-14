let width = 500,
	height = 0,
	filter = 0,
	selectedSticker = [],
	streaming = false,
	imageUrl = "",
	url = "";

const host = location.host;

//Dom element
const video = document.getElementById('video');
const canvas = document.getElementById('canvas');
const photos = document.getElementById('photos');
const photoButton = document.getElementById('photo-button');
const clearButton = document.getElementById('clear-button');
const imageUpload = document.getElementById('image-upload');
const stickerMenu = document.getElementsByName('sticker-menu');
const saveButton = document.getElementById('save-button');
const stickers = document.getElementById('stickers');
const uploadForm = document.getElementById('upload-form');
const deleteIcon = document.getElementsByClassName('delete');


//Get stream
navigator.mediaDevices.getUserMedia({video: true, audio: false}
	)
	.then(function(stream) {
		video.srcObject = stream;
		//Play video
		video.play();
	})
	.catch(function(error) {
		console.log(`Error: ${error}`);
	});

// Play when ready
video.addEventListener('canplay', function(e) {
	if (!streaming) {
		//set video canvas
		height = video.videoHeight / (video.videoWidth / width);

		video.setAttribute('width', width);
		video.setAttribute('height', height);
		canvas.setAttribute('width', width);
		canvas.setAttribute('height', height);

		streaming = true;
	}
}, false);


// photo button event
photoButton.addEventListener('click', function(e) {
	photoButton.classList.add("hide");
	uploadForm.classList.add("hide");
	video.classList.add("hide");
	saveButton.classList.remove("hide");
	clearButton.classList.remove("hide");
	takePicture();
	e.preventDefault();
}, false);

//clear event
clearButton.addEventListener('click', function(e) {
	//Reload page
	console.log(e);
	window.location.reload();
})


// take picture from canvas
function takePicture() {

	//create canvas
	const context = canvas.getContext('2d');

	if (stickers.classList.contains("hide")) {
		stickers.classList.remove("hide");
	}

	if (width && height) {
		//set canvas props
		canvas.width = width;
		canvas.height = height;
		//draw an image
		context.drawImage(video, 0, 0, width, height);

		//create image from the canvas
		imageUrl = canvas.toDataURL('image/png');

		//create image element
		const img = document.createElement('img');

		//set image src
		img.setAttribute('src', imageUrl);

		//set image filter

		//add image to photos
		photos.appendChild(img);
	}
}


saveButton.addEventListener('click', function(e) {
	const url = "http://localhost:8080/camagru/editor/upload";
	const formData = new FormData();
	formData.append('webCamImage', imageUrl);
	formData.append('selectedStickers', selectedSticker);
	fetch(url, {
		    method : 'POST',
		    body: formData
		}).then(
	    response => response.text() 
	    ).then(
	    data => {
			console.log(data);
			window.location.reload();
	    	}
	    );
	    //Reload page
});

//delete icon
for(let i = 0; i < deleteIcon.length; i++) {
  deleteIcon[i].addEventListener("click", function(e) {
  	let url = "";
	if (host.indexOf("Windows")) {
		console.log('test');
		url += "http://localhost/camagru/editor/delete";
	} else {
		url += "http://localhost:8080/camagru/editor/delete";
	}
    const imageID =  deleteIcon[i].getAttribute("id");
	const formData = new FormData();
	formData.append('image-id', imageID);
	fetch(url, {
		method : 'POST',
		body: formData
	}).then(
	response => response.text()
	).then(
	data => {
		// console.log(data);
		window.location.reload();
	})
	//Reload page
	e.preventDefault();
  })
}


stickerMenu[0].addEventListener('change', function(e) {
	const sticker = document.getElementById("sticker-1");
	if (stickerMenu[0].checked == true) {
		const stickerPath = sticker.children[0].getAttribute('src');
		selectedSticker.push(stickerPath); 		
	} else {
		selectedSticker.splice(0, 1);
	}
	e.preventDefault();
})


stickerMenu[1].addEventListener('change', function(e) {
	const sticker = document.getElementById("sticker-2");
	if (stickerMenu[1].checked == true) {
		const stickerPath = sticker.children[0].getAttribute('src');
		selectedSticker.push(stickerPath);
	} else {
		selectedSticker.splice(1, 1);
	}
	e.preventDefault();
})

stickerMenu[2].addEventListener('change', function(e) {
	const sticker = document.getElementById("sticker-3");
	if (stickerMenu[2].checked == true) {
		const stickerPath = sticker.children[0].getAttribute('src');
		selectedSticker.push(stickerPath);
	} else {
		selectedSticker.splice(2, 1);
	}
	e.preventDefault();
})

stickerMenu[3].addEventListener('change', function(e) {
	const sticker = document.getElementById("sticker-4");
	if (stickerMenu[3].checked == true) {
		const stickerPath = sticker.children[0].getAttribute('src');
		selectedSticker.push(stickerPath);
	} else {
		selectedSticker.splice(3, 1);
	}
	e.preventDefault();
})
