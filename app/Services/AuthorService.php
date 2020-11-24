<?php

namespace App\Services;

use App\Repositories\AuthorRepositoryInterface;
use Exception;

class AuthorService
{
    private $authorRepository;
    private $simpleTableService;

    public function __construct(AuthorRepositoryInterface $authorRepository, SimpleTableService $simpleTableService)
    {
        $this->authorRepository = $authorRepository;
        $this->simpleTableService = $simpleTableService;
    }

    public function all()
    {
        return $this->simpleTableService->processData($this->authorRepository, null, false);
    }

    public function get($id)
    {
        return $this->authorRepository->get($id);
    }

    public function getDataForSelectbox()
    {
        return $this->authorRepository->getDataForSelectbox();
    }

    /**
     * Store a new author into DB.
     *
     * @param $data
     * @return mixed
     * @throws Exception
     */
    public function save($data)
    {
        try {
            $result = $this->authorRepository->save($data);
        } catch (Exception $e) {
            return $e;
        }

        return $result;
    }

    /**
     * Update author entry in DB.
     *
     * @param $data
     * @param null $id
     * @return mixed
     * @throws Exception
     */
    public function update($data, $id)
    {
        try {
            $result = $this->authorRepository->update($data, $id);
        } catch (Exception $e) {
            return $e;
        }

        return $result;
    }

    public function destroy(int $id)
    {
        try {
            $this->authorRepository->get($id);
            $result = $this->authorRepository->delete($id);
        } catch (Exception $e) {
            return $e;
        }

        return $result;
    }
}
