<?php
namespace WebBook\Model\Settings;
use Core, WebBook\Model;

/**
 * The middle ground between the database and the model.
 *
 * The repository is essentially an ORM, but simplified.
 *
 * @copyright 2012 Christopher Hill <cjhill@gmail.com>
 * @author    Christopher Hill <cjhill@gmail.com>
 * @version   0.1
 * @since     24/01/2013
 */
class Repository extends Core\Repository
{
	/**
	 * Saves a record to the database.
	 *
	 * This function handles both uppdate and save for an easier Model. If
	 * there is an ID in the store then we update, otherwise we insert.
	 *
	 * @access public
	 * @return mixed
	 */
	public function save() {
		return ! isset($this->book_id)
			? $this->insert()
			: $this->update();
	}

	/**
	 * Insert a record into the database.
	 *
	 * @access public
	 * @return mixed  False is failure, integer of new record ID if success.
	 */
	public function insert() {
		$query = Model\Database::get()->prepare("
			INSERT INTO `section` (
				`book_id`,
				`chapter_id`,
				`section_order`,
				`section_type`,
				`section_content`,
				`section_word_count`,
				`section_created`
			) VALUES (
				:book_id,
				:chapter_id,
				:section_order,
				:section_type,
				:section_content,
				:section_word_count,
				:section_created
			)
		");

		// And execute query
		$query->execute(array(
			':book_id'            => $this->book_id,
			':chapter_id'         => $this->chapter_id,
			':section_order'      => $this->section_order,
			':section_type'       => $this->section_type,
			':section_content'    => $this->section_content,
			':section_word_count' => $this->section_word_count,
			':section_created'    => $this->section_created
		));

		return $pdo->lastInsertId();
	}

	/**
	 * Update a single record.
	 *
	 * @access public
	 * @return boolean
	 */
	public function update() {
		$query = Model\Database::get()->prepare("
			UPDATE `setting` s
			SET	s.setting_autosave            = :setting_autosave,
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
		return $query->execute(array(
			':setting_autosave'         => $this->setting_autosave,
			':setting_font_family'      => $this->setting_font_family,
			':setting_font_size'        => $this->setting_font_size,
			':setting_font_color'       => $this->setting_font_color,
			':setting_line_height'      => $this->setting_line_height,
			':setting_alignment'        => $this->setting_alignment,
			':setting_background'       => $this->setting_background,
			':setting_page_paddings'    => $this->setting_page_paddings,
			':setting_display_comments' => $this->setting_display_comments,
			':book_id'                  => $this->book_id
		));
	}

	/**
	 * Get a single book's settings.
	 *
	 * @access public
	 * @return mixed  Array on success, false on failure.
	 */
	public function get() {
		$query = Model\Database::get()->prepare("
			SELECT *
			FROM   `setting` s
			WHERE  s.book_id = :book_id
			LIMIT  1
		");

		// And execute query
		$query->execute(array(':book_id' => $this->book_id));

		return $query->fetch();
	}
}