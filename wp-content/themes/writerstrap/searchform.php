<?php
/**
 * The template for displaying search forms in WriterStrap
 *
 * @package WriterStrap
 * @since WP WriterStrap 1.1
 */
?>
<form id="searchform" action="<?php echo home_url(); ?>/" method="get">
<input id="s" name="s" size="20" type="text" value="" x-webkit-speech speech onwebkitspeechchange="this.form.submit();" placeholder="Serach..." />
</form>