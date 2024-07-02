document.getElementById('source-text').addEventListener('keydown', function(event) {
    const openingBrackets = ['(', '[', '{'];
    const closingBrackets = [')', ']', '}'];
    const textarea = event.target;
    
    if (openingBrackets.includes(event.key)) {
        event.preventDefault();

        const start = textarea.selectionStart;
        const end = textarea.selectionEnd;
        
        const openBracket = event.key;
        const closeBracket = closingBrackets[openingBrackets.indexOf(openBracket)];
        
        const text = textarea.value;
        textarea.value = text.substring(0, start) + openBracket + closeBracket + text.substring(end);
        
        textarea.setSelectionRange(start + 1, start + 1);
    }
});
