document.getElementById("scrollButton").addEventListener("click", function() {
    const targetElement = document.getElementById("apply");
    targetElement.scrollIntoView({ behavior: "smooth" });
});