<?php

namespace App\Services;

use App\Repositories\BookRepositoryInterface;
use Exception;

class BookService
{
    private $bookRepository;
    private $simpleTableService;

    public function __construct(BookRepositoryInterface $bookRepository, SimpleTableService $simpleTableService)
    {
        $this->bookRepository = $bookRepository;
        $this->simpleTableService = $simpleTableService;
    }

    public function all()
    {
        return $this->simpleTableService->processData($this->bookRepository, null, false);
    }

    public function get($id)
    {
        return $this->bookRepository->get($id);
    }

    public function changeStatus($book)
    {
        $book['is_borrowed'] = $book['is_borrowed'] ? 0 : 1;
        return $this->update($book->toArray(), $book['id']);
    }

    /**
     * Store a new book into DB.
     *
     * @param $data
     * @return mixed
     * @throws Exception
     */
    public function save($data)
    {
        try {
            $result = $this->bookRepository->save($data);
        } catch (Exception $e) {
            return $e;
        }

        return $result;
    }

    /**
     * Update book entry in DB.
     *
     * @param $data
     * @param null $id
     * @return mixed
     * @throws Exception
     */
    public function update($data, $id)
    {
        try {
            $data['is_borrowed'] = $data['is_borrowed'] ?? 0;
            $result = $this->bookRepository->update($data, $id);
        } catch (Exception $e) {
            return $e;
        }

        return $result;
    }

    public function destroy(int $id)
    {
        try {
            $this->bookRepository->get($id);
            $result = $this->bookRepository->delete($id);
        } catch (Exception $e) {
            return $e;
        }

        return $result;
    }
}
