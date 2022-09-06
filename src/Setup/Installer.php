<?php

declare(strict_types=1);

namespace StwElleThemeChanges\Setup;

use Doctrine\DBAL\Connection;
use StwElleThemeChanges\Setup\Helper;
use Shopware\Core\Framework\Context;
use Shopware\Core\Framework\DataAbstractionLayer\Search\Criteria;
use Shopware\Core\Framework\DataAbstractionLayer\Search\Filter\EqualsFilter;
use Symfony\Component\DependencyInjection\ContainerInterface;


class Installer
{
    /**
     * @var Connection
     */
    protected $connection;

    /**
     * @var Helper
     */
    private $helper;

    /**
     * Installer constructor.
     *
     * @param Connection                $connection
     */

    /**
     * @var ContainerInterface
     */
    protected $container;

    public function __construct(Connection $connection, ContainerInterface $container)
    {
        $this->connection = $connection;
        $this->helper = new Helper($connection);
        $this->container = $container;
    }

    public function install()
    { 
        $elleCustomMenuIcons = $this->fetchCustomFieldSetId('elle_custom_menu_icons');
        if (!$elleCustomMenuIcons) {
            $repo = $this->container->get('custom_field_set.repository');
            $attributeSet = $this->helper->prepareElleCategoryCustomMenuIcons();
            $repo->create([$attributeSet], Context::createDefaultContext());
        }

        
        return false;
    }

    private function fetchCustomFieldSetId($technicalName)
    {
        $customFieldSetRepo = $this->container->get('custom_field_set.repository');

        $criteria = (new Criteria())
            ->addFilter(new EqualsFilter('custom_field_set.name', $technicalName));

        $result = $customFieldSetRepo->search($criteria, Context::createDefaultContext());

        $customFieldSetDetails = $result->first();

        return ($customFieldSetDetails) ? $customFieldSetDetails->getId() : null;
    }
}
