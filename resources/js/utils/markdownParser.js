// markdownParser.js

// Helper function to escape HTML special characters
export const escapeSpecialChars = (str) => {
    if (!str) return '';
    const charMap = {
        '<': '<',
        '>': '>',
        '&': '&',
        '"': '"',
        "'": '\''
    };
    return str.replace(/[<>&"']/g, (match) => charMap[match]);
};

// Tokenizer
const tokenize = (markdown) => {
    const tokens = [];
    let i = 0;

    const MAX_CODE_BLOCK_LENGTH = 50000; // Adjust this value as needed (e.g., 50KB)

    while (i < markdown.length) {
        if (markdown[i] === '\\') {
            if (markdown[i + 1] === '#' || markdown[i + 1] === '*' || markdown[i + 1] === '_' || markdown[i + 1] === '`' || markdown[i + 1] === '[' || markdown[i + 1] === ']' || markdown[i + 1] === '(' || markdown[i + 1] === ')' || markdown[i + 1] === '>' || markdown[i + 1] === '-' || markdown[i + 1] === '+' || markdown[i + 1] === '.' || markdown[i + 1] === '!' || markdown[i + 1] === '~' || markdown[i + 1] === '$' || markdown[i + 1] === '\\') {
                tokens.push({ type: 'text', content: markdown[i + 1] });
                i += 2;
                continue;
            } else {
                tokens.push({ type: 'text', content: '\\' });
                i++;
                continue;
            }
        }
        if (markdown[i] === '#') {
            let level = 0;
            let originalIndex = i;
            while (i < markdown.length && markdown[i] === '#' && level < 6) {
                level++;
                i++;
            }
            if (i < markdown.length && markdown[i] === ' ') {
                i++;
                let content = '';
                while (i < markdown.length && markdown[i] !== '\n') {
                    content += markdown[i];
                    i++;
                }
                tokens.push({ type: 'heading', level: level, content: content.trim() });
            } else {
                i = originalIndex;
                let content = '';
                while (i < markdown.length && markdown[i] !== '\n') {
                    content += markdown[i];
                    i++;
                }
                tokens.push({ type: 'paragraph', content: content.trim() });
            }
        } else if (markdown[i] === '>') {
            i++;
            if (markdown[i] === ' ') i++;
            let content = '';
            while (i < markdown.length && markdown[i] !== '\n') {
                content += markdown[i];
                i++;
            }
            tokens.push({ type: 'blockquote', content: content.trim() });
        } else if ((markdown[i] === '*' && markdown[i + 1] === '*') || (markdown[i] === '_' && markdown[i + 1] === '_')) {
            const marker = markdown[i] + markdown[i + 1];
            i += 2;
            let content = '';
            while (i < markdown.length && !(markdown[i] === marker[0] && markdown[i + 1] === marker[1])) {
                content += markdown[i];
                i++;
            }
            tokens.push({ type: 'bold', content: content.trim() });
            i += 2;
        } else if (markdown[i] === '*' || markdown[i] === '_') {
            const marker = markdown[i];
            i++;
            let content = '';
            while (i < markdown.length && markdown[i] !== marker) {
                content += markdown[i];
                i++;
            }
            tokens.push({ type: 'italic', content: content.trim() });
            i++;
        } else if (markdown[i] === '-' && markdown[i + 1] === '-' && markdown[i + 2] === '-') {
            i += 3;
            tokens.push({ type: 'hr' });
        } else if (markdown[i] === '`' && markdown[i + 1] === '`' && markdown[i + 2] === '`') {
            i += 3;
            let content = '';
            let codeBlockLength = 0; // Track code block length
            while (i < markdown.length && !(markdown[i] === '`' && markdown[i + 1] === '`' && markdown[i + 2] === '`')) {
                if (codeBlockLength < MAX_CODE_BLOCK_LENGTH) { // Only accumulate if within limit
                    content += content + markdown[i];
                    codeBlockLength++;
                }
                i++;
            }
            if (codeBlockLength >= MAX_CODE_BLOCK_LENGTH) {
                content += "\n\n**[Code block truncated due to excessive length]**"; // Add warning
            }
            tokens.push({ type: 'code_block', content: content.trim() });
            i += 3;
        } else if (markdown[i] === '`') {
            i++;
            let content = '';
            while (i < markdown.length && markdown[i] !== '`') {
                content += markdown[i];
                i++;
            }
            tokens.push({ type: 'inline_code', content: content.trim() });
            i++;
        } else if (markdown[i] === '!') {
            i++;
            if (markdown[i] === '[') {
                i++;
                let altText = '';
                while (i < markdown.length && markdown[i] !== ']') {
                    altText += markdown[i];
                    i++;
                }
                i++;
                if (markdown[i] === '(') {
                    i++;
                    let url = '';
                    while (i < markdown.length && markdown[i] !== ')') {
                        url += markdown[i];
                        i++;
                    }
                    tokens.push({ type: 'image', altText: altText.trim(), url: url.trim() });
                    i++;
                }
            } else {
                tokens.push({ type: 'text', content: '!' });
            }
        } else if (markdown[i] === '[') {
            i++;
            let content = '';
            while (i < markdown.length && markdown[i] !== ']') {
                content += markdown[i];
                i++;
            }
            if (markdown[i] === ']') {
                content = '';
                i++;
            } else if (i < markdown.length && markdown[i] !== ']') {
                tokens.push({ type: 'text', content: '[' + content });
                continue;
            } else {
                i++;
            }

            if (markdown[i] === '(') {
                i++;
                let url = '';
                while (i < markdown.length && markdown[i] !== ')') {
                    url += markdown[i];
                    i++;
                }
                if (markdown[i] === ')') {
                    i++;
                    tokens.push({ type: 'link', content: content.trim(), url: url.trim() });
                } else {
                    tokens.push({ type: 'text', content: '[' + content + '(' + url });
                }

            } else {
                tokens.push({ type: 'text', content: '[' + content });
            }
        } else if (markdown[i] === '~' && markdown[i + 1] === '~') {
            i += 2;
            let content = '';
            while (i < markdown.length && !(markdown[i] === '~' && markdown[i + 1] === '~')) {
                content += markdown[i];
                i++;
            }
            tokens.push({ type: 'strikethrough', content: content.trim() });
            i += 2;
        } else if (markdown[i] === '\n') {
            let newlineCount = 0;
            while (i < markdown.length && markdown[i] === '\n') {
                newlineCount++;
                i++;
            }
            tokens.push({ type: 'newline', count: newlineCount });
        } else if (markdown[i] === '$' && markdown[i + 1] === '$') {
            // Block Math
            i += 2;
            let formula = '';
            while (i < markdown.length && !(markdown[i] === '$' && markdown[i + 1] === '$')) {
                formula += markdown[i];
                i++;
            }
            if (markdown[i] === '$' && markdown[i+1] === '$') {
                tokens.push({ type: 'block_math', formula: formula.trim() });
                i += 2;
            } else {
                //Unclosed $$, treat as text
                tokens.push({ type: 'text', content: '$$' + formula }); // Include the initial $$ as text
            }
        } else if (markdown[i] === '$') {
            // Inline Math
            i++; // Skip the opening $
            let formula = '';
            while (i < markdown.length && markdown[i] !== '$') {
                formula += markdown[i];
                i++;
            }
            if (markdown[i] === '$') { // Check for closing $
                tokens.push({ type: 'inline_math', formula: formula.trim() });
                i++; // Skip the closing $
            } else {
                // Unclosed $, treat as text
                tokens.push({ type: 'text', content: '$' + formula }); // Include the initial $ as text
            }
        } else if (markdown[i] === '*' || markdown[i] === '-' || markdown[i] === '+') {
            const marker = markdown[i];
            i++;
            if (markdown[i] === ' ') {
                i++;
                let content = '';
                while (i < markdown.length && markdown[i] !== '\n') {
                    content += markdown[i];
                    i++;
                }
                tokens.push({ type: 'list_item', listType: 'unordered', content: content.trim() });
            } else {
                tokens.push({ type: 'text', content: marker });
            }
        } else if (/\d/.test(markdown[i])) {
            let numberStr = '';
            while (/\d/.test(markdown[i])) {
                numberStr += markdown[i];
                i++;
            }
            if (markdown[i] === '.' && markdown[i + 1] === ' ') {
                i += 2;
                let content = '';
                while (i < markdown.length && markdown[i] !== '\n') {
                    content += markdown[i];
                    i++;
                }
                tokens.push({ type: 'list_item', listType: 'ordered', content: content.trim() });
            } else {
                tokens.push({ type: 'text', content: numberStr + (markdown[i] === '.' ? '.' : '') });
            }
        }
        else {
            let content = '';
            while (i < markdown.length && markdown[i] !== '\n') {
                content += markdown[i];
                i++;
            }
            tokens.push({ type: 'paragraph', content: content.trim() });
        }
    }
    return tokens;
};

// Parser (Modified to create sections)
const parse = (tokens) => {
    const ast = { type: 'document', sections: [] };
    let currentSection = null;

    for (const token of tokens) {
        if (token.type === 'newline' && token.count >= 2) {
            if (currentSection) {
                ast.sections.push(currentSection);
                currentSection = null;
            }
            continue;
        }

        if (!currentSection) {
            currentSection = { type: 'section', children: [] };
        }

        currentSection.children.push(token);
    }

    if (currentSection) {
        ast.sections.push(currentSection);
    }

    if (ast.sections.length === 0) {
        ast.sections.push({ type: 'section', children: [] });
    }

    return ast;
};


// Renderer (Modified to render sections)
const render = (ast) => {
    let htmlSections = [];

    for (const section of ast.sections) {
        let sectionHTML = '';
        let paragraphOpen = false;
        let blockquoteOpen = false;
        let listOpen = false;
        let listType = null;

        const headingStyles = {
            1: 'font-size: 32px; font-weight: bold;',
            2: 'font-size: 28px; font-weight: bold;',
            3: 'font-size: 24px; font-weight: bold;',
            4: 'font-size: 20px; font-weight: bold;',
            5: 'font-size: 18px; font-weight: bold;',
            6: 'font-size: 16px; font-weight: bold;',
        };

        for (const token of section.children) {
            switch (token.type) {
                case 'heading':
                    if (paragraphOpen) {
                        sectionHTML += `</p>`;
                        paragraphOpen = false;
                    }
                    if (blockquoteOpen) {
                        sectionHTML += `</blockquote>`;
                        blockquoteOpen = false;
                    }
                    if (listOpen) {
                        sectionHTML += `</${listType === 'ordered' ? 'ol' : 'ul'}>`;
                        listOpen = false;
                        listType = null;
                    }
                    const headingStyle = headingStyles[token.level] || '';
                    sectionHTML += `<h${token.level} style="${headingStyle}">${escapeSpecialChars(token.content)}</h${token.level}>`;
                    break;
                case 'paragraph':
                    if (!paragraphOpen) {
                        if (blockquoteOpen) {
                            sectionHTML += `<p>`;
                        } else if (listOpen) {
                            sectionHTML += `<p>`;
                        }
                        else {
                            sectionHTML += `<p>`;
                            paragraphOpen = true;
                        }
                    }
                    sectionHTML += `${escapeSpecialChars(token.content)}`;
                    break;
                case 'text':
                    if (!paragraphOpen) {
                        if (blockquoteOpen) {
                            sectionHTML += `<p>`;
                        } else if (listOpen) {
                            sectionHTML += `<p>`;
                        }
                        else {
                            sectionHTML += `<p>`;
                            paragraphOpen = true;
                        }
                    }
                    sectionHTML += `${escapeSpecialChars(token.content)}`;
                    break;
                case 'bold':
                    sectionHTML += `<strong style="font-weight: bold;">${render({ sections: [{ type: 'section', children: [{ type: 'text', content: token.content }] }] })}</strong>`;
                    break;
                case 'italic':
                    sectionHTML += `<em style="font-style: italic;">${render({ sections: [{ type: 'section', children: [{ type: 'text', content: token.content }] }] })}</em>`;
                    break;
                case 'link':
                    sectionHTML += `<a href="${escapeSpecialChars(token.url)}">${render({ sections: [{ type: 'section', children: [{ type: 'text', content: token.content }] }] })}</a>`;
                    break;
                case 'inline_code':
                    sectionHTML += `<code style="background-color: #DDDDDD;">${escapeSpecialChars(token.content)}</code>`;
                    break;
                case 'code_block':
                    if (paragraphOpen) {
                        sectionHTML += `</p>`;
                        paragraphOpen = false;
                    }
                    if (blockquoteOpen) {
                        sectionHTML += `</blockquote>`;
                        blockquoteOpen = false;
                    }
                    if (listOpen) {
                        sectionHTML += `</${listType === 'ordered' ? 'ol' : 'ul'}>`;
                        listOpen = false;
                        listType = null;
                    }
                    sectionHTML += `<pre><code style="display: block; padding: 0.5em; background: #F0F0F0;">${escapeSpecialChars(token.content)}</code></pre>`;
                    break;
                case 'image':
                    sectionHTML += `<img src="${escapeSpecialChars(token.url)}" alt="${escapeSpecialChars(token.altText)}" />`;
                    break;
                case 'strikethrough':
                    sectionHTML += `<del>${render({ sections: [{ type: 'section', children: [{ type: 'text', content: token.content }] }] })}</del>`;
                    break;
                case 'inline_math': {
                    const protocol = location.protocol === "https:" ? "https:" : "http:";
                    const url = protocol + '//i.upmath.me/svg/' + encodeURIComponent('$$' + node.formula + '$$'); // Encoded with single $ now
                    sectionHTML += `<img class="latex-code" style="vertical-align: middle; display: inline-block;" src="${url}" alt="${node.formula}" />`; // Ensure inline-block
                    break;
                }
                case 'block_math': {
                    const protocol = location.protocol === "https:" ? "https:" : "http:";
                    const url = protocol + '//i.upmath.me/svg/' + encodeURIComponent(token.formula.trim());
                    if (paragraphOpen) {
                        sectionHTML += `</p>`;
                        paragraphOpen = false;
                    }
                    if (blockquoteOpen) {
                        sectionHTML += `</blockquote>`;
                        blockquoteOpen = false;
                    }
                    if (listOpen) {
                        sectionHTML += `</${listType === 'ordered' ? 'ol' : 'ul'}>`;
                        listOpen = false;
                        listType = null;
                    }
                    sectionHTML += `<div class="latex-code" style="text-align:center;"><img src="${url}" alt="${token.formula.trim()}" /></div>`;
                    break;
                }
                case 'blockquote':
                    if (paragraphOpen) {
                        sectionHTML += `</p>`;
                        paragraphOpen = false;
                    }
                    if (listOpen) {
                        sectionHTML += `</${listType === 'ordered' ? 'ol' : 'ul'}>`;
                        listOpen = false;
                        listType = null;
                    }
                    if (!blockquoteOpen) {
                        sectionHTML += `<blockquote>`;
                        blockquoteOpen = true;
                    }
                    sectionHTML += render({ sections: [{ type: 'section', children: [{ type: 'text', content: token.content }] }] });
                    break;
                case 'hr':
                    if (paragraphOpen) {
                        sectionHTML += `</p>`;
                        paragraphOpen = false;
                    }
                    if (blockquoteOpen) {
                        sectionHTML += `</blockquote>`;
                        blockquoteOpen = false;
                    }
                    if (listOpen) {
                        sectionHTML += `</${listType === 'ordered' ? 'ol' : 'ul'}>`;
                        listOpen = false;
                        listType = null;
                    }
                    sectionHTML += `<hr>`;
                    break;
                case 'list_item':
                    if (!listOpen || listType !== token.listType) {
                        if (paragraphOpen) {
                            sectionHTML += `</p>`;
                            paragraphOpen = false;
                        }
                        if (blockquoteOpen) {
                            sectionHTML += `</blockquote>`;
                            blockquoteOpen = false;
                        }
                        if (listOpen) {
                            sectionHTML += `</${listType === 'ordered' ? 'ol' : 'ul'}>`;
                        }
                        listType = token.listType;
                        sectionHTML += `<${listType === 'ordered' ? 'ol' : 'ul'}>`;
                        listOpen = true;
                    }
                    sectionHTML += `<li>${render({ sections: [{ type: 'section', children: [{ type: 'text', content: token.content }] }] })}</li>`;
                    break;
                case 'newline':
                    if (token.count >= 2 && paragraphOpen) {
                        sectionHTML += `</p><br>`;
                        paragraphOpen = false;
                    } else if (token.count >= 2 && blockquoteOpen) {
                        sectionHTML += `<br>`;
                    }
                    else if (token.count >= 2) {
                        sectionHTML += `<br>`;
                    }
                    else if (paragraphOpen) {
                        sectionHTML += ` `;
                    }
                    else if (blockquoteOpen) {
                        sectionHTML += ` `;
                    }
                    break;
                default:
                    break;
            }
        }

        if (paragraphOpen) {
            sectionHTML += `</p>`;
        }
        if (blockquoteOpen) {
            sectionHTML += `</blockquote>`;
        }
        if (listOpen) {
            sectionHTML += `</${listType === 'ordered' ? 'ol' : 'ul'}>`;
        }
        htmlSections.push(sectionHTML);
    }

    return htmlSections;
};


// Main Parser Function (Modified to return HTML sections)
const parseMarkdown = (markdownText) => {
    const tokens = tokenize(markdownText);
    const ast = parse(tokens);
    const htmlSections = render(ast);
    return htmlSections;
};

export default parseMarkdown;
