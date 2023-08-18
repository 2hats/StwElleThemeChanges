<?php declare(strict_types=1);

namespace StwElleThemeChanges\Setup;

use Doctrine\DBAL\Connection;
use Shopware\Core\Framework\Plugin\Context\UninstallContext;
use Shopware\Core\Framework\Uuid\Uuid;
use Shopware\Core\Framework\Context;
use Shopware\Core\Framework\DataAbstractionLayer\Search\Criteria;
use Shopware\Core\Framework\DataAbstractionLayer\Search\Filter\EqualsFilter;
use Symfony\Component\DependencyInjection\ContainerInterface;

class Uninstaller
{
    /**
     * @var Connection
     */
    protected $connection;
    
    /**
     * @var ContainerInterface
     */
    protected $container;

    /**
     * Installer constructor.
     *
     * @param Connection                $connection
     */
    public function __construct(Connection $connection, ContainerInterface $container) 
    {
        $this->connection = $connection;
        $this->container = $container;

    }

    /**
     * @param UninstallContext $uninstallContext
     */
    public function uninstall(UninstallContext $uninstallContext)
    {
         
        if ($uninstallContext->keepUserData()) {
            return;
        }
        
        $customFieldSetRepo = $this->container->get('custom_field_set.repository');

        $elle_custom_menu_icons = $this->fetchCustomFieldSetId('elle_custom_menu_icons');
        if ($this->checkValidUuid($elle_custom_menu_icons)) {
            $customFieldSetRepo->delete([['id' => $elle_custom_menu_icons]], Context::createDefaultContext());
        } 
        $elle_custom_category_layout = $this->fetchCustomFieldSetId('elle_custom_category_layout');
        if ($this->checkValidUuid($elle_custom_category_layout)) {
            $customFieldSetRepo->delete([['id' => $elle_custom_category_layout]], Context::createDefaultContext());
        } 

        return true;
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

    public function checkValidUuid($id)
    {
        if (!empty($id)) {
            if (Uuid::isValid($id)) {
                return true;
            }
        }

        return false;
    }

}