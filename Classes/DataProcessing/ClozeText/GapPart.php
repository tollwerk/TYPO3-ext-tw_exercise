<?php

declare(strict_types=1);

namespace Tollwerk\TwExercise\DataProcessing\ClozeText;

use Tollwerk\TwExercise\Domain\Model\ClozeGap;

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
class GapPart extends AbstractPart
{
    /**
     * Type
     *
     * @var string
     */
    protected string $type = 'gap';

    /**
     * Leading description
     *
     * @var string
     */
    protected string $leadingDescription;

    /**
     * Gap
     *
     * @var array
     */
    protected array $gap;

    /**
     * Trailing description
     * @var string
     */
    protected string $trailingDescription;

    /**
     * Constructor
     *
     * @param array    $gap                 Gap object
     * @param string   $leadingDescription  Leading description
     * @param string   $trailingDescription Trailing description
     */
    public function __construct(array $gap = [], string $leadingDescription = '', string $trailingDescription = '')
    {
        $this->gap = $gap;
        $this->leadingDescription = $leadingDescription;
        $this->trailingDescription = $trailingDescription;
    }

    /**
     * Get leadingDescription
     *
     * @return string
     */
    public function getLeadingDescription(): string
    {
        return $this->leadingDescription;
    }

    /**
     * Get gap
     *
     * @return array
     */
    public function getGap(): array
    {
        return $this->gap;
    }

    /**
     * Get trailing description
     *
     * @return string
     */
    public function getTrailingDescription(): string
    {
        return $this->trailingDescription;
    }

    /**
     * @param string $leadingDescription
     */
    public function setLeadingDescription(string $leadingDescription): void
    {
        $this->leadingDescription = $leadingDescription;
    }

    /**
     * @param array $gap
     */
    public function setGap(array $gap): void
    {
        $this->gap = $gap;
    }

    /**
     * @param string $trailingDescription
     */
    public function setTrailingDescription(string $trailingDescription): void
    {
        $this->trailingDescription = $trailingDescription;
    }
}
