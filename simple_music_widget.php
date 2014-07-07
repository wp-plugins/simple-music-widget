<?php
/**
 * Plugin Name: Simple Music Widget
 * Plugin URI: https://github.com/dolatabadi/WordPress-Plugins/tree/master/simple-music-widget
 * Description: This plugin creates a widget that can be used to display a music player which includes artist's name, song, album and a cover image.
 * Version: 1.1
 * Author: Dolatabadi
 * Author URI: https://github.com/dolatabadi
 * License: GNU General Public License v2
*/

/**
 * Loading language files.
 */
function simple_music_widget_init() {
  load_plugin_textdomain( 'simple-music-widget', false, basename( dirname( __FILE__ ) ) . '/languages');
}
add_action('init', 'simple_music_widget_init');

/**
 * Loading custom style for the widget.
 */
function simple_music_widget_styles() {
		wp_register_style('simple_music_widget_styles', plugins_url('/css/style.css',__FILE__ ));
		wp_enqueue_style('simple_music_widget_styles');
}
add_action( 'init','simple_music_widget_styles');

/**
 * Adding the widget.
 */
class simple_music_widget extends WP_Widget {
	public function __construct() {
		parent::__construct(
	 		'Simple_music_widget',
			__('Simple Music Widget', 'simple-music-widget'),
			array( 'description' => __( 'Displays a music widget', 'simple-music-widget' ), )
		);
	}
	/**
	* Displays the widget.
	*/
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
					<?php
					printf(__('<p><strong>Artist:</strong> %s<br><strong>Song:</strong> %s <br><strong>Album:</strong> %s </p>','simple-music-widget'),$artist, $song, $album);
					?>
					</div>
					<!-- song URL -->
					<?php echo '<audio preload="" controls="" src="'.$url.'"><p>Your browser does not support the audio element.</p></audio>'; ?>
			</div>
			<!-- description -->
			<div class="meta">
				<?php echo $description; ?>
			</div>	
              <?php echo $after_widget; ?>
        <?php
    }
	/**
	* Update the widget fields.
	*/
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
	
	/**
	* Creating the widget fields.
	*/
	function form($instance) {	
	if( $instance) {
		$title = esc_attr($instance['title']);
		$artist = esc_attr($instance['artist']);
		$song = esc_attr($instance['song']);
		$album = esc_attr($instance['album']);
		$cover = esc_attr($instance['cover']);
		$url = esc_attr($instance['url']);
		$description = esc_attr($instance['description']);
	} else { 
			$title = ''; $artist = ''; $song = ''; $album = ''; $cover = '';$url = '';$description = '';
		}
        ?>
		<p>
			<label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title :', 'simple-music-widget'); ?></label> 
			<input class="widefat" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>" />
        </p>
        <p>
			<label for="<?php echo $this->get_field_id('artist'); ?>"><?php _e('Artist :', 'simple-music-widget'); ?></label> 
			<input class="widefat" name="<?php echo $this->get_field_name('artist'); ?>" type="text" value="<?php echo $artist; ?>" />
        </p>
		<p>
			<label for="<?php echo $this->get_field_id('song'); ?>"><?php _e('Song :', 'simple-music-widget'); ?></label> 
			<input class="widefat" name="<?php echo $this->get_field_name('song'); ?>" type="text" value="<?php echo $song; ?>" />
        </p>
		<p>
			<label for="<?php echo $this->get_field_id('album'); ?>"><?php _e('Album :', 'simple-music-widget'); ?></label> 
			<input class="widefat" name="<?php echo $this->get_field_name('album'); ?>" type="text" value="<?php echo $album; ?>" />
        </p>
		<p>
			<label for="<?php echo $this->get_field_id('cover'); ?>"><?php _e('Cover Photo : (preferred image size is 56x86 pixels)', 'simple-music-widget'); ?></label> 
			<input class="widefat" name="<?php echo $this->get_field_name('cover'); ?>" type="text" value="<?php echo $cover; ?>" />
        </p>
		<p>
			<label for="<?php echo $this->get_field_id('url'); ?>"><?php _e('Direct URL : (www.example.com/sample.mp3)', 'simple-music-widget'); ?></label> 
			<input class="widefat" name="<?php echo $this->get_field_name('url'); ?>" type="text" value="<?php echo $url; ?>" />
        </p>
		<p>
			<label for="<?php echo $this->get_field_id('description'); ?>"><?php _e('Description :', 'simple-music-widget'); ?></label> 
			<textarea rows="4" class="widefat" name="<?php echo $this->get_field_name('description'); ?>" type="text" id="<?php echo $this->get_field_id('description'); ?>"><?php echo $description; ?></textarea> 
        </p>
        <?php 
    }
}
/**
 * Widget registration.
 */
add_action('widgets_init', create_function('', 'return register_widget("simple_music_widget");'));
?>