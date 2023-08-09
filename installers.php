<?php

class BraveKitInstallers {
    private $theme_zip_path;
    private $plugins_dir;
    private $wp_filesystem = false;

    public function __construct() {
        $this->theme_zip_path = plugin_dir_path(__FILE__) . 'theme/bravefactor-theme.zip';
        $this->plugins_dir = plugin_dir_path(__FILE__) . 'plugins/';
    }

    public function install_bravefactor_theme() {
        if (file_exists($this->theme_zip_path)) {
            $this->init_filesystem();

            $this->unzip_and_activate_theme();
        }
    }

    public function install_required_plugins() {
        $this->init_filesystem();

        foreach (glob($this->plugins_dir . '*.zip') as $plugin_zip_path) {
            $this->install_plugin($plugin_zip_path);
        }
    }

    private function init_filesystem() {
        require_once(ABSPATH . 'wp-admin/includes/file.php');
        WP_Filesystem();
        global $wp_filesystem;
        $this->wp_filesystem = $wp_filesystem;

        if (!$this->wp_filesystem) {
            throw new Exception("Unable to initialize WP Filesystem.");
        }
    }

    private function unzip_and_activate_theme() {
        $unzipfile = unzip_file($this->theme_zip_path, get_theme_root());

        if ($unzipfile) {
            switch_theme('bravefactor-theme');
        }
    }

    private function install_plugin($plugin_zip_path) {
        $destination = WP_PLUGIN_DIR;
        unzip_file($plugin_zip_path, $destination);
        // Here, you can also activate the plugin if needed
    }
}
