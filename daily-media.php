<?php
/*
Plugin Name: Daily Media Directories
Plugin URI: https://github.com/BandonRandon/daily-media-directories
Description: Adds media to daily folders instead of the default of Month/Year folders.
Author: Brooke.
Author URI: https://brooke.codes
License: GPLv2 or later
*/

/*
This program is free software; you can redistribute it and/or
modify it under the terms of the GNU General Public License
as published by the Free Software Foundation; either version 2
of the License, or (at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program; if not, write to the Free Software
Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA  02110-1301, USA.
*/

/*
This work is based entirely off of https://wordpress.stackexchange.com/a/71079/2204
by StackExchange user brasofilo
*/

if ( ! defined( 'ABSPATH' ) ) {
	exit;
};

function daily_media_directories_upload_prefilter( $file ) {
    add_filter('upload_dir', 'daily_media_directories_upload_directory');
    return $file;
}
add_filter('wp_handle_upload_prefilter', 'daily_media_directories_upload_prefilter');



function daily_media_directories_handle_upload( $fileinfo ) {
    remove_filter('upload_dir', 'daily_media_directories_upload_directory');
    return $fileinfo;
}
add_filter('wp_handle_upload', 'daily_media_directories_handle_upload');


function daily_media_directories_upload_directory( $path ){

	//get the current date and respect the WordPress timezone setting.
    $y = current_time( 'Y' );
    $m = current_time( 'm' );
    $d = current_time( 'd' );

    $new_media_dir = '/' . $y . '/' . $m . '/' . $d;

    $path['path']    = str_replace($path['subdir'], '', $path['path']); //remove default subdir (year/month)
    $path['url']     = str_replace($path['subdir'], '', $path['url']);
    $path['subdir']  = $new_media_dir;
    $path['path']   .= $new_media_dir;
    $path['url']    .= $new_media_dir;

    return $path;
}
