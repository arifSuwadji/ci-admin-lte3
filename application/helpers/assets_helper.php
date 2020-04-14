<?php

function asset_js($value=''){
    return '<script type="text/javascript" src="'.base_url("public/admin/lte3/dist/js/".$value).'"></script>';
}

function asset_css($value=''){
    return '<link rel="stylesheet" href="'.base_url("public/admin/lte3/dist/css/".$value).'"/>';
}

function asset_icon($value=''){
    return '<link rel="icon" rel="stylesheet" href="'.base_url("public/admin/lte3/dist/img/".$value).'"/>';
}

function asset_plugin_css($value=''){
    return '<link rel="stylesheet" href="'.base_url("public/admin/lte3/plugins/".$value).'"/>';
}

function asset_plugin_js($value=''){
    return '<script src="'.base_url('public/admin/lte3/plugins/'.$value).'"></script>';
}

function asset_image_chat($value=''){
    return '<img src="'.base_url("public/admin/lte3/dist/img/".$value).'" alt="User Avatar" class="img-size-50 mr-3 img-circle">';
}

function asset_logo($value=''){
    return '<img src="'.base_url('public/admin/lte3/dist/img/'.$value).'" alt="APD Logo" class="brand-image img-circle elevation-3" style="opacity: .8">';
}

function asset_image_profile($value=''){
    return '<img src="'.base_url('public/admin/lte3/dist/img/'.$value).'" class="img-circle elevation-2" alt="User Image">';
}
?>