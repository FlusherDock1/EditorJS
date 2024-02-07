const fs = require('fs');

// destination will be created or overwritten by default.

const tools = [
    'paragraph',
    'header',
    'table',
    'raw',
    'quote',
    'image',
    'attaches',
    'list',
    'delimiter',
    'code',
    'warning',
    'embed',
    'marker',
    'underline',
    'inline-code'
];

tools.forEach((toolName) => {
    let filePath = `./node_modules/@editorjs/${toolName}/dist/${toolName}.umd.js`;
    if (!fs.existsSync(filePath)) {
        filePath = `./node_modules/@editorjs/${toolName}/dist/bundle.js`
    }
    fs.copyFile(filePath, `./js/${toolName}Tool.js`, (err) => {
        if (err) { throw err; }
        console.log(`${toolName} was copied to js folder`);
    });
});

