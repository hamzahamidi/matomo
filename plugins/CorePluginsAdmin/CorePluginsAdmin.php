<?php
/**
 * Piwik - Open source web analytics
 *
 * @link http://piwik.org
 * @license http://www.gnu.org/licenses/gpl-3.0.html GPL v3 or later
 *
 * @category Piwik_Plugins
 * @package CorePluginsAdmin
 */
namespace Piwik\Plugins\CorePluginsAdmin;

use Piwik\Piwik;

/**
 *
 * @package CorePluginsAdmin
 */
class CorePluginsAdmin extends \Piwik\Plugin
{
    /**
     * @see Piwik_Plugin::getListHooksRegistered
     */
    public function getListHooksRegistered()
    {
        return array(
            'AdminMenu.add' => 'addMenu',
            'AssetManager.getJsFiles' => 'getJsFiles',
            'AssetManager.getStylesheetFiles' => 'getStylesheetFiles',
        );
    }

    public function getStylesheetFiles($stylesheets)
    {
        $stylesheets[] = "plugins/CorePluginsAdmin/stylesheets/marketplace.less";
    }

    function addMenu()
    {
        $marketplace = new Marketplace();
        $pluginsHavingUpdate = $marketplace->getPluginsHavingUpdate($themesOnly = false);
        $themesHavingUpdate  = $marketplace->getPluginsHavingUpdate($themesOnly = true);

        $pluginsUpdateMessage = '';
        if (!empty($pluginsHavingUpdate)) {
            $pluginsUpdateMessage = sprintf(' (%d)', count($pluginsHavingUpdate));
        }

        $themesUpdateMessage = '';
        if (!empty($themesHavingUpdate)) {
            $themesUpdateMessage = sprintf(' (%d)', count($themesHavingUpdate));
        }

        Piwik_AddAdminSubMenu('CorePluginsAdmin_MenuPlatform', null, "", Piwik::isUserIsSuperUser(), $order = 15);
        Piwik_AddAdminSubMenu('CorePluginsAdmin_MenuPlatform', Piwik_Translate('General_Plugins') . $pluginsUpdateMessage,
            array('module' => 'CorePluginsAdmin', 'action' => 'plugins', 'activated' => ''),
            Piwik::isUserIsSuperUser(),
            $order = 1);
        Piwik_AddAdminSubMenu('CorePluginsAdmin_MenuPlatform', Piwik_Translate('CorePluginsAdmin_Themes') . $themesUpdateMessage,
            array('module' => 'CorePluginsAdmin', 'action' => 'themes', 'activated' => ''),
            Piwik::isUserIsSuperUser(),
            $order = 3);
        Piwik_AddAdminSubMenu('CorePluginsAdmin_MenuPlatform', 'CorePluginsAdmin_MenuExtend',
            array('module' => 'CorePluginsAdmin', 'action' => 'extend', 'activated' => ''),
            Piwik::isUserIsSuperUser(),
            $order = 5);
    }

    public function getJsFiles(&$jsFiles)
    {
        $jsFiles[] = "plugins/CoreHome/javascripts/popover.js";
        $jsFiles[] = "plugins/CorePluginsAdmin/javascripts/pluginDetail.js";
    }

}
