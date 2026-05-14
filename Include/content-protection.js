/**
 * content-protection.js
 * Basic client-side restrictions to deter casual copying.
 */

(function() {
    // 1. Disable Right-Click (Context Menu)
    document.addEventListener('contextmenu', function(e) {
        e.preventDefault();
    });

    // 2. Disable Keyboard Shortcuts
    document.addEventListener('keydown', function(e) {
        // F12 (Developer Tools)
        if (e.key === 'F12') {
            e.preventDefault();
        }
        // Ctrl+Shift+I / Cmd+Option+I (DevTools)
        if ((e.ctrlKey || e.metaKey) && e.shiftKey && e.key === 'I') {
            e.preventDefault();
        }
        // Ctrl+Shift+J / Cmd+Option+J (Console)
        if ((e.ctrlKey || e.metaKey) && e.shiftKey && e.key === 'J') {
            e.preventDefault();
        }
        // Ctrl+Shift+C / Cmd+Option+C (Inspect Element)
        if ((e.ctrlKey || e.metaKey) && e.shiftKey && e.key === 'C') {
            e.preventDefault();
        }
        // Ctrl+U / Cmd+U (View Source)
        if ((e.ctrlKey || e.metaKey) && e.key === 'u') {
            e.preventDefault();
        }
        // Ctrl+C / Cmd+C (Copy text)
        if ((e.ctrlKey || e.metaKey) && e.key === 'c') {
            e.preventDefault();
        }
        // Ctrl+S / Cmd+S (Save Page)
        if ((e.ctrlKey || e.metaKey) && e.key === 's') {
            e.preventDefault();
        }
        // Ctrl+P / Cmd+P (Print Page)
        if ((e.ctrlKey || e.metaKey) && e.key === 'p') {
            e.preventDefault();
        }
    });

    // 3. Disable Dragging (Prevents dragging images or text to the desktop)
    document.addEventListener('dragstart', function(e) {
        e.preventDefault();
    });

    // 4. Disable Text Selection via JS (Fallback for older browsers)
    document.addEventListener('selectstart', function(e) {
        e.preventDefault();
    });
})();