<?php
/**
 * Gallery builders
*/
function abcfggcl_gbldrs_get_pg($customPostID) {

    $divItems = '';
    $cls = 'ggclCtnr gg111';
    $style = '';

    $optns = get_post_custom( $customPostID );
    $cntrH = isset( $optns['_abcfggcl_cntr_h'] ) ? esc_attr( $optns['_abcfggcl_cntr_h'][0] ) : '';
    $cntrW = isset( $optns['_abcfggcl_cntr_w'] ) ? esc_attr( $optns['_abcfggcl_cntr_w'][0] ) : '';
    $cntrLM = isset( $optns['_abcfggcl_cntr_lm'] ) ? esc_attr( $optns['_abcfggcl_cntr_lm'][0] ) : '';
    $cntrTM = isset( $optns['_abcfggcl_cntr_tm'] ) ? esc_attr( $optns['_abcfggcl_cntr_tm'][0] ) : '';
    $itemLM = isset( $optns['_abcfggcl_item_lm'] ) ? esc_attr( $optns['_abcfggcl_item_lm'][0] ) : '';
    $itemTM = isset( $optns['_abcfggcl_item_tm'] ) ? esc_attr( $optns['_abcfggcl_item_tm'][0] ) : '';
    $imgFr = isset( $optns['_abcfggcl_img_fr'] ) ? esc_attr( $optns['_abcfggcl_img_fr'][0] ) : '';
    $imgAn = isset( $optns['_abcfggcl_img_annimate'] ) ? esc_attr( $optns['_abcfggcl_img_annimate'][0] ) : '';
    $layout = isset( $optns['_abcfggcl_layout'] ) ? esc_attr( $optns['_abcfggcl_layout'][0] ) : '1';
    $imgSize = isset( $optns['_abcfggcl_img_size'] ) ? esc_attr( $optns['_abcfggcl_img_size'][0] ) : '';
    $skin = isset( $optns['_abcfggcl_skin'] ) ? esc_attr( $optns['_abcfggcl_skin'][0] ) : 'W';

    $h4Style = '';
    $h4Style = abcfggcl_lib_css_style_tag($h4Style);

    $items = abcfggcl_gbldrs_get_items($customPostID, $layout, $imgFr, $imgAn, $itemTM, $itemLM, $imgSize, $skin, $h4Style);

    $style = abcfggcl_lib_css_wh($cntrW, $cntrH) . abcfggcl_lib_css_ptl($cntrTM, $cntrLM);
    $style = abcfggcl_lib_css_style_tag($style);

    if(!empty($items)) { $divItems = '<div id="equalH" class="' . $cls . '"' . $style . '>' . $items . '<div class="ggclClr"></div></div>'; }
    $js = '<script type="text/javascript">jQuery(window).load(function(){ jQuery("#equalH").equalHs(); });</script>';
    return $divItems . ' ' . $js;
}

function abcfggcl_gbldrs_get_items($postID, $layout, $imgFr, $imgAn, $itemTM, $itemLM, $imgSize, $skin, $h4Style){

    $post = get_post( $postID );
    $pCnt = $post->post_content;

    $out = '';
    //if(empty($pCnt)) return $out;
    $gImgs = abcfggcl_gbldrs_get_gallery_imgs( $postID, $pCnt, $imgSize );

    if(empty($gImgs)) {return;}

    foreach($gImgs as $gImg){
        $imgUrl = $gImg['imgUrl'];
        $imgW = $gImg['w'];
        $imgH = $gImg['h'];
        $alt = $gImg['alt'];
        $linkUrl = $gImg['linkUrl'];
        $linkTarget = $gImg['linkTarget'];
        $title = $gImg['title'];
        $cap1 = $gImg['cap1'];

        $imgTag = abcfggcl_lib_htmlbldr_img_tag('', $imgUrl, $alt, $title, $imgW, $imgH );
        $out .= abcfggcl_gbldrs_build_item( $imgFr, $imgAn, $itemTM, $itemLM, $cap1, $linkUrl, $linkTarget, $imgW, $imgTag, $layout, $skin, $h4Style );
    }

    return $out;
 }

//-----------------------------------------------------------------------
function abcfggcl_gbldrs_build_item($imgFr, $imgAn, $itemTM, $itemLM, $cap1, $linkUrl, $linkTarget, $imgW, $imgTag, $layout, $skin, $h4Style ){

    $hasTxt = 1;
    $txtDiv = '';
    if(abcfggcl_lib_isblank($cap1)){ $hasTxt = 0; }

    $cls = 'ggclItemCntr';
    $style = abcfggcl_lib_cssbldr_style_margin_tl($itemTM, $itemLM);
    $cntrS = '<div class="' . $cls . '"' . $style . '>';
    $cntrE = '</div>';

    $imgDiv = abcfggcl_gbldrs_build_img_div($skin, $imgFr, $imgAn, $imgTag, $linkUrl, $linkTarget);

    if($hasTxt === 1){
        $cap1 = esc_attr($cap1);
        $txtDiv = abcfggcl_gbldrs_build_txt_div_multiline($cap1, $linkUrl, $linkTarget, $imgW, $layout, $h4Style );
    }

    return $cntrS . $imgDiv . $txtDiv . $cntrE;
 }

//-----------------------------------------------------------------------
function abcfggcl_gbldrs_build_img_div($skin, $imgFr, $imgAn, $imgTag, $linkUrl, $linkTarget){

    $frS = '';
    $frE = '';
    $clsA= '';
    switch ($imgAn){
    case 'S':
        $clsA = 'ggclImgSc ';
        break;
    case 'F':
        $clsA = 'ggclImgBkgW ggclImgFd ';
        break;
   case 'D':
        $clsA = 'ggclImgBkgB ggclImgFd ';
        break;
    default:
        break;
    }

    $clsFr = '';
    if($imgFr == 'B') { $clsFr = 'ggclImgB_' . $skin . ' '; }
    $clsImg = trim('ggclImg ' . $clsFr . $clsA);

    $aTag = abcfggcl_lib_htmlbldr_html_a_tag($linkUrl, $imgTag, $linkTarget, '','', '', false);
    $img = $frS . '<div class="' . $clsImg . '">' . $aTag . '</div>' . $frE;

    return $img;
 }

function abcfggcl_gbldrs_build_txt_div_multiline($cap1, $linkUrl, $linkTarget, $imgW, $layout, $h4Style ){

    $txtCntrCls = 'ggclTxtMlCntr';
    $txtCntrW = $imgW;
    $txtCntrCls2 = abcfggcl_gbldrs_txt_align( $layout, 'ggclAlign' );

    $cls = abcfggcl_lib_css_class_tag($txtCntrCls . ' ' . $txtCntrCls2 );
    $style = abcfggcl_lib_css_style_tag(abcfggcl_lib_css_w($txtCntrW));
    $cntrS = abcfggcl_lib_htmlbldr_div_cls_style( $cls, $style );
    $l1 = '';

    $l1 = abcfggcl_gbldrs_build_txt_h4($cap1, $linkUrl, $linkTarget, $h4Style );
    return  $cntrS . $l1 . '</div>';
}

//-----------------------------------------------------------------------
function abcfggcl_gbldrs_build_txt_h4($cap1, $linkUrl, $linkTarget, $h4Style ){

    if(abcfggcl_lib_isblank($cap1)){ return '';}

    $aTag = abcfggcl_lib_htmlbldr_html_a_tag($linkUrl, $cap1, $linkTarget, '', '', '', false);
    return '<h4' . $h4Style . '>' . $aTag . '</h4>';
}

function abcfggcl_gbldrs_txt_align( $layout, $txtCntrCls ){

    switch ($layout){
    case '1':
        $txtCntrCls .= 'L';
        break;
    case '2':
        $txtCntrCls .= 'R';
        break;
    case '3':
        $txtCntrCls .= 'C';
        break;
    default:
        break;
    }
    return $txtCntrCls;
}


function abcfggcl_gbldrs_get_gallery_imgs( $postID, $pCnt, $imgSize ) {
    $pCnt = trim($pCnt);

    if(empty($pCnt)){
        echo __('WordPress Gallery shortcode is missing. Please add WordPress Gallery to the Grid Gallery.', 'abcfggcl-td');
        return array();
    }
    $g = '[gallery';
    if(substr($pCnt, 0, 8) != $g) {
        $pos = strpos($pCnt, $g);
        if ($pos === false) {
        echo __('WordPress Gallery shortcode is missing. Please add WordPress Gallery to the Grid Gallery.', 'abcfggcl-td');
        return array();
        }
    }

    $shortcodeArgs = shortcode_parse_atts(abcfggcl_gbldrs_get_regex_match('/\[gallery\s(.*)\]/isU', $pCnt));

    if(!array_key_exists( 'ids', $shortcodeArgs )){
       echo __('Error: WordPress Gallery shortcode has no picture IDs.', 'abcfggcl-td');
       return array();
    }

    $ids = $shortcodeArgs['ids'];
    $attr = array(
        'include' => $ids,
        'order'       => 'DESC',
        'orderby'     => 'post__in',
        'id'          => $postID,
        'size'        => $imgSize
    );

    if (function_exists('abcfmlcf_get_images')) {
        return abcfmlcf_get_images($attr);
    }
    else {
        echo __('Required plugin is missing. Please install plugin: Media Library Custom Fields.', 'abcfggcl-td');
        return array();
    }

}

function abcfggcl_gbldrs_get_regex_match( $regex, $content ) {
    $matches = array();
    preg_match($regex, $content, $matches);
    return $matches[1];
}

