document.addEventListener("DOMContentLoaded", function() {
    // Select all the sections that need to be animated
    const sections = document.querySelectorAll('.fade-in-section');

    // Function to check if an element is in the viewport
    const isInViewport = (element) => {
        const rect = element.getBoundingClientRect();
        return rect.top <= window.innerHeight && rect.bottom >= 0;
    };

    // Function to handle the fade-in effect
    const checkSections = () => {
        sections.forEach(section => {
            if (isInViewport(section)) {
                section.style.transition = 'opacity 2.75s ease-out';  // Smooth transition
                section.style.opacity = 1; // Make the section visible
            }
        });
    };

    // Run the checkSections function on scroll
    window.addEventListener('scroll', checkSections);

    // Run the check once to handle sections already in view
    checkSections();
});
