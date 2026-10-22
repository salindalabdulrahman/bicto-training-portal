wp.customize.bind( 'ready', function() {

	// Contextual: Header Posts Grid Source.
	wp.customize( ( 'set_header_posts_grid[source]' ), function( value ) {
		var setupControl = function( source ) {

			return function( control ) {
				var setActiveState, isDisplayed;

				isDisplayed = function() {
					return ( source === value.get() );
				};

				setActiveState = function() {
					control.active.set( isDisplayed() );
				};

				control.active.validate = isDisplayed;
				setActiveState();
				value.bind( setActiveState );
			};

		};

		wp.customize.control( ( 'set_header_posts_grid[categories]' ), setupControl( 'categories' ) );
		wp.customize.control( ( 'set_header_posts_grid[tags]' ), setupControl( 'tags' ) );
	} );

} );
