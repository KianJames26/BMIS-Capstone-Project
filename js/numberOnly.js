const inputBox = document.querySelectorAll("input[type=number]");

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