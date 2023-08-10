<?php

class DatabaseInstaller {
    private $wpdb;
    private $sql_file_path;
    private $backup_file_path;  // Path to the backup file

    public function __construct() {
        global $wpdb;
        $this->wpdb = $wpdb;
        $this->sql_file_path = plugin_dir_path(__FILE__) . 'database/bravefactor.sql';
    }

    public function restore_database() {
        // Check if the SQL file exists
        if (!file_exists($this->sql_file_path)) {
            return "Error: SQL file doesn't exist.";
        }
    
        // Read the SQL file
        $sql = file_get_contents($this->sql_file_path);
    
        // Split SQL into individual queries
        $queries = explode(';', $sql);
    
        // Execute each query
        foreach ($queries as $query) {
            if (trim($query) && 
                strpos($query, $this->wpdb->prefix . 'users') === false && 
                strpos($query, $this->wpdb->prefix . 'usermeta') === false) {
                
                $this->wpdb->query($query);
            }
        }
    
        return "Database restored successfully with exclusions!";
    }    
    
}
