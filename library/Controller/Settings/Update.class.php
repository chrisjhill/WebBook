<?php
/**
 * Update the settings.
 *
 * @copyright   2012 Christopher Hill <cjhill@gmail.com>
 * @author      Christopher Hill <cjhill@gmail.com>
 * @version     0.1
 * @since       22/10/2012
 */

class Controller_Settings_Update extends Model_Notice
{
    /**
     * Update the settings.
     *
     * Array(
     *     'user'                     => Model_User,
     *     'settings'                 => Model_Settings,
     *     'book'                     => Model_Book,
     *
     *     'setting_autosave'         => 1 or 0,
     *     'setting_font_family'      => 'PALATINO',
     *     'setting_font_size'        => 16,
     *     'setting_font_color'       => '111',
     *     'setting_line_height'      => '1.6',
     *     'setting_alignment'        => 'JUSTIFIED',
     *     'setting_background'       => 'wood',
     *     'setting_page_paddings'    => 'MEDIUM',
     *     'setting_display_comments' => 1 or 0
     * )     
     *
     * @param array $param
     * @return boolean
     */
    public function update($param) {
        // Get PDO
        $pdo = Model_Database::getPdoConnection();
        
        // Set query string
        $query = $pdo->prepare("
            UPDATE `setting` s
            SET    s.setting_autosave         = :setting_autosave,
                   s.setting_font_family      = :setting_font_family,
                   s.setting_font_size        = :setting_font_size,
                   s.setting_font_color       = :setting_font_color,
                   s.setting_line_height      = :setting_line_height,
                   s.setting_alignment        = :setting_alignment,
                   s.setting_background       = :setting_background,
                   s.setting_page_paddings    = :setting_page_paddings,
                   s.setting_display_comments = :setting_display_comments
            WHERE  s.book_id                  = :book_id
            LIMIT  1
        ");
        
        // And execute query
        $query->execute(array(
            ':setting_autosave'         => $param['setting_autosave'],
            ':setting_font_family'      => $param['setting_font_family'],
            ':setting_font_size'        => $param['setting_font_size'],
            ':setting_font_color'       => $param['setting_font_color'],
            ':setting_line_height'      => $param['setting_line_height'],
            ':setting_alignment'        => $param['setting_alignment'],
            ':setting_background'       => $param['setting_background'],
            ':setting_page_paddings'    => $param['setting_page_paddings'],
            ':setting_display_comments' => $param['setting_display_comments'],

            ':book_id'                  => $param['book']->getInfo('book_id')
        ));

        // Log the event
        //$log = new Model_Log();
        //$log->insert(array(
        //    'user_id'       => $param['user']->getInfo('user_id'),
        //    'action'        => 'settings-update',
        //    'status'        => 'success',
        //    'description'   => $param['user']->getInfo('user_name') . ' updated the settings.'
        //));

        // Produce the message
        $this->setOutcome('success');
        $this->setIntro('Settings successfully updated.');
        return $this->getMessage();
    }
}