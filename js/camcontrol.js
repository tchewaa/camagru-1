window.onload = function(){
    const camera = document.querySelector('.camera');
    const body = this.document.querySelector('.container-fluid');

    camera.setAttribute('style', 'display: inline block');
}

function toggleCamera() {
    console.log('test');
    const camera = document.querySelector('.camera');
    if (camera.style.display == 'none') {
        camera.setAttribute('style', 'display: inline block');
    } else {
        camera.setAttribute('style', 'display: none');
    }
}