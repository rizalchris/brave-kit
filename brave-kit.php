<?php

/*
Plugin Name: Brave Kit
Description: Installs the bravefactor-theme and required plugins.
Version: 1.0
Author: Brave
*/

require_once plugin_dir_path(__FILE__) . 'installers.php';

class BraveKit {
    private $installer;

    public function __construct() {
        $this->installer = new BraveKitInstallers();
        
        register_activation_hook(__FILE__, [$this->installer, 'install_bravefactor_theme']);
        register_activation_hook(__FILE__, [$this->installer, 'install_required_plugins']);
    }
}

// Initialize the class
new BraveKit();
