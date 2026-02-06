<?php

/**
 * SVG Icons Trait
 * 
 * Centralized SVG icon library for the Magical Posts Display plugin
 * Contains all SVG icons used throughout the plugin
 * 
 * @package MagicalPostsDisplay
 * @since 1.2.54
 */

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

trait SVG_Icons_Trait
{
    /**
     * Get Reading Time Clock Icon
     * 
     * @param int $size Icon size in pixels (default: 16)
     * @return string SVG icon markup
     */
    protected function get_reading_time_icon($size = 16)
    {
        return '<svg width="' . esc_attr($size) . '" height="' . esc_attr($size) . '" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <circle cx="12" cy="12" r="10"/>
            <path d="M12 6v6l4 2"/>
        </svg>';
    }

    /**
     * Get View Count Eye Icon
     * 
     * @param int $size Icon size in pixels (default: 16)
     * @return string SVG icon markup
     */
    protected function get_view_count_icon($size = 16)
    {
        return '<svg width="' . esc_attr($size) . '" height="' . esc_attr($size) . '" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/>
            <circle cx="12" cy="12" r="3"/>
        </svg>';
    }

    /**
     * Get Facebook Icon
     * 
     * @param int $size Icon size in pixels (default: 20)
     * @return string SVG icon markup
     */
    protected function get_facebook_icon($size = 20)
    {
        return '<svg width="' . esc_attr($size) . '" height="' . esc_attr($size) . '" viewBox="0 0 24 24" fill="currentColor">
            <path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/>
        </svg>';
    }

    /**
     * Get X (Twitter) Icon
     * 
     * @param int $size Icon size in pixels (default: 20)
     * @return string SVG icon markup
     */
    protected function get_twitter_icon($size = 20)
    {
        return '<svg width="' . esc_attr($size) . '" height="' . esc_attr($size) . '" viewBox="0 0 24 24" fill="currentColor">
            <path d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-5.214-6.817L4.99 21.75H1.68l7.73-8.835L1.254 2.25H8.08l4.713 6.231zm-1.161 17.52h1.833L7.084 4.126H5.117z"/>
        </svg>';
    }

    /**
     * Get LinkedIn Icon
     * 
     * @param int $size Icon size in pixels (default: 20)
     * @return string SVG icon markup
     */
    protected function get_linkedin_icon($size = 20)
    {
        return '<svg width="' . esc_attr($size) . '" height="' . esc_attr($size) . '" viewBox="0 0 24 24" fill="currentColor">
            <path d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433c-1.144 0-2.063-.926-2.063-2.065 0-1.138.92-2.063 2.063-2.063 1.14 0 2.064.925 2.064 2.063 0 1.139-.925 2.065-2.064 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z"/>
        </svg>';
    }

    /**
     * Get Pinterest Icon
     * 
     * @param int $size Icon size in pixels (default: 20)
     * @return string SVG icon markup
     */
    protected function get_pinterest_icon($size = 20)
    {
        return '<svg width="' . esc_attr($size) . '" height="' . esc_attr($size) . '" viewBox="0 0 24 24" fill="currentColor">
            <path d="M12.017 0C5.396 0 .029 5.367.029 11.987c0 5.079 3.158 9.417 7.618 11.174-.105-.949-.199-2.403.041-3.439.219-.937 1.406-5.957 1.406-5.957s-.359-.72-.359-1.781c0-1.663.967-2.911 2.168-2.911 1.024 0 1.518.769 1.518 1.688 0 1.029-.653 2.567-.992 3.992-.285 1.193.6 2.165 1.775 2.165 2.128 0 3.768-2.245 3.768-5.487 0-2.861-2.063-4.869-5.008-4.869-3.41 0-5.409 2.562-5.409 5.199 0 1.033.394 2.143.889 2.741.099.12.112.225.085.345-.09.375-.293 1.199-.334 1.363-.053.225-.172.271-.402.165-1.495-.69-2.433-2.878-2.433-4.646 0-3.776 2.748-7.252 7.92-7.252 4.158 0 7.392 2.967 7.392 6.923 0 4.135-2.607 7.462-6.233 7.462-1.214 0-2.357-.629-2.749-1.378 0 0-.599 2.282-.744 2.84-.282 1.084-1.064 2.456-1.549 3.235C9.584 23.815 10.77 24.001 12.017 24.001c6.624 0 11.99-5.367 11.99-11.987C24.007 5.367 18.641.001 12.017.001z"/>
        </svg>';
    }

    /**
     * Get Instagram Icon
     * 
     * @param int $size Icon size in pixels (default: 20)
     * @return string SVG icon markup
     */
    protected function get_instagram_icon($size = 20)
    {
        return '<svg width="' . esc_attr($size) . '" height="' . esc_attr($size) . '" viewBox="0 0 24 24" fill="currentColor">
            <path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/>
        </svg>';
    }

    /**
     * Get Video Play Icon
     * 
     * @param int $size Icon size in pixels (default: 48)
     * @return string SVG icon markup
     */
    protected function get_video_play_icon($size = 48)
    {
        return '<svg width="' . esc_attr($size) . '" height="' . esc_attr($size) . '" viewBox="0 0 24 24" fill="currentColor" class="mgpd-play-icon">
            <circle cx="12" cy="12" r="12" fill="rgba(0,0,0,0.6)"/>
            <polygon points="9,6 9,18 18,12" fill="white"/>
        </svg>';
    }
    /**
     * Get time Icon
     * 
     * @param int $size Icon size in pixels (default: 48)
     * @return string SVG icon markup
     */
    protected function get_time_icon($size = 24)
    {
        return '<svg width="' . esc_attr($size) . '" height="' . esc_attr($size) . '" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
			<rect x="3" y="4" width="18" height="18" rx="2" ry="2" />
					<line x1="16" y1="2" x2="16" y2="6" />
					<line x1="8" y1="2" x2="8" y2="6" />
					<line x1="3" y1="10" x2="21" y1="10" />
		</svg>';
    }
    /**
     * Get loading Icon
     * 
     * @param int $size Icon size in pixels (default: 40)
     * @return string SVG icon markup
     */
    protected function get_loading_spinner_icon($size = 40)
    {
        return '<svg class="mgpd-spinner" width="' . esc_attr($size) . '" height="' . esc_attr($size) . '" viewBox="0 0 50 50" style="animation: spin 1s linear infinite;"><circle cx="25" cy="25" r="20" fill="none" stroke="currentColor" stroke-width="4" stroke-dasharray="31.4 31.4" stroke-linecap="round"></circle></svg>';
    }

    /**
     * Get all social media icons as an array
     * 
     * @param int $size Icon size in pixels (default: 20)
     * @return array Associative array of social platform => SVG markup
     */
    protected function get_all_social_icons($size = 20)
    {
        return array(
            'facebook' => $this->get_facebook_icon($size),
            'twitter' => $this->get_twitter_icon($size),
            'linkedin' => $this->get_linkedin_icon($size),
            'pinterest' => $this->get_pinterest_icon($size),
            'instagram' => $this->get_instagram_icon($size),
        );
    }

    /**
     * Get social share button with icon
     * 
     * @param string $platform Social media platform (facebook, twitter, linkedin, pinterest, instagram)
     * @param string $url URL to share
     * @param string $title Title to share (for twitter, pinterest)
     * @param int $size Icon size in pixels (default: 20)
     * @return string Complete anchor tag with SVG icon
     */
    protected function get_social_share_button($platform, $url, $title = '', $size = 20)
    {
        $encoded_url = urlencode($url);
        $encoded_title = urlencode($title);

        $share_urls = array(
            'facebook' => 'https://www.facebook.com/sharer/sharer.php?u=' . $encoded_url,
            'twitter' => 'https://x.com/intent/tweet?url=' . $encoded_url . '&text=' . $encoded_title,
            'linkedin' => 'https://www.linkedin.com/sharing/share-offsite/?url=' . $encoded_url,
            'pinterest' => 'https://pinterest.com/pin/create/button/?url=' . $encoded_url . '&description=' . $encoded_title,
            'instagram' => 'https://www.instagram.com/sharer.php?u=' . $encoded_url,
        );

        $icon_methods = array(
            'facebook' => 'get_facebook_icon',
            'twitter' => 'get_twitter_icon',
            'linkedin' => 'get_linkedin_icon',
            'pinterest' => 'get_pinterest_icon',
            'instagram' => 'get_instagram_icon',
        );

        if (!isset($share_urls[$platform]) || !isset($icon_methods[$platform])) {
            return '';
        }

        $icon = $this->{$icon_methods[$platform]}($size);
        $share_url = $share_urls[$platform];

        return '<a href="' . esc_url($share_url) . '" target="_blank" class="mgpd-share-' . esc_attr($platform) . '">' . $icon . '</a>';
    }

    /**
     * Get all social share buttons
     * 
     * @param string $url URL to share
     * @param string $title Title to share
     * @param array $platforms Array of platforms to include (default: all)
     * @param int $size Icon size in pixels (default: 20)
     * @return string HTML markup for all social share buttons
     */
    protected function get_all_social_share_buttons($url, $title = '', $platforms = null, $size = 20)
    {
        if ($platforms === null) {
            $platforms = array('facebook', 'twitter', 'linkedin', 'pinterest', 'instagram');
        }

        $output = '';
        foreach ($platforms as $platform) {
            $output .= $this->get_social_share_button($platform, $url, $title, $size);
        }

        return $output;
    }
}
