document.addEventListener('DOMContentLoaded', () => {
    autoVanish()
})

function autoVanish() {
    const errorMessage = document.getElementsByClassName('error-message');
    if (errorMessage.length) {
        setTimeout(function(){
            errorMessage[0].remove();
        }, 3000);
    }
    setTimeout(() => {autovanish();}, 500);
}


// document.addEventListener('DOMContentLoaded', () => {
//     autovanish();
// })

// function autovanish(){
// const avDivs = document.getElementsByClassName('error-message');
// if (avDivs.length){
// setTimeout(function(){
// avDivs[0].remove();
// }, 3000); //removes the element after 3000ms
// }
// setTimeout(() => {autovanish();}, 500); //re-run every 500ms   
// }