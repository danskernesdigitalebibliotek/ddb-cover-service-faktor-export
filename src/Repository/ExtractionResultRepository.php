<?php

/**
 * @file
 * Contains repository for ExtractionResult documents.
 */

namespace App\Repository;

use App\Document\ExtractionResult;
use Doctrine\ODM\MongoDB\DocumentManager;
use Doctrine\ODM\MongoDB\Repository\DocumentRepository;

/**
 * Class ExtractionResultRepository.
 */
class ExtractionResultRepository extends DocumentRepository
{
    /**
     * ExtractionResultRepository constructor.
     *
     * @param DocumentManager $documentManager
     *   The doctrine document manager
     */
    public function __construct(DocumentManager $documentManager)
    {
        // Because unit of work and class meta data are not injectable we
        // manually inject them.
        $uow = $documentManager->getUnitOfWork();
        $classMetaData = $documentManager->getClassMetadata(ExtractionResult::class);
        parent::__construct($documentManager, $uow, $classMetaData);
    }

    /**
     * Get the newest entry.
     *
     * @return array|object|null
     *   The result
     */
    public function getNewestEntry()
    {
        return $this->createQueryBuilder()
            ->sort('date', 'DESC')
            ->limit(1)
            ->getQuery()
            ->getSingleResult();
    }
}
