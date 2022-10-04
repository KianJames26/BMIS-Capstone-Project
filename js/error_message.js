document.addEventListener('DOMContentLoaded', () => {
    autoVanish();
})

function autoVanish() {
    const errorMessage = document.getElementsByClassName('error-message');
    if (errorMessage.length) {
        setTimeout(function(){
            errorMessage[0].remove();
        }, 3000);
    }
    // setTimeout(() => {autovanish();}, 500);
}


