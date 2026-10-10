<?php
/**
 * Widgets Manager Template for Magical Posts Display
 *
 * @package Magical Posts Display
 */

defined('ABSPATH') || exit;

if (!function_exists('is_plugin_active')) {
    require_once ABSPATH . 'wp-admin/includes/plugin.php';
}

$mg_plugin_file  = 'magical-addons-for-elementor/magical-addons-for-elementor.php';
$is_tb_installed = file_exists(WP_PLUGIN_DIR . '/' . $mg_plugin_file);
$is_tb_active    = function_exists('mg_tb') || class_exists('MgTB') || is_plugin_active($mg_plugin_file);

$metadata = function_exists('mpd_get_elements_metadata') ? mpd_get_elements_metadata() : array();
$active   = function_exists('mpd_get_active_elements') ? mpd_get_active_elements() : array();

// Count active widgets
$total_count  = 0;
$active_count = 0;
foreach ($metadata as $category) {
    foreach ($category['widgets'] as $widget_key => $widget_data) {
        $total_count++;
        if (!empty($active[$widget_key])) {
            $active_count++;
        }
    }
}
?>

<div class="mgpd-elements-wrapper">
    <!-- Notice output -->
    <?php if (function_exists('settings_errors')) { settings_errors('mgpd_elements_notices'); } ?>

    <!-- Header & Action Bar -->
    <div class="mgpd-elements-header">
        <div class="mgpd-elements-intro">
            <h3 class="mgpd-elements-title">
                <span class="dashicons dashicons-admin-generic"></span>
                <?php esc_html_e('Elementor Widgets Manager', 'magical-posts-display'); ?>
            </h3>
            <p class="mgpd-elements-subtitle">
                <?php esc_html_e('Enable or disable individual widgets. Disabled widgets will not load into memory, significantly boosting performance and keeping your Elementor editor panel fast and uncluttered.', 'magical-posts-display'); ?>
            </p>
            <div class="mgpd-elements-counter">
                <span class="mgpd-badge-counter">
                    <strong id="mgpd-active-count"><?php echo esc_html($active_count); ?></strong> / <?php echo esc_html($total_count); ?> <?php esc_html_e('Widgets Enabled', 'magical-posts-display'); ?>
                </span>
            </div>
        </div>

        <div class="mgpd-elements-actions">
            <button type="button" class="button mgpd-btn-bulk" id="mgpd-enable-all">
                <span class="dashicons dashicons-yes-alt"></span>
                <span><?php esc_html_e('Enable All', 'magical-posts-display'); ?></span>
            </button>
            <button type="button" class="button mgpd-btn-bulk" id="mgpd-disable-all">
                <span class="dashicons dashicons-dismiss"></span>
                <span><?php esc_html_e('Disable All', 'magical-posts-display'); ?></span>
            </button>
            <button type="button" class="button button-primary mgpd-btn-save" id="mgpd-save-top">
                <span class="dashicons dashicons-saved"></span>
                <span class="mgpd-save-text"><?php esc_html_e('Save Changes', 'magical-posts-display'); ?></span>
            </button>
        </div>
    </div>

    <!-- Elements Form -->
    <form method="post" id="mgpd-elements-form" action="<?php echo esc_url(admin_url('admin.php?page=mgpd-page#magical_ptab_elements')); ?>">
        <?php wp_nonce_field('mgpd_save_elements', 'mgpd_save_elements_nonce'); ?>

        <?php foreach ($metadata as $cat_key => $category) : ?>
            <div class="mgpd-elements-section" id="mgpd-section-<?php echo esc_attr($cat_key); ?>">
                <div class="mgpd-section-header-wrap">
                    <div class="mgpd-section-header-left">
                        <h3 class="mgpd-elements-section-title">
                            <?php echo esc_html($category['title']); ?>
                        </h3>
                        <?php if ($cat_key === 'theme_builder') : ?>
                            <?php if (!$is_tb_active) : ?>
                                <div class="mgpd-tb-section-alert">
                                    <span class="dashicons dashicons-warning"></span>
                                    <span class="mgpd-tb-alert-text">
                                        <?php esc_html_e('These widgets only work when Magical Addons for Elementor is active.', 'magical-posts-display'); ?>
                                    </span>
                                    <button type="button" class="button mgpd-btn-tb-quick-install mgpd-btn-ajax-addons" data-action="<?php echo $is_tb_installed ? 'activate' : 'install'; ?>">
                                        <span class="dashicons <?php echo $is_tb_installed ? 'dashicons-update' : 'dashicons-download'; ?> mgpd-btn-icon"></span>
                                        <span class="mgpd-btn-text">
                                            <?php echo $is_tb_installed ? esc_html__('Activate Now (1-Click)', 'magical-posts-display') : esc_html__('Install Now (1-Click Free)', 'magical-posts-display'); ?>
                                        </span>
                                    </button>
                                </div>
                            <?php else : ?>
                                <div class="mgpd-tb-section-connected">
                                    <span class="dashicons dashicons-yes-alt"></span>
                                    <span><?php esc_html_e('Connected with Magical Addons Theme Builder engine.', 'magical-posts-display'); ?></span>
                                    <a href="<?php echo esc_url(admin_url('admin.php?page=magical-addons#/theme-builder')); ?>" target="_blank" class="mgpd-tb-open-link">
                                        <?php esc_html_e('Open Templates &rarr;', 'magical-posts-display'); ?>
                                    </a>
                                </div>
                            <?php endif; ?>
                        <?php endif; ?>
                    </div>
                    <span class="mgpd-section-count">
                        <?php echo esc_html(count($category['widgets'])); ?> <?php esc_html_e('Widgets', 'magical-posts-display'); ?>
                    </span>
                </div>

                <div class="mgpd-elements-grid">
                    <?php foreach ($category['widgets'] as $widget_key => $widget_data) : 
                        $is_enabled = !empty($active[$widget_key]);
                    ?>
                        <div class="mgpd-element-card <?php echo $is_enabled ? 'is-active' : 'is-disabled'; ?>">
                            <div class="mgpd-element-card-header">
                                <div class="mgpd-element-icon">
                                    <span class="dashicons <?php echo esc_attr($widget_data['icon']); ?>"></span>
                                </div>
                                <div class="mgpd-element-info">
                                    <h4 class="mgpd-element-name"><?php echo esc_html($widget_data['name']); ?></h4>
                                    <p class="mgpd-element-desc"><?php echo esc_html($widget_data['description']); ?></p>
                                </div>
                            </div>

                            <div class="mgpd-element-card-footer">
                                <span class="mgpd-element-status-label">
                                    <?php echo $is_enabled ? esc_html__('Active', 'magical-posts-display') : esc_html__('Disabled', 'magical-posts-display'); ?>
                                </span>
                                <label class="mgpd-switch" aria-label="<?php echo esc_attr(sprintf(__('Toggle %s', 'magical-posts-display'), $widget_data['name'])); ?>">
                                    <input type="checkbox" name="mgpd_elements[<?php echo esc_attr($widget_key); ?>]" value="1" class="mgpd-element-toggle" <?php checked($is_enabled, true); ?>>
                                    <span class="mgpd-slider"></span>
                                </label>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        <?php endforeach; ?>

        <div class="mgpd-elements-bottom-actions">
            <button type="button" class="button button-primary button-hero mgpd-btn-save" id="mgpd-save-bottom">
                <span class="dashicons dashicons-saved"></span>
                <span class="mgpd-save-text"><?php esc_html_e('Save Widget Settings', 'magical-posts-display'); ?></span>
            </button>
        </div>
    </form>

    <!-- Save Toast Notification -->
    <div id="mgpd-toast" class="mgpd-save-toast">
        <span class="dashicons dashicons-yes-alt"></span>
        <span class="mgpd-toast-text"><?php esc_html_e('Settings saved successfully!', 'magical-posts-display'); ?></span>
    </div>
</div>

<script type="text/javascript">
(function($) {
    'use strict';
    $(document).ready(function() {
        function updateActiveCount() {
            var activeCount = $('.mgpd-element-toggle:checked').length;
            $('#mgpd-active-count').text(activeCount);
        }

        function showToast(message, isSuccess) {
            var $toast = $('#mgpd-toast');
            $toast.removeClass('toast-success toast-error');
            if (isSuccess) {
                $toast.addClass('toast-success');
                $toast.find('.dashicons').attr('class', 'dashicons dashicons-yes-alt');
            } else {
                $toast.addClass('toast-error');
                $toast.find('.dashicons').attr('class', 'dashicons dashicons-warning');
            }
            $toast.find('.mgpd-toast-text').text(message);
            $toast.addClass('is-visible');

            clearTimeout(window.mgpdToastTimer);
            window.mgpdToastTimer = setTimeout(function() {
                $toast.removeClass('is-visible');
            }, 2600);
        }

        // Toggle card style on switch change
        $('.mgpd-element-toggle').on('change', function() {
            var $card = $(this).closest('.mgpd-element-card');
            var $label = $card.find('.mgpd-element-status-label');
            if ($(this).is(':checked')) {
                $card.removeClass('is-disabled').addClass('is-active');
                $label.text('<?php echo esc_js(__('Active', 'magical-posts-display')); ?>');
            } else {
                $card.removeClass('is-active').addClass('is-disabled');
                $label.text('<?php echo esc_js(__('Disabled', 'magical-posts-display')); ?>');
            }
            updateActiveCount();
        });

        // Enable All
        $('#mgpd-enable-all').on('click', function(e) {
            e.preventDefault();
            $('.mgpd-element-toggle').prop('checked', true).trigger('change');
        });

        // Disable All
        $('#mgpd-disable-all').on('click', function(e) {
            e.preventDefault();
            $('.mgpd-element-toggle').prop('checked', false).trigger('change');
        });

        // AJAX Save Handler (Zero page reload)
        $('.mgpd-btn-save').on('click', function(e) {
            e.preventDefault();
            var $saveBtns = $('.mgpd-btn-save');
            var $textSpans = $saveBtns.find('.mgpd-save-text');
            var $icons = $saveBtns.find('.dashicons');

            $saveBtns.prop('disabled', true);
            $icons.removeClass('dashicons-saved dashicons-yes-alt').addClass('dashicons-update mgpd-spin');
            $textSpans.text('<?php echo esc_js(__('Saving Changes...', 'magical-posts-display')); ?>');

            var elementsData = {};
            $('.mgpd-element-toggle').each(function() {
                var name = $(this).attr('name').replace('mgpd_elements[', '').replace(']', '');
                if ($(this).is(':checked')) {
                    elementsData[name] = 1;
                } else {
                    elementsData[name] = 0;
                }
            });

            var nonce = $('[name="mgpd_save_elements_nonce"]').val();

            $.ajax({
                url: typeof mgpdAdmin !== 'undefined' ? mgpdAdmin.ajax_url : ajaxurl,
                type: 'POST',
                data: {
                    action: 'mgpd_save_elements',
                    nonce: nonce,
                    elements: elementsData
                },
                success: function(res) {
                    $icons.removeClass('dashicons-update mgpd-spin').addClass('dashicons-yes-alt');
                    $textSpans.text('<?php echo esc_js(__('Saved Successfully!', 'magical-posts-display')); ?>');
                    showToast(res.data && res.data.message ? res.data.message : '<?php echo esc_js(__('Widget settings saved successfully!', 'magical-posts-display')); ?>', true);

                    setTimeout(function() {
                        $saveBtns.prop('disabled', false);
                        $icons.removeClass('dashicons-yes-alt').addClass('dashicons-saved');
                        $textSpans.text('<?php echo esc_js(__('Save Changes', 'magical-posts-display')); ?>');
                        $('#mgpd-save-bottom .mgpd-save-text').text('<?php echo esc_js(__('Save Widget Settings', 'magical-posts-display')); ?>');
                    }, 1800);
                },
                error: function() {
                    $icons.removeClass('dashicons-update mgpd-spin').addClass('dashicons-warning');
                    $textSpans.text('<?php echo esc_js(__('Save Failed', 'magical-posts-display')); ?>');
                    showToast('<?php echo esc_js(__('Error saving settings. Please try again.', 'magical-posts-display')); ?>', false);

                    setTimeout(function() {
                        $saveBtns.prop('disabled', false);
                        $icons.removeClass('dashicons-warning').addClass('dashicons-saved');
                        $textSpans.text('<?php echo esc_js(__('Save Changes', 'magical-posts-display')); ?>');
                        $('#mgpd-save-bottom .mgpd-save-text').text('<?php echo esc_js(__('Save Widget Settings', 'magical-posts-display')); ?>');
                    }, 2000);
                }
            });
        });

        // 1-Click Install/Activate Handler inside section alert
        $(document).on('click', '.mgpd-btn-ajax-addons', function(e) {
            e.preventDefault();
            var $btn = $(this);
            var actionType = $btn.data('action');

            $btn.prop('disabled', true);
            $btn.find('.dashicons').removeClass('dashicons-download dashicons-update dashicons-yes-alt').addClass('dashicons-update mgpd-spin');
            $btn.find('.mgpd-btn-text').text(actionType === 'activate' ? '<?php echo esc_js(__('Activating...', 'magical-posts-display')); ?>' : '<?php echo esc_js(__('Installing...', 'magical-posts-display')); ?>');

            $.ajax({
                url: typeof mgpdAdmin !== 'undefined' ? mgpdAdmin.ajax_url : ajaxurl,
                type: 'POST',
                data: {
                    action: 'mgpd_install_activate_addons',
                    nonce: typeof mgpdAdmin !== 'undefined' ? mgpdAdmin.nonce : ''
                },
                success: function(res) {
                    if (res.success) {
                        $btn.find('.dashicons').removeClass('dashicons-update mgpd-spin').addClass('dashicons-yes-alt');
                        $btn.find('.mgpd-btn-text').text('<?php echo esc_js(__('Activated!', 'magical-posts-display')); ?>');
                        showToast(res.data && res.data.message ? res.data.message : '<?php echo esc_js(__('Magical Addons activated successfully!', 'magical-posts-display')); ?>', true);
                        setTimeout(function() {
                            window.location.reload();
                        }, 1200);
                    } else {
                        $btn.prop('disabled', false);
                        $btn.find('.dashicons').removeClass('dashicons-update mgpd-spin').addClass('dashicons-download');
                        $btn.find('.mgpd-btn-text').text('<?php echo esc_js(__('Try Again', 'magical-posts-display')); ?>');
                        showToast(res.data && res.data.message ? res.data.message : '<?php echo esc_js(__('Activation failed.', 'magical-posts-display')); ?>', false);
                    }
                },
                error: function() {
                    $btn.prop('disabled', false);
                    $btn.find('.dashicons').removeClass('dashicons-update mgpd-spin').addClass('dashicons-download');
                    $btn.find('.mgpd-btn-text').text('<?php echo esc_js(__('Try Again', 'magical-posts-display')); ?>');
                    showToast('<?php echo esc_js(__('Unexpected error occurred.', 'magical-posts-display')); ?>', false);
                }
            });
        });
    });
})(jQuery);
</script>
