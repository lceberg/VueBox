(function() {

	/* Text */
	Vue.component( 'vuebox-text', {
		props: ['title', 'name', 'value', 'caption']
	} );

	/* Textarea */
	Vue.component( 'vuebox-textarea', {
		props: ['title', 'name', 'value', 'caption']
	} );

	/* Colorpicker */
	Vue.component( 'vuebox-colorpicker', {
		ready: function() {
			jQuery( this.$el.children[1] ).wpColorPicker();
		},

		props: ['title', 'name', 'value', 'caption']
	} );

	/* Image */
	Vue.component( 'vuebox-image', {
		props: ['title', 'name', 'value', 'caption', 'url'],
		methods: {
			pickImage: function() {
				var _this      = this;
				var mediaFrame = false;

				if ( mediaFrame ) {
					mediaFrame.open();
				}

				mediaFrame = wp.media({
					multiple: false
				});

				mediaFrame.on( 'select', function() {
					var attachment = mediaFrame.state().get( 'selection' ).first().toJSON();

					_this.value = attachment.id;
					_this.url   = attachment.url;
				} );


				mediaFrame.open();
			},

			removeImage: function() {
				this.value = '';
				this.url   = false;
			}
		}
	} );

	/* Repeater */
	Vue.component( 'vuebox-repeater', {
		props: ['title', 'name', 'value', 'children', 'caption', 'fieldsets'],
		methods: {
			addFieldset: function() {
				this.fieldsets++;
			}
		}
	} );

})();