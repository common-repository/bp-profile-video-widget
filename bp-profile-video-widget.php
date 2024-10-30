<?php

/* Hooks & Filters */

add_action( 'widgets_init', 'slush_bpprofilevideo_widget_fn' );

/***** BP Profile Player Widget *****/

/* Creates the widget itself */

class Slushman_bpprofilevideo_widget extends WP_Widget {

	function Slushman_bpprofilevideo_widget() {
	
		$widget_ops = array( 'classname' => 'slushman-bpprofilevideo-widget', 'description' => __( 'BP Profile Video Widget', 'slushman-bpprofilevideo-widget' ) );
		
		$this->WP_Widget( 'bpprofilevideo_widget', __( 'BP Profile Video Widget' ), $widget_ops );
		
	} // End of Slushman_bpprofilevideo_widget()
	
	function widget( $args, $instance ) {
	
		extract( $args );
		
		echo $before_widget;
		
		$title = empty( $instance['title'] ) ? '' : apply_filters( 'widget_title', $instance['title'] );
		
		echo ( empty( $title ) ? '' : $before_title . $title . $after_title );
				
		do_action( 'bp_before_sidebar_me' ); ?>
		
		<div id="sidebar-me"><?php
		
// Get widget options and profile data

		$videoURL		= xprofile_get_field_data( "Video URL" );	
		$description 	= xprofile_get_field_data( "Video Player Description" );
		$width 			= $instance['width'];
		$aspect 		= $instance['aspect'];
		
// Determine the height from the width and aspect ratio in the Widget options

		if ( !empty( $aspect ) ) { $multiplier = ( $aspect == "Normal" ? .75 : ( $aspect == "HD" ? .5625 : '' ) ); }

		$height 				= ( ( $width * $multiplier ) + 25 );
		list( $prefix,, $site ) = explode( '/', $videoURL );
		list( $a, $b, $c ) 		= explode( '.', $site );
		$service 				= ( $a == 'www' ? $b : $a );
		
// Get the correct correct video ID based on the service
		if ( !empty( $service ) && $service == 'youtube' ) {
		
			$ytvIDlen = 11;	// This is the length of YouTube's video IDs
		
			// For youtube.com/watch? URLs
			$idStarts = strpos( $videoURL, "?v=" );
			
			// In case the "v=" is NOT right after the "?"
			if( $idStarts === FALSE ) { $idStarts = strpos( $videoURL, "&v=" ); }
			
			// For the new shortened URLs
			if( $idStarts === FALSE ) { $idStarts = strpos( $videoURL, "be/" ); }
			
			// If still FALSE, URL doesn't have a vid ID
			if( $idStarts === FALSE ) {	die( "YouTube video ID not found. Please double-check your URL." ); }
			
			// Offset the start location to match the beginning of the ID string
			$idStarts +=3;
			
			// Get the ID string and return it
			$videoID 	= substr( $videoURL, $idStarts, $ytvIDlen );
			$serv		= 'YT';
						
		} elseif ( !empty( $service ) && $service == 'youtu' ) {
		
			$videoID 	= end( explode( '/', $videoURL ) );
			$serv		= 'YT';
		
		} elseif ( !empty( $service ) && $service == 'vimeo' ) {
		
			$videoID = end( explode( '/', $videoURL ) );
		
		} elseif ( !empty( $service ) && $service == 'facebook' ) {
		
			// Length of Facebook's video IDs
			$fbvIDlen = 17;
		
			$idStarts = strpos( $videoURL, "?v=" );
			
			// Offset the start location to match the beginning of the ID string
			$idStarts +=3;
			
			// Get the ID string and return it
			$videoID = substr( $videoURL, $idStarts, $fbvIDlen );
			
		} elseif ( !empty( $service ) && $service == 'flickr' ) {
		
			
			
			list( $prefix,, $site,, $user, $videoID ) = explode( '/', $videoURL );
			
		} // End of service check
				
// Get the correct embed code cased on the service
		
		if ( !empty( $service ) && $serv == 'YT' && !empty( $videoID ) ) { ?>
		
			<object width="<?php echo $width; ?>" height="<?php echo $height; ?>">
				<param name="movie" value="http://www.youtube.com/v/<?php echo $videoID; ?>&autoplay=0"></param>
				<param name="wmode" value="transparent"></param>
				<embed src="http://www.youtube.com/v/<?php echo $videoID; ?>&autoplay=0" type="application/x-shockwave-flash" wmode="transparent" width="<?php echo $width; ?>" height="<?php echo $height; ?>"></embed>
			</object><?php
		
		} elseif ( !empty( $service ) && $service == 'vimeo' && !empty( $videoID ) ) { ?>
		
			<iframe src="http://player.vimeo.com/video/<?php echo $videoID; ?>?byline=0&amp;portrait=0" width="<?php echo $width; ?>" height="<?php echo $height; ?>" frameborder="0"></iframe><?php
		
		} elseif ( !empty( $service ) && $service == 'facebook' && !empty( $videoID ) ) { ?>
		
			<object width="<?php echo $width; ?>" height="<?php echo $height; ?>" > 
				<param name="allowfullscreen" value="true" /> 
				<param name="allowscriptaccess" value="always" /> 
				<param name="movie" value="http://www.facebook.com/v/<?php echo $videoID; ?>" /> 
				<embed src="http://www.facebook.com/v/<?php echo $videoID; ?>" type="application/x-shockwave-flash" allowscriptaccess="always" allowfullscreen="true" width="<?php echo $width; ?>" height="<?php echo $height; ?>"></embed>
			</object><?php
		
		} else {
		
			echo '<p>' . $instance['emptymsg'] . '</p>';
		
		} // End of embed codes ?>
			
		<br /><br /><?php 
		
		echo ( isset( $description ) && !empty( $description ) ? $description : '' ) ;
		
		do_action( 'bp_sidebar_me' ); ?>
		
		</div><!-- End BP Profile Video Widget -->
		
		<?php do_action( 'bp_after_sidebar_me' );
		
		echo $after_widget;
		
	} // End of widget()
	
// Updates the widget
	
	function update( $new_instance, $old_instance ) {
	
		$instance 				= $old_instance;
		$instance['title'] 		= strip_tags( $new_instance['title'] );
		$instance['width'] 		= strip_tags( $new_instance['width'] );
		$instance['aspect'] 	= strip_tags( $new_instance['aspect'] );
		$instance['emptymsg'] 	= strip_tags( $new_instance['emptymsg'] );
		
		return $instance;
		
	} // End of update()
	
// Creates the widget options form
	
	function form( $instance ) {
	
		$defaults 	= array( 'title' => 'Video Player', 'width' => '','aspect' => 'Normal', 'emptymsg' => 'This user has not activated their video player.' );
		$instance 	= wp_parse_args( (array)$instance, array( 'title','width','aspect','emptymsg' ) );
		$title 		= esc_attr( $instance['title'] );
		$width 		= esc_attr( $instance['width'] );
		$aspect 	= esc_attr( $instance['aspect'] );
		$emptymsg 	= esc_attr( $instance['emptymsg'] ); ?>

		<p>
			<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title' ); ?>: 
			<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo $title; ?>" />
			</label>
		</p>
		
		<p>
			<label for="<?php echo $this->get_field_id( 'width' ); ?>"><?php _e( 'Width' ); ?>: 
			<input class="widefat" id="<?php echo $this->get_field_id( 'width' ); ?>" name="<?php echo $this->get_field_name( 'width' ); ?>" type="text" value="<?php echo $width; ?>" />
			</label>
		</p>
		
		<p>
			<label for="<?php echo $this->get_field_id( 'aspect' ); ?>"><?php _e( 'Aspect' ); ?>: 
			<select id="<?php echo $this->get_field_id( 'aspect' ); ?>" name="<?php echo $this->get_field_name( 'aspect' ); ?>">
				<option value="Normal" <?php selected( $aspect, 'Normal' ); ?>>Normal</option>
				<option value="HD" <?php selected( $aspect, 'HD' ); ?>>HD</option>
			</select>
			</label>
		</p>
		
		<p>
			<label for="<?php echo $this->get_field_id( 'emptymsg' ); ?>"><?php _e( 'Empty Message' ); ?>: 
			<input class="widefat" id="<?php echo $this->get_field_id( 'emptymsg' ); ?>" name="<?php echo $this->get_field_name( 'emptymsg' ); ?>" type="text" value="<?php echo $emptymsg; ?>" />
			</label>
		</p><?php

	} // End of form()

} // End of class Slushman_bpprofilevideo_widget()

function slush_bpprofilevideo_widget_fn() {

	register_widget( 'Slushman_bpprofilevideo_widget' );
	
} // End of slush_bpprofilevideo_widget_fn()

?>