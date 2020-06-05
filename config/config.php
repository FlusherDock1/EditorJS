<?php

return [
    'scripts' => [
        '/plugins/reazzon/editor/formwidgets/editorjs/assets/js/vendor.js',
        '/plugins/reazzon/editor/formwidgets/editorjs/assets/js/tools/link.js',
        '/plugins/reazzon/editor/formwidgets/editorjs/assets/js/tools/list.js',
        '/plugins/reazzon/editor/formwidgets/editorjs/assets/js/tools/header.js',
        '/plugins/reazzon/editor/formwidgets/editorjs/assets/js/tools/code.js',
        '/plugins/reazzon/editor/formwidgets/editorjs/assets/js/tools/table.js',
        '/plugins/reazzon/editor/formwidgets/editorjs/assets/js/tools/checklist.js',
        '/plugins/reazzon/editor/formwidgets/editorjs/assets/js/tools/marker.js',
        '/plugins/reazzon/editor/formwidgets/editorjs/assets/js/tools/embed.js',
        '/plugins/reazzon/editor/formwidgets/editorjs/assets/js/tools/raw.js',
        '/plugins/reazzon/editor/formwidgets/editorjs/assets/js/tools/delimiter.js',
        '/plugins/reazzon/editor/formwidgets/editorjs/assets/js/tools/image.js',
        '/plugins/reazzon/editor/formwidgets/editorjs/assets/js/editor.js',
    ],
    'toolSettings' => [
        'header' => [
            'class' => 'Header',
            'shortcut' => 'CMD+SHIFT+H',
        ],
        'Marker' => [
            'class' => 'Marker',
            'shortcut' => 'CMD+SHIFT+M',
        ],
        'image' => [
            'class' => 'ImageTool',
            'config' => [
                'endpoints' => [
                    'byFile' => '/editorjs/plugins/image/uploadFile',
                    'byUrl' => '/editorjs/plugins/image/fetchUrl',
                ]
            ]
        ],
        'linkTool' => [
            'class' => 'LinkTool',
            'config' => [
                'endpoint' => '/editorjs/plugins/linktool',
            ]
        ],
        'list' => [
            'class' => 'List',
            'inlineToolbar' => true,
        ],
        'checklist' => [
            'class' => 'Checklist',
            'inlineToolbar' => true,
        ],
        'table' => [
            'class' => 'Table',
            'inlineToolbar' => true,
            'config' => [
                'rows' => 2,
                'cols' => 3,
            ],
        ],
        'code' => [
            'class' => 'CodeTool',
        ],
        'embed' => [
            'class' => 'Embed',
        ],
//        'raw' => [
//            'class' => 'RawTool'
//        ],
//        'delimiter' => [
//            'class' => 'Delimiter'
//        ],
    ],
    'validationSettings' => [
        'tools' => [
            'header' => [
                'text' => [
                    'type' => 'string',
                ],
                'level' => [
                    'type' => 'int',
                    'canBeOnly' => [1, 2, 3, 4, 5]
                ]
            ],
            'paragraph' => [
                'text' => [
                    'type' => 'string',
                    'allowedTags' => 'i,b,u,a[href],span[class],code[class],mark[class]'
                ]
            ],
            'list' => [
                'style' => [
                    'type' => 'string',
                    'canBeOnly' =>
                        [
                            0 => 'ordered',
                            1 => 'unordered',
                        ],
                ],
                'items' => [
                    'type' => 'array',
                    'data' => [
                        '-' => [
                            'type' => 'string',
                            'allowedTags' => 'i,b,u',
                        ],
                    ],
                ],
            ],
            'image' => [
                'file' => [
                    'type' => 'array',
                    'data' => [
                        'url' => [
                            'type' => 'string',
                        ],
                        'thumbnails' => [
                            'type' => 'array',
                            'required' => false,
                            'data' => [
                                '-' => [
                                    'type' => 'string',
                                ]
                            ],
                        ]
                    ],
                ],
                'caption' => [
                    'type' => 'string'
                ],
                'withBorder' => [
                    'type' => 'boolean'
                ],
                'withBackground' => [
                    'type' => 'boolean'
                ],
                'stretched' => [
                    'type' => 'boolean'
                ]
            ],
            'code' => [
                'code' => [
                    'type' => 'string'
                ]
            ],
            'linkTool' => [
                'link' => [
                    'type' => 'string'
                ],
                'meta' => [
                    'type' => 'array',
                    'data' => [
                        'title' => [
                            'type' => 'string',
                        ],
                        'description' => [
                            'type' => 'string',
                        ],
                        'image' => [
                            'type' => 'array',
                            'data' => [
                                'url' => [
                                    'type' => 'string',
                                ],
                            ]
                        ]
                    ]
                ]
            ],
            'checklist' => [
                'items' => [
                    'type' => 'array',
                    'data' => [
                        '-' => [
                            'type' => 'array',
                            'data' => [
                                'text' => [
                                    'type' => 'string',
                                    'required' => false
                                ],
                                'checked' => [
                                    'type' => 'boolean',
                                    'required' => false
                                ],
                            ],

                        ],
                    ],
                ],
            ],
            'delimiter' => [

            ],
            'table' => [
                'content' => [
                    'type' => 'array',
                    'data' => [
                        '-' => [
                            'type' => 'array',
                            'data' => [
                                '-' => [
                                    'type' => 'string',
                                ]
                            ]
                        ]
                    ]
                ]
            ],
            'raw' => [
                'html' => [
                    'type' => 'string',
                    'allowedTags' => '*',
                ]
            ],
            'embed' => [
                'service' => [
                    'type' => 'string'
                ],
                'source' => [
                    'type' => 'string'
                ],
                'embed' => [
                    'type' => 'string'
                ],
                'width' => [
                    'type' => 'int'
                ],
                'height' => [
                    'type' => 'int'
                ],
                'caption' => [
                    'type' => 'string',
                    'required' => false,
                ],
            ]
        ]
    ]
];
