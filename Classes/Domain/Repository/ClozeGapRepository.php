<?php

declare(strict_types=1);

/**
 * ClozeGapRepository
 *
 * @category   Tollwerk
 * @package    Tollwerk\TwExercise
 * @subpackage Tollwerk\TwExercise\Domain\Repository
 * @author     tollwerk GmbH <info@tollwerk.de>
 * @copyright  2024 tollwerk Gmbh <info@tollwerk.de>
 * @license    GPL https://www.gnu.org/licenses/gpl-3.0.html.en
 * @link       https://tollwerk.de
 */

namespace Tollwerk\TwExercise\Domain\Repository;

use Tollwerk\TwExercise\Utility\ClozeUtility;
use TYPO3\CMS\Core\Database\ConnectionPool;
use TYPO3\CMS\Core\Database\Query\QueryBuilder;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Persistence\Generic\Mapper\DataMapper;
use TYPO3\CMS\Extbase\Persistence\Repository;
use TYPO3\CMS\Extbase\Utility\DebuggerUtility;

class ClozeGapRepository extends Repository
{
    /**
     * Find a single ClozeGap element by its value
     *
     * @param string $value Value
     *
     * @return ?array
     *
     * @throws \Doctrine\DBAL\Exception
     */
    public function findOneByValue(string $value, int $parentId): ?array
    {
        /** @var QueryBuilder $queryBuilder */
        $queryBuilder = GeneralUtility::makeInstance(ConnectionPool::class)->getQueryBuilderForTable('tx_twexercise_domain_model_cloze_gap');
        $record = $queryBuilder->select('uid', 'identifier', 'value', 'is_example', 'options')
            ->from('tx_twexercise_domain_model_cloze_gap')
            ->where($queryBuilder->expr()->eq('value', $queryBuilder->createNamedParameter(trim($value))))
            ->andWhere($queryBuilder->expr()->eq('parent_id', $queryBuilder->createNamedParameter($parentId)))
            ->executeQuery()
            ->fetchAssociative();

        if (!$record || empty($record)) {
            return null;
        }

        /** @var DataMapper $dataMapper */
        $dataMapper = GeneralUtility::makeInstance(DataMapper::class);

        return [
            'uid' => $record['uid'],
            'identifier' => $record['identifier'],
            'value' => $record['value'],
            'isExample' => !!$record['is_example'],
            'options' => ClozeUtility::getGapOptions($record['options'])
        ];
    }

    public function findByParentId(int $parentId): array
    {
        /** @var QueryBuilder $queryBuilder */
        $queryBuilder = GeneralUtility::makeInstance(ConnectionPool::class)->getQueryBuilderForTable('tx_twexercise_domain_model_cloze_gap');
        $records = $queryBuilder->select('uid', 'identifier', 'value', 'is_example', 'options')
            ->from('tx_twexercise_domain_model_cloze_gap')
            ->where($queryBuilder->expr()->eq('parent_id', $parentId))
            ->andWhere($queryBuilder->expr()->eq('is_example', $queryBuilder->createNamedParameter(0)))
            ->executeQuery()
            ->fetchAllAssociative();


        $gaps = [];
        foreach($records as $record) {
            $record['options'] = ClozeUtility::getGapOptions($record['options']);
            $gaps[] = $record;
        }

        return $gaps;
    }
}
