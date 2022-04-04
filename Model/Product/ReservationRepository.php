<?php

declare(strict_types = 1);

namespace Marsskom\ReservationAdmin\Model\Product;

use Exception;
use Magento\Framework\Api\SearchCriteria\CollectionProcessorInterface;
use Magento\Framework\Api\SearchCriteriaInterface;
use Magento\Framework\Exception\CouldNotSaveException;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\Exception\StateException;
use Magento\Framework\Exception\ValidatorException;
use Marsskom\ReservationAdmin\Api\Data\Product\ReservationInterface;
use Marsskom\ReservationAdmin\Api\Data\Product\ReservationInterfaceFactory;
use Marsskom\ReservationAdmin\Api\Data\Product\ReservationSearchResultInterface;
use Marsskom\ReservationAdmin\Api\Data\Product\ReservationSearchResultInterfaceFactory;
use Marsskom\ReservationAdmin\Api\Product\ReservationRepositoryInterface;
use Marsskom\ReservationAdmin\Model\ResourceModel\Product\CollectionFactory;
use Marsskom\ReservationAdmin\Model\ResourceModel\Product\Reservation as ResourceModel;

class ReservationRepository implements ReservationRepositoryInterface
{
    /**
     * @var ReservationInterface[]
     */
    private array $instances = [];

    protected CollectionProcessorInterface $collectionProcessor;

    protected ResourceModel $resourceModel;

    protected ReservationInterfaceFactory $reservFactory;

    protected CollectionFactory $collectionFactory;

    protected ReservationSearchResultInterfaceFactory $reservResFactory;

    /**
     * Reservation repository constructor.
     *
     * @param CollectionProcessorInterface            $collectionProcessor
     * @param ResourceModel                           $resourceModel
     * @param ReservationInterfaceFactory             $reservFactory
     * @param CollectionFactory                       $collectionFactory
     * @param ReservationSearchResultInterfaceFactory $reservResFactory
     */
    public function __construct(
        CollectionProcessorInterface $collectionProcessor,
        ResourceModel $resourceModel,
        ReservationInterfaceFactory $reservFactory,
        CollectionFactory $collectionFactory,
        ReservationSearchResultInterfaceFactory $reservResFactory
    ) {
        $this->collectionProcessor = $collectionProcessor;
        $this->resourceModel = $resourceModel;
        $this->reservFactory = $reservFactory;
        $this->collectionFactory = $collectionFactory;
        $this->reservResFactory = $reservResFactory;
    }

    /**
     * @inheridoc
     *
     * @throws CouldNotSaveException
     */
    public function save(ReservationInterface $model): ReservationInterface
    {
        try {
            $this->resourceModel->save($model);
        } catch (Exception $exception) {
            throw new CouldNotSaveException(
                __('Could not save the model: %1', $exception->getMessage())
            );
        }

        return $model;
    }

    /**
     * @inheridoc
     *
     * @throws NoSuchEntityException
     */
    public function getById(int $reservationId): ReservationInterface
    {
        if (isset($this->instances[$reservationId])) {
            return $this->instances[$reservationId];
        }

        $model = $this->reservFactory->create();
        $this->resourceModel->load($model, $reservationId);

        if (!$model->getId()) {
            throw new NoSuchEntityException(
                __("Requested model doesn't exist, id %1", $reservationId)
            );
        }

        $this->instances[$reservationId] = $model;

        return $this->instances[$reservationId];
    }

    /**
     * @inheridoc
     *
     * @throws StateException
     */
    public function delete(ReservationInterface $model): bool
    {
        $modelId = $model->getId();

        try {
            $this->resourceModel->delete($model);
        } catch (ValidatorException $e) {
            throw new StateException(__($e->getMessage()));
        } catch (Exception $e) {
            throw new StateException(
                __('Unable to remove model with id %1', $modelId)
            );
        }

        unset($this->instances[$modelId]);

        return true;
    }

    /**
     * @inheridoc
     *
     * @throws NoSuchEntityException
     * @throws StateException
     */
    public function deleteById(int $reservationId): bool
    {
        return $this->delete(
            $this->getById($reservationId)
        );
    }

    /**
     * @inheridoc
     */
    public function getList(SearchCriteriaInterface $searchCriteria): ReservationSearchResultInterface
    {
        $collection = $this->collectionFactory->create();
        $this->collectionProcessor->process($searchCriteria, $collection);

        return $this->reservResFactory
            ->create()
            ->setSearchCriteria($searchCriteria)
            ->setItems($collection->getItems())
            ->setTotalCount($collection->getSize());
    }
}
