<?php

/**
 * Theme Contact Info Widget
 * @package Highlt
 * @since 1.0.0
 */

if (!defined('ABSPATH')) {
	exit(); //exit if access directly
}

class Highlt_Contact_Info_Widget extends WP_Widget
{

	public function __construct()
	{
		parent::__construct(
			'highlt_contact_info',
			esc_html__('Highlt: Contact Info', 'highlt-core'),
			array('description' => esc_html__('Display contact info widget', 'highlt-core'))
		);
	}

	public function form($instance)
	{
		$title = isset($instance['title']) ? $instance['title'] : '';
		$contact_info = array(
			'location',
			'phone',
			'email'
		);
		foreach ($contact_info as $ci) {
			if (! isset($instance[$ci])) {
				$instance[$ci] = "";
			}
		}
?>
		<p>
			<label for="<?php echo esc_attr($this->get_field_id('title')); ?>"><?php esc_html_e('Title:', 'highlt-core'); ?></label>
			<input type="text" class="widefat" id="<?php echo esc_attr($this->get_field_id('title')) ?>" name="<?php echo esc_attr($this->get_field_name('title')); ?>" value="<?php echo esc_attr($title) ?>">
		</p>
		<?php foreach ($contact_info as $ci) : ?>
			<p>
				<label for="<?php echo esc_attr($this->get_field_id($ci)); ?>"><?php echo esc_html(ucfirst($ci) . " " . esc_html__('Info', 'highlt-core')); ?>
					: </label>
				<br />
				<input class="widefat" type="text" id="<?php echo esc_attr($this->get_field_id($ci)); ?>"
					name="<?php echo esc_attr($this->get_field_name($ci)); ?>"
					value="<?php echo esc_attr($instance[$ci]); ?>" />
				<small><?php echo esc_html__('Leave it blank if you don\'t want to show this info', 'highlt-core') ?></small>
			</p>

		<?php endforeach;
	}
	public function widget($args, $instance)
	{
		$title = isset($instance['title']) ? apply_filters('widget_title', $instance['title']) : '';
		echo wp_kses_post($args['before_widget']);
		//widget title
		if (! empty($title)) {
			echo wp_kses_post($args['before_title']) . esc_html($title) . wp_kses_post($args['after_title']);
		}
		?>

<?php
		if (!empty($instance['email']) || !empty($instance['location']) || !empty($instance['phone'])):
			echo wp_kses_post(' <ul class="contact_info_list">');
			printf('   <li class="single-info-item"> <div class="icon"> <svg width="19" height="17" viewBox="0 0 19 17" fill="none" xmlns="http://www.w3.org/2000/svg">
<path d="M3.125 0.477051C2.2962 0.477051 1.50134 0.81946 0.915291 1.42895C0.32924 2.03845 0 2.8651 0 3.72705V4.05368L9.375 9.30405L18.75 4.0553V3.72705C18.75 2.8651 18.4208 2.03845 17.8347 1.42895C17.2487 0.81946 16.4538 0.477051 15.625 0.477051H3.125ZM18.75 5.89968L9.74531 10.942C9.6315 11.0058 9.50426 11.0391 9.375 11.0391C9.24574 11.0391 9.1185 11.0058 9.00469 10.942L0 5.89968V13.4771C0 14.339 0.32924 15.1657 0.915291 15.7751C1.50134 16.3846 2.2962 16.7271 3.125 16.7271H15.625C16.4538 16.7271 17.2487 16.3846 17.8347 15.7751C18.4208 15.1657 18.75 14.339 18.75 13.4771V5.89968Z" fill="url(#paint0_linear_36_252)"/>
<defs>
<linearGradient id="paint0_linear_36_252" x1="9.375" y1="0.477051" x2="9.375" y2="16.7271" gradientUnits="userSpaceOnUse">
<stop stop-color="#FFBE01"/>
<stop offset="1" stop-color="#FF5B01" stop-opacity="0.9"/>
</linearGradient>
</defs>
</svg>
</div>  <span class="details"> %s </span></li>', esc_html($instance['email']));
			printf('   <li class="single-info-item"> <div class="icon"> <svg width="17" height="23" viewBox="0 0 17 23" fill="none" xmlns="http://www.w3.org/2000/svg">
<path d="M8.26144 8.04085L6.53852 9.64852C6.7647 10.4598 7.08291 11.2403 7.48644 11.9733C7.90643 12.7014 8.41168 13.3724 8.9906 13.971L11.2219 13.256C12.4719 12.8552 13.8364 13.2668 14.6677 14.296L15.9385 15.869C16.4531 16.5005 16.711 17.3155 16.6577 18.1413C16.6045 18.9672 16.2441 19.739 15.6531 20.2934C13.5802 22.2607 10.3885 22.9258 7.99894 20.9737C5.89879 19.2539 4.12181 17.1458 2.75727 14.7554C1.38973 12.3761 0.47453 9.74577 0.0614385 7.00735C-0.396895 3.92635 1.77186 1.46068 4.47602 0.620016C6.08852 0.117349 7.80935 0.979682 8.40102 2.58735L9.09894 4.48318C9.55727 5.73118 9.2281 7.13735 8.26144 8.03868V8.04085Z" fill="url(#paint0_linear_36_257)"/>
<defs>
<linearGradient id="paint0_linear_36_257" x1="8.3323" y1="0.477051" x2="8.3323" y2="22.1458" gradientUnits="userSpaceOnUse">
<stop stop-color="#0BDB90"/>
<stop offset="1" stop-color="#3AE33A" stop-opacity="0.65"/>
</linearGradient>
</defs>
</svg>

 </div> <span class="details"> %s </span></li>', esc_html($instance['phone']));
			printf('   <li class="single-info-item"> <div class="icon"> <svg width="15" height="20" viewBox="0 0 15 20" fill="none" xmlns="http://www.w3.org/2000/svg">
<path d="M7.29167 19.2307C5.97598 18.1084 4.75645 16.8781 3.64583 15.5526C1.97917 13.562 9.15515e-07 10.5974 9.15515e-07 7.77237C-0.000721895 6.32963 0.426572 4.91909 1.22781 3.71928C2.02904 2.51946 3.1682 1.58431 4.50111 1.03216C5.83403 0.480016 7.30078 0.335697 8.71575 0.617469C10.1307 0.899242 11.4303 1.59444 12.45 2.61508C13.1289 3.29098 13.667 4.09481 14.0332 4.98005C14.3994 5.8653 14.5864 6.81438 14.5833 7.77237C14.5833 10.5974 12.6042 13.562 10.9375 15.5526C9.82688 16.8781 8.60735 18.1084 7.29167 19.2307ZM7.29167 4.64737C6.46287 4.64737 5.66801 4.97661 5.08196 5.56267C4.49591 6.14872 4.16667 6.94357 4.16667 7.77237C4.16667 8.60118 4.49591 9.39603 5.08196 9.98208C5.66801 10.5681 6.46287 10.8974 7.29167 10.8974C8.12047 10.8974 8.91533 10.5681 9.50138 9.98208C10.0874 9.39603 10.4167 8.60118 10.4167 7.77237C10.4167 6.94357 10.0874 6.14872 9.50138 5.56267C8.91533 4.97661 8.12047 4.64737 7.29167 4.64737Z" fill="url(#paint0_linear_36_261)"/>
<defs>
<linearGradient id="paint0_linear_36_261" x1="7.29169" y1="0.477051" x2="7.29169" y2="19.2307" gradientUnits="userSpaceOnUse">
<stop stop-color="#407BFF"/>
<stop offset="1" stop-color="#407BFF" stop-opacity="0.65"/>
</linearGradient>
</defs>
</svg>
</div>  <span class="details"> %s </span></li>', esc_html($instance['location']));
			echo wp_kses_post('</ul>');
		endif;


		echo wp_kses_post($args['after_widget']);
	}

	public function update($new_instance, $old_instance)
	{
		$instance = array();
		$instance['location']  = sanitize_text_field($new_instance['location']);
		$instance['title']     = sanitize_text_field($new_instance['title']);
		$instance['phone']     = sanitize_text_field($new_instance['phone']);
		$instance['email']     = sanitize_text_field($new_instance['email']);

		return $instance;
	}
}

if (!function_exists('Highlt_Contact_Info_Widget')) {
	function Highlt_Contact_Info_Widget()
	{
		register_widget('Highlt_Contact_Info_Widget');
	}
	add_action('widgets_init', 'Highlt_Contact_Info_Widget');
}
