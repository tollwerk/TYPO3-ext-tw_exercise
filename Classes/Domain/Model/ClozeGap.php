<?php

declare(strict_types=1);

/**
 * ClozeGap
 *
 * @category   Tollwerk
 * @package    Tollwerk\TwExercise
 * @subpackage Tollwerk\TwExercise\Domain\Model
 * @author     tollwerk GmbH <info@tollwerk.de>
 * @copyright  2024 tollwerk Gmbh <info@tollwerk.de>
 * @license    GPL https://www.gnu.org/licenses/gpl-3.0.html.en
 * @link       https://tollwerk.de
 */


namespace Tollwerk\TwExercise\Domain\Model;

use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\DomainObject\AbstractEntity;

class ClozeGap extends AbstractEntity
{
    /**
     * Identifier
     *
     * @var string
     */
    protected string $identifier = '';

    /**
     * Value
     *
     * @var string
     */
    protected string $value = '';

    /**
     * IsExample
     *
     * @var bool
     */
    protected bool $isExample = false;

    /**
     * Options
     *
     * @var string
     */
    protected $options;

    /**
     * @return string
     */
    public function getIdentifier(): string
    {
        return $this->identifier;
    }

    /**
     * @param string $identifier
     */
    public function setIdentifier(string $identifier): void
    {
        $this->identifier = $identifier;
    }

    /**
     * @return string
     */
    public function getValue(): string
    {
        return $this->value;
    }

    /**
     * @param string $value
     */
    public function setValue(string $value): void
    {
        $this->value = $value;
    }

    /**
     * @return bool
     */
    public function isExample(): bool
    {
        return $this->isExample;
    }

    /**
     * @param bool $isExample
     */
    public function setIsExample(bool $isExample): void
    {
        $this->isExample = $isExample;
    }

    /**
     * Get Options
     *
     * @return array
     */
    public function getOptions(): array
    {
        return GeneralUtility::trimExplode(PHP_EOL, $this->options);
    }

    /**
     * Set options
     * @param array $options
     */
    public function setOptions(array $options): void
    {
        $this->options = implode(PHP_EOL, $options);
    }
}
