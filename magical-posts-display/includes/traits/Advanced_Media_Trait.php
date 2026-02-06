<?php
/**
 * Advanced Media Trait
 * 
 * Reusable trait for advanced media source functionality
 * Supports featured images, content images, video embeds, and priority fallback
 * 
 * @package Magical Posts Display
 * @since 1.2.55
 */

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

trait Advanced_Media_Trait {
    
    /**
     * Get media based on advanced source settings
     * 
     * @param int $post_id Post ID
     * @param array $settings Widget settings
     * @return string HTML output
     */
    public function get_advanced_media($post_id, $settings = []) {
        $media_source = isset($settings['mgpg_media_source']) ? $settings['mgpg_media_source'] : 'featured';
        $show_play_icon = isset($settings['mgpg_video_play_icon']) ? $settings['mgpg_video_play_icon'] : 'yes';
        
        $output = '';
        
        switch ($media_source) {
            case 'content':
                $output = $this->get_content_image($post_id);
                break;
                
            case 'video':
                $output = $this->get_video_embed($post_id, $show_play_icon);
                break;
                
            case 'priority':
                $priority = isset($settings['mgpg_media_priority']) ? $settings['mgpg_media_priority'] : ['video', 'featured', 'content', 'placeholder'];
                $output = $this->get_priority_media($post_id, $priority, $show_play_icon);
                break;
                
            case 'featured':
            default:
                $output = $this->get_featured_image($post_id);
                break;
        }
        
        return $output;
    }
    
    /**
     * Get featured image
     * 
     * @param int $post_id Post ID
     * @return string HTML output
     */
    private function get_featured_image($post_id) {
        if (has_post_thumbnail($post_id)) {
            return get_the_post_thumbnail($post_id, 'full');
        }
        return $this->get_placeholder_image();
    }
    
    /**
     * Get first image from post content
     * 
     * @param int $post_id Post ID
     * @return string HTML output
     */
    private function get_content_image($post_id) {
        $post = get_post($post_id);
        if (!$post) {
            return $this->get_placeholder_image();
        }
        
        $content = $post->post_content;
        
        // Match img tags
        preg_match('/<img[^>]+src=["\']([^"\']+)["\'][^>]*>/i', $content, $matches);
        
        if (!empty($matches[1])) {
            $img_url = $matches[1];
            $img_alt = '';
            
            // Try to get alt text
            if (preg_match('/alt=["\']([^"\']*)["\']/', $matches[0], $alt_match)) {
                $img_alt = $alt_match[1];
            }
            
            return sprintf('<img src="%s" alt="%s" />', esc_url($img_url), esc_attr($img_alt));
        }
        
        // Fallback to featured image or placeholder
        if (has_post_thumbnail($post_id)) {
            return $this->get_featured_image($post_id);
        }
        
        return $this->get_placeholder_image();
    }
    
    /**
     * Get video embed (YouTube or Vimeo)
     * 
     * @param int $post_id Post ID
     * @param string $show_play_icon Whether to show play icon
     * @return string HTML output
     */
    private function get_video_embed($post_id, $show_play_icon = 'yes') {
        $post = get_post($post_id);
        if (!$post) {
            return $this->get_placeholder_image();
        }
        
        $content = $post->post_content;
        
        // Check for YouTube embed
        $youtube_pattern = '/<iframe[^>]+src=["\'](?:https?:)?\/\/(?:www\.)?(?:youtube\.com\/embed\/|youtu\.be\/)([a-zA-Z0-9_-]+)[^"\']*["\'][^>]*>/i';
        if (preg_match($youtube_pattern, $content, $youtube_match)) {
            $video_id = $youtube_match[1];
            return $this->render_youtube_video($video_id, $post_id, $show_play_icon);
        }
        
        // Check for YouTube URL in content
        $youtube_url_pattern = '/(?:https?:)?\/\/(?:www\.)?(?:youtube\.com\/watch\?v=|youtu\.be\/)([a-zA-Z0-9_-]+)/i';
        if (preg_match($youtube_url_pattern, $content, $youtube_url_match)) {
            $video_id = $youtube_url_match[1];
            return $this->render_youtube_video($video_id, $post_id, $show_play_icon);
        }
        
        // Check for Vimeo embed
        $vimeo_pattern = '/<iframe[^>]+src=["\'](?:https?:)?\/\/(?:www\.)?player\.vimeo\.com\/video\/(\d+)[^"\']*["\'][^>]*>/i';
        if (preg_match($vimeo_pattern, $content, $vimeo_match)) {
            $video_id = $vimeo_match[1];
            return $this->render_vimeo_video($video_id, $post_id, $show_play_icon);
        }
        
        // Check for Vimeo URL in content
        $vimeo_url_pattern = '/(?:https?:)?\/\/(?:www\.)?vimeo\.com\/(\d+)/i';
        if (preg_match($vimeo_url_pattern, $content, $vimeo_url_match)) {
            $video_id = $vimeo_url_match[1];
            return $this->render_vimeo_video($video_id, $post_id, $show_play_icon);
        }
        
        // No video found, fallback to featured image
        if (has_post_thumbnail($post_id)) {
            return $this->get_featured_image($post_id);
        }
        
        return $this->get_placeholder_image();
    }
    
    /**
     * Render YouTube video with thumbnail
     * 
     * @param string $video_id YouTube video ID
     * @param int $post_id Post ID
     * @param string $show_play_icon Whether to show play icon
     * @return string HTML output
     */
    private function render_youtube_video($video_id, $post_id, $show_play_icon = 'yes') {
        $thumbnail_url = "https://img.youtube.com/vi/{$video_id}/maxresdefault.jpg";
        $video_url = "https://www.youtube.com/embed/{$video_id}?autoplay=1";
        $post_title = get_the_title($post_id);
        
        $output = '<a href="' . esc_url($video_url) . '" class="mgpd-video-wrapper venobox mgyouvideo" data-vbtype="video" data-autoplay="true" data-video-type="youtube" data-video-id="' . esc_attr($video_id) . '">';
        $output .= '<img src="' . esc_url($thumbnail_url) . '" alt="' . esc_attr($post_title) . '" />';
        
        if ($show_play_icon === 'yes') {
            $output .= '<span class="mgpd-video-play-icon"></span>';
        }
        
        $output .= '</a>';
        
        return $output;
    }
    
    /**
     * Render Vimeo video with thumbnail
     * 
     * @param string $video_id Vimeo video ID
     * @param int $post_id Post ID
     * @param string $show_play_icon Whether to show play icon
     * @return string HTML output
     */
    private function render_vimeo_video($video_id, $post_id, $show_play_icon = 'yes') {
        // Get Vimeo thumbnail via API
        $thumbnail_url = $this->get_vimeo_thumbnail($video_id);
        $video_url = "https://player.vimeo.com/video/{$video_id}?autoplay=1";
        $post_title = get_the_title($post_id);
        
        $output = '<a href="' . esc_url($video_url) . '" class="mgpd-video-wrapper venobox mgyouvideo" data-vbtype="video" data-autoplay="true" data-video-type="vimeo" data-video-id="' . esc_attr($video_id) . '">';
        $output .= '<img src="' . esc_url($thumbnail_url) . '" alt="' . esc_attr($post_title) . '" />';
        
        if ($show_play_icon === 'yes') {
            $output .= '<span class="mgpd-video-play-icon"></span>';
        }
        
        $output .= '</a>';
        
        return $output;
    }
    
    /**
     * Get Vimeo thumbnail URL
     * 
     * @param string $video_id Vimeo video ID
     * @return string Thumbnail URL
     */
    private function get_vimeo_thumbnail($video_id) {
        // Check transient cache first
        $cache_key = 'mgpd_vimeo_thumb_' . $video_id;
        $thumbnail = get_transient($cache_key);
        
        if ($thumbnail !== false) {
            return $thumbnail;
        }
        
        // Fetch from Vimeo API
        $api_url = "https://vimeo.com/api/v2/video/{$video_id}.json";
        $response = wp_remote_get($api_url);
        
        if (is_wp_error($response)) {
            return $this->get_placeholder_image_url();
        }
        
        $body = wp_remote_retrieve_body($response);
        $data = json_decode($body, true);
        
        if (!empty($data[0]['thumbnail_large'])) {
            $thumbnail = $data[0]['thumbnail_large'];
            // Cache for 24 hours
            set_transient($cache_key, $thumbnail, DAY_IN_SECONDS);
            return $thumbnail;
        }
        
        return $this->get_placeholder_image_url();
    }
    
    /**
     * Get media based on priority fallback
     * 
     * @param int $post_id Post ID
     * @param array $priority Priority order
     * @param string $show_play_icon Whether to show play icon
     * @return string HTML output
     */
    private function get_priority_media($post_id, $priority, $show_play_icon = 'yes') {
        foreach ($priority as $source) {
            switch ($source) {
                case 'video':
                    $output = $this->get_video_embed($post_id, $show_play_icon);
                    // Check if video was actually found (not fallback)
                    if (strpos($output, 'mgpd-video-wrapper') !== false) {
                        return $output;
                    }
                    break;
                    
                case 'featured':
                    if (has_post_thumbnail($post_id)) {
                        return $this->get_featured_image($post_id);
                    }
                    break;
                    
                case 'content':
                    $post = get_post($post_id);
                    if ($post && preg_match('/<img[^>]+src=["\']([^"\']+)["\']/', $post->post_content)) {
                        return $this->get_content_image($post_id);
                    }
                    break;
                    
                case 'placeholder':
                    return $this->get_placeholder_image();
            }
        }
        
        // Ultimate fallback
        return $this->get_placeholder_image();
    }
    
    /**
     * Get placeholder image HTML
     * 
     * @return string HTML output
     */
    private function get_placeholder_image() {
        return '<div class="mgpd-placeholder-img"></div>';
    }
    
    /**
     * Get placeholder image URL (Deprecated - keeping for compatibility)
     * 
     * @return string Image URL
     */
    private function get_placeholder_image_url() {
        // Return empty string as we're now using CSS background
        return '';
    }
    
    /**
     * Check if post has video content
     * 
     * @param int $post_id Post ID
     * @return bool
     */
    public function has_video_content($post_id) {
        $post = get_post($post_id);
        if (!$post) {
            return false;
        }
        
        $content = $post->post_content;
        
        // Check for YouTube
        if (preg_match('/(?:youtube\.com|youtu\.be)/i', $content)) {
            return true;
        }
        
        // Check for Vimeo
        if (preg_match('/vimeo\.com/i', $content)) {
            return true;
        }
        
        return false;
    }
}
