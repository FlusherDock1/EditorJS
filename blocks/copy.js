const fs = require('fs');

// destination will be created or overwritten by default.

const blocks = [
    'paragraph',
    'header',
    'table',
    'raw',
    'quote',
    'list',
    'delimiter',
    'code',
    'warning'
];

blocks.forEach((blockName) => {
    fs.copyFile(`./node_modules/@editorjs/${blockName}/dist/${blockName}.umd.js`, `./js/${blockName}Block.js`, (err) => {
        if (err) throw err;
        console.log(`${blockName} was copied to js folder`);
    });
});

