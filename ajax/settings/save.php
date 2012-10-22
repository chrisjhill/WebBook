<?php
include $_SERVER['DOCUMENT_ROOT'] . '/library/Bootstrap.php';

// Save the settings
$settingsUpdate = new Controller_Settings_Update();
echo $settingsUpdate->update(array(
    'user'                     => $user,
    'settings'                 => $settings,
    'book'                     => $book,

    'setting_autosave'         => $_POST['setting_autosave'],
    'setting_font_family'      => $_POST['setting_font_family'],
    'setting_font_size'        => $_POST['setting_font_size'],
    'setting_font_color'       => $_POST['setting_font_color'],
    'setting_line_height'      => $_POST['setting_line_height'],
    'setting_alignment'        => $_POST['setting_alignment'],
    'setting_background'       => $_POST['setting_background'],
    'setting_page_paddings'    => $_POST['setting_page_paddings'],
    'setting_display_comments' => $_POST['setting_display_comments']
));