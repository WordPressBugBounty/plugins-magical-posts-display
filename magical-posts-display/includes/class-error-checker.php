<?php

/**
 * PHP Error Check and Fix Script
 * 
 * This script checks for common PHP errors in the reorganized plugin
 * and provides fixes for any issues found.
 * 
 * @package Magical Posts Display
 * @since 1.2.54
 */

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

class MPD_Error_Checker
{
    private $errors = [];
    private $warnings = [];
    private $fixes_applied = [];

    /**
     * Run comprehensive error checks
     */
    public function run_checks()
    {
        $this->check_class_method_consistency();
        $this->check_file_includes();
        $this->check_function_calls();
        $this->check_class_initializations();
        $this->generate_report();
    }

    /**
     * Check for missing methods referenced in hooks
     */
    private function check_class_method_consistency()
    {
        // Check main plugin class
        $main_file = MAGICAL_POSTS_DISPLAY_DIR . 'magical-posts-display.php';
        if (file_exists($main_file)) {
            $content = file_get_contents($main_file);

            // Check for method calls that might be missing
            if (strpos($content, "[\$this, 'elementor_notice_hide_options']") !== false) {
                if (strpos($content, 'function elementor_notice_hide_options') === false) {
                    $this->errors[] = "Method 'elementor_notice_hide_options' called but not defined in main class";
                }
            }
        }
    }

    /**
     * Check for missing file includes
     */
    private function check_file_includes()
    {
        $required_files = [
            'includes/class-assets-manager.php',
            'includes/class-ajax-handler.php',
            'includes/class-hooks-handler.php',
            'file-include.php'
        ];

        foreach ($required_files as $file) {
            $full_path = MAGICAL_POSTS_DISPLAY_DIR . $file;
            if (!file_exists($full_path)) {
                $this->errors[] = "Required file missing: {$file}";
            }
        }
    }

    /**
     * Check for function calls to missing functions
     */
    private function check_function_calls()
    {
        // Check if custom functions exist
        $functions_to_check = [
            'mp_display_check_main_ok',
            'mpd_check_plugin_active'
        ];

        foreach ($functions_to_check as $function) {
            if (!function_exists($function)) {
                $this->warnings[] = "Custom function '{$function}' may not be defined yet (loaded later)";
            }
        }
    }

    /**
     * Check class initializations
     */
    private function check_class_initializations()
    {
        $classes_to_check = [
            'MPD_Assets_Manager',
            'MPD_Ajax_Handler',
            'MPD_Hooks_Handler',
            'mgpAdminInfo'
        ];

        foreach ($classes_to_check as $class) {
            if (!class_exists($class)) {
                $this->warnings[] = "Class '{$class}' not loaded yet (may be loaded later in initialization)";
            }
        }
    }

    /**
     * Generate error report
     */
    private function generate_report()
    {
        echo "<h2>🔍 PHP Error Check Results</h2>\n";

        if (empty($this->errors) && empty($this->warnings)) {
            echo "<p style='color: green;'>✅ <strong>No critical errors found!</strong></p>\n";
        }

        if (!empty($this->errors)) {
            echo "<h3 style='color: red;'>❌ Critical Errors:</h3>\n";
            foreach ($this->errors as $error) {
                echo "<p style='color: red;'>• {$error}</p>\n";
            }
        }

        if (!empty($this->warnings)) {
            echo "<h3 style='color: orange;'>⚠️ Warnings:</h3>\n";
            foreach ($this->warnings as $warning) {
                echo "<p style='color: orange;'>• {$warning}</p>\n";
            }
        }

        if (!empty($this->fixes_applied)) {
            echo "<h3 style='color: blue;'>🔧 Fixes Applied:</h3>\n";
            foreach ($this->fixes_applied as $fix) {
                echo "<p style='color: blue;'>• {$fix}</p>\n";
            }
        }
    }

    /**
     * Apply automatic fixes for common issues
     */
    public function apply_fixes()
    {
        // This would contain fix implementations
        // For now, we'll just identify issues
        return $this->fixes_applied;
    }
}

// Only run in admin context for safety
if (is_admin()) {
    // Uncomment the line below to run the error checker
    // $error_checker = new MPD_Error_Checker();
    // $error_checker->run_checks();
}
