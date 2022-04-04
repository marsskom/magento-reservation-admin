<?php

declare(strict_types = 1);

namespace Marsskom\ReservationAdmin\Api\Product;

use Magento\Framework\Api\SearchCriteriaInterface;
use Magento\Framework\Exception\CouldNotSaveException;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\Exception\StateException;
use Marsskom\ReservationAdmin\Api\Data\Product\ReservationInterface;
use Marsskom\ReservationAdmin\Api\Data\Product\ReservationSearchResultInterface;

interface ReservationRepositoryInterface
{
    /**
     * Saves reservation row.
     *
     * @param ReservationInterface $model
     *
     * @return ReservationInterface
     *
     * @throws CouldNotSaveException
     */
    public function save(ReservationInterface $model): ReservationInterface;

    /**
     * Returns reservation row by id.
     *
     * @param int $reservationId
     *
     * @return ReservationInterface
     *
     * @throws NoSuchEntityException
     */
    public function getById(int $reservationId): ReservationInterface;

    /**
     * Deletes reservation row.
     *
     * @param ReservationInterface $model
     *
     * @return bool
     *
     * @throws StateException
     */
    public function delete(ReservationInterface $model): bool;

    /**
     * Deletes reservation row by id.
     *
     * @param int $reservationId
     *
     * @return bool
     *
     * @throws NoSuchEntityException
     * @throws StateException
     */
    public function deleteById(int $reservationId): bool;

    /**
     * Returns reservation list by search criteria.
     *
     * @param SearchCriteriaInterface $searchCriteria
     *
     * @return ReservationSearchResultInterface
     */
    public function getList(SearchCriteriaInterface $searchCriteria): ReservationSearchResultInterface;
}
