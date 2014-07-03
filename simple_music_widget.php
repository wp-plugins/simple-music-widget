<?php
/**
 * Plugin Name: Simple Music Widget
 * Plugin URI: https://github.com/dolatabadi/WordPress-Plugins/tree/master/simple-music-widget
 * Description: This plugin creates a widget that can be used to display a music player which includes artist's name, song, album and a cover image.
 * Version: 1.0
 * Author: Dolatabadi
 * Author URI: https://github.com/dolatabadi
 * License: GNU General Public License v2
*/
function simeplemusicwidget_init() {
  load_plugin_textdomain( 'simeplemusicwidget', false, 'simple-music-widget/languages' );
}
add_action('init', 'simeplemusicwidget_init');

// loading custom style
function simple_music_widget_styles() {
		wp_register_style('simple_music_widget_styles', plugins_url('/css/style.css',__FILE__ ));
		wp_enqueue_style('simple_music_widget_styles');
}
add_action( 'init','simple_music_widget_styles');

class simple_music_widget extends WP_Widget {
	public function __construct() {
		parent::__construct(
	 		'Simple_music_widget',
			'Simple music widget',
			array( 'description' => __( 'Displays a music widget', 'simeplemusicwidget' ), ) // Args
		);
	}
	// display the widget
	function widget($args, $instance) {	
        extract( $args );
        $title 	= apply_filters('widget_title', $instance['title']);
		$artist = $instance['artist'];
		$song 	= $instance['song'];
		$album 	= $instance['album'];
		$cover 	= $instance['cover'];
		$url 	= $instance['url'];
		$description = $instance['description'];
        ?>
		<?php echo $before_widget; ?>
			<?php if ( $title )
				echo $before_title . $title . $after_title; ?>	      
			<div class="simple-music-widget">
					<!-- album cover -->
					<div class="artwork">
						<?php echo '<img alt="audio" src="'.$cover.'">'; ?>
					</div>
					<!-- song details -->
					<div class="songspecific songsmall">
					<?php echo '<p><strong>Artist: </strong>'.$artist.'<br><strong>Song: </strong>'.$song.'<br><strong>Album: </strong>'.$album.'</p>';?>
					</div>
					<!-- song URL -->
					<?php echo '<audio preload="" controls="" src="'.$url.'"><p>Your browser does not support the audio element.</p></audio>'; ?>
			</div><!-- end .audio -->
			<!-- short description -->
			<div class="meta">
				<?php echo $description; ?>
			</div>	
              <?php echo $after_widget; ?>
        <?php
    }
	// update the widget fields
	function update($new_instance, $old_instance) {		
		$instance = $old_instance;
		$instance['title'] = strip_tags($new_instance['title']);
		$instance['artist'] = strip_tags($new_instance['artist']);
		$instance['song'] = strip_tags($new_instance['song']);
		$instance['album'] = strip_tags($new_instance['album']);
		$instance['cover'] = strip_tags($new_instance['cover']);
		$instance['url'] = strip_tags($new_instance['url']);
		$instance['description'] = strip_tags($new_instance['description']);
        return $instance;
    }
	
	// creating the forms
	function form($instance) {	
	if( $instance) {
		$title = esc_attr($instance['title']); // widget title
		$artist = esc_attr($instance['artist']); // artist name
		$song = esc_attr($instance['song']); // song name
		$album = esc_attr($instance['album']); // album name
		$cover = esc_attr($instance['cover']); // cover image URL
		$url = esc_attr($instance['url']); // music file URL
		$description = esc_attr($instance['description']); // description of the song
	} else { 
		$title = ''; 
		$artist = ''; 
		$song = ''; 
		$album = '';
		$cover = '';
		$url = '';
		$description = '';
		}
        ?>
		<p>
			<label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title :', 'simeplemusicwidget'); ?></label> 
			<input class="widefat" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>" />
        </p>
        <p>
			<label for="<?php echo $this->get_field_id('artist'); ?>"><?php _e('Artist :', 'simeplemusicwidget'); ?></label> 
			<input class="widefat" name="<?php echo $this->get_field_name('artist'); ?>" type="text" value="<?php echo $artist; ?>" />
        </p>
		<p>
			<label for="<?php echo $this->get_field_id('song'); ?>"><?php _e('Song :', 'simeplemusicwidget'); ?></label> 
			<input class="widefat" name="<?php echo $this->get_field_name('song'); ?>" type="text" value="<?php echo $song; ?>" />
        </p>
		<p>
			<label for="<?php echo $this->get_field_id('album'); ?>"><?php _e('Album :', 'simeplemusicwidget'); ?></label> 
			<input class="widefat" name="<?php echo $this->get_field_name('album'); ?>" type="text" value="<?php echo $album; ?>" />
        </p>
		<p>
			<label for="<?php echo $this->get_field_id('cover'); ?>"><?php _e('Cover Photo : (preferred image size is 56x86 pixels)', 'simeplemusicwidget'); ?></label> 
			<input class="widefat" name="<?php echo $this->get_field_name('cover'); ?>" type="text" value="<?php echo $cover; ?>" />
        </p>
		<p>
			<label for="<?php echo $this->get_field_id('url'); ?>"><?php _e('Direct URL : (www.example.com/sample.mp3)', 'simeplemusicwidget'); ?></label> 
			<input class="widefat" name="<?php echo $this->get_field_name('url'); ?>" type="text" value="<?php echo $url; ?>" />
        </p>
		<p>
			<label for="<?php echo $this->get_field_id('description'); ?>"><?php _e('Description :', 'simeplemusicwidget'); ?></label> 
			<textarea rows="4" class="widefat" name="<?php echo $this->get_field_name('description'); ?>" type="text" id="<?php echo $this->get_field_id('description'); ?>"><?php echo $description; ?></textarea> 
        </p>
        <?php 
    }
} // end
// widget registration
add_action('widgets_init', create_function('', 'return register_widget("simple_music_widget");'));
?>