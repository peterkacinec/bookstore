<?php

namespace App\Http\Controllers;

use App\Http\Requests\BookRequest;
use App\Services\AuthorService;
use App\Services\BookService;
use Illuminate\Http\Response;

class BookController extends Controller
{
    private $bookService;
    private $authorService;

    public function __construct(BookService $bookService, AuthorService $authorService)
    {
        $this->bookService = $bookService;
        $this->authorService = $authorService;
    }

    public function index()
    {
        $result = [];
        $authors = $this->authorService->getDataForSelectbox();
        try {
            $result = $this->bookService->all();
        } catch (\Exception $e) {
            request()->session()->now('fail', $e->getMessage());
        }

        if (request()->ajax()) {
            return response()->json($result);
        }

        return view('books.index', [
            'data' => $result,
            'authors' => array_merge([''],$authors),
        ]);
    }

    public function create()
    {
        $authors = $this->authorService->all();
        return view('books.create', ['authors' => $authors]);
    }

    /**
     * Store a new book.
     *
     * @param BookRequest $request
     * @return mixed
     */
    public function store(BookRequest $request)
    {
        $data = $request->validated();

        try {
            $result = $this->bookService->save($data);
        } catch (\Exception $e) {
            if ($request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => __('general.Create failed') . ' ' . $e->getMessage(),
                ], $e->getCode() ? $e->getCode() : Response::HTTP_VERSION_NOT_SUPPORTED);
            } else {
                return back()
                    ->withFail(__('general.Create failed') . ' ' . $e->getMessage())
                    ->withInput();
            }
        }

        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'id' => $result->id,
                'message' => __('general.Created successfully'),
            ], Response::HTTP_OK);
        } else {
            return redirect()
                ->route('books.show', $result->id)
                ->withSuccess(__('general.Created successfully'));
        }
    }

    public function show(int $id)
    {
        try {
            $result = $this->bookService->get($id);
        } catch (\Exception $e) {
            return back()
                ->withFail($e->getMessage());
        }

        return view('books.show', ['data' => $result]);
    }

    public function edit(int $id)
    {
        try {
            $data = $this->bookService->get($id);
            $authors = $this->authorService->all();
        } catch (\Exception $e) {
            return back()
                ->withFail($e->getMessage());
        }

        return view('books.edit', [
            'data' => $data,
            'authors' => $authors,
        ]);
    }

    public function update(BookRequest $request, int $id)
    {
        $data = $request->validated();

        try {
            $result = $this->bookService->update($data, $id);
        } catch (\Exception $e) {
            return back()
                ->withFail(__('general.Update failed') . ' ' . $e->getMessage())
                ->withInput();
        }

        return redirect()
            ->route('books.show', $result->id)
            ->withSuccess(__('general.Updated successfully'));
    }

    public function destroy(int $id)
    {
        try {
            $this->bookService->destroy($id);

            if (request()->ajax()) {
                return response()->json([
                    'success' => true,
                    'id' => $id,
                    'message' => __('general.Deleted successfully'),
                ], Response::HTTP_OK);
            } else {
                return redirect()
                    ->route('books.index')
                    ->withSuccess(__('general.Deleted successfully'));
            }
        } catch (\Exception $e) {
            if (request()->ajax()) {
                return response()->json([
                    'success' => false,
                    'id' => $id,
                    'message' => $e->getMessage(),
                ], $e->getCode() ? $e->getCode() : Response::HTTP_VERSION_NOT_SUPPORTED);
            } else {
                return redirect()
                    ->route('books.index')
                    ->withFail($e->getMessage());
            }
        }
    }

    public function changeStatus(int $id)
    {
        try {
            if ($id) {
                //check if exist
                $book = $this->bookService->get($id);

                $this->bookService->changeStatus($book);

                if (request()->ajax()) {
                    return response()->json([
                        'success' => true,
                        'id' => $id,
                        'message' => __('general.Updated successfully'),
                    ], Response::HTTP_OK);
                } else {
                    return redirect()
                        ->route('books.index')
                        ->withSuccess(__('general.Updated successfully'));
                }
            }
        } catch (\Exception $e) {
            if (request()->ajax()) {
                return response()->json([
                    'success' => false,
                    'id' => $id,
                    'message' => __('general.Update failed').' '.$e->getMessage(),
                ], $e->getCode() ? $e->getCode() : Response::HTTP_VERSION_NOT_SUPPORTED);
            } else {
                return redirect()
                    ->route('books.index')
                    ->withFail(__('general.Update failed').' '.$e->getMessage());
            }
        }
    }
}
