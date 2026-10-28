<?php

declare(strict_types=1);

/**
 * ClozeSolutionsViewHelper
 *
 * @category   Tollwerk
 * @package    Tollwerk\TwExercise
 * @subpackage Tollwerk\TwExercise\ViewHelpers\SolutionsTable
 * @author     tollwerk GmbH <info@tollwerk.de>
 * @copyright  2026 tollwerk Gmbh <info@tollwerk.de>
 * @license    GPL https://www.gnu.org/licenses/gpl-3.0.html.en
 * @link       https://tollwerk.de
 */

namespace Tollwerk\TwExercise\ViewHelpers\SolutionsTable;

use Tollwerk\TwExercise\Domain\Model\Solution;
use TYPO3\CMS\Extbase\Utility\LocalizationUtility;
use TYPO3Fluid\Fluid\Core\ViewHelper\AbstractViewHelper;

/**
 * ClozeSolutionsViewHelper
 *
 * Transform array with ClozeGap records for use inside the SolutionsTable partial
 *
 * @package    Tollwerk\TwEprivacy
 * @subpackage Tollwerk\TwEprivacy\ViewHelpers
 */
class ClozeViewHelper extends AbstractViewHelper
{
    /**
     * Initialize arguments
     *
     * @return void
     */
    public function initializeArguments()
    {
        parent::initializeArguments();
        $this->registerArgument(
            'gaps',
            'array',
            'Array with ClozeGap records',
            false,
            []
        );
        $this->registerArgument(
            'givenAnswersByIdentifier',
            'array',
            'Given answers by identifier, like `[\'A1\' => \'This is my answer\']`',
            false,
            []
        );
    }

    /**
     * Default implementation of static rendering; useful API method if your ViewHelper
     * when compiled is able to render itself statically to increase performance. This
     * default implementation will simply delegate to the ViewHelperInvoker.
     *
     * @return array
     */
    public function render(): array {
        // Get all given answers for further processing.
        $givenAnswers = $this->arguments['givenAnswersByIdentifier'];

        // Fill solutions array with Solution objects.
        $solutions = [];
        foreach($this->arguments['gaps'] as $gap) {
            // Get given answer.
            if(!$gap['is_example']) {
                $givenAnswer = LocalizationUtility::translate(
                    'solutions_table.given_answer.empty',
                    'TwExercise'
                );
                if (!empty($givenAnswers[$gap['identifier']])) {
                    $givenAnswer = $givenAnswers[$gap['identifier']];
                }

                $solutions[] = new Solution(
                    $gap['identifier'],
                    $givenAnswer,
                    $gap['value'],
                    $gap['points'] ?? 1
                );
            }
        }

        return $solutions;
    }
}
