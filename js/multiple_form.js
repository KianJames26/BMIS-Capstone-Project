function showErrorBox() {
    const errorBox = document.getElementById('error-box');
    errorBox.classList.toggle('show-error-box');
    errorBox.style.display = "inherit";
}
function hideErrorBox(input) {
    const errorBox = document.getElementById('error-box');
    errorBox.classList.replace('show-error-box','disappear');
    setTimeout(()=>{
        errorBox.style.display="none";
        input.style.borderColor = 'red';
        setTimeout(()=> { 
            input.style.borderColor = '#dddddd';
        }, 500);
    },400);
}

function topFunction() {
    document.documentElement.scrollTop = 0;
    document.body.scrollTop = 0;
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

    let duplicateLrn = false;

    Object.keys(existingLrn).forEach(key => {
        if (existingLrn[key].lrn === lrn.value) {
            duplicateLrn = true
        }
    });

    if (gradeLevel.value === "") {
        const okBtn = document.getElementById('ok');
        document.getElementById('error-message').innerHTML = "Please Select Grade Level to Enroll";
        showErrorBox();
        okBtn.addEventListener('click', ()=>{
            hideErrorBox(gradeLevel);
        });
    }else if (duplicateLrn){
        const okBtn = document.getElementById('ok');
        document.getElementById('error-message').innerHTML = "LRN is Already in our database";
        showErrorBox();
        okBtn.addEventListener('click', ()=>{
            hideErrorBox(lrn);
        });
    }else if (lrn.value === "" || lrn.value.length != 12) {
        alert("Please Enter a Valid LRN");
        lrn.style.borderColor = 'red';
        setTimeout(function() { 
            lrn.style.borderColor = '#dddddd';
        }, 500);
    } else if (lastName.value.trim().length < 2) {
        alert("Please Enter your Last Name!");
        lastName.style.borderColor = 'red';
        setTimeout(function() { 
            lastName.style.borderColor = '#dddddd';
        }, 500);
    } else if (firstName.value.trim().length < 2) {
        alert("Please Enter your Firstname!");
        firstName.style.borderColor = 'red';
        setTimeout(function() { 
            firstName.style.borderColor = '#dddddd';
        }, 500);
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
    const contactNumber = document.getElementById('contact-number');
    const validEmail = validateEmail();
    
    function validateEmail() {
        const mailFormat = /^(([^<>()[\]\\.,;:\s@"]+(\.[^<>()[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;

        if (document.getElementById('email').value.match(mailFormat)) {
            return true;
        } else {
            return false;
        }
    }

    if (gender === "null") {
        alert("Please Select your Gender!");
    }else if(birthDay.value === ""){
        alert("Please Enter your Date of Birth!");
        birthday.style.borderColor = 'red';
        setTimeout(function() { 
            birthDay.style.borderColor = '#dddddd';
        }, 500);
    }else if(birthPlace.value.trim() === "" || birthplace.value.trim().length < 4){
        alert("Please Enter a valid Place of Birth!");
        birthPlace.style.borderColor = 'red';
        setTimeout(function() { 
            birthPlace.style.borderColor = '#dddddd';
        }, 500);
    }else if (contactNumber.value === "" || contactNumber.value.length > 11 || contactNumber.value.length < 11) {
        alert("Please Enter a valid Contact Number");
        contactNumber.style.borderColor = 'red';
        setTimeout(function() { 
            contactNumber.style.borderColor = '#dddddd';
        }, 500);
    }else if (!validEmail) {
        alert("Please Enter a Valid Email!");
        document.getElementById('email').style.borderColor = 'red';
        setTimeout(function() { 
            document.getElementById('email').style.borderColor = '#dddddd';
        }, 500);
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
    const houseAddress = document.getElementById('house-address');
    const barangay = document.getElementById('barangay');
    const city = document.getElementById('city');
    const province = document.getElementById('province');
    const parentFullName = document.getElementById('parent-fullname');
    const parentContact = document.getElementById('parent-contact');
    const relationship = document.getElementById('relationship');

    if(houseAddress.value.trim() === ""){
        alert("Please Enter your House Number & Street");
        houseAddress.style.borderColor = 'red';
        setTimeout(function() { 
            houseAddress.style.borderColor = '#dddddd';
        }, 500);
    }else if(barangay.value.trim() === ""){
        alert("Please Enter your Barangay");
        barangay.style.borderColor = 'red';
        setTimeout(function() { 
            barangay.style.borderColor = '#dddddd';
        }, 500);
    }else if(city.value.trim() === ""){
        alert("Please Enter your City");
        city.style.borderColor = 'red';
        setTimeout(function() { 
            city.style.borderColor = '#dddddd';
        }, 500);
    }else if(province.value.trim() === ""){
        alert("Please Enter your Province");
        province.style.borderColor = 'red';
        setTimeout(function() { 
            province.style.borderColor = '#dddddd';
        }, 500);
    }else if(parentFullName.value.trim() === ""){
        alert("Please Enter your Parent/Guardian Full Name");
        parentFullName.style.borderColor = 'red';
        setTimeout(function() { 
            parentFullName.style.borderColor = '#dddddd';
        }, 500);
    }else if (parentContact.value === "" || parentContact.value.length > 11 || parentContact.value.length < 11) {
        alert("Please Enter a valid Contact Number");
        parentContact.style.borderColor = 'red';
        setTimeout(function() { 
            parentContact.style.borderColor = '#dddddd';
        }, 500);
    }else if(relationship.value.trim() === ""){
        alert("Please Enter your Parent/Guardian Relationship");
        relationship.style.borderColor = 'red';
        setTimeout(function() { 
            relationship.style.borderColor = '#dddddd';
        }, 500);
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
    const lastSchool = document.getElementById('last-school');
    const lastSchoolAddress = document.getElementById('last-school-address');
    const studentPicture = document.getElementById('student-picture');
    const reportCard = document.getElementById('report-card');
    const birthCertificate = document.getElementById('birth-certificate');

    if(lastSchool.value.trim() === ""){
        alert("Please Enter your Last School");
        lastSchool.style.borderColor = 'red';
        setTimeout(function() { 
            lastSchool.style.borderColor = '#dddddd';
        }, 500);
    }else if(lastSchoolAddress.value.trim() === ""){
        alert("Please Enter your Last School Address");
        lastSchoolAddress.style.borderColor = 'red';
        setTimeout(function() { 
            lastSchoolAddress.style.borderColor = '#dddddd';
        }, 500);
    }else if (studentPicture.files.length == 0){
        alert("Please Upload your 1x1 Picture");
        studentPicture.style.borderColor = 'red';
        studentPicture.style.transition = '0.5s';
        setTimeout(function() { 
            studentPicture.style.borderColor = '#dddddd';
        }, 500);
    }else if (reportCard.files.length == 0){
        alert("Please Upload your Form 138");
        reportCard.style.borderColor = 'red';
        reportCard.style.transition = '0.5s';
        setTimeout(function() { 
            reportCard.style.borderColor = '#dddddd';
        }, 500);
    }else if (birthCertificate.files.length == 0){
        alert("Please Upload your Birth Certificate");
        birthCertificate.style.borderColor = 'red';
        birthCertificate.style.transition = '0.5s';
        setTimeout(function() { 
            reportCard.style.borderColor = '#dddddd';
        }, 500);
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



function showAllInput() {
    const lrn = document.getElementById("lrn").value;
    const lastName = document.getElementById("last-name").value;
    const firstName = document.getElementById("first-name").value;
    const middleName = document.getElementById('middle-name').value;
    const suffix = document.getElementById('suffix').value;
    const gender = document.querySelector('input[name="gender-choice"]:checked').value;
    const birthDay = document.getElementById("birthday").value;
    const birthPlace = document.getElementById('birthplace').value;
    const contactNumber = document.getElementById('contact-number').value;
    const email = document.getElementById('email').value;
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

    document.getElementById('showLRN').innerHTML = lrn;
    document.getElementById('showLName').innerHTML = lastName;
    document.getElementById('showFName').innerHTML = firstName;
    document.getElementById('showMName').innerHTML = middleName;
    document.getElementById('showSuffix').innerHTML = suffix;
    document.getElementById('showGender').innerHTML = gender;
    document.getElementById('showBirthday').innerHTML = birthDay;
    document.getElementById('showBirthPlace').innerHTML = birthPlace;
    document.getElementById('showContactNumber').innerHTML = contactNumber;
    document.getElementById('showEmail').innerHTML = email;
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
}