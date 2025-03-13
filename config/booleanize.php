<?php

/*
 * This file is a part of package t-co-labs/booleanize
 *
 * (c) T.Labs & Co.
 * Contact for Work: T. <hongty.huynh@gmail.com>
 *
 * We're PHP and Laravel whizzes, and we'd love to work with you! We can:
 *  - Design the perfect fit solution for your app.
 *  - Make your code cleaner and faster.
 *  - Refactoring and Optimize performance.
 *  - Ensure Laravel best practices are followed.
 *  - Provide expert Laravel support.
 *  - Review code and Quality Assurance.
 *  - Offer team and project leadership.
 *  - Delivery Manager
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
// config for TLabsCo/Booleanize
return [
    /*
     * this configuration will set auto-couple mapping for boolean value when you call convert
     * Ex:
     * 'default' => [
            'true' => 'y',
            'false' => 'n'
        ],
     *  then you call convert with TRUE value will return 'y' and same for FALSE will return 'n'
     */
    'default' => [
        'true' => true,
        'false' => false,
    ],
    'values' => [
        'true' => [
            'y',
            'yes',
            'active',
            'enable',
            'on',
            '1',
            'true',
            1,
            true,
            'good',
            'ok',
        ],
        'false' => [
            'n',
            'no',
            'inactive',
            'disable',
            'off',
            '0',
            'false',
            0,
            false,
            'bad',
            'not_ok',
        ],
        'map' => [
            ['y' => 'n'],
            ['yes' => 'no'],
            ['active' => 'inactive'],
            ['enable' => 'disable'],
            ['on' => 'off'],
            // NOTE: can not config for fixed couple - PHP array index bool auto casting
            // ['1' => '0'], [1 => 0], [true => false],
            ['true' => 'false'],
            ['good' => 'bad'],
            ['ok' => 'not_ok'],
        ],
        'human' => [
            'true' => ['Yes, I agree'],
            'false' => ['No, I don\'t'],
            'unknown' => ['Yes or No depend on your mind'],
        ],
    ],
    'types' => [
        'allow' => ['boolean', 'integer', 'double', 'string', 'array', 'object', 'NULL'],
        'null_as' => false,
        'object_as' => true,
        'object_empty_as' => false,
        'array_as' => true,
        'array_empty_as' => false,
        'other_as' => 'exception',
    ],
];
