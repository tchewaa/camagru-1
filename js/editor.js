let width = 500,
	height = 0,
	filter = 0,
	selectedSticker = "",
	streaming = false;

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


//Get stream
navigator.mediaDevices.getUserMedia({video: true, audio: false}
	)
	.then(function(stream) {
		// console.log(stream);
		// console.log(video);
		//link to video source
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
	saveButton.classList.remove("hide");
	clearButton.classList.remove("hide");
	takePicture();
	e.preventDefault();
}, false);


//image upload
const handleImage = (e) => {
	// const selectedFiles = [...imageUpload.files];
	const context = canvas.getContext('2d');

	// console.log(e.target.files[0]);
	const image = e.target.files[0];
	context.drawImage(image, 0, 0, width, height);

	e.preventDefault();
}

imageUpload.addEventListener("change", handleImage);

//filter event
// photoFilter.addEventListener('click', function(e) {
	//set filter to choosen option
	// filter = e.target.value;
	//set filter to video
	// video.style.filter = filter;

	// e.preventDefault();

// });

//clear event
clearButton.addEventListener('click', function(e) {
	//clear photos
	photos.innerHTML = '';
	//change filter back to none
	// filter = 'none';
	// set video filter
	// video.style.filter = filter;
	//reset select list
	// photoFilter.selectedIndex = 0;
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
		const imageUrl = canvas.toDataURL('image/png');

		//create image element
		const img = document.createElement('img');

		//set image src
		img.setAttribute('src', imageUrl);

		//set image filter
		// img.style.filter = filter;

		//add image to photos
		photos.appendChild(img);
	}
}

stickerMenu[0].addEventListener('change', function(e) {
	if (stickerMenu[0].checked == true) {
		console.log('sticker 1 checked');
		selectedSticker = selectedSticker + e.target.value + ','; 		
	} else {
		console.log('sticker 1 unchecked')
		selectedSticker = selectedSticker.replace('1.png,', '');
	}
	e.preventDefault();
})


stickerMenu[1].addEventListener('change', function(e) {
	if (stickerMenu[1].checked == true) {
		console.log('sticker 2 checked');
		selectedSticker = selectedSticker + e.target.value + ','; 		
	} else {
		console.log('sticker 2 unchecked')
		selectedSticker = selectedSticker.replace('2.png,', '');
	}
	e.preventDefault();
})

stickerMenu[2].addEventListener('change', function(e) {
	if (stickerMenu[2].checked == true) {
		console.log('sticker 3 checked');
		selectedSticker = selectedSticker + e.target.value + ','; 		
	} else {
		console.log('sticker 3 unchecked')
		selectedSticker = selectedSticker.replace('3.png,', '');
	}
	e.preventDefault();
})

stickerMenu[3].addEventListener('change', function(e) {
	if (stickerMenu[3].checked == true) {
		console.log('sticker 4 checked');
		selectedSticker = selectedSticker + e.target.value + ','; 		
	} else {
		console.log('sticker 4 unchecked')
		selectedSticker = selectedSticker.replace('4.png,', '');
	}
	console.log(selectedSticker);
	e.preventDefault();
})
