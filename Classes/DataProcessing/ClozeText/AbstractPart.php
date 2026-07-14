<?php

declare(strict_types=1);

namespace Tollwerk\TwExercise\DataProcessing\ClozeText;

/**
 * AbstractPart
 *
 * @category   Tollwerk
 * @package    Tollwerk\TwExercise
 * @subpackage Tollwerk\TwExercise\DataProcessing\ClozeText
 * @author     tollwerk GmbH <info@tollwerk.de>
 * @copyright  2024 tollwerk Gmbh <info@tollwerk.de>
 * @license    GPL https://www.gnu.org/licenses/gpl-3.0.html.en
 * @link       https://tollwerk.de
 */
abstract class AbstractPart
{
    /**
     * The part type, see AbstractPart::TYPE_TEXT etc.
     * Overwrite in subclass.
     *
     * @var string
     */
    protected string $type = '';

    /**
     * Get type
     *
     * @return string
     */
    public function getType(): string
    {
        return $this->type;
    }
}
