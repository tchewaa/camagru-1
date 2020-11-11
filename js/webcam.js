let width = 500,
	height = 0,
	filter = 0,
	// sticker = "",
	streaming = false;

//Dom element
const video = document.getElementById('video');
const canvas = document.getElementById('canvas');
const photos = document.getElementById('photos');
const photoButton = document.getElementById('photo-button');
const clearButton = document.getElementById('clear-button');
const photoFilter = document.getElementById('photo-filter');

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
	takePicture();
	e.preventDefault();
}, false);


//filter event
photoFilter.addEventListener('click', function(e) {
	//set filter to choosen option
	filter = e.target.value;
	//set filter to video
	video.style.filter = filter;

	e.preventDefault();

});

//clear event
clearButton.addEventListener('click', function(e) {
	//clear photos
	photos.innerHTML = '';
	//change filter back to none
	filter = 'none';
	// set video filter
	video.style.filter = filter;
	//reset select list
	photoFilter.selectedIndex = 0;
})

// take picture from canvas
function takePicture() {

	//create canvas
	const context = canvas.getContext('2d');
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
		img.style.filter = filter;

		//add image to photos
		photos.appendChild(img);
	}
}

