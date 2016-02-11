<?php
/**
 * Customizer custom controls
 *
 * Customizer hidden input field.
 *
 * @package     WebMan WordPress Theme Framework
 * @subpackage  Customize
 *
 * @since    1.0
 * @version  1.0
 */





class Firefly_Control_Hidden extends WP_Customize_Control {

	public $type = 'hidden';

	public function render_content() {
		?>

		<textarea <?php $this->link(); ?>><?php echo esc_textarea( $this->value() ); ?></textarea>

		<?php
	}

} // /Firefly_Control_Hidden
