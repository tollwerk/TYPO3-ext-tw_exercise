<?php

declare(strict_types=1);

namespace Tollwerk\TwExercise\DataProcessing\ClozeText;

/**
 * PartProcessor
 *
 * @category   Tollwerk
 * @package    Tollwerk\TwExercise
 * @subpackage Tollwerk\TwExercise\DataProcessing\ClozeText
 * @author     tollwerk GmbH <info@tollwerk.de>
 * @copyright  2024 tollwerk Gmbh <info@tollwerk.de>
 * @license    GPL https://www.gnu.org/licenses/gpl-3.0.html.en
 * @link       https://tollwerk.de
 */
class PartProcessor
{
    const TYPE_GAP_MARKER = 'gap marker';
    const TYPE_REGULAR_TEXT = 'regular text';
    const TYPE_GAP_VALUE = 'gap value';
    const TYPE_LEADING_GAP_DESCRIPTION = 'leading gap description';
    const TYPE_TRAILING_GAP_DESCRIPTION = 'trailing gap description';

    /**
     * StartGap
     *
     * @var bool
     */
    protected bool $startGap = false;

    /**
     * EndGap
     *
     * @var bool
     */
    protected bool $endGap = false;

    /**
     * StartGapWrap
     *
     * @var bool
     */
    protected bool $insideWrap = false;

    /**
     * Current part
     *
     * @var ?string
     */
    protected ?string $currentPart = null;

    /**
     * Is marker?
     *
     * @var bool
     */
    protected bool $isMarker = false;

    /**
     * @return bool
     */
    public function isStartGap(): bool
    {
        return $this->startGap;
    }

    /**
     * @return bool
     */
    public function isEndGap(): bool
    {
        return $this->endGap;
    }

    /**
     * @return bool
     */
    public function isInsideWrap(): bool
    {
        return $this->insideWrap;
    }

    /**
     * @return string|null
     */
    public function getCurrentPart(): ?string
    {
        return $this->currentPart;
    }

    /**
     * Update marker registry with current part
     *
     * @param string $part Current part
     *
     * @return void
     */
    public function update(string $part)
    {
        $this->currentPart = $part;

        // Check if current part is marker or not.
        if (!in_array($this->currentPart, ['{{', '[[', ']]', '}}'])) {
            $this->isMarker = false;
            return;
        }
        $this->isMarker = true;

        // Update gap and wrap properties when current part is a marker.
        if ($this->currentPart == '{{') {
            $this->insideWrap = true;
        }
        if ($this->currentPart == '[[') {
            $this->startGap = true;
        }
        if ($this->currentPart == ']]') {
            $this->startGap = false;
            $this->endGap = true;
        }
        if ($this->currentPart == '}}') {
            $this->insideWrap = false;
        }
    }

    /**
     * Reset everything
     *
     * @return void
     */
    public function reset()
    {
        $this->startGap = false;
        $this->endGap = false;
        $this->insideWrap = false;
    }

    /**
     * Check markers
     *
     * @param bool $insideWrap InsideWrap status
     * @param bool $startGap StartGap status
     * @param bool $endGap EndGap status
     *
     * @return bool
     */
    public function check(bool $insideWrap, bool $startGap, bool $endGap)
    {
        return (
            $insideWrap === $this->insideWrap
            && $startGap === $this->startGap
            && $endGap === $this->endGap
        );
    }

    /**
     * Check if gap marker
     *
     * @return bool
     */
    public function isMarker(): bool
    {
        return $this->isMarker;
    }

    /**
     * Check if regular text
     *
     * @return bool
     */
    public function isRegularText(): bool
    {
        if ($this->isMarker) {
            return false;
        }

        return $this->check(false, false, false);
    }

    /**
     * Check if lading gap description
     *
     * @return bool
     */
    public function isLeadingGapDescription(): bool
    {
        if ($this->isMarker) {
            return false;
        }

        return $this->check(true, false, false);
    }

    /**
     * Check if gap text
     *
     * @return bool
     */
    public function isGapValue(): bool
    {
        if ($this->isMarker) {
            return false;
        }

        return $this->startGap;
    }

    /**
     * Check if trailing gap text
     *
     * @return bool
     */
    public function isTrailingDescription(): bool
    {
        if ($this->isMarker) {
            return false;
        }

        return $this->check(true, false, true);
    }

    /**
     * Get type of current part
     *
     * @return string
     */
    public function getType(): string
    {
        return implode(', ', array_filter([
            $this->isMarker() ? self::TYPE_GAP_MARKER : null,
            $this->isGapValue() ? self::TYPE_GAP_VALUE : null,
            $this->isRegularText() ? self::TYPE_REGULAR_TEXT : null,
            $this->isLeadingGapDescription() ? self::TYPE_LEADING_GAP_DESCRIPTION : null,
            $this->isTrailingDescription() ? self::TYPE_TRAILING_GAP_DESCRIPTION : null,
        ]));
    }

    public function isInsideAnyGap(): bool
    {
        return $this->insideWrap || $this->startGap;
    }

    /**
     * Get marker stats
     *
     * @return array
     */
    public function getMarkerStats(): array
    {
        return [
            'insideWrap' => $this->insideWrap,
            'startGap' => $this->startGap,
            'endGab' => $this->endGap,
        ];
    }
}
