// Získa textový element a pôvodný text
const textElement = document.getElementById("text");
const originalText = textElement.innerText.split("");

// Funkcia na vytvorenie náhodného písmena
function getRandomLetter() {
    const letters = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz";
    return letters.charAt(Math.floor(Math.random() * letters.length));
}

// Funkcia na náhodnú zmenu písmen v pôvodnom texte
function randomizeText() {
    // Skopíruje pôvodný text
    let newText = [...originalText];

    // Vyberie náhodné pozície na zmenu (max 3)
    let positions = [];
    while (positions.length < 3) {
        let pos = Math.floor(Math.random() * originalText.length);
        if (!positions.includes(pos)) positions.push(pos);
    }

    // Nahradí vybrané pozície náhodnými písmenami
    positions.forEach(pos => {
        newText[pos] = getRandomLetter();
    });

    // Zmení textový obsah
    textElement.innerText = newText.join("");
}

// Spustí cyklickú zmenu textu každých 300 ms
setInterval(randomizeText, 200);
