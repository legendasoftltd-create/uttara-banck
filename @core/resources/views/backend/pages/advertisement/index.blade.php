@extends('backend.admin-master')
@section('site-title')
    {{__('All Our Activities')}}
@endsection

@section('style')
<x-datatable.css/>
<x-media.css/>
@endsection

@section('content')
    <div class="col-lg-12 col-ml-12 padding-bottom-30">
        <div class="row">
            <div class="col-lg-12">
                <div class="margin-top-40"></div>
                <x-error-msg/>
                <x-flash-msg/>
            </div>
            <div class="col-lg-12 mt-5">
                <div class="card">
                    <div class="card-body">
                        <div class="header-wrap d-flex justify-content-between">
                            <div class="left-content">
                                <h4 class="header-title">{{__('All Our Activities')}}  </h4>
                               @if(check_page_permission_by_string('Our Activities Delete') || check_page_permission_by_string('activities_delete'))
                               <div class="bulk-delete-wrapper">
                                    <div class="select-box-wrap">
                                        <select name="bulk_option" id="bulk_option">
                                            <option value="">{{{__('Bulk Action')}}}</option>
                                            <option value="delete">{{{__('Delete')}}}</option>
                                        </select>
                                        <button class="btn btn-primary btn-sm" id="bulk_delete_btn">{{__('Apply')}}</button>
                                    </div>
                                </div>
                               @endif
                            </div>
                            @if(check_page_permission_by_string('Our Activities Edit') || check_page_permission_by_string('activities_edit'))
                            <div class="right-content">
                                <a href="{{ route('admin.advertisement.new')}}" class="btn btn-primary">{{__('Add New Activity')}}</a>
                            </div>
                            @endif
                        </div>
                        <div class="table-wrap table-responsive">
                            <table class="table table-default">
                                <thead>
                                @if(check_page_permission_by_string('Our Activities Delete') || check_page_permission_by_string('activities_delete'))
                                <th class="no-sort">
                                    <div class="mark-all-checkbox">
                                        <input type="checkbox" class="all-checkbox">
                                    </div>
                                </th>
                                @endif
                                <th>{{__('ID')}}</th>
                                <th>{{__('Title')}}</th>
                                <th>{{__('Type')}}</th>
                                <th>{{__('Size')}}</th>
                                <th>{{__('Image')}}</th>
                                <th>{{__('Image Courtesy')}}</th>
                                <th>{{__('Click')}}</th>
                                <th>{{__('Impression')}}</th>
                                <th>{{__('Status')}}</th>
                                <th>{{__('Action')}}</th>
                                </thead>
                                <tbody>
                                    @foreach($all_advertisements as $data)
                                        <tr>
                                            @if(check_page_permission_by_string('Our Activities Delete') || check_page_permission_by_string('activities_delete'))
                                            <td>
                                                <x-bulk-delete-checkbox :id="$data->id"/>
                                            </td>
                                            @endif
                                            <td>{{$data->id}}</td>
                                            <td>{{$data->title}}</td>
                                            <td>{{__(str_replace('_',' ',$data->type))}}</td>
                                            <td>{{$data->size}}</td>
                                            <td>
                                                @php
                                                    $add_img = get_attachment_image_by_id($data->image,null,true);
                                                @endphp
                                                @if (!empty($add_img))
                                                    <div class="attachment-preview">
                                                        <div class="thumbnail">
                                                            <div class="centered">
                                                                <img class="avatar user-thumb" src="{{$add_img['img_url']}}" alt="">
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endif
                                            </td>
                                            <td>
                                                @if(!empty($data->image_courtesy))
                                                    <span class="badge badge-info">{{$data->image_courtesy}}</span>
                                                @else
                                                    <span class="text-muted">-</span>
                                                @endif
                                            </td>
                                            <td>{{$data->click}}</td>
                                            <td>{{$data->impression}}</td>
                                            <td>
                                                @php
                                                $type = 'warning';
                                                $name = __('Inactive');
                                                  if($data->status === 1){
                                                      $type = 'primary';
                                                      $name = __('Active');
                                                  }
                                                 @endphp
                                                    <span class="alert alert-{{$type}}">{{$name}}</span>
                                            </td>
                                            <td>
                                                @if(check_page_permission_by_string('Our Activities Delete') || check_page_permission_by_string('activities_delete'))
                                                  <x-delete-popover :url="route('admin.advertisement.delete',$data->id)"/>
                                                @endif
                                                @if(check_page_permission_by_string('Our Activities Edit') || check_page_permission_by_string('activities_edit'))
                                                  <x-edit-icon :url="route('admin.advertisement.edit',$data->id)"/>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
  <x-media.markup/>
@endsection

@section('script')

    <script type="text/javascript">
        (function(){
            "use strict";
            $(document).ready(function(){
                <x-bulk-action-js :url="route('admin.advertisement.bulk.action')"/>
              });
        })(jQuery);
    </script>


<x-media.js/>
@endsection
