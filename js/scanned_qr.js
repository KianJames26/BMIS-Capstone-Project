function showErrorBox(msg, inputBox) {
    const errorBox = document.getElementById('hidden-error');
    errorBox.innerHTML = "<div id='error-box' class='appear'><p class='title'>ERROR!</p><p id='error-message'>"+msg+"</p><div class='action'><div id='ok'>Okay</div></div></div>";
    document.getElementById('form').appendChild(errorBox);
    const okBtn = document.getElementById('ok');
    okBtn.addEventListener('click', ()=>{
        hideErrorBox(inputBox);
    });
}
function hideErrorBox(inputBox) {
    const errorBox = document.getElementById('error-box');
    errorBox.classList.replace('appear', 'disappear');
    setTimeout(() => {
        errorBox.remove();
        document.getElementById(inputBox).style.borderColor = "red";
        setTimeout(() => {
            document.getElementById(inputBox).style.borderColor = "#dddddd";
        }, 400);
    }, 400);
}
function studentPictureValidation() {
    const studentPicture = document.getElementById('student-picture');

    const allowedExtension = /(\.jpg|\.jpeg|\.png)$/i;

    if(!allowedExtension.exec(studentPicture.value)){
        showErrorBox("Please upload a file with .jpg/.jpeg/.png extenstion only", studentPicture.id);
        studentPicture.value = '';
        return false;
    }
}

function pdfValidation(id){
    const fileInput = document.getElementById(id);

    const allowedExtension = /(\.pdf)$/i;

    if(!allowedExtension.exec(fileInput.value)){
        showErrorBox("Please upload a file with .pdf extenstion only", fileInput.id);
        fileInput.value = '';
        return false;
    }
}