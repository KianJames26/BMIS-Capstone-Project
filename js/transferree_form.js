function showErrorBox(msg, inputBox) {
    const errorBox = document.getElementById('hidden-error');
    errorBox.innerHTML = "<div id='error-box' class='appear'><p class='title'>ERROR!</p><p id='error-message'>"+msg+"</p><div class='action'><div id='ok'>Okay</div></div></div>";
    document.getElementById('form').appendChild(errorBox);
    const okBtn = document.getElementById('ok');
    okBtn.addEventListener('click', ()=>{
        topFunction();
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

function topFunction() {
    const container = document.getElementsByClassName('container')[0];
    container.scrollTop = 0;
}
function goToPageOne() {
    const pageOne = document.getElementById("page-1");
    const pageTwo = document.getElementById("page-2");
    const pageThree = document.getElementById("page-3");
    const pageFour = document.getElementById("page-4");
    const pageFive = document.getElementById('page-5');

    pageOne.style.display = "inherit";
    pageTwo.style.display = "none";
    pageThree.style.display = "none";
    pageFour.style.display = "none";
    pageFive.style.display = "none";
    topFunction();
}

function goToPageTwo(existingLrn) {
    const pageOne = document.getElementById("page-1");
    const pageTwo = document.getElementById("page-2");
    const pageThree = document.getElementById("page-3");
    const pageFour = document.getElementById("page-4");
    const pageFive = document.getElementById('page-5');
    
    const gradeLevel = document.getElementById('grade-level');
    const lrn = document.getElementById("lrn");
    const lastName = document.getElementById("last-name");
    const firstName = document.getElementById("first-name");
    const gwa = document.getElementById('gwa');

    let duplicateLrn = false;

    Object.keys(existingLrn).forEach(key => {
        if (existingLrn[key].lrn === lrn.value) {
            duplicateLrn = true
        }
    });
    if (gradeLevel.value === "") {
        showErrorBox("Please Enter Grade Level to Enroll", gradeLevel.id);
    }else if (duplicateLrn){
        showErrorBox("LRN already in the Database", lrn.id);
    }else if (lrn.value === "" || lrn.value.length != 12) {
        showErrorBox("Please Enter a Valid LRN", lrn.id);
    }else if (gwa.value === "") {
        showErrorBox("Please Enter Average", gwa.id);
    } else if (lastName.value.trim().length < 2) {
        showErrorBox("Please Enter your Last Name!", lastName.id);
    } else if (firstName.value.trim().length < 2) {
        showErrorBox("Please Enter your Firstname!". firstName.id);
    }else {
        pageOne.style.display = "none";
        pageTwo.style.display = "inherit";
        pageThree.style.display = "none";
        pageFour.style.display = "none";
        pageFive.style.display = "none";
        topFunction();
    }
}

function goToPageThree() {
    const gender = document.querySelector('input[name="gender-choice"]:checked').value;
    const birthDay = document.getElementById("birthday");
    const birthPlace = document.getElementById('birthplace');
    const lastSchool = document.getElementById('last-school');
    const lastSchoolAddress = document.getElementById('last-school-address');


    if (gender === "null") {
        showErrorBox("Please Select your Gender!");
    }else if(birthDay.value === ""){
        showErrorBox("Please Enter your Date of Birth!",birthDay.id);
    }else if(birthPlace.value.trim() === "" || birthplace.value.trim().length < 4){
        showErrorBox("Please Enter a valid Place of Birth!", birthPlace);
    }else if(lastSchool.value.trim() === ""){
        showErrorBox("Please Enter your Last School", lastSchool.id);
    }else if(lastSchoolAddress.value.trim() === ""){
        showErrorBox("Please Enter your Last School Address", lastSchoolAddress.id);
    }else{
        const pageOne = document.getElementById("page-1");
        const pageTwo = document.getElementById("page-2");
        const pageThree = document.getElementById("page-3");
        const pageFour = document.getElementById("page-4");
        const pageFive = document.getElementById('page-5');

        pageOne.style.display = "none";
        pageTwo.style.display = "none";
        pageThree.style.display = "inherit";
        pageFour.style.display = "none";
        pageFive.style.display = "none";
        topFunction();
    }
}

function goToPageFour() {
    const barangay = document.getElementById('barangay');
    const city = document.getElementById('city');
    const province = document.getElementById('province');
    const parentFullName = document.getElementById('parent-fullname');
    const parentContact = document.getElementById('parent-contact');
    const relationship = document.getElementById('relationship');

    if(province.value.trim() === ""){
        showErrorBox("Please Enter your Province", province.id);
    }else if(city.value.trim() === ""){
        showErrorBox("Please Enter your City", city.id);
    }else if(barangay.value.trim() === ""){
        showErrorBox("Please Enter your Barangay", barangay.id);
        barangay.style.borderColor = 'red';
    }else if(parentFullName.value.trim() === ""){
        showErrorBox("Please Enter your Parent/Guardian Full Name", parentFullName.id);
    }else if (parentContact.value === "" || parentContact.value.length > 11 || parentContact.value.length < 11) {
        showErrorBox("Please Enter a valid Contact Number", parentContact.id);
    }else if(relationship.value.trim() === ""){
        showErrorBox("Please Enter your Parent/Guardian Relationship", relationship.id);
    }else{
        const pageOne = document.getElementById("page-1");
        const pageTwo = document.getElementById("page-2");
        const pageThree = document.getElementById("page-3");
        const pageFour = document.getElementById("page-4");
        const pageFive = document.getElementById('page-5');
    
        pageOne.style.display = "none";
        pageTwo.style.display = "non";
        pageThree.style.display = "none";
        pageFour.style.display = "inherit";
        pageFive.style.display = "none";
        topFunction();
    }
}

function goToPageFive() {
    const studentPicture = document.getElementById('student-picture');
    const reportCard = document.getElementById('report-card');
    const birthCertificate = document.getElementById('birth-certificate');

    if (studentPicture.files.length == 0){
        showErrorBox("Please Upload your 1x1 Picture", studentPicture.id);
    }else if (reportCard.files.length == 0){
        showErrorBox("Please Upload your Form 138", reportCard.id);
    }else if (birthCertificate.files.length == 0){
        showErrorBox("Please Upload your Birth Certificate", birthCertificate.id);
    }else{
        showAllInput();
        const pageOne = document.getElementById("page-1");
        const pageTwo = document.getElementById("page-2");
        const pageThree = document.getElementById("page-3");
        const pageFour = document.getElementById("page-4");
        const pageFive = document.getElementById('page-5');
    
        pageOne.style.display = "none";
        pageTwo.style.display = "non";
        pageThree.style.display = "none";
        pageFour.style.display = "none";
        pageFive.style.display = "inherit";
        topFunction();
    }
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

function showAllInput() {
    const lrn = document.getElementById("lrn").value;
    const lastName = document.getElementById("last-name").value;
    const firstName = document.getElementById("first-name").value;
    const middleName = document.getElementById('middle-name').value;
    const suffix = document.getElementById('suffix').value;
    const gender = document.querySelector('input[name="gender-choice"]:checked').value;
    const birthDay = document.getElementById("birthday").value;
    const birthPlace = document.getElementById('birthplace').value;
    const houseAddress = document.getElementById('house-address').value;
    const barangay = document.getElementById('barangay').value;
    const city = document.getElementById('city').value;
    const province = document.getElementById('province').value;
    const parentFullName = document.getElementById('parent-fullname').value;
    const parentContact = document.getElementById('parent-contact').value;
    const relationship = document.getElementById('relationship').value;
    const lastSchool = document.getElementById('last-school').value;
    const lastSchoolAddress = document.getElementById('last-school-address').value;
    const studentPicture = document.getElementById('student-picture').files[0].name;
    const reportCard = document.getElementById('report-card').files[0].name;
    const birthCertificate = document.getElementById('birth-certificate').files[0].name;
    const gradeLevel = document.getElementById('grade-level').value;

    document.getElementById('showLRN').innerHTML = lrn;
    document.getElementById('showLName').innerHTML = lastName;
    document.getElementById('showFName').innerHTML = firstName;
    document.getElementById('showMName').innerHTML = middleName;
    document.getElementById('showSuffix').innerHTML = suffix;
    document.getElementById('showGender').innerHTML = gender;
    document.getElementById('showBirthday').innerHTML = birthDay;
    document.getElementById('showBirthPlace').innerHTML = birthPlace;
    document.getElementById('showHouse').innerHTML = houseAddress;
    document.getElementById('showBarangay').innerHTML = barangay;
    document.getElementById('showCity').innerHTML = city;
    document.getElementById('showProvince').innerHTML = province;
    document.getElementById('showParentFullName').innerHTML = parentFullName;
    document.getElementById('showParentContact').innerHTML = parentContact;
    document.getElementById('showParentRelationship').innerHTML = relationship;
    document.getElementById('showLastSchool').innerHTML = lastSchool;
    document.getElementById('showLastSchoolAddress').innerHTML = lastSchoolAddress;
    document.getElementById('showPicture').innerHTML = studentPicture;
    document.getElementById('showReportCard').innerHTML = reportCard;
    document.getElementById('showBirthCertificate').innerHTML = birthCertificate;
    document.getElementById('showGrade').innerHTML = gradeLevel;
}


// const validEmail = validateEmail();
    
// function validateEmail() {
//     const mailFormat = /^(([^<>()[\]\\.,;:\s@"]+(\.[^<>()[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;

//     if (document.getElementById('email').value.match(mailFormat)) {
//         return true;
//     } else {
//         return false;
//     }
// }