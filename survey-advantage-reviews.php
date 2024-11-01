<?php
/*
Plugin Name: Survey Advantage Reviews For WordPress
Version: 1.0.0
Plugin URI: http://SurveyAdvantage.com
Author: Survey Advantage
Author URI: http://www.SurveyAdvantage.com
Description: Display your Survey Advantage Reviews on your WordPress installation!
*/

function replaceShortcode ( $pageContent )
{
    $feedID = get_option('feed_id');

    if(!empty($feedID)) {
        $reviewsHTML = "<script type=\"text/javascript\" src=\"//SurveyAdvantageTools.com/LoudSpeaker/LoudSpeaker.js\"></script>
					<iframe class=\"surveyAdvantageTestimonialPublisherIFrame\" src=\"//SurveyAdvantageTools.com/LoudSpeaker/LS.php?LSID={$feedID}\" seamless=\"seamless\" allowtransparency=\"true\" frameborder=\"0\" scrolling=\"no\" width=\"100%\" height=\"100%\"></iframe>";
    } else {
        $reviewsHTML = "<div style='margin:20px;padding: 20px;border: 1px solid #CCC;'>Please configure your <strong>Survey Advantage Reviews</strong> plugin via your WordPress Admin section.</div>";
    }

	$pageContent = str_replace('[Survey-Advantage-Reviews]', $reviewsHTML, $pageContent);

	return $pageContent;
}

if (function_exists('add_filter'))
{
	add_filter('the_content', 'replaceShortcode', 1);
}


/********************************/


add_action('admin_menu', 'plugin_create_menu');
function plugin_create_menu() {
    add_menu_page('Survey Advantage Reviews Plugin Settings', 'Survey Advantage Reviews', 'administrator', __FILE__, 'plugin_settings_page' , plugins_url('/images/icon.png', __FILE__) );

    add_action( 'admin_init', 'register_plugin_settings' );
}

function register_plugin_settings() {
    register_setting( 'plugin-settings-group', 'feed_id' );
}

function plugin_settings_page() {
    if(!empty($_POST['page-dropdown'])){
        $my_post = array(
            'ID'           => $_POST['page-dropdown'],
            'post_content' => '[Survey-Advantage-Reviews]',
        );

        wp_update_post( $my_post );
    }
?>
    <h1 style="margin: 20px 0 40px 0;font-size: 300%;">Survey Advantage Reviews:</h1>
    <div class="wrap" style="width: 600px;margin: 0 auto;">

        <h3>Signup For Survey Advantage</h3>
        <div style="width: 550px;margin: 0 auto;">
            <p>Survey Advantage is the leader in customer feedback with survey design and administration generating real-time feedback, sales leads, testimonials, and 5-star reviews that enable you to:</p>
            <ul style="list-style: disc outside none;padding: 0 0 0 30px;">
                <li>Survey your customers on a regular basis gaining valuable insight into your customer's thoughts to assist you with growing your company.</li>
                <li>Gain new sales opportunities asking each respondent what products or services they may be buy from competitors.</li>
                <li>Track your company's growth in several key-areas utilizing our benchmark analytics comparing you to other companies in your industry and your other locations.</li>
            </ul>
            <p class="submit"><input name="submit" id="submit" class="button button-primary" onclick="window.location.href='http://SurveyAdvantage.com/learn_more';" value="Sign Up Now" type="submit"></p>
        </div>

        <hr style="margin: 40px 0 20px 0;">

        <h2>Step 1:</h2>
        <form method="post" action="options.php" style="width: 400px;margin: 0 auto;">
            <?php settings_fields( 'plugin-settings-group' ); ?>
            <?php do_settings_sections( 'plugin-settings-group' ); ?>
            <p><strong>Note:</strong> Your Feed ID can be obtained from your Survey Advantage Dashboard under the "Marketing Module" section.</p>
            <table class="form-table">
                <tr valign="top">
                    <th scope="row">Feed ID</th>
                    <td><input type="text" name="feed_id" value="<?php echo esc_attr( get_option('feed_id') ); ?>" /></td>
                </tr>
            </table>

            <?php submit_button(); ?>
        </form>

        <h2 style="margin-top: 40px;">Step 2:</h2>
        <form method="post" style="width: 400px;margin: 0 auto;">
            <p><strong>Note:</strong> All content on this page will be <strong>ERASED</strong>. Please ensure that you <strong>backup any important data</strong> you wish to keep.</p>
            <table class="form-table">
                <tr valign="top">
                    <th scope="row">Testimonials Page</th>
                    <td>
                        <select name="page-dropdown">
                            <option value=""><?php echo esc_attr( __( 'Select page' ) ); ?></option>
                            <?php
                            $pages = get_pages();
                            foreach ( $pages as $page ) {
                                $option = '<option value="' . $page->ID . '">';
                                $option .= $page->post_title;
                                $option .= '</option>';
                                echo $option;
                            }
                            ?>
                        </select>
                    </td>
                </tr>
            </table>

            <p class="submit"><input name="submit" id="submit" class="button button-primary" value="Update Page" type="submit"></p>
        </form>

        <h2 style="margin-top: 40px;">Done!</h2>
        <div style="width: 400px;margin: 0 auto;">
            <p>That's it - Your Done! What? Did you <i>want</i> it to be harder? :)</p>
        </div>

        <hr style="margin: 80px 0;">

        <h3>Advanced Usage:</h3>
        <div style="width: 400px;margin: 0 auto;">
            <h4 style="margin-top: 20px;">Shortcode:</h4>
            <center><code style="padding: 10px;font-size:150%;">[Survey-Advantage-Reviews]</code></center>
            <p style="margin-top: 30px;">To have more control over the placement of your Survey Advantage Testimonial Publisher's location on your website:</p>
            <ol>
                <li>Enter Feed ID on Step 1 above.</li>
                <li>Place the shortcode above on the page where you wish for the feed to display.</li>
            </ol>
        </div>
    </div>
<?php }