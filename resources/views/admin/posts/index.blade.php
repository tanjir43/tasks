@extends('layouts.admin')
@section('css')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/css/all.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.min.css">
<link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.css" rel="stylesheet">
@endsection

@php
    use App\Enums\Category;
@endphp
@section('content')
    <div class="row">
        <div class="col-sm-12 col-md-8">
            <x-card variant="primary" outline="true" title="{!! __('Post').' '.__('msg.list') !!}">
                <x-slot name="body">
                    <div class="table-responsive">
                        <table class="table table-bordered" id="post_table" style="width: 100%">
                            <thead>
                                <tr>
                                    <th class="text-center" style="width:25%">{{ __('msg.title') }}</th>
                                    <th class="text-center" style="width:30%">{{ __('Description') }}</th>
                                    <th class="text-center" style="width: 20%">{{ __('msg.action_by') }}</th>
                                    <th style="text-align: right;width: 20%">{{ __('msg.action') }}</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </x-slot>
            </x-card>
        </div>

        <div class="col-sm-12 col-md-4">
            <x-form route="post.save" :update="$record->id ?? null">
                <x-slot name="body">
                    <x-card variant="primary"  title="{{__('Post').' '.__('msg.information')}}">
                        <x-slot name="body">
                            <div class="form-group mt-3">
                                <?php
                                    $attr = [
                                        'id'        => 'title',
                                        'class'     => 'form-control mt-1',
                                        'required'  => 'required',
                                    ];
                                ?>
                                {!! Form::label('title',__('msg.title')) !!} <span class="text-danger">*</span>
                                {!! Form::text('title',$record->title ?? old('title'),$attr) !!}
                            </div>

                            <div class="form-group mt-3">
                                {!! Form::label('category', __('Category')) !!} <span class="text-danger">*</span>
                                {!! Form::select('category', $categories, $record->category_id ?? old('category'), [
                                    'id' => 'category',
                                    'class' => 'form-control mt-1',
                                    'required' => 'required',
                                ]) !!}
                            </div>


                            {{-- <div class="form-group mb-1 mt-3">
                                {!! Form::label('file', __('msg.picture') ) !!} <br />
                                @if(!empty($record->media))
                                    <img src="{{ $record->media->attachment }}" class="img-thumbnail"  width="250px">
                                @else
                                    <input type="file" name="file">
                                @endif
                            </div> --}}

                            <div class="form-group mt-3">
                                <?php
                                    $attr = [
                                        'id'        => 'description',
                                        'class'     => 'mt-1',
                                    ];
                                ?>
                               {!! Form::label('description', __('msg.description')) !!} <br>
                               {!! Form::textarea('description',$record->description ?? old('description'),$attr) !!}

                            </div>
                            <div class="form-group mt-3">
                                {!! Form::label('status', __('Status')) !!}
                                <div>
                                    <div class="form-check form-check-inline">
                                        {!! Form::radio('status', 'draft', isset($record) && $record->status == 'draft', ['id' => 'status_draft', 'class' => 'form-check-input']) !!}
                                        {!! Form::label('status_draft', __('Draft'), ['class' => 'form-check-label']) !!}
                                    </div>
                                    <div class="form-check form-check-inline">
                                        {!! Form::radio('status', 'published', isset($record) && $record->status == 'published', ['id' => 'status_published', 'class' => 'form-check-input']) !!}
                                        {!! Form::label('status_published', __('Published'), ['class' => 'form-check-label']) !!}
                                    </div>
                                    <div class="form-check form-check-inline">
                                        {!! Form::radio('status', 'archived', isset($record) && $record->status == 'archived', ['id' => 'status_archived', 'class' => 'form-check-input']) !!}
                                        {!! Form::label('status_archived', __('Archived'), ['class' => 'form-check-label']) !!}
                                    </div>
                                </div>
                            </div>

                            <x-slot name="footer">
                                {!! Form::submit(__('msg.save'),["class"=>"btn btn-success float-right"]) !!}
                            </x-slot>
                        </x-slot>
                    </x-card>
                </x-slot>
            </x-form>
        </div>
    </div>
@endsection


@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.js"></script>
<script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>

<script>
    const address = $('#description');
    address.summernote({
        height     : 120,
        placeholder:'make a description here...',
        toolbar: [
            ['style', ['bold']],
            ['font', [ 'fontname','fontsize']],
        ]
    });
</script>

<script>
    $(function() {
        window.LaravelDataTables = window.LaravelDataTables || {};
        window.LaravelDataTables["dataTableBuilder"] = $("#post_table").DataTable({
            "serverSide": true,
            "processing": true,
            "ajax": {
                "url": '{{ route('post.datatable') }}',
                "type": "GET"
            },
            "columns": [
                { data: 'title', "orderable": true, "searchable": true },
                { data: 'description', "orderable": false, "searchable": false },
                { data: 'created_at', "orderable": false, "searchable": false },
                { data: 'action', name: 'action', orderable: false, searchable: false },
            ]
        });
    });
</script>

@endpush
