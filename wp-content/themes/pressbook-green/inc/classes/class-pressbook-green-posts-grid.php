<?php // phpcs:ignore WordPress.Files.FileName.NotHyphenatedLowercase
/**
 * Posts grid base class.
 *
 * @package PressBook_Green
 */

/**
 * Base class for posts grid service classes.
 */
abstract class PressBook_Green_Posts_Grid extends PressBook\Options {
	/**
	 * Posts Source.
	 *
	 * @return array
	 */
	public function source() {
		return array(
			''           => esc_html__( 'All Posts', 'pressbook-green' ),
			'categories' => esc_html__( 'Posts from Selected Categories', 'pressbook-green' ),
			'tags'       => esc_html__( 'Posts from Selected Tags', 'pressbook-green' ),
		);
	}

	/**
	 * Posts Count.
	 *
	 * @return array
	 */
	public function count() {
		return array(
			'1'  => esc_html_x( '1', 'Related Posts Count (Grid Layout)', 'pressbook-green' ),
			'2'  => esc_html_x( '2', 'Related Posts Count (Grid Layout)', 'pressbook-green' ),
			'3'  => esc_html_x( '3', 'Related Posts Count (Grid Layout)', 'pressbook-green' ),
			'4'  => esc_html_x( '4', 'Related Posts Count (Grid Layout)', 'pressbook-green' ),
			'5'  => esc_html_x( '5', 'Related Posts Count (Grid Layout)', 'pressbook-green' ),
			'6'  => esc_html_x( '6', 'Related Posts Count (Grid Layout)', 'pressbook-green' ),
			'7'  => esc_html_x( '7', 'Related Posts Count (Grid Layout)', 'pressbook-green' ),
			'8'  => esc_html_x( '8', 'Related Posts Count (Grid Layout)', 'pressbook-green' ),
			'9'  => esc_html_x( '9', 'Related Posts Count (Grid Layout)', 'pressbook-green' ),
			'10' => esc_html_x( '10', 'Related Posts Count (Grid Layout)', 'pressbook-green' ),
			'11' => esc_html_x( '11', 'Related Posts Count (Grid Layout)', 'pressbook-green' ),
			'12' => esc_html_x( '12', 'Related Posts Count (Grid Layout)', 'pressbook-green' ),
		);
	}

	/**
	 * Posts Order.
	 *
	 * @return array
	 */
	public function order() {
		return array(
			'desc' => esc_html__( 'Latest First', 'pressbook-green' ),
			'asc'  => esc_html__( 'Oldest First', 'pressbook-green' ),
		);
	}

	/**
	 * Posts Order By.
	 *
	 * @return array
	 */
	public function orderby() {
		return array(
			'rand'     => esc_html__( 'Random Order', 'pressbook-green' ),
			'date'     => esc_html__( 'Post Date', 'pressbook-green' ),
			'modified' => esc_html__( 'Last Modified Date', 'pressbook-green' ),
		);
	}
}
