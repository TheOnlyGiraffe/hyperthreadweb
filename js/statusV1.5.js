document.addEventListener('DOMContentLoaded', (event) => {
    // Function to load HTML snippet into divs by class name
    async function loadHTMLSnippet(basePath, className) {
        const snippetPath = `${basePath}${className}.html`; // Construct the file path

        try {
            const response = await fetch(snippetPath);
            if (!response.ok) {
                throw new Error(`HTTP error! status: ${response.status}`);
            }
            const html = await response.text();
            // Query all elements with the specified class and inject the HTML
            document.querySelectorAll('.' + className).forEach(element => {
                element.innerHTML = html;
            });
        } catch (e) {
            console.error('Error loading the HTML snippet: ', e);
        }
    }

    // List of class names to load snippets for game status
    const gameStatusClassNames =
        [
            'aio-hwid-status',
            'exozone-eft-status',
            'nextcheat-eft-status',
            'fec-apex-status',
            'fec-bf2042-status',
            'fec-cod-status',
            'fec-cs2-status',
            'fec-fortnite-status',
            'klar-r6-lite-status',
            'klar-r6-pro-status',
            'qc-rust-ext-status',
            'qc-rust-int-status',
            'qc-rust-priv-status',
            'evade-rust-status',
            'fl-rust-status',
            'qc-hwid-status',
            'rainy-rust-status',
            'vsync-hwid-status',
            'bwh-val-glow-status',
            'private-val-status',
            'vsync-val-legit-status',
            'vsync-val-pro-status',
            'vsync-val-unlock-status',
            'wrath-apex-status',
        ];

    // List of class names to load snippets for status
    const statusClassNames =
        [
            'ud',
            'risky',
            'detected',
            'up',
            'updating',
            'offline',
        ];

    // Load game status snippets first
    async function loadGameStatusSnippets() {
        for (const className of gameStatusClassNames) {
            await loadHTMLSnippet('/js/html-snippets/game-status/', className);
        }
    }

    // Load status snippets after game status
    async function loadStatusSnippets() {
        for (const className of statusClassNames) {
            await loadHTMLSnippet('/js/html-snippets/game-status/status/', className);
        }
    }

    // Load snippets in sequence
    (async function loadSnippets() {
        await loadGameStatusSnippets();
        await loadStatusSnippets();
    })();
});
