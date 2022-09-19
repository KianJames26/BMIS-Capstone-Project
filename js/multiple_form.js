function goToPageOne() {
    const pageOne = document.getElementById("page-1");
    const pageTwo = document.getElementById("page-2");
    const pageThree = document.getElementById("page-3");
    const pageFour = document.getElementById("page-4");

    pageOne.style.display = "inherit";
    pageTwo.style.display = "none";
    pageThree.style.display = "none";
    pageFour.style.display = "none";
}

function goToPageTwo() {
    const lrn = document.getElementById("lrn");
    const lastName = document.getElementById("last-name");
    const firstName = document.getElementById("first-name");

    if (lrn.value === "" || lrn.value.length != 12) {
        alert("Please Enter a Valid LRN");
        lrn.style.borderColor = 'red';
        setTimeout(function() { 
            lrn.style.borderColor = '#dddddd';
        }, 500);
        
    } else if (lastName.value.length < 2) {
        alert("Please Enter your Last Name!");
        lastName.style.borderColor = 'red';
        setTimeout(function() { 
            lastName.style.borderColor = '#dddddd';
        }, 500);
    } else if (firstName.value.length < 2) {
        alert("Please Enter your Firstname!");
        firstName.style.borderColor = 'red';
        setTimeout(function() { 
            firstName.style.borderColor = '#dddddd';
        }, 500);
    }else {
        const pageOne = document.getElementById("page-1");
        const pageTwo = document.getElementById("page-2");
        const pageThree = document.getElementById("page-3");
        const pageFour = document.getElementById("page-4");
    
        pageOne.style.display = "none";
        pageTwo.style.display = "inherit";
        pageThree.style.display = "none";
        pageFour.style.display = "none";
    }
    // const pageOne = document.getElementById("page-1");
    // const pageTwo = document.getElementById("page-2");
    // const pageThree = document.getElementById("page-3");
    // const pageFour = document.getElementById("page-4");

    // pageOne.style.display = "none";
    // pageTwo.style.display = "inherit";
    // pageThree.style.display = "none";
    // pageFour.style.display = "none";
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
    }else if(birthPlace.value === "" || birthplace.value.length < 4){
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

        pageOne.style.display = "none";
        pageTwo.style.display = "none";
        pageThree.style.display = "inherit";
        pageFour.style.display = "none";
    }
    
    // const pageOne = document.getElementById("page-1");
    // const pageTwo = document.getElementById("page-2");
    // const pageThree = document.getElementById("page-3");
    // const pageFour = document.getElementById("page-4");

    // pageOne.style.display = "none";
    // pageTwo.style.display = "none";
    // pageThree.style.display = "inherit";
    // pageFour.style.display = "none";
}

function goToPageFour() {
    const pageOne = document.getElementById("page-1");
    const pageTwo = document.getElementById("page-2");
    const pageThree = document.getElementById("page-3");
    const pageFour = document.getElementById("page-4");

    pageOne.style.display = "none";
    pageTwo.style.display = "non";
    pageThree.style.display = "none";
    pageFour.style.display = "inherit";
}


