<?php
return [
    'plugin' => [
        'name' => 'Editor',
        'description' => 'Блочный редактор следующего поколения.'
    ],
    'permission' => [
        'access_settings' => 'Управление настройками плагина'
    ],
    'settings' => [
        'menu_label' => 'Настройки Editor',
        'menu_description' => 'Управление интеграциями, и т.д.',
        'tab' => [
            'integrations' => [
                'name' => 'Интеграции',
                'warning' => [
                    'title' => 'Важно!',
                    'text' => 'Не рекомендуется заменять визуальный редактор у плагинов, где уже существует контент, 
                               так как Editor вероятнее всего сможет затереть их. Рекомендуется включать интеграции только на свежую установку системы!'
                ],
                'static_pages' => [
                    'name' => 'RainLab.StaticPages интеграция',
                    'comment' => 'Замена стандартного визуального редактора у поля `markup` на Editor.',
                ],
                'blog' => [
                    'name' => 'RainLab.Blog интеграция',
                    'comment' => 'Замена стандартного визуального редактора у поля `content` на Editor.'
                ],
                'good_news' => [
                    'name' => 'Lovata.GoodNews интеграция',
                    'comment' => 'Замена стандартного визуального редактора у поля `content` на Editor.'
                ],
                'indikator_news' => [
                    'name' => 'Indikator.News интеграция',
                    'comment' => 'Замена стандартного визуального редактора у поля `content` на Editor. Используйте тег `content_render` для вывода статьи',
                ],
                'section_standard' => [
                    'name' => 'Стандартные плагины'
                ],
                'section_custom' => [
                    'name' => 'Сторонние плагины'
                ]
            ]
        ]
    ]
];