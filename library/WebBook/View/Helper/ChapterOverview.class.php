<?php
namespace WebBook\View\Helper;
use Core;

/**
 * Outputs the chapter overview view.
 *
 * @copyright   2012 Christopher Hill <cjhill@gmail.com>
 * @author      Christopher Hill <cjhill@gmail.com>
 */
class ChapterOverview extends Core\ViewHelper
{
	/**
	 * Outputs the chapter overview view.
	 *
	 * <code>
	 * array(
	 *     'book' => Model\Book
	 * )
	 * </code>
	 *
	 * @access public
	 * @param  array  $params A collection of variables that has been passed to us.
	 * @return string         A rendered View Helper Partial template file.
	 */
	public function render($params = array()) {
		// Create a container for the section HTML
		$chapterHtml   = '';
		$chapterNumber = 1;

		// Loop over each chapter and add the HTML to the return variable
		foreach ($params['book'] as $chapterId => $chapter) {
			// Loop over each section in this chapter
			foreach ($chapter as $sectionId => $section) {
				// We only want the chapter title
				if ($section->section_type != 'chaptertitle') {
					continue;
				}

				// Place the chapter's sections into a chapter
				$chapterHtml .= $this->renderPartial('ChapterOverviewItem', array(
					'chapterNumber'    => $chapterNumber++,
					'chapterId'        => $section->chapter_id,
					'chapterTitle'     => $section->section_content,
					'chapterWordCount' => number_format($this->getWordsInChapter($chapter))
				));

				// We have added the chapter title, no need to continue
				break;
			}
		}

		return $chapterHtml;
	}

	/**
	 * Return how many words are in a chapter.
	 *
	 * @access private
	 * @param  Model\Chapter\Instance $chapter The chapter instance.
	 * @return int
	 */
	private function getWordsInChapter($chapter) {
		$wordCount = 0;

		foreach ($chapter as $section) {
			$wordCount += $section->section_word_count;
		}

		return $wordCount;
	}
}