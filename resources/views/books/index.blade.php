@php
    $columns = [
        [
            'label' => __('book.Book title'),
            'key' => 'title',
            'type' => 'text',
            'settings' => [
                'sortable' => true,
                'searchable' => true,
                'placeholder' => __('general.Search placeholder')
            ]
        ],
        [
            'label' => __('book.Author'),
            'key' => 'author_full_name',
            'map' => 'author_id',
            'type' => 'select',
            'options' => $authors,
            'settings' => [
                'sortable' => true,
                'searchable' => true,
                'placeholder' => __('general.Search placeholder')
            ]
        ],
        [
            'label' => __('book.Is borrowed'),
            'key' => 'is_borrowed_label',
            'map' => 'is_borrowed',
            'type' => 'select',
            'options' => [
                [],
                [
                    'id' => 0,
                    'value' => 'Nie'
                ],[
                    'id' => 1,
                    'value' => 'Áno'
                ],
            ],
            'settings' => [
                'sortable' => true,
                'searchable' => true,
                'placeholder' => __('general.Search placeholder')
            ]
        ],
        [
            'label' => __('general.Created at'),
            'key' => 'created_at',
            'type' => 'date',
            'settings' => [
                'sortable' => true,
                'searchable' => true,
                'placeholder' => __('general.Search placeholder')
            ]
        ],
    ];

    $config = [
        'reloadUrl'     => "/books",
        'showPagination' => \App\Models\Book::INDEX_VIEW_PAGINATION,
        'showPerPageSelect' => \App\Models\Book::INDEX_VIEW_PER_PAGE_SELECT,
        'itemsPerPage'  => \App\Helpers\SimpleTable::ITEMS_PER_PAGE,
        'numberOfRows'  => \App\Helpers\SimpleTable::NUMBER_OF_ROWS,
        'sortKey'       => \App\Helpers\SimpleTable::SORT_KEY,
        'sortDirection' => \App\Helpers\SimpleTable::SORT_DIRECTION,
        'searchable'    => true,

        'inlineNew' => [
            'label' => 'add',
            'title' => __('general.Create'),
            'key' => 'store',
            'class' => 'btn btn-sm btn-outline-primary mr-1',
            'action' => 'createItem',
            'url' => "/books",
            'fields' => [
                [
                    'label' => __('book.Book title'),
                    'key' => 'title',
                    'type' => 'text',
                    'settings' => [
                        'divClass' => 'col col-12 col-sm-3  pl-0',
                        'required' => true,
                        'searchable' => true
                    ]
                ],
                [
                    'label' => __('book.Author'),
                    'key' => 'author_id',
                    'type' => 'select',
                    'settings' => [
                        'divClass' => 'col col-12 col-sm-3  pl-0',
                        'required' => true,
                        'searchable' => true
                    ],
                    'options' => $authors
                ],
                [
                    'label' => __('book.Is borrowed'),
                    'key' => 'is_borrowed',
                    'type' => 'checkbox',
                    'settings' => [
                        'divClass' => 'col col-12 col-sm-3  pl-0',
                        'required' => true,
                        'searchable' => true
                    ]
                ],
            ],
        ]
    ];

    $actions = [
        [
            'label' => 'cached',
            'title' => __('general.Change status'),
            'key' => 'change',
            'class' => 'btn btn-sm btn-outline-primary',
            'url' => url(\App\Models\Book::ENTITY_ROUTE_PREFIX."/{id}/change-status"),
            'dataToggle' => 'modal',
            'dataTarget' => '#modalConfirm',
            'modalText' => __('general.Confirmation change status'),
            'requestMethod' => 'POST',
            'ajax' => true
        ]
    ];

    $gridview = new \App\Helpers\SimpleTable($columns, $data, \App\Models\Book::ENTITY_ROUTE_PREFIX, $config, $actions, true);
@endphp
@extends ('layouts.app')
@section ('content')
    <div class="card">
        <div class="card-header">@lang('book.Books list')</div>
        <div class="card-body">
            <div class="form-group form-row">
                <a role="button" title="@lang('general.Create')" class="btn btn-primary btn-sm" href="{{ route('books.create') }}"><span class="material-icons">add</span></a>
            </div>
            <?= $gridview->render(); ?>
        </div>
    </div>
@endsection
