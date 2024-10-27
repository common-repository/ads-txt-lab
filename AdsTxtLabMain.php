<?php

/**
 * Created by Sebastian Viereck IT-Services
 * www.sebastianviereck.de
 * Date: 24.10.17
 * Time: 14:01
 */
class AdsTxtLabMain
{
    const ADMIN_URL = 'ads_txt_lab_admin';
    const OPTION_GROUP = 'ads_txt_lab_option_group';
    const OPTION_ID = 'ads_txt_lab_option_id';

    const HTACCESS_MARKER_NAME = 'AdsTxtLab';

    public static function getAdminUrl()
    {
        return "options-general.php?page=" . AdsTxtLabMain::ADMIN_URL;
    }

    public function checkId($id){
        if(strlen($id) > 32){
            return false;
        }
        if(!preg_match('/^[0-9a-z]+$/', $id)){
            return false;
        }
        return true;
    }

    public function updateHtaccess($id){
        $htaccess = $this->getWordpressRoot().'.htaccess';
        if(!file_exists($htaccess)){
            //create htaccess
            file_put_contents($htaccess, '');
            chmod($htaccess, 0664);
        }
        if(file_exists($htaccess)){
            if(is_writable($htaccess)){
                $content = $this->getRedirectRule($id);
                insert_with_markers($htaccess, self::HTACCESS_MARKER_NAME, $content);
                return true;
            }
            else{
                throw new Exception('.htaccess not writable');
            }
        }
        else{
            throw new Exception('.htaccess not found');
        }
    }

    public function getRedirectRule($id){
        return "Redirect 301 /ads.txt https://www.adstxtlab.com/adstxt.php?id=$id";
    }

    private function getWordpressRoot()
    {
        return ABSPATH;
    }
}