console.log('test 1');
window.onload = function(){
    var camera = document.querySelector('.camera');
    var body = this.document.querySelector('.container-fluid');

    camera.setAttribute('style', 'display: none');
}

function toggleCamera() {
    console.log('test');
    var camera = document.querySelector('.camera');
    if (camera.style.display == 'none') {
        camera.setAttribute('style', 'display: inline block');
    } else {
        camera.setAttribute('style', 'display: none');
    }
}