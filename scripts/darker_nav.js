myMove = () => {
    const elem = document.getElementById('navbar');
    window.addEventListener('scroll', () => {
        const scrollPosition = document.documentElement.scrollTop;

        if (window.scrollY > 50) {
            elem.style.background = "#121212";
            elem.style.transition = "background 0.75s ease-in-out";
        } else {
            elem.style.background = "transparent";
        }
    })
}

myMove();