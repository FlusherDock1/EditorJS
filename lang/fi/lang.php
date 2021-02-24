<?php
return [
    'plugin' => [
        'name' => 'Editori',
        'description' => 'Seuraavan sukupolven blokkityylinen editori'
    ],
    'permission' => [
        'access_settings' => 'Hallinnoi plugin-asetuksia'
    ],
    'settings' => [
        'menu_label' => 'Editorin asetukset',
        'menu_description' => 'Hallitse integraatioita.',
        'integrations' => [
            'name' => 'Integraatiot',
            'warning' => [
                'title' => 'Jatka varoen!',
                'text' => 'mikäli sinulla on tietueita alla olevissa plugineissa, tiedot voivat tuhoutua Editorin käyttöönoton yhteydessä!!! Käytä integraatioita vain uudessa asennuksessa!!!'
            ],
            'static_pages' => [
                'name' => 'RainLab.StaticPages-integraatio',
                'comment' => 'Vaihdetaan oletus richeditor `markup` kentästä tähän Editoriin.'
            ],
            'blog' => [
                'name' => 'RainLab.Blog-integraatio',
                'comment' => 'Vaihdetaan oletus richeditor `content` kentästä tähän Editoriin.'
            ],
            'good_news' => [
                'name' => 'Lovata.GoodNews-integraatio',
                'comment' => 'Vaihdetaan oletus richeditor `content` kentästä tähän Editoriin.'
            ],
            'indikator_news' => [
                'name' => 'Indikator.News-integraatio',
                'comment' => 'Vaihdetaan oletus richeditor `content` kentästä tähän Editoriin. Käytä `content_render` attribuuttia saadaksesi näkymä Editorin sisällöstä.'
            ],
            'section_standard' => [
                'name' => 'Vakio pluginit'
            ],
            'section_custom' => [
                'name' => 'Toisen osapuolen pluginit'
            ]
        ],
        'editor' => [
            'name' => 'Yleiset',
            'disable_secure_endpoints' => [
                'name' => 'Ota blokkaus pois käytöstä ulkoa tuleville EditorJS plugin pyynnöille',
                'comment' => 'Jos haluat käyttää EditorJS:ää loppukäyttäjän näkymässä, suositellaan tätä asetusta päälle.'
            ],
            'disable_secure_backendauth' => [
                'name' => 'Poista ylläpitäjän autorisointitarkastus käytöstä pyydettäessä EditorJS plugineja',
                'comment' => 'Jos haluat käyttää EditorJS:ää loppukäyttäjän näkymässä kyseisellä sivustolla, ei ole suotavaa poistaa blokkausta käytöstä.'
            ]
        ]
    ],
];
