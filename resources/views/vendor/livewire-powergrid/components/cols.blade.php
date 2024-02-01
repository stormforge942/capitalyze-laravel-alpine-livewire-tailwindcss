@props([
    'column' => null,
    'theme' => null,
    'multiSort' => false,
    'sortArray' => [],
    'sortField' => null,
    'sortDirection' => null,
    'enabledFilters' => null,
    'actions' => null,
    'dataField' => null,
])
@php
    $field = filled($column->dataField) ? $column->dataField : $column->field;
@endphp
<th class="{{ $theme->table->thClass . ' ' . $column->headerClass }}" wire:key="{{ md5($column->field) }}"
    @if ($column->sortable) x-data x-multisort-shift-click="{{ $this->id }}" @endif
    style="{{ $column->hidden === true ? 'display:none' : '' }}; width: max-content; @if ($column->sortable) cursor:pointer; @endif {{ $theme->table->thStyle . ' ' . $column->headerStyle }}">
    <div @class(['flex items-center gap-1', $theme->cols->divClass]) style="{{ $theme->cols->divStyle }}"
        @if ($column->sortable) wire:click="sortBy('{{ $field }}')" @endif>
        <span>{{ $column->title }}</span>
        @if ($column->sortable)
            <span>
                @if ($multiSort && array_key_exists($field, $sortArray))
                    @if ($sortArray[$field] == 'desc')
                        &#8595;
                    @else
                        &#8593;
                    @endif
                @elseif($multiSort)
                    &#8597;
                @else
                    @if ($sortField !== $field)
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                            viewBox="0 0 16
                    16" fill="none">
                            <path d="M12 6L8 2L4 6H12ZM12 10L8 14L4 10H12Z" fill="#464E49" />
                        </svg>
                    @elseif ($sortDirection == 'desc')
                        &#8593;
                    @else
                        &#8595;
                    @endif
                @endif
            </span>
        @endif
    </div>
</th>
