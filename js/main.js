const host = location.host;

// window.addEventListener('load', function (e) {
//     console.log('Page loaded');
// });

const loadSpinner = document.getElementById('load-spinner');

//handle Like button
const likeButton = document.getElementById('like-button');

likeButton.addEventListener('DOMContentLoaded', function (e) {
    console.log("Check if user already liked the image");
    // likeButton.innerText = "Like";
});

likeButton.addEventListener('click', function(e) {
    loadSpinner.classList.add('loading');

    try {
        const formData = new FormData();
        const imageId = likeButton.value;
        const likeStatus = likeButton.innerText;
        const url = (host.indexOf("Windows")) ? "http://localhost/camagru/home/like" : "http://localhost:8080/camagru/image/like";
        formData.append('image-id', imageId);
        formData.append('like-status', likeStatus);

        setTimeout( async function () {
            const response = await fetch(url, {
                method: 'POST',
                body: formData
            });
            window.location.reload();
        }, 2000)

    } catch (e) {
        console.log(e.message);
    }
    e.preventDefault();
});

//handle comment
const commentButton = document.getElementById('comment-button');
const commentText = document.getElementById('comment-text');

commentButton.addEventListener('click', function (e) {
    loadSpinner.classList.add('loading');

    try {
        if (commentText.value !== '') {
            const formData = new FormData();
            const comment = commentText.value;
            const imageId = commentButton.value;
            formData.append('image-id', imageId);
            formData.append('comment', comment);
            const url = (host.indexOf("Windows")) ? "http://localhost/camagru/home/comment" : "http://localhost:8080/camagru/image/comment";

            setTimeout( async function () {
                const response = await fetch(url, {
                    method: 'POST',
                    body: formData
                });
                window.location.reload();
            }, 2000)
            e.preventDefault();
        } else {
            alert("You cannot post empty comment...");
        }
    } catch (e) {
        alert("Something went wrong...");
    }
});