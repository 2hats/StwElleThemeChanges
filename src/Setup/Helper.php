<?php

declare(strict_types=1);

namespace StwElleThemeChanges\Setup;

use Doctrine\DBAL\Connection;
use Shopware\Core\Framework\Uuid\Uuid;
use Shopware\Core\Defaults;
use Shopware\Core\System\CustomField\CustomFieldTypes;

class Helper
{
    /**
     * @var Connection
     */
    protected $connection;

    /**
     * Installer constructor.
     *
     * @param Connection                $connection
     */
    public function __construct(Connection $connection)
    {
        $this->connection = $connection;
    }



    public function prepareElleCategoryCustomMenuIcons()
    {
        $id = Uuid::randomHex();
        $attributeSet = [
            'id' => $id,
            'name' => 'elle_custom_menu_icons',
            'config' => [
                'label' => [
                    'en-GB' => 'Elle - Menu icons',
                    'de-DE' => 'Elle - Menüsymbole',
                ]
            ],
            'customFields' => [
                [
                    'id' => Uuid::randomHex(),
                    'name' => 'menu_icon',
                    'type' => 'image',
                    'config' => [
                        'label' => [
                            'en-GB' => 'Icon',
                            'de-DE' => 'Symbole',
                        ],
                        'componentName' => 'sw-media-field',
                        'customFieldType' => 'media',
                        'customFieldPosition' => 1,
                    ],
                ],
            ],
            'relations' => [
                [
                    'entityName' => 'category',
                ],
            ],
        ];
        return $attributeSet;
    }

    public function prepareElleCategoryCustomStyles()
    {
        $id = Uuid::randomHex();
        $attributeSet = [
            'id' => $id,
            'name' => 'elle_custom_category_layout',
            'config' => [
                'label' => [
                    'en-GB' => 'Layout Settings',
                    'de-DE' => 'Layouteinstellungen',
                ]
            ],
            'customFields' => [
                [
                    'id' => Uuid::randomHex(),
                    'name' => 'breadscrub',
                    'type' => 'select',
                    
                    'config' => [
                        'label' => [
                            'en-GB' => 'Breadcrumb Style',
                            'de-DE' => 'Breadcrumb-Layout',
                        ],
                        'options' => [
                            [
                                'label' => [
                                    'en-GB' => 'Default',
                                    'de-DE' => 'Standard',
                                ],
                                'value' => 'breadcrumb_default',
                            ],
                            [
                                'label' => [
                                    'en-GB' => 'White Style',
                                    'de-DE' => 'Weißer Stil',
                                ],
                                'value' => 'breadcrumb_white',
                            ],
                            
                        ],
                        'componentName' => 'sw-single-select',
                        'customFieldType' => 'media',
                        'customFieldPosition' => 1,
                    ],
                ],
            ],
            'relations' => [
                [
                    'entityName' => 'category',
                ],
            ],
        ];
        return $attributeSet;
    }
}
