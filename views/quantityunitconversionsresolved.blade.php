@extends('layout.default')

@section('title', $__t('QU conversions resolved'))

@section('viewJsName', 'quantityunitconversionsresolved')

@section('content')
<div class="row">
	<div class="col">
		<div class="title-related-links">
			<h2 class="title">@yield('title')</h2>
			@if($product != null)
			<h2>
				<span class="text-muted small">{{ $__t('Product') }} <strong>{{ $product->name }}</strong></span>
			</h2>
			@endif
		</div>
	</div>
</div>

<hr class="my-2">

<div class="row d-md-flex"
	id="table-filter-row">
	<div class="col-6">
		<div class="input-group">
			<div class="input-group-prepend">
				<span class="input-group-text"><i class="fa-solid fa-search"></i></span>
			</div>
			<input type="text"
				id="search"
				class="form-control"
				placeholder="{{ $__t('Search') }}">
		</div>
	</div>
	<div class="col-5">
		<div class="input-group">
			<div class="input-group-prepend">
				<span class="input-group-text"><i class="fa-solid fa-filter"></i>&nbsp;{{ $__t('Quantity unit') }}</span>
			</div>
			<select class="custom-control custom-select"
				id="quantity-unit-filter">
				<option value="all">{{ $__t('All') }}</option>
				@foreach($quantityUnits as $quantityUnit)
				<option value="{{ $quantityUnit->id }}">{{ $quantityUnit->name }}</option>
				@endforeach
			</select>
		</div>
	</div>
	<div class="col-1">
		<div class="float-right">
			<button id="clear-filter-button"
				class="btn btn-sm btn-outline-info"
				data-toggle="tooltip"
				title="{{ $__t('Clear filter') }}">
				<i class="fa-solid fa-filter-circle-xmark"></i>
			</button>
		</div>
	</div>
</div>

<div class="row">
	<div class="col">

		<table id="qu-conversions-resolved-table"
			class="table table-sm table-striped nowrap w-100">
			<thead>
				<tr>
					<th class="border-right"><a class="text-muted change-table-columns-visibility-button"
							data-toggle="tooltip"
							title="{{ $__t('Table options') }}"
							data-table-selector="#qu-conversions-resolved-table"
							href="#"><i class="fa-solid fa-eye"></i></a>
					</th>
					<th class="allow-grouping">{{ $__t('Quantity unit from') }}</th>
					<th class="allow-grouping">{{ $__t('Quantity unit to') }}</th>
					<th>{{ $__t('Factor') }}</th>
					<th></th>
				</tr>
			</thead>
			<tbody class="d-none">
				@foreach($quantityUnitConversionsResolved as $quConversion)
				<tr>
					<td class="fit-content border-right"></td>
					<td>
						{{ FindObjectInArrayByPropertyValue($quantityUnits, 'id', $quConversion->from_qu_id)->name }}
					</td>
					<td>
						{{ FindObjectInArrayByPropertyValue($quantityUnits, 'id', $quConversion->to_qu_id)->name }}
					</td>
					<td>
						<span class="locale-number locale-number-quantity-amount">{{ $quConversion->factor }}</span>
					</td>
					<td class="font-italic">
						{!! $__t('This means 1 %1$s is the same as %2$s %3$s', FindObjectInArrayByPropertyValue($quantityUnits, 'id', $quConversion->from_qu_id)->name, '<span class="locale-number locale-number-quantity-amount">' . $quConversion->factor . '</span>', $__n($quConversion->factor, FindObjectInArrayByPropertyValue($quantityUnits, 'id', $quConversion->to_qu_id)->name, FindObjectInArrayByPropertyValue($quantityUnits, 'id', $quConversion->to_qu_id)->name_plural, true)) !!}
					</td>
				</tr>
				@endforeach
			</tbody>
		</table>

	</div>
</div>
@stop
