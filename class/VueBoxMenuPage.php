<?php

class VueBoxMenuPage extends VueBoxContainer {

	public function fields( $fields ) {
		$this->data['fields'] = (array) $fields;

		add_action( 'admin_menu', array( $this, 'init_menu_page' ) );
		add_action( 'admin_init', array( $this, 'save_options' ) );

		return $this;
	}

	public function init_menu_page() {
		add_menu_page(
			$this->data['title'],
			$this->data['title'],
			'manage_options',
			'vuebox-' . sanitize_title( $this->data['title'] ),
			array( $this, 'render_menu_page' )
		);
	}

	public function render_menu_page() {
		$container_id = str_replace( '_', '-', $this->data['name'] ); ?>
		<div id="vuebox-<?php echo $container_id; ?>" class="vuebox-container" v-cloak>
			<div class="wrap">
				<h2><?php echo $this->data['title']; ?></h2>

				<form action="<?php echo add_query_arg( 'page', 'vuebox-' . sanitize_title( $this->data['title'] ) ); ?>" method="post">
					<?php vuebox_render_fields( $this, $this->data['fields'] ); ?>
					<div class="vuebox-form-actions">
						<input type="submit" class="button button-primary" value="<?php _e( 'Save Options', 'vuebox' ); ?>" />
					</div>
					<input type="hidden" name="vuebox-<?php echo $container_id; ?>" value="1" />
				</form>
			</div>
		</div>
		<?php
	}

	public function save_options() {
		$container_id = str_replace( '_', '-', $this->data['name'] );

		if ( ! isset( $_POST["vuebox-{$container_id}"] ) ) {
			return;
		}

		foreach ( $this->data['fields'] as $field ) {
			$field_name = $field->data['name'];

			if ( ! isset( $_POST[$field_name] ) ) {
				return;
			}

			update_option( $field_name, $_POST[$field_name] );
		}
	}

}
