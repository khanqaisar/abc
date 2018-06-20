<?php
global $wp_widget_factory;
?>
<div id="tamm-panel-content" class="tamm-panel-content tamm-panel">
	<p>
		<textarea name="<%= taMegaMenu.getFieldName( 'content', data['menu-item-db-id'] ) %>" class="widefat" rows="20" contenteditable="true"><%= megaData.content %></textarea>
	</p>

	<p class="description"><?php esc_html_e( 'Allow HTML and Shortcodes', 'martfury' ) ?></p>
</div>