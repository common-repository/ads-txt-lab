<?php
/**
 * Created by Sebastian Viereck IT-Services
 * www.sebastianviereck.de
 * Date: 24.10.17
 * Time: 14:01
 */
//require_once '../AdsTxtLabMain.php';
defined('ABSPATH') or die('No script kiddies please!');
$adsTxtLabMain = new AdsTxtLabMain();
$updateSucces = false;
$validationError = false;
$error = false;
if(isset($_POST['submit']) && wp_verify_nonce( $_POST['_wpnonce'], AdsTxtLabMain::getAdminUrl() )){
    check_admin_referer( AdsTxtLabMain::getAdminUrl() );
    $id = $_POST['ads_txt_id'];
    $id = trim($id);
    if($adsTxtLabMain->checkId($id)){
        try{
            $adsTxtLabMain->updateHtaccess($id);
            $updateSucces = true;
        }
        catch(Exception $e){
            $error = $e->getMessage();
        }
        update_option( AdsTxtLabMain::OPTION_ID, $id );
    }
    else{
        $validationError = 'the ads.txt lab ID did not match, it should be a string like: abc123abc4321';
    }
}

?>
<div class="wrap">
    <h1>
        ads.txt lab
    </h1>

    <?php if ($error) : ?>
        <div>
            <p class="notice notice-error">
                <?php _e( "the .htaccess could not be written, please insert the following code manually:"); ?>
            </p>
        </div>
        <p class="notice notice-error">
            <?php echo nl2br(esc_attr($adsTxtLabMain->getRedirectRule($id))) ?>
        </p>
    <?php endif; ?>
    <?php if ($validationError) : ?>
        <div>
            <p class="notice notice-error">
                <?php _e( $validationError); ?>
            </p>
        </div>
    <?php endif; ?>
    <?php if ($updateSucces) : ?>
        <div>
            <p class="notice notice-success">
                <?php _e( ".htaccess updated"); ?>
            </p>
        </div>
    <?php endif; ?>
    <p>Please insert your ads.txt lab ID here:</p>

    <form method="post" >

        <?php echo wp_nonce_field(AdsTxtLabMain::getAdminUrl()) ?>
        <input type="text" name="ads_txt_id" id="ads_txt_id"  value="<?php echo esc_attr( get_option(AdsTxtLabMain::OPTION_ID) ); ?>" />

        <?php submit_button(); ?>

    </form>
    <p>
        if you don’t yet have an ID, please register for free at <a target="_blank" href="http://www.adstxtlab.com/">www.adstxtlab.com</a>
    </p>
</div>