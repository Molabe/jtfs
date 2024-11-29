// Disable Ctrl+S and other specific key combinations
document.addEventListener('keydown', function (e) {
    // Prevent Ctrl+S (Save page)
    if (e.ctrlKey && e.key === 's') {
        e.preventDefault();
        alert('Saving this page is disabled.');
    }

    // Prevent opening Developer Tools (e.g., Ctrl+Shift+I, F12)
    if (
        (e.ctrlKey && e.shiftKey && (e.key === 'I' || e.key === 'J')) || // Ctrl+Shift+I / Ctrl+Shift+J
        e.key === 'F12' // F12 key
    ) {
        e.preventDefault();
        alert('Developer tools are disabled.');
    }
});

// Disable right-click context menu
document.addEventListener('contextmenu', function (e) {
    e.preventDefault();
    alert('Right-click is disabled.');
});

// Monitor and prevent opening DevTools by resizing or detaching
(function () {
    const devtoolsChecker = setInterval(function () {
        if (window.outerWidth - window.innerWidth > 100 || window.outerHeight - window.innerHeight > 100) {
            alert('Developer tools are disabled.');
            window.close(); // Close the tab (optional, may not work in all browsers)
            clearInterval(devtoolsChecker);
        }
    }, 500); // Check every 500ms
})();
