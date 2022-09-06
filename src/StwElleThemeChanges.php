<?php declare(strict_types=1);

namespace StwElleThemeChanges;

use Shopware\Core\Framework\Plugin;
use Shopware\Core\Framework\Plugin\Context\InstallContext;
use Shopware\Core\Framework\Plugin\Context\UninstallContext;
use StwElleThemeChanges\Setup\Installer;
use StwElleThemeChanges\Setup\Uninstaller;
use Doctrine\DBAL\Connection;

class StwElleThemeChanges extends Plugin
{
    public function install(InstallContext $installContext): void
    {
        $installer = new Installer(
            $this->container->get(Connection::class),
            $this->container
        );

        $installer->install();
    }

    public function uninstall(UninstallContext $context): void
    {
        $unInstaller = new Uninstaller(
            $this->container->get(Connection::class),
            $this->container
        );

        $unInstaller->uninstall($context);
    }
}