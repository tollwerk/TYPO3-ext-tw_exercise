<?php

declare(strict_types=1);

/**
 * ClozeGapRepository
 *
 * @category   Tollwerk
 * @package    Tollwerk\TwExercise
 * @subpackage Tollwerk\TwExercise\Utility
 * @author     tollwerk GmbH <info@tollwerk.de>
 * @copyright  2024 tollwerk Gmbh <info@tollwerk.de>
 * @license    GPL https://www.gnu.org/licenses/gpl-3.0.html.en
 * @link       https://tollwerk.de
 */

namespace Tollwerk\TwExercise\Utility;

use TYPO3\CMS\Core\Utility\GeneralUtility;

class ClozeUtility
{
    /**
     * Explode ClozeGap options from a given string.
     *
     * @param string $optionsString String with options. One option per line.
     *                              Options can have a suffix, like 'a: my option'.
     *
     * @return string[]
     */
    public static function getGapOptions(string $optionsString)
    {
        $options = [];
        foreach (GeneralUtility::trimExplode(PHP_EOL, $optionsString) as $key => $option) {
            $optionParts = GeneralUtility::trimExplode(':', $option);
            if (count($optionParts) > 1) {
                $options[$optionParts[0]] = $optionParts[1];
                continue;
            }

            $options[] = $optionParts[0];
        }
        return $options;
    }
}
