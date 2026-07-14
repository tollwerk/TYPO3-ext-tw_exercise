<?php

declare(strict_types=1);

namespace Tollwerk\TwExercise\DataProcessing\ClozeText;

/**
 * ClozeTextDataProcessor
 *
 * @category   Tollwerk
 * @package    Tollwerk\TwExercise
 * @subpackage Tollwerk\TwExercise\DataProcessing\ClozeText
 * @author     tollwerk GmbH <info@tollwerk.de>
 * @copyright  2024 tollwerk Gmbh <info@tollwerk.de>
 * @license    GPL https://www.gnu.org/licenses/gpl-3.0.html.en
 * @link       https://tollwerk.de
 */
class TextPart extends AbstractPart
{
    /**
     * Type
     *
     * @var string
     */
    protected string $type = 'text';

    /**
     * Text
     *
     * @var string
     */
    protected string $text;

    /**
     * Constructor
     *
     * @param string $text
     */
    public function __construct(string $text = '')
    {
        $this->text = $text;
    }

    public function getText(): string
    {
        return $this->text;
    }
}
