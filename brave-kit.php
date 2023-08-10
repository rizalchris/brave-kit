<?php

/*
Plugin Name: Brave Kit
Description: Installs the bravefactor-theme and required plugins, and provides database restoration tools.
Version: 1.0
Author: Brave Factor
*/

require_once plugin_dir_path(__FILE__) . 'installers.php';
require_once plugin_dir_path(__FILE__) . 'database.php';

class BraveKit {
    private $installer;
    private $dbInstaller;

    public function __construct() {
        $this->installer = new BraveKitInstallers();
        $this->dbInstaller = new DatabaseInstaller();
        
        register_activation_hook(__FILE__, [$this->installer, 'install_bravefactor_theme']);
        register_activation_hook(__FILE__, [$this->installer, 'install_required_plugins']);
        register_activation_hook(__FILE__, [$this->dbInstaller, 'restore_and_replace']);
    }
}

// Initialize the class
new BraveKit();