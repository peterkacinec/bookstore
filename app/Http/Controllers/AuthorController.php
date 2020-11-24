<?php

namespace App\Http\Controllers;

use App\Http\Requests\AuthorRequest;
use App\Services\AuthorService;
use Illuminate\Http\Response;

class AuthorController extends Controller
{
    private $authorService;

    public function __construct(AuthorService $authorService)
    {
        $this->authorService = $authorService;
    }

    public function index()
    {
        $result = [];
        try {
            $result = $this->authorService->all();
        } catch (\Exception $e) {
            request()->session()->now('fail', $e->getMessage());
        }

        if (request()->ajax()) {
            return response()->json($result);
        }

        return view('authors.index', ['data' => $result]);
    }

    public function create()
    {
        return view('authors.create');
    }

    /**
     * Store a new user.
     *
     * @param AuthorRequest $request
     * @return mixed
     */
    public function store(AuthorRequest $request)
    {
        $data = $request->validated();

        try {
            $result = $this->authorService->save($data);
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
                ->route('authors.show', $result->id)
                ->withSuccess(__('general.Created successfully'));
        }
    }

    public function show(int $id)
    {
        try {
            $result = $this->authorService->get($id);
        } catch (\Exception $e) {
            return back()
                ->withFail($e->getMessage());
        }

        return view('authors.show', ['data' => $result]);
    }

    public function edit(int $id)
    {
        try {
            $data = $this->authorService->get($id);
        } catch (\Exception $e) {
            return back()
                ->withFail($e->getMessage());
        }

        return view('authors.edit', ['data' => $data]);
    }

    public function update(AuthorRequest $request, int $id)
    {
        $data = $request->validated();

        try {
            $result = $this->authorService->update($data, $id);
        } catch (\Exception $e) {
            return back()
                ->withFail(__('general.Update failed') . ' ' . $e->getMessage())
                ->withInput();
        }

        return redirect()
            ->route('authors.show', $result->id)
            ->withSuccess(__('general.Updated successfully'));
    }

    public function destroy(int $id)
    {
        try {
            $this->authorService->destroy($id);

            if (request()->ajax()) {
                return response()->json([
                    'success' => true,
                    'id' => $id,
                    'message' => __('general.Deleted successfully'),
                ], Response::HTTP_OK);
            } else {
                return redirect()
                    ->route('authors.index')
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
                    ->route('authors.index')
                    ->withFail($e->getMessage());
            }
        }
    }
}
