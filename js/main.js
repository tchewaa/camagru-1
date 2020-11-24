const host = location.host;

//handle Like button
const likeButton = document.getElementById('like-button');

likeButton.addEventListener('DOMContentLoaded', function (e) {
    console.log("Check if user already liked the image");
    // likeButton.innerText = "Like";
});

likeButton.addEventListener('click', function(e) {
    console.log("Like button cliked...");
    console.log("Image ID: " + likeButton.value);
    const formData = new FormData();
    const imageId = likeButton.value;
    const url = (host.indexOf("Windows")) ? "http://localhost/camagru/like/update" : "http://localhost:8080/camagru/like/update";
    formData.append('image-id', imageId);
    fetch(url, {
        method: 'POST',
        body: formData
    }).then(
        response => response.text()
    ).then(
        data => {
            console.log(data);
            //reload page after liking image
            // window.location.reload();
        }
    )
    console.log("URL:" + url);
    e.preventDefault();
});

//handle comment
const commentButton = document.getElementById('comment-button');
const commentText = document.getElementById('comment-text');

commentButton.addEventListener('click', function (e) {
   console.log("commenting");
   console.log(commentText.innerHTML);
});