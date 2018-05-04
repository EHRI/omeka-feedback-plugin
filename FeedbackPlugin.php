<?php
/**
 * Feedback Plugin
 *
 * @copyright Copyright 2017 King's College London, Department of Digital Humanities
 * @license http://www.gnu.org/licenses/gpl-3.0.txt GNU GPLv3
 */

/**
 * Feedback plugin.
 */
class FeedbackPlugin extends Omeka_Plugin_AbstractPlugin
{
    /**
     * @var array Hooks for the plugin.
     */
    protected $_hooks = array('install', 'uninstall', 'upgrade', 'initialize',
        'define_acl', 'define_routes', 'config_form', 'config');

    /**
     * @var array Filters for the plugin.
     */
    protected $_filters = array(
        'admin_navigation_main',
    );

    /**
     * @var array Options and their default values.
     */
    protected $_options = array();

    /**
     * Install the plugin.
     * @throws Exception
     */
    public function hookInstall()
    {

        $this->_db->query(<<<SQL
        CREATE TABLE IF NOT EXISTS {$this->_db->prefix}feedback_items (
            id          int(10) unsigned NOT NULL auto_increment,
            email       varchar(255) NOT NULL,
            url         text collate utf8_unicode_ci NOT NULL,
            title       mediumtext collate utf8_unicode_ci NOT NULL,
            feedback    mediumtext collate utf8_unicode_ci NOT NULL,
            created     timestamp NOT NULL DEFAULT NOW(),            
            PRIMARY KEY (id)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
SQL
        );

        $this->_installOptions();
    }

    /**
     * Uninstall the plugin.
     */
    public function hookUninstall()
    {
        $this->_db->query(
            "DROP TABLE IF EXISTS {$this->_db->prefix}feedback_items");

        $this->_uninstallOptions();
    }

    /**
     * Upgrade the plugin.
     *
     * @param array $args contains: 'old_version' and 'new_version'
     */
    public function hookUpgrade($args)
    {
    }

    /**
     * Add the translations.
     */
    public function hookInitialize()
    {
    }

    public function hookDefineRoutes($args)
    {
        $args['router']->addConfig(new Zend_Config_Ini(
                dirname(__FILE__) . "/routes.ini")
        );
    }

    /**
     * Display the plugin config form.
     */
    public function hookConfigForm()
    {
        require dirname(__FILE__) . '/config_form.php';
    }

    /**
     * Define the ACL.
     *
     * @param Omeka_Acl
     */
    public function hookDefineAcl($args)
    {
        $acl = $args['acl'];

        $mappingResource = new Zend_Acl_Resource('Feedback_FeedbackItem');
        $acl->add($mappingResource);
    }

    /**
     * Set the options from the config form input.
     */
    public function hookConfig()
    {
        set_option('feedback_notification_sender', $_POST['feedback_notification_sender']);
        set_option('feedback_recipient_emails', $_POST['feedback_recipient_emails']);
    }

    public function hookPublicHead($args)
    {
        queue_css_file('feedback', $media = "all", $conditional = false, $dir = 'css');
        queue_js_file("feedback", $dir = "js");
    }

    /**
     * Add a link to the administrative navigation bar.
     *
     * @param array $nav The array of label/URI pairs.
     * @return array
     */
    public function filterAdminNavigationMain($nav)
    {
        $nav[] = array(
            'label' => __('Feedback'),
            'uri' => url('feedback')
        );
        return $nav;
    }
}
