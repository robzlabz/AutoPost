<?php 
/*
Plugin Name: AutoPost Agcmanager
Plugin URI: http://agcmanager.com/
Description: AyoPosting ! <a href="https://agcmanager.com/" target="_blank">AgcManager</a> akan bantu manage keyword dan postingan kamu
Author: Robbyn Rahmandaru
Version: 3.2
Author URI: http://blog.agcmanager.com/
*/

function fe($s) { return function_exists($s); }
function je($s) { return json_encode($s); }

add_action('admin_menu','agcm_addmenu');
function agcm_addmenu() {
    add_dashboard_page('AgcManager Connector', 'AGCM Connector', 'manage_options', 'agcm_index', 'agcm_index', plugins_url( 'tc.ico', __FILE__ ));
}

function agcm_index() {
    include __DIR__ . '/views/index.php';
}

function agcm_function(){
    $auth = get_option('agcm_authorization_key', '__auth__');
    if(isset($_POST['__agcmanager__' . get_option('agcm_token')])){ 
        el(serialize($_POST));
        if(isset($_POST['_p_'])){
            el('[' . date('d-m-y H:i:s') . '] Create Post ' . $_POST['title']);
            $cid = 0; /* BUAT CETGORY */
            $pid = wp_insert_post(array(
                'post_title' => $_POST['title'],
                'post_category' => array($cid),
                'post_name'  => sanitize_title_with_dashes($_POST['title']),
                'post_status' => 'draft',
                'post_author' => 1 
            ));
            if(empty($pid)) {
                echo json_encode(array('status' => 'err', 'message' => 'failed to create post'));
            } else {
                wp_set_post_tags($pid, $_POST['tags']);
                echo json_encode(array('status' => 'ok','pid' => $pid));
            }
        } elseif(isset($_POST['_at_'])) { // download image

            $atitle = remove_accents($_POST['atitle']);
            $pp = $_POST['pid'];
            $uimg = $_POST['image'];

            list($r, $e) = explode('&', $uimg);
            $uimg = urldecode(substr($r, 35, strlen($r)-1));
            el($uimg);

            el('[' . date('d-m-y H:i:s') . '] Posting Attachment ' . $_POST['atitle'] . ' - ' . $uimg);

            $ext = explode('.', $uimg);
            $ext = end($ext);
            if(empty($ext) || strlen($ext) > 4) {$ext = 'jpg';}

            $udir = wp_upload_dir();
            $fimg = $udir['path'] . '/' . sanitize_title_with_dashes($atitle) . '.' . $ext;
            $dimg = g($uimg);

            $fw = file_put_contents($fimg, $dimg);

            if($fw != false || ! empty($dimg)) {
                $attachment = array(
                    'guid'           => $udir['url'] . '/' . sanitize_title_with_dashes($atitle) . '.' . $ext, 
                    'post_mime_type' => 'image/' . $ext,
                    'post_title'     => $atitle,
                    'post_status'    => 'inherit',
                    'post_date'      =>  $_POST['date']
                );

                $attach_id = wp_insert_attachment( $attachment, $fimg, $pp );

                require_once( ABSPATH . 'wp-admin/includes/image.php' );

                $attach_data = wp_generate_attachment_metadata( $attach_id, $fimg );
                wp_update_attachment_metadata( $attach_id, $attach_data );

                set_post_thumbnail( $pp, $attach_id );

                if(empty($attach_id)) {
                    echo json_encode(array('status' => 'err', 'message' => 'failed to create attachment'));
                } else {
                    echo json_encode(array('status' => 'ok', 'aid' => $attach_id));
                }
                exit;
            }

            echo json_encode(array('status' => 'err', 'message' => 'Failed to save image'));
        } else if(isset($_POST['_pu_'])) {
            wp_update_post(array(
                'ID' => $_POST['pid'],
                'post_status' => 'publish'
            ), true);
            if(is_wp_error($_POST['pid'])){
                echo je(array('status' => 'error'));
            } else {
                echo je(array('status' => 'ok'));
            }
        } elseif(isset($_POST['_gg_'])) { 
            echo cmz(g($_POST['u'])); 
        }
        exit;
    } else if(isset($_POST['_ct_'])) {
        if($_POST['token'] == get_option('agcm_token')) {
            echo 'ok';
        } else {
            echo 'wrong token';
        }
        exit;
    }
}
add_action('init', 'agcm_function');


if( ! fe('sample') ) { function sample(){/* code here */}};

if( ! fe('gt') ) { function gt(){return base64_encode(rand(0,9999).'_agc'.rand(0,9999).'manager_'.rand(0,9999));}};
if( ! fe('cmz') ) { function cmz($d){ return preg_replace(array('/[\s]+/'), ' ', $d); }};
if( ! fe('el') ) { function el($d){file_put_contents(__DIR__.'/log.txt', $d . "\n", FILE_APPEND);}};

if( ! fe('g') ) { function g($u){
    $ua = explode('|', 'Mozilla/5.0 (Windows NT 6.1; WOW64; rv:40.0) Gecko/20100101 Firefox/40.1|Mozilla/5.0 (Windows NT 6.3; rv:36.0) Gecko/20100101 Firefox/36.0|Mozilla/5.0 (Macintosh; Intel Mac OS X 10_10; rv:33.0) Gecko/20100101 Firefox/33.0');
    $c = curl_init(); 
    curl_setopt($c, CURLOPT_URL, $u); 
    curl_setopt($c, CURLOPT_FOLLOWLOCATION, true);
    curl_setopt($c, CURLOPT_RETURNTRANSFER, 1); 
    curl_setopt($c, CURLOPT_USERAGENT, $ua[rand(0, count($ua)-1)]);
    $r = curl_exec($c); 
    curl_close($c);      
    return $r;
}};

if( ! fe('p') ) { function p($u, array $d){
    $ua = explode('|','Mozilla/5.0 (Windows NT 6.1; WOW64; rv:40.0) Gecko/20100101 Firefox/40.1|Mozilla/5.0 (Windows NT 6.3; rv:36.0) Gecko/20100101 Firefox/36.0|Mozilla/5.0 (Macintosh; Intel Mac OS X 10_10; rv:33.0) Gecko/20100101 Firefox/33.0');
    $c = curl_init();
    curl_setopt($c, CURLOPT_URL, $u);
    curl_setopt($c, CURLOPT_POST, true);
    curl_setopt($c, CURLOPT_FOLLOWLOCATION, true);
    curl_setopt($c, CURLOPT_POSTFIELDS, http_build_query($d));
    curl_setopt($c, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($c, CURLOPT_USERAGENT, $ua[rand(0, count($ua)-1)]);
    $r = curl_exec($c);
    curl_close($c);
    return $r;
}};


