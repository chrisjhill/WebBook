<?php
/**
 * Contains information on the book settings.
 *
 * @copyright   2012 Christopher Hill <cjhill@gmail.com>
 * @author      Christopher Hill <cjhill@gmail.com>
 * @version     0.1
 * @since       22/10/2012
 */

class Model_Settings
{
    /**
     * Information on the settings.
     *
     * @var array
     */
    private $_info = array();
    
    /**
     * Model_Setting class instance.
     *
     * @var Model_User
     * @static
     */
    private static $_classInstance;

    /**
     * Do nothing
     */
    public function __construct() { }
    
    /**
     * Get an instance of the settings.
     *
     * @param int $bookId
     * @return Model_User
     */
    public function getInstance($bookId) {
        // Have we already created the instance?
        if (is_null(self::$_classInstance)) {
            // Create instance
            self::$_classInstance = new Model_Settings();
            
            // Set settings
            self::$_classInstance->setSettings($bookId);
        }
        
        // And return
        return self::$_classInstance;
    }
    
    /**
     * Set the settings.
     *
     * @param int $bookId
     */
    public function setSettings($bookId) {
        // Get the database connection
        $pdo = Model_Database::getPdoConnection();
        
        // Set query string
        $query = $pdo->prepare("
            SELECT s.book_id, s.setting_autosave,
                   s.setting_font_family, s.setting_font_size, s.setting_font_color, s.setting_line_height, s.setting_alignment,
                   s.setting_background, s.setting_page_paddings, s.setting_display_comments
            FROM   `setting` s
            WHERE  s.book_id = :book_id
            LIMIT  1
        ");
        
        // And execute query
        $query->execute(array(
            ':book_id' => $bookId
        ));
        
        // Could we find the settings?
        if ($query->rowCount() >= 1) {
            // Set the settings
            $this->_info = $query->fetch();
        }
    }

    /**
     * Returns a setting.
     *
     * @return mixed
     */
    public function getSetting($index) {
        return isset($this->_info[$index])
            ? $this->_info[$index]
            : '';
    }
    
    /**
     * What background does the user want?
     *
     * @return string
     */
    public function getBackground() {
        switch ($this->getSetting('setting_background')) {
            case 'squares'  : return 'background:#EEE url(/public/images/body-bg-squares.png) fixed top left'; break;
            case 'wood'     : return 'background:#EEE url(/public/images/body-bg-wood.jpg) fixed top left';    break;
            
            case 'white'    : return 'background:#FFF'; break;
            case 'grey'     : return 'background:#CCC'; break;
            case 'greyer'   : return 'background:#888'; break;
            case 'charcoal' : return 'background:#444'; break;
            case 'black'    : return 'background:#000'; break;
            
            default         : return $this->getSetting('setting_background'); break;
        }
    }
    
    
    /**
     * What colour box shadow do we need?
     *
     * @return string
     */
    public function getShadow() {
        switch ($this->getSetting('setting_background')) {
            case 'squares'  : return 'box-shadow:0px 0px 5px 2px #DDD'; break;
            case 'wood'     : return 'box-shadow:0px 0px 5px 2px #c49a6a'; break;
            
            case 'white'    : return 'box-shadow:0px 0px 5px 2px #EEE'; break;
            case 'grey'     : return 'box-shadow:0px 0px 5px 2px #BBB'; break;
            case 'greyer'   : return 'box-shadow:0px 0px 5px 2px #777'; break;
            case 'charcoal' : return 'box-shadow:0px 0px 5px 2px #333'; break;
            case 'black'    : return ''; break;
            
            default         : return ''; break;
        }
    }
    
    /**
     * The users custom font.
     *
     * @return string
     */
    public function getFont() {
        // Build the string we want to return
        $output = 'color:#' . $this->getSetting('setting_font_color') . ';font:' . $this->getSetting('setting_font_size') . 'px/' . $this->getSetting('setting_line_height') . 'em {{FAMILY}}';
    
        // Which font?
        switch ($this->getSetting('setting_font_family')) {
            case 'helvetica' : return str_replace('{{FAMILY}}', 'Helvetica,Arial,"Liberation sans","Bitstream Vera Sans",sans-serif', $output); break;
            case 'arial'     : return str_replace('{{FAMILY}}', 'Arial,Helvetica,"Liberation sans","Bitstream Vera Sans",sans-serif', $output); break;
            case 'georgia'   : return str_replace('{{FAMILY}}', 'Georgia,"Palatino Linotype", "Book Antiqua", Palatino, FreeSerif, serif', $output); break;
            default          : return str_replace('{{FAMILY}}', '"Palatino Linotype", "Book Antiqua", Palatino, FreeSerif, serif', $output); break;
        }
    }
    
    /**
     * The users custom alignment.
     *
     * @return string
     */
    public function getAlignment() {
        return 'text-align:' . $this->getSetting('setting_alignment');
    }
    
    /**
     * The users custom padding. 
     */
    public function getPadding() {
        // What is the width of the editable content area?
        $totalWidth = 850;
        
        // Minus the padding from the right
        $totalWidth = $totalWidth - ($this->getSetting('setting_page_paddings') * 2);

        // And send the padding
        return 'width:' . $totalWidth . 'px;padding:' . $this->getSetting('setting_page_paddings') . 'px';
    }
}