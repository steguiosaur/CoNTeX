// Sync scroll on source-text and main-preview
document.addEventListener('DOMContentLoaded', function() {
    var sourceText = document.getElementById('source-text');
    var mainPreview = document.getElementById('main-preview');

    // Function to synchronize scrolling
    function syncScroll(event) {
        var target = event.target;
        if (target.id === 'source-text') {
            mainPreview.scrollTop = target.scrollTop;
        } else {
            sourceText.scrollTop = target.scrollTop;
        }
    }

    // Add scroll event listeners
    sourceText.addEventListener('scroll', syncScroll);
    mainPreview.addEventListener('scroll', syncScroll);
});


// Render Markdown content on page load with default text
var sourceText = document.getElementById('source-text').value;
document.getElementById('render-text').innerHTML = parseMarkdown(sourceText);

// Render Markdown content on every textarea input
document.getElementById('source-text').addEventListener('input', function() {
    document.getElementById('render-text').innerHTML = parseMarkdown(this.value);
});
