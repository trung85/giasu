<form method="POST" action="options.php" class="">
	<h1><?php esc_html_e( 'Tutor Management Settings', $this->domain ); ?></h1>


    <div>
    	<?php settings_fields( $this->settings_name ); ?>
    	<?php do_settings_sections( $this->settings_name ); ?>
        <?php submit_button(); ?>
    </div>
</form>
