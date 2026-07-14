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

class Solution
{
    /**
     * Task
     *
     * @var string
     */
    protected string $task = '';

    /**
     * GivenAnswer
     *
     * @var string
     */
    protected $givenAnswer = '';

    /**
     * CorrectAnswer
     *
     * @var string
     */
    protected $correctAnswer = '';

    /**
     * Points
     *
     * @var float
     */
    protected $points = 0.0;

    /**
     * Constructor
     *
     * @param string $task          Task
     * @param string $givenAnswer   GivenAnswer
     * @param string $correctAnswer CorrectAnswer
     * @param float  $points        Points
     */
    public function __construct(string $task, string $givenAnswer, string $correctAnswer, float $points)
    {
        $this->task = $task;
        $this->givenAnswer = $givenAnswer;
        $this->correctAnswer = $correctAnswer;
        $this->points = $points;
    }

    /**
     * @return string
     */
    public function getTask(): string
    {
        return $this->task;
    }

    /**
     * @param string $task
     */
    public function setTask(string $task): void
    {
        $this->task = $task;
    }

    /**
     * @return string
     */
    public function getGivenAnswer(): string
    {
        return $this->givenAnswer;
    }

    /**
     * @param string $givenAnswer
     */
    public function setGivenAnswer(string $givenAnswer): void
    {
        $this->givenAnswer = $givenAnswer;
    }

    /**
     * @return string
     */
    public function getCorrectAnswer(): string
    {
        return $this->correctAnswer;
    }

    /**
     * @param string $correctAnswer
     */
    public function setCorrectAnswer(string $correctAnswer): void
    {
        $this->correctAnswer = $correctAnswer;
    }

    /**
     * @return float
     */
    public function getPoints(): float
    {
        return $this->points;
    }

    /**
     * @param float $points
     */
    public function setPoints(float $points): void
    {
        $this->points = $points;
    }
}
