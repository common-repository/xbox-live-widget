<?php
/**
 * Plugin Name: Xbox Live Avatar
 * Plugin URI: http://products.binamedia.com/wordpress-xbox-live-widget
 * Description: A widget that displays gamercard or tree different types of avatar full body, icon large or icon small. It uses the official Xbox live URLs.
 * Version: 0.1
 * Author: Dan Miranda
 * Author URI: http://binamedia.com
 *
 */

/**
 * We add the load function to widgets_init
 */
add_action( 'widgets_init', 'Xbox_live_load_widgets' );

/**
 * We register the Xbox_live_Widget class.
 */
function Xbox_live_load_widgets() {
	register_widget( 'Xbox_live_Widget' );
}

/**
 * This is the widget class that handles the behaviour
 */
class Xbox_live_Widget extends WP_Widget {

	/**
	 * Widget setup.
	 */
	function Xbox_live_Widget() {
		/* Widget settings. */
		$widget_ops = array( 'classname' => 'Xbox_live_Widget', 'description' => __('A widget that displays gamercard or tree different types of avatar full body, icon large or icon small. It uses the official Xbox live URLs.', 'xbox_live') );

		/* Widget control settings. */
		$control_ops = array( 'width' => 250, 'height' => 350, 'id_base' => 'bm-xbox-live' );

		/* Create the widget. */
		$this->WP_Widget( 'bm-xbox-live', __('Xbox Live', 'xbox_live'), $widget_ops, $control_ops );
	}

	/**
	 * Widget diplayed on the screen.
	 */
	function widget( $args, $instance ) {
		extract( $args );

		/* Our variables from the widget settings. */
		$title = apply_filters('widget_title', $instance['title'] );
		$gamertag = apply_filters('widget_title', $instance['gamertag'] );		
		$widget_mode = isset( $instance['widget_mode'] ) ? $instance['widget_mode'] : false;

		/* Before widget (defined by themes). */
		echo $before_widget;

		/* Display the widget title if one was input (before and after defined by themes). */
		if ( $title )
			echo $before_title . $title . $after_title;

		/* Display the selected avatar */
		switch ( $widget_mode ){			
			case 'GamerCard':
printf(  __('<iframe width="204" height="140" src="http://gamercard.xbox.com/en-US/%1$s.card" ></iframe>', 'xbox_live') , $gamertag );			
				break;
			case 'AvatarBody':
printf(  __('<img style="width: 100%; text-align: center;" src="http://avatar.xboxlive.com/avatar/%1$s/avatar-body.png" /><p><a href="http://live.xbox.com/en-US/MyXbox/Profile?Gamertag=%1$s">%1$s</a></p>', 'xbox_live') , $gamertag );			
				break;
			case 'AvatarIconLarge':
printf(  __('<img style="width: 100%; text-align: center;" src="http://avatar.xboxlive.com/avatar/%1$s/avatarpic-l.png" /><p><a href="http://live.xbox.com/en-US/MyXbox/Profile?Gamertag=%1$s">%1$s</a></p>', 'xbox_live') , $gamertag );			
				break;
			case 'AvatarIconSmall':
printf(  __('<img style="width: 100%; text-align: center;" src="http://avatar.xboxlive.com/avatar/%1$s/avatarpic-s.png" /><p><a href="http://live.xbox.com/en-US/MyXbox/Profile?Gamertag=%1$s">%1$s</a></p>', 'xbox_live') , $gamertag );						
				break;
			}

		/* After widget (defined by themes). */
		echo $after_widget;
	}

	/**
	 * Update the widget settings.
	 */
	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;

		/* Strip tags for title and name to remove HTML (important for text inputs). */
		$instance['title'] = strip_tags( $new_instance['title'] );

		/* Strip tags for title and name to remove HTML (important for text inputs). */
		$instance['gamertag'] = strip_tags( $new_instance['gamertag'] );
		
		/* No need to strip tags for gamercard mode. */		
		$instance['widget_mode'] = $new_instance['widget_mode'];

		return $instance;
	}

	/**
	 * Displays the widget settings controls on the widget panel.
	 */
	function form( $instance ) {

		/* Set up some default widget settings. */
		$defaults = array( 'gamertag' => __('', 'xbox_live'), 'widget_mode' => __('GamerCard', 'xbox_live'));
		$instance = wp_parse_args( (array) $instance, $defaults ); ?>

		<!-- Title: Text Input -->
		<p>
			<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e('Title:', 'xbox_live'); ?></label>
			<input id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" value="<?php echo $instance['title']; ?>" style="width:100%;" />
		</p>

		<!-- Gamertag: Text Input -->
		<p>
			<label for="<?php echo $this->get_field_id( 'gamertag' ); ?>"><?php _e('Your Gamertag:', 'xbox_live'); ?></label>
			<input id="<?php echo $this->get_field_id( 'gamertag' ); ?>" name="<?php echo $this->get_field_name( 'gamertag' ); ?>" value="<?php echo $instance['gamertag']; ?>" style="width:100%;" />
		</p>

		<!-- WidgetMode: Select Box -->
		<p>
			<label for="<?php echo $this->get_field_id( 'widget_mode' ); ?>"><?php _e('Widget Mode:', 'example'); ?></label> 
			<select id="<?php echo $this->get_field_id( 'widget_mode' ); ?>" name="<?php echo $this->get_field_name( 'widget_mode' ); ?>" class="widefat" style="width:100%;">
				<option <?php if ( 'GamerCard' == $instance['widget_mode'] ) echo 'selected="selected"'; ?>>GamerCard</option>
				<option <?php if ( 'AvatarBody' == $instance['widget_mode'] ) echo 'selected="selected"'; ?>>AvatarBody</option>
				<option <?php if ( 'AvatarIconLarge' == $instance['widget_mode'] ) echo 'selected="selected"'; ?>>AvatarIconLarge</option>
				<option <?php if ( 'AvatarIconSmall' == $instance['widget_mode'] ) echo 'selected="selected"'; ?>>AvatarIconSmall</option>
			</select>
		</p>

	<?php
	}
}

?>