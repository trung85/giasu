<?php
/*
	Plugin name: Support Online
	Description: This plugin create widget for support online
	Author: foxrain
	Author URI: http://thuthuatwordpress.org
	Plugin URI: http://thuthuatwordpress.org
	Version: 1.0
*/

/**
 * FIT support online widget class
 *
 * @category FIT
 * @package  Widgets
 * @since    1.0
 */
class Fit_Online_Support_Widget extends WP_Widget

{
	/**
	 * Holds widget settings defaults, populated in constructor.
	 *
	 * @var array
	 */
	protected $defaults;

	/**
	 * Constructor. Set the default widget options and create widget.
	 *
	 * @since 1.0
	 */

	function __construct()

	{

		$this->defaults = array(
			
			'title'                => '',
			'group_num'            => 1,
			'tel'                  => '',
			'hotline'              => '',
			'email'                => '',
			'support_extra'        => '',
			'group_supporters_num' => ''
		);


		$widget_ops = array(
			'classname'   => 'support-online-widget',
			'description' => __( 'Support online by Yahoo and Skype', 'fit' )

		);

		$control_ops = array(
			'width'   => 505,
			'height'  => 250,
			'id_base' => 'support-online'
		);
		$this->WP_Widget( 'support-online', __( 'FIT - Online Support', 'fit' ), $widget_ops, $control_ops );

	}

	/**
	 * Echo the widget content.
	 *
	 * @since 1.0
	 */
	function widget( $args, $instance )

	{
		extract( $args );
		/** Merge with defaults */
		$instance = wp_parse_args( (array) $instance, $this->defaults );
		echo $before_widget;

		if ( !empty( $instance['title'] ) )
		{
			echo $before_title . apply_filters( 'widget_title', $instance['title'] ) . $after_title;
		}

		echo '<script type="text/javascript" src="http://download.skype.com/share/skypebuttons/js/skypeCheck.js"></script>';
		?>
		<!-- Support group -->

		<?php for ( $i = 0; $i < $instance['group_num']; $i++ ) : ?>
		<div id="support-group-<?php echo $i + 1; ?>" class="support-group">
			<?php if ( !empty( $instance['group_title'][$i] ) ) : ?>
				<div class="group-name"><span><?php echo $instance['group_title'][$i]; ?></span></div><?php endif; ?>
			<?php for ( $j = 0; $j < $instance['group_supporters_num'][$i]; $j++ ) : ?>

				<div id="supporter-<?php echo $j + 1; ?>" class="<?php echo $j % 2 == 0 ? 'supp-odd' : 'supp-even'; ?> supporter">
					<div class="supporter-info">
						<?php if ( !empty( $instance['supporter_name'][$i][$j] ) ) : ?>
							<p class="supporter-name"><?php echo $instance['supporter_name'][$i][$j]; ?></p><?php endif; ?>
						<?php if ( !empty( $instance['supporter_phone'][$i][$j] ) ) : ?>
							<p class="supporter-phone"><?php echo $instance['supporter_phone'][$i][$j]; ?></p><?php endif; ?>
					</div>

					<!-- end .supporter-info -->

					<div class="supporter-online">
						<?php if ( !empty( $instance['supporter_yahoo'][$i][$j] ) ) : ?><p class="supporter-yahoo">
							<a href="<?php echo 'ymsgr:sendim?' . $instance['supporter_yahoo'][$i][$j]; ?>"><img src="<?php echo 'http://opi.yahoo.com/online?u=' . $instance['supporter_yahoo'][$i][$j] . '&m=g&t=' . $instance['supporter_yahoo_opi'][$i][$j]; ?>" alt="<?php _e( 'Online Support via Yahoo', 'fit' ); ?>" /></a>
							</p><?php endif; ?>
						<?php if ( !empty( $instance['supporter_skype'][$i][$j] ) ) : ?><p class="supporter-skype">
							<a href="<?php echo 'skype:' . $instance['supporter_skype'][$i][$j] . '?chat'; ?>" onclick="return skypeCheck();"><img src="http://mystatus.skype.com/smallclassic/<?php echo $instance['supporter_skype'][$i][$j]; ?>" alt="<?php _e( 'Online Support via Skype', 'fit' ); ?>" /></a>
							</p><?php endif; ?>
					</div>
					<!-- end .supporter-online -->
				</div><!-- end .supporter -->
			<?php endfor; ?>
		</div><!-- end .supporter-group -->
	<?php endfor; ?>

		<!-- End support group -->
		<?php if ( !empty( $instance['tel'] ) || !empty( $instance['hotline'] ) || !empty( $instance['email'] ) ) : ?>

		<div id="hotline-area" class="hotline-area">

			<?php if ( !empty( $instance['tel'] ) ) : ?>

				<span class="tel">
						<span class="label"><?php _e( 'Tel: ', 'fit' ); ?></span>
		        		<span class="num"><?php echo $instance['tel']; ?></span>
		        	</span>
			<?php endif; ?>

			<?php if ( !empty( $instance['hotline'] ) ) : ?>

				<span class="hotline">
		        		<span class="label"><?php _e( 'Hotline: ', 'fit' ); ?></span>
		        		<span class="num"><?php echo $instance['hotline']; ?></span>
		        	</span>
			<?php endif; ?>
			<?php if ( !empty( $instance['email'] ) ) : ?>
				<p class="email">
					<span><?php _e( 'Email: ', 'fit' ); ?></span>
					<a href="mailto:<?php echo $instance['email'] ?>"><?php echo $instance['email']; ?></a>
				</p>
			<?php endif; ?>
		</div><!-- end #hotline-area -->
	<?php endif; ?>
		<?php
		if ( !empty( $instance['support_extra'] ) )
		{
			echo '<div class="support-extra">' . $instance['support_extra'] . '</div>';
		}
		echo '<div class="clear"></div>';
		echo $after_widget;
	}

	/**
	 * Update a particular instance.
	 *
	 * @param array $new_instance
	 * @param array $old_instance
	 *
	 * @return array
	 */

	function update( $new_instance, $old_instance )
	{
		return $new_instance;
	}

	/**
	 * Echo the settings update form.
	 *
	 * @since 1.0
	 *
	 * @param array $instance Current settings
	 *
	 * @return string|void
	 */

	function form( $instance )
	{
		/** Merge with defaults */
		$instance = wp_parse_args( (array) $instance, $this->defaults );
		?>

		<p><label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title', 'fit' ); ?>:</label>
			<input type="text" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" value="<?php echo esc_attr( $instance['title'] ); ?>" style="width:95%;" />
		</p>

		<hr />
		<p>
			<label for="<?php echo $this->get_field_id( 'tel' ); ?>" style="width: 49%; display: inline-block;"><?php _e( 'Tel', 'fit' ); ?>:</label>
			<label for="<?php echo $this->get_field_id( 'hotline' ); ?>" style="width: 49%; display: inline-block;"><?php _e( 'Hotline', 'fit' ); ?>:</label>
		</p>
		<p>
			<input type="text" id="<?php echo $this->get_field_id( 'tel' ); ?>" name="<?php echo $this->get_field_name( 'tel' ); ?>" value="<?php echo esc_attr( $instance['tel'] ); ?>" style="width:48%;" />
			<input type="text" id="<?php echo $this->get_field_id( 'hotline' ); ?>" name="<?php echo $this->get_field_name( 'hotline' ); ?>" value="<?php echo esc_attr( $instance['hotline'] ); ?>" style="width:49%;" />
		</p>
		<p><label for="<?php echo $this->get_field_id( 'email' ); ?>"><?php _e( 'Email', 'fit' ); ?>:</label>

			<input type="text" id="<?php echo $this->get_field_id( 'email' ); ?>" name="<?php echo $this->get_field_name( 'email' ); ?>" value="<?php echo esc_attr( $instance['email'] ); ?>" style="width:95%;" />
		</p>

		<hr />
		<p style="background: #ccc; padding: 5px;">
			<label for="<?php echo $this->get_field_id( 'group_num' ); ?>"><?php _e( 'Number of support group', 'fit' ); ?>:</label>
			<input type="text" id="<?php echo $this->get_field_id( 'group_num' ); ?>" name="<?php echo $this->get_field_name( 'group_num' ); ?>" value="<?php echo esc_attr( $instance['group_num'] ); ?>" size="2" />
			<input type="submit" name="savewidget" id="savewidget" class="button-secondary widget-control-save" value="Save" />
			<img alt="" style="padding-bottom: 4px;" title="" class="ajax-feedback " src="<?php echo admin_url( '/' ); ?>images/wpspin_light.gif" />
		</p>

		<hr />
		<?php for ( $i = 0; $i < $instance['group_num']; $i++ ) : ?>
		<p>
			<label for="<?php echo $this->get_field_id( 'group_title_' . $i ); ?>"><strong><?php _e( 'Group title ', 'fit' );
					echo $i + 1; ?></strong></label>&nbsp;&nbsp;&nbsp;
			<input type="text" id="<?php echo $this->get_field_id( 'group_title_' . $i ); ?>" name="<?php echo $this->get_field_name( 'group_title' ); ?>[]" value="<?php echo esc_attr( $instance['group_title'][$i] ); ?>" size="40" />
			<label for="<?php echo $this->get_field_id( 'supports_num_' . $i ); ?>"><?php _e( 'Supporters', 'fit' ) ?></label>
			<input type="text" id="<?php echo $this->get_field_id( 'supports_num_' . $i ); ?>" name="<?php echo $this->get_field_name( 'group_supporters_num' ); ?>[]" value="<?php echo esc_attr( $instance['group_supporters_num'][$i] ); ?>" size="2" />
			<input type="submit" name="savewidget" id="savewidget" class="button-secondary widget-control-save" value="Save" />
			<img alt="" style="padding-bottom: 4px;" title="" class="ajax-feedback " src="<?php echo admin_url( '/' ); ?>images/wpspin_light.gif" />
		</p>

		<p>
		<?php $supporter_num = intval( $instance['group_supporters_num'][$i] ); ?>
		<?php for ( $j = 0; $j < $supporter_num; $j++ ) : ?>
			<div style="width: 47%; padding: 5px; margin: 5px 0; background: #eee; <?php echo $j % 2 == 0 ? 'float: left;' : 'float: right;'; ?>">
				<p>
					<label for="<?php echo $this->get_field_id( 'supporter_name_' . $i . $j ); ?>"><?php _e( 'Name', 'fit' ); ?></label>
					<input type="text" id="<?php echo $this->get_field_id( 'supporter_name_' . $i . $j ); ?>" name="<?php echo $this->get_field_name( 'supporter_name' ); ?>[<?php echo $i; ?>][]" value="<?php echo esc_attr( $instance['supporter_name'][$i][$j] ); ?>" size="33" />
				</p>

				<p>
					<label for="<?php echo $this->get_field_id( 'supporter_phone_' . $i . $j ); ?>"><?php _e( 'Phone', 'fit' ); ?></label>
					<input type="text" id="<?php echo $this->get_field_id( 'supporter_phone_' . $i . $j ); ?>" name="<?php echo $this->get_field_name( 'supporter_phone' ); ?>[<?php echo $i; ?>][]" value="<?php echo esc_attr( $instance['supporter_phone'][$i][$j] ); ?>" size="32" />
				</p>

				<p>
					<label for="<?php echo $this->get_field_id( 'supporter_skype_' . $i . $j ); ?>"><?php _e( 'Skype', 'fit' ); ?></label>
					<input type="text" id="<?php echo $this->get_field_id( 'supporter_skype_' . $i . $j ); ?>" name="<?php echo $this->get_field_name( 'supporter_skype' ); ?>[<?php echo $i; ?>][]" value="<?php echo esc_attr( $instance['supporter_skype'][$i][$j] ); ?>" size="33" />
				</p>

				<p>
					<label for="<?php echo $this->get_field_id( 'supporter_yahoo_' . $i . $j ); ?>"><?php _e( 'Yahoo', 'fit' ); ?></label>
					<input type="text" id="<?php echo $this->get_field_id( 'supporter_yahoo_' . $i . $j ); ?>" name="<?php echo $this->get_field_name( 'supporter_yahoo' ); ?>[<?php echo $i; ?>][]" value="<?php echo esc_attr( $instance['supporter_yahoo'][$i][$j] ); ?>" size="19" />
					<label for="<?php echo $this->get_field_id( 'supporter_yahoo_opi_' . $i . $j ); ?>"><?php _e( 'OPI', 'fit' ); ?></label>

					<select id="<?php echo $this->get_field_id( 'supporter_yahoo_opi_' . $i . $j ); ?>" name="<?php echo $this->get_field_name( 'supporter_yahoo_opi' ); ?>[<?php echo $i; ?>][]">

						<?php for ( $k = 1; $k <= 22; $k++ ) : ?>
							<option value="<?php echo $k; ?>" <?php selected( $k, $instance['supporter_yahoo_opi'][$i][$j] ); ?>><?php echo $k; ?></option>
						<?php endfor; ?>
					</select>
				</p>
			</div>
		<?php endfor; ?>
		</p>
		<hr class="clear" />
	<?php endfor; ?>
		<label for="<?php echo $this->get_field_id( 'support_extra' ); ?>"><strong><?php _e( 'Extra :', 'fit' ); ?></strong></label>

		<textarea id="<?php echo $this->get_field_id( 'support_extra' ); ?>" name="<?php echo $this->get_field_name( 'support_extra' ); ?>" style="width: 98%;"><?php echo esc_attr( $instance['support_extra'] ); ?></textarea>
	<?php
	}
}

add_action('widgets_init', create_function( '', 'return register_widget( "Fit_Online_Support_Widget" );' ));