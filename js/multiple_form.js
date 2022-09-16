

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

    console.log(lrn);
    if (lrn.value === "") {
        alert("empty LRN");
        lrn.style.borderColor = 'red';
        setTimeout(function() { 
            lrn.style.borderColor = '#dddddd';
        }, 500);
        
    } else if (lrn.value.length != 12) {
        alert("invalid lrn");
        lrn.style.borderColor = 'red';
        setTimeout(function() { 
            lrn.style.borderColor = '#dddddd';
        }, 500);
    } else if (lastName.value.length < 2) {
        alert("invalid last name");
        lastName.style.borderColor = 'red';
        setTimeout(function() { 
            lastName.style.borderColor = '#dddddd';
        }, 500);
    } else if (firstName.value.length < 2) {
        alert("invalid first name");
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
    }//Lacking of condition!!!
}

function goToPageThree() {
    const pageOne = document.getElementById("page-1");
    const pageTwo = document.getElementById("page-2");
    const pageThree = document.getElementById("page-3");
    const pageFour = document.getElementById("page-4");

    pageOne.style.display = "none";
    pageTwo.style.display = "none";
    pageThree.style.display = "inherit";
    pageFour.style.display = "none";
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


