@php
    $columns = [
        [
            'label' => __('author.Name'),
            'key' => 'name',
            'type' => 'text',
            'settings' => [
                'sortable' => true,
                'searchable' => true,
                'placeholder' => __('general.Search placeholder')
            ]
        ],
        [
            'label' => __('author.Surname'),
            'key' => 'surname',
            'type' => 'text',
            'settings' => [
                'sortable' => true,
                'searchable' => true,
                'placeholder' => __('general.Search placeholder')
            ]
        ],
        [
            'label' => __('author.Number of books'),
            'key' => 'number_of_books',
            'type' => 'string',
            'settings' => [
                'sortable' => false,
                'searchable' => false,
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
        'reloadUrl'     => "/authors",
        'showPagination' => \App\Models\Author::INDEX_VIEW_PAGINATION,
        'showPerPageSelect' => \App\Models\Author::INDEX_VIEW_PER_PAGE_SELECT,
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
            'url' => "/authors",
            'fields' => [
                [
                    'label' => __('author.Name'),
                    'key' => 'name',
                    'type' => 'text',
                    'settings' => [
                        'divClass' => 'col col-12 col-sm-4  pl-0',
                        'required' => true,
                        'searchable' => true
                    ]
                ],
                [
                    'label' => __('author.Surname'),
                    'key' => 'surname',
                    'type' => 'text',
                    'settings' => [
                        'divClass' => 'col col-12 col-sm-6  pl-0',
                        'required' => true,
                        'searchable' => true
                    ]
                ],
            ],
        ]
    ];

    $gridview = new \App\Helpers\SimpleTable($columns, $data, \App\Models\Author::ENTITY_ROUTE_PREFIX, $config);
@endphp
@extends ('layouts.app')
@section ('content')
    <div class="card">
        <div class="card-header">@lang('author.Author list')</div>
        <div class="card-body">
            <div class="form-group form-row">
                <a role="button" title="@lang('general.Create')" class="btn btn-primary btn-sm" href="{{ route('authors.create') }}"><span class="material-icons">add</span></a>
            </div>
            <?= $gridview->render(); ?>
        </div>
    </div>
@endsection
