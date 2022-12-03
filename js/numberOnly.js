const inputBox = [document.querySelector("#lrn"), document.querySelector("#parent-contact")];

const invalidChars = [
    "-",
    "+",
    "e",
];

inputBox.forEach((element)=>{
    element.addEventListener("input", function() {
        this.value = this.value.replace(/[e\+\-]/gi, "");
    });

    element.addEventListener("keydown", function(e) {
        if (invalidChars.includes(e.key)) {
            e.preventDefault();
        }
    });
})