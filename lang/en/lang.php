<?php
return [
    'plugin' => [
        'name' => 'Editor',
        'description' => 'Next generation block styled editor'
    ],
    'permission' => [
        'access_settings' => 'Manage plugin settings'
    ],
    'settings' => [
        'menu_label' => 'Editor settings',
        'menu_description' => 'Manage integrations and etc.',
        'integrations' => [
            'name' => 'Integrations',
            'warning' => [
                'title' => 'Proceed with caution!',
                'text' => 'if you already have records in plugins below, they can be corrupted after saving with Editor integration enabled!!! Use integrations only on fresh install!!!'
            ],
            'static_pages' => [
                'name' => 'RainLab.StaticPages Integration',
                'comment' => 'Switching default richeditor in `markup` field to Editor.'
            ],
            'blog' => [
                'name' => 'RainLab.Blog Integration',
                'comment' => 'Switching default richeditor in `content` field to Editor.'
            ],
            'good_news' => [
                'name' => 'Lovata.GoodNews Integration',
                'comment' => 'Switching default richeditor in `content` field to Editor.'
            ],
            'indikator_news' => [
                'name' => 'Indikator.News Integration',
                'comment' => 'Switching default richeditor in `content` field to Editor. Use `content_render` attribute to get rendered Editor content.'
            ],
            'section_standard' => [
                'name' => 'Standard plugins'
            ],
            'section_custom' => [
                'name' => 'Second party plugins'
            ]
        ],
        'editor' => [
            'name' => 'Main',
            'disable_secure_endpoints' => [
                'name' => 'Turn off blocking of external requests to EditorJS plugins',
                'comment' => 'If you want to use EditorJS on the frontend, it is recommended to enable this setting.'
            ],
            'disable_secure_backendauth' => [
                'name' => 'Disable admin authorization check when querying EditorJS plugins',
                'comment' => 'If you want to use EditorJS on the frontend and only on the current site, it is not recommended to disable blocking.'
            ]
        ]
    ],
];
