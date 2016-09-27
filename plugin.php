<?php
/**
 * Plugin Name: The Events Calendar Extension: Add Link to Return to Current Month in Month View
 * Description: Add a "Back to Current" month link between the "Previous Month" and "Next Month" links on Month View.
 * Version: 1.0.0
 * Author: Modern Tribe, Inc.
 * Author URI: http://m.tri.be/1971
 * License: GPLv2 or later
 */

defined( 'WPINC' ) or die;

class Tribe__Extension__Add_Link_to_Return_to_Current_Month_in_Month_View {

    /**
     * The semantic version number of this extension; should always match the plugin header.
     */
    const VERSION = '1.0.0';

    /**
     * Each plugin required by this extension
     *
     * @var array Plugins are listed in 'main class' => 'minimum version #' format
     */
    public $plugins_required = array(
        'Tribe__Events__Main' => '4.2'
    );

    /**
     * The constructor; delays initializing the extension until all other plugins are loaded.
     */
    public function __construct() {
        add_action( 'plugins_loaded', array( $this, 'init' ), 100 );
    }

    /**
     * Extension hooks and initialization; exits if the extension is not authorized by Tribe Common to run.
     */
    public function init() {

        // Exit early if our framework is saying this extension should not run.
        if ( ! function_exists( 'tribe_register_plugin' ) || ! tribe_register_plugin( __FILE__, __CLASS__, self::VERSION, $this->plugins_required ) ) {
            return;
        }

        add_filter( 'tribe_events_the_previous_month_link', array( $this, 'add_back_to_current_month_link' ) );
        add_action( 'tribe_events_before_nav', array( $this, 'add_back_to_current_month_link_css' ) );
    }

    /**
     * Add some CSS for the  "Back to Current Month" link.
     *
     * @return string
     */
    public function add_back_to_current_month_link_css() {

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

    /**
     * Add a "Back to Current Month" link between previous and next month links.
     *
     * @return string
     */
    public function add_back_to_current_month_link( $html ) {

        if ( date_i18n( 'Y-m-01' ) !== tribe_get_month_view_date() ) {
            $html .= sprintf( '<li class="tribe-events-nav-current"><a href="%s">Back to Current Month</a></li>', Tribe__Events__Main::instance()->getLink( 'month' ) );
        }

        return $html;
    }
}

new Tribe__Extension__Add_Link_to_Return_to_Current_Month_in_Month_View();
