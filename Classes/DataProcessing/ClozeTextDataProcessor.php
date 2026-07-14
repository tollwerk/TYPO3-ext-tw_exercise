<?php

declare(strict_types=1);

/**
 * ClozeTextDataProcessor
 *
 * @category   Tollwerk
 * @package    Tollwerk\TwExercise
 * @subpackage Tollwerk\TwExercise\DataProcessing
 * @author     tollwerk GmbH <info@tollwerk.de>
 * @copyright  2024 tollwerk Gmbh <info@tollwerk.de>
 * @license    GPL https://www.gnu.org/licenses/gpl-3.0.html.en
 * @link       https://tollwerk.de
 */

namespace Tollwerk\TwExercise\DataProcessing;

use Tollwerk\TwExercise\DataProcessing\ClozeText\GapPart;
use Tollwerk\TwExercise\DataProcessing\ClozeText\PartProcessor;
use Tollwerk\TwExercise\DataProcessing\ClozeText\TextPart;
use Tollwerk\TwExercise\Domain\Model\ClozeGap;
use Tollwerk\TwExercise\Domain\Repository\ClozeGapRepository;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Configuration\ConfigurationManager;
use TYPO3\CMS\Extbase\Utility\DebuggerUtility;
use TYPO3\CMS\Frontend\ContentObject\ContentObjectRenderer;
use TYPO3\CMS\Frontend\ContentObject\DataProcessorInterface;

class ClozeTextDataProcessor implements DataProcessorInterface
{
    /**
     * TypoScript settings
     *
     * @var array
     */
    protected array $settings;

    /**
     * ClozeGapRepository
     *
     * @var ClozeGapRepository
     */
    protected ClozeGapRepository $clozeGapRepository;

    /**
     * Constructor
     *
     * @throws \TYPO3\CMS\Extbase\Configuration\Exception\InvalidConfigurationTypeException
     */
    public function __construct() {
        $this->clozeGapRepository = GeneralUtility::makeInstance(ClozeGapRepository::class);
        $this->settings = GeneralUtility::makeInstance(ConfigurationManager::class)
            ->getConfiguration(
                ConfigurationManager::CONFIGURATION_TYPE_SETTINGS,
                'TwExercise'
            );
    }

    /**
     * Split a text by double new lines, ignoring whitespaces between two line feeds.
     *
     * @param string $text Text
     *
     * @return array
     */
    public function splitByDoubleNewLine(string $text): array
    {
        return preg_split('/\s*\n\s*\n\s*/', $text);
    }

    /**
     * Split a text by cloze markers '[[', ']]', '{{' and '}}'.
     * Keep all found markers as array items for further processing.
     *
     * @param string $text
     * @return array
     */
    public function splitByClozeMarkers(string $text): array
    {
        return preg_split(
            '/({{|}})|(\[\[|\]\])/',
            $text, -1,
            PREG_SPLIT_DELIM_CAPTURE + PREG_SPLIT_NO_EMPTY
        );
    }

    /**
     * Iterate array with all text parts of a cloze text, including the cloze markers
     * and process them for usage inside the fluid template.
     *
     * @param array $parts All text parts including markers. Something like `['This is a', '{{', 'Test', '}}']`.
     * @param int $parentUid Uid of the parent tt_content element
     *
     * @return array
     */
    public function processClozeParts(array $parts, int $parentUid): array
    {
        // Initialize some variables and objects.
        $processedParts = [];
        $debug = [
            'parts' => $parts,
            'processing' => [],
        ];
        $partProcessor = new PartProcessor();

        // Iterate all parts, skip them in case of cloze markers or aggregate and add them to $processedParts.
        $gapPart = null;
        foreach ($parts as $part) {
            // Update part processor with current part.
            $partProcessor->update($part);

            // If not inside a gap/wrap any more but $gapPart is not null, add it to processed parts.
            if (!$partProcessor->isInsideAnyGap() && $gapPart !== null) {
                $processedParts[] = $gapPart;
                $gapPart = null;
            }

            // Add debug information.
            $debug['processing'][] = [
                'part' => $part,
                'marker stats' => $partProcessor->getMarkerStats(),
                'type' => $partProcessor->getType(),
            ];

            // If it is not a marker, add current part to final result.
            if ($partProcessor->getType() !== PartProcessor::TYPE_GAP_MARKER) {
                // Add text part.
                if ($partProcessor->isRegularText()) {
                    $processedParts[] = new TextPart($part);
                }

                // Create and/or add gap part.
                if ($partProcessor->isInsideAnyGap()) {
                    // Create new GapPart object if necessary.
                    if ($gapPart === null) {
                        $gapPart = new GapPart();
                    }

                    // Add leading description.
                    if ($partProcessor->isLeadingGapDescription()) {
                        $gapPart->setLeadingDescription($part);
                    }

                    // Add gap value.
                    if ($partProcessor->isGapValue()) {
                        $gap = $this->clozeGapRepository->findOneByValue($part, $parentUid);

                        if (!$gap) {
                            $gap = [
                                'value' => $part,
                                'options' => [
                                    $part
                                ],
                            ];
                        }

                        if ($gap) {
                            $gapPart->setGap($gap);
                        }
                    }

                    // Add trailing description.
                    if ($partProcessor->isTrailingDescription()) {
                        $gapPart->setTrailingDescription($part);
                    }
                }
            }

            // Reset when not inside any gap. Must be at the very end of the foreach-cycle.
            if (!$partProcessor->isInsideAnyGap()) {
                $partProcessor->reset();
            }
        }

        // Add processed parts to debug info and show it if enabled with TypoScript.
        $debug['processed'] = $processedParts;
        if (!empty($this->settings['debug'])) {
            debug($debug, sprintf(
                'Content [%s], %s::%s()',
                $parentUid,
                __CLASS__,
                __FUNCTION__
            ));
        }

        return $processedParts;
    }

    /**
     * Process data for the content element "My new content element"
     *
     * @param ContentObjectRenderer $cObj The data of the content element or page
     * @param array $contentObjectConfiguration The configuration of Content Object
     * @param array $processorConfiguration The configuration of this processor
     * @param array $processedData Key/value store of processed data (e.g. to be passed to a Fluid View)
     * @return array the processed data as key/value store
     */
    public function process(
        ContentObjectRenderer $cObj,
        array                 $contentObjectConfiguration,
        array                 $processorConfiguration,
        array                 $processedData
    )
    {
        // Initialize some basic properties.
        $clozeData = [];

        // Get all cloze gap records for this content element.
        $clozeData['gaps'] = $this->clozeGapRepository->findByParentId($cObj->data['uid']);

        // Get max points.
        $clozeData['maxPoints'] = round(
            (
                count($clozeData['gaps'])
                * floatval($cObj->data['tx_twexercise_points'])
                * floatval($cObj->data['tx_twexercise_points_multiplier'])
            ),
            2
        );

        // Get and process all paragraphs.
        $clozeData['paragraphs'] = [];
        $paragraphs = $this->splitByDoubleNewLine($cObj->data['bodytext']);
        foreach ($paragraphs as $paragraphText) {
            // Get all text parts of this paragraph and process them.
            $parts = $this->splitByClozeMarkers($paragraphText);
            $processedParts = $this->processClozeParts($parts, $cObj->data['uid']);
            $clozeData['paragraphs'][] = $processedParts;
        }

        // Assign $clozeData.
        $processedData['cloze'] = $clozeData;

        return $processedData;
    }
}
