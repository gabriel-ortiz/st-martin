<?php
/**
 * Metaboxes
 *
 * Metaboxes are segmented by concerns to make the codebase more manageable
 * Create a new file under the metaboxes directory when appropriate.
 */
require_once STM_INC . 'metaboxes/general.php';
require_once STM_INC . 'metaboxes/page-themes.php';

// Add General metabox first, so it always appears at top
STM_WP\MetaBoxes\General\setup();
STM_WP\MetaBoxes\PageThemes\setup();
// Add other metaboxes here
//require_once STM_INC . 'metaboxes/uploads.php';