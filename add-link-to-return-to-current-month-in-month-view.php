<?php
/**
 * Plugin Name: The Events Calendar — Add Link to Return to Current Month in Month View
 * Description: Add a "Back to Current" month link between the "Previous Month" and "Next Month" links on Month View.
 * Version: 1.0.0
 * Author: Modern Tribe, Inc.
 * Author URI: http://m.tri.be/1x
 * License: GPLv2 or later
 */
 
defined( 'WPINC' ) or die;

if ( class_exists( 'Tribe__Events__Main' ) ) {

	/**
	 * Add some CSS for the  "Back to Current Month" link.
	 *
	 * @return string
	 */
	function tribe_add_back_to_current_month_link_css() {

			if ( ! tribe_is_month() ) {
				return;
			}
		?>
			<style>
				ul.tribe-events-sub-nav > li {
					width: 32%;
					margin-right: 0;
					margin-left: 0;
					padding-left: 0;
					padding-right: 0;
				}
				ul.tribe-events-sub-nav > li.tribe-events-nav-current a {
					float: left;
					width: 100%;
					text-align: center;
				}
			</style>
		<?php
	}

	add_action( 'tribe_events_before_nav', 'tribe_add_back_to_current_month_link_css' );

	/**
	 * Add a "Back to Current Month" link between previous and next month links.
	 *
	 * @return string
	 */
	function tribe_add_back_to_current_month_link( $html ) {

		if ( date_i18n( 'Y-m-01' ) !== tribe_get_month_view_date() ) {
			$html .= sprintf( '<li class="tribe-events-nav-current"><a href="%s">Back to Current Month</a></li>', Tribe__Events__Main::instance()->getLink( 'month' ) );
		}

		return $html;
	}

	add_filter( 'tribe_events_the_previous_month_link', 'tribe_add_back_to_current_month_link' );
}
