<?php

class DatabaseInstaller {

    private $sql_file_path;
    private $wpdb;

    public function __construct() {
        global $wpdb;
        $this->wpdb = $wpdb;
        $this->sql_file_path = plugin_dir_path(__FILE__) . 'database/bravefactor.sql';
    }

    public function restore_and_replace() {
        // Check if the SQL file exists
        if (!file_exists($this->sql_file_path)) {
            return "Error: SQL file doesn't exist.";
        }
    
        // Read the SQL file
        $sql = file_get_contents($this->sql_file_path);
    
        // Replace the old prefix with the current WordPress table prefix
        $old_prefix = 'uqh_';  // Replace with the prefix from bravefactor.sql
        $sql = str_replace($old_prefix, $this->wpdb->prefix, $sql);
    
        // Split SQL into individual queries
        $queries = explode(';', $sql);
    
        // Execute the adjusted queries, excluding wp_users and wp_usermeta
        try {
            foreach ($queries as $query) {
                // Check if the query is related to users or usermeta table
                if (strpos($query, $this->wpdb->prefix . 'users') === false && strpos($query, $this->wpdb->prefix . 'usermeta') === false && trim($query)) {
                    $this->wpdb->query($query);
                }
            }
        } catch (Exception $e) {
            return "Error executing SQL: " . $e->getMessage();
        }
    
        return "Database restored successfully with wp_users and wp_usermeta excluded!";
    }
    
}
