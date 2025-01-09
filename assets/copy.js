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

const tunes = [
    'text-variant-tune'
]

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

tunes.forEach((tuneName) => {
    let filePath = `./node_modules/@editorjs/${tuneName}/dist/${tuneName}.js`;
    if (!fs.existsSync(filePath)) {
        filePath = `./node_modules/@editorjs/${tuneName}/dist/bundle.js`
    }
    fs.copyFile(filePath, `./js/${tuneName}Tune.js`, (err) => {
        if (err) { throw err; }
        console.log(`${tuneName} was copied to js folder`);
    });
});

