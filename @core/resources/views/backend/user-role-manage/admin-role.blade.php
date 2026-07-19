@extends('backend.admin-master')
@section('style')
    <link rel="stylesheet" href="{{asset('assets/backend/css/nice-select.css')}}">
@endsection
@section('site-title')
    {{__('All Admin Role')}}
@endsection
@section('content')

@php
    $permissions_by_module = [
        "User Management" => [
            "All Users" => "admin_manage",
            "Add New User" => "admin_manage",
            "All User Role & Permission" => "admin_manage",
        ],
        "Pages" => [
            "All Pages" => "pages_view",
            "Add New Page" => "pages_edit",
            "Delete Page" => "pages_delete",
        ],
        "News" => [
            "All News" => "news_view",
            "Add New News" => "news_edit",
            "Delete News" => "news_delete",
        ],
        "Our Activities" => [
            "All Our Activities" => "activities_view",
            "Add New Activity" => "activities_edit",
            "Delete Activity" => "activities_delete",
        ],
        "Our Services" => [
            "Our Services View" => "services_view",
            "Our Services Create" => "services_create",
            "Our Services Edit" => "services_edit",
            "Our Services Delete" => "services_delete",
            "Category View" => "services_category_view",
            "Category Create" => "services_category_create",
            "Category Edit" => "services_category_edit",
            "Category Delete" => "services_category_delete",
        ],
        "Important Information" => [
            "Important Information View" => "important_information_view",
            "Important Information Create" => "important_information_create",
            "Important Information Edit" => "important_information_edit",
            "Important Information Delete" => "important_information_delete",
            "Category View" => "important_information_category_view",
            "Category Create" => "important_information_category_create",
            "Category Edit" => "important_information_category_edit",
            "Category Delete" => "important_information_category_delete",
        ],
        "Image Gallery" => [
            "Image Gallery View" => "image_gallery_view",
            "Image Gallery Create" => "image_gallery_create",
            "Image Gallery Edit" => "image_gallery_edit",
            "Image Gallery Delete" => "image_gallery_delete",
            "Category View" => "image_gallery_category_view",
            "Category Create" => "image_gallery_category_create",
            "Category Edit" => "image_gallery_category_edit",
            "Category Delete" => "image_gallery_category_delete",
            "Gallery Page Settings" => "image_gallery_settings",
        ],
        "Video Gallery" => [
            "Video Gallery View" => "video_gallery_view",
            "Video Gallery Create" => "video_gallery_create",
            "Video Gallery Edit" => "video_gallery_edit",
            "Video Gallery Delete" => "video_gallery_delete",
            "Gallery Page Settings" => "video_gallery_settings",
        ],
        "Our Achievement" => [
            "Our Achievement View" => "achievement_view",
            "Our Achievement Create" => "achievement_create",
            "Our Achievement Edit" => "achievement_edit",
            "Our Achievement Delete" => "achievement_delete",
        ],
        "Team Manage" => [
            "Board of Director" => [
                "View" => "board_of_director_view",
                "Create" => "board_of_director_create",
                "Edit" => "board_of_director_edit",
                "Delete" => "board_of_director_delete",
            ],
            "Executive Committee" => [
                "View" => "executive_committee_view",
                "Create" => "executive_committee_create",
                "Edit" => "executive_committee_edit",
                "Delete" => "executive_committee_delete",
            ],
            "Audit Committee" => [
                "View" => "audit_committee_view",
                "Create" => "audit_committee_create",
                "Edit" => "audit_committee_edit",
                "Delete" => "audit_committee_delete",
            ],
            "Risk Management Committee" => [
                "View" => "risk_management_committee_view",
                "Create" => "risk_management_committee_create",
                "Edit" => "risk_management_committee_edit",
                "Delete" => "risk_management_committee_delete",
            ],
            "Senior Management" => [
                "View" => "senior_management_view",
                "Create" => "senior_management_create",
                "Edit" => "senior_management_edit",
                "Delete" => "senior_management_delete",
            ],
            "Designations" => [
                "View" => "designation_view",
                "Create" => "designation_create",
                "Edit" => "designation_edit",
                "Delete" => "designation_delete",
            ],
        ],
        "Loan & Deposit Manage" => [
            "Products View" => "products_view",
            "Products Create" => "products_create",
            "Products Edit" => "products_edit",
            "Products Delete" => "products_delete",
            "Product Type View" => "products_category_view",
            "Product Type Create" => "products_category_create",
            "Product Type Edit" => "products_category_edit",
            "Product Type Delete" => "products_category_delete",
        ],
        "All Modules" => [
            "Career Manage" => [
                "Jobs View" => "jobs_view",
                "Jobs Create" => "jobs_create",
                "Jobs Edit" => "jobs_edit",
                "Jobs Delete" => "jobs_delete",
                "Category View" => "jobs_category_view",
                "Category Create" => "jobs_category_create",
                "Category Edit" => "jobs_category_edit",
                "Category Delete" => "jobs_category_delete",
                "Job Page Settings" => "jobs_settings",
                "Job Single Page Settings" => "jobs_single_page_settings",
            ],
            "Support Tickets" => [
                "Tickets View" => "support_ticket_view",
                "Tickets Create" => "support_ticket_create",
                "Tickets Edit" => "support_ticket_edit",
                "Tickets Delete" => "support_ticket_delete",
                "Departments View" => "support_ticket_department_view",
                "Departments Create" => "support_ticket_department_create",
                "Departments Edit" => "support_ticket_department_edit",
                "Departments Delete" => "support_ticket_department_delete",
            ],
            "Locations" => [
                "Locations View" => "locations_view",
                "Locations Create" => "locations_create",
                "Locations Edit" => "locations_edit",
                "Locations Delete" => "locations_delete",
            ],
            "Bank Downloads" => [
                "Downloads View" => "downloads_view",
                "Downloads Create" => "downloads_create",
                "Downloads Edit" => "downloads_edit",
                "Downloads Delete" => "downloads_delete",
                "Category View" => "downloads_category_view",
                "Category Create" => "downloads_category_create",
                "Category Edit" => "downloads_category_edit",
                "Category Delete" => "downloads_category_delete",
            ],
            "Visitor Log" => [
                "Visitor Log View" => "visitor_log_view",
                "Visitor Log Delete" => "visitor_log_delete",
            ],
            "Auction" => [
                "Auctions View" => "auction_view",
                "Auctions Create" => "auction_create",
                "Auctions Edit" => "auction_edit",
                "Auctions Delete" => "auction_delete",
                "Auction Page Settings" => "auction_settings",
            ],
            "Notice" => [
                "Notices View" => "notice_view",
                "Notices Create" => "notice_create",
                "Notices Edit" => "notice_edit",
                "Notices Delete" => "notice_delete",
                "Notice Page Settings" => "notice_settings",
            ],
            "Complaint" => [
                "Complaints View" => "complaint_view",
                "Complaints Create" => "complaint_create",
                "Complaints Edit" => "complaint_edit",
                "Complaints Delete" => "complaint_delete",
            ],
            "Audit Trail" => "audit_log_manage",
            "Exchange Rates" => [
                "Exchange Rates View" => "exchange_rate_view",
                "Exchange Rates Create" => "exchange_rate_create",
                "Exchange Rates Edit" => "exchange_rate_edit",
                "Exchange Rates Delete" => "exchange_rate_delete",
            ],
            "Tender" => [
                "Tenders View" => "tender_view",
                "Tenders Create" => "tender_create",
                "Tenders Edit" => "tender_edit",
                "Tenders Delete" => "tender_delete",
                "Tender Page Settings" => "tender_settings",
            ],
            "Useful Links" => [
                "Useful Links View" => "useful_links_view",
                "Useful Links Create" => "useful_links_create",
                "Useful Links Edit" => "useful_links_edit",
                "Useful Links Delete" => "useful_links_delete",
                "Useful Links Page Settings" => "useful_links_settings",
            ],
        ],
        "Appearance Settings" => [
            "Topbar Settings" => [
                "View" => "topbar_settings_view",
                "Edit" => "topbar_settings_edit",
                "Delete" => "topbar_settings_delete",
            ],
            "Popup Builder" => [
                "View" => "popup_builder_view",
                "Edit" => "popup_builder_edit",
                "Delete" => "popup_builder_delete",
            ],
            "Header Area" => [
                "View" => "home_page_manage_view",
                "Create" => "home_page_manage_create",
                "Edit" => "home_page_manage_edit",
                "Delete" => "home_page_manage_delete",
            ],
            "404 Page Manage" => [
                "View" => "404_page_manage_view",
                "Edit" => "404_page_manage_edit",
            ],
            "Maintain Page Manage" => [
                "View" => "maintenance_page_view",
                "Edit" => "maintenance_page_edit",
            ],
            "Footer Settings" => [
                "View" => "footer_settings_view",
                "Edit" => "footer_settings_edit",
            ],
            "Media Manage" => [
                "View" => "media_manage_view",
            ],
        ],
        "General Settings" => [
            "Basic Settings" => [
                "View" => "general_settings_view",
                "Edit" => "general_settings_edit",
            ],
            "Site Identity" => [
                "View" => "site_identity_view",
                "Edit" => "site_identity_edit",
            ],
            "Third Party Scripts" => [
                "View" => "third_party_scripts_view",
                "Edit" => "third_party_scripts_edit",
            ],
            "SMTP Settings" => [
                "View" => "smtp_settings_view",
                "Edit" => "smtp_settings_edit",
            ],
            "Cache Settings" => [
                "View" => "cache_settings_view",
                "Edit" => "cache_settings_edit",
            ],
            "GDPR Cookies Settings" => [
                "View" => "gdpr_settings_view",
                "Edit" => "gdpr_settings_edit",
            ],
            "Sitemap Settings" => [
                "View" => "sitemap_settings_view",
                "Edit" => "sitemap_settings_edit",
            ],
            "RSS Feed Settings" => [
                "View" => "rss_settings_view",
                "Edit" => "rss_settings_edit",
            ],
            "Faq" => [
                "View" => "faq_view",
                "Create" => "faq_create",
                "Edit" => "faq_edit",
                "Delete" => "faq_delete",
            ],
        ]
    ];
@endphp

    <div class="col-lg-12 col-ml-12 padding-bottom-30">
        <div class="row">
            <div class="col-lg-12">
                @include('backend/partials/message')
            </div>
            <div class="col-lg-6 mt-5">
                <div class="card">
                    <div class="card-body">
                        <h4 class="header-title">{{__('All Admin Role')}}</h4>
                        <div class="data-tables datatable-primary">
                            <table id="all_user_table" class="table table-default">
                                <thead class="text-capitalize">
                                <tr>
                                    <th>{{__('ID')}}</th>
                                    <th>{{__('Role')}}</th>
                                    <th>{{__('Permissions')}}</th>
                                    <th>{{__('Action')}}</th>
                                </tr>
                                </thead>
                                <tbody>
                                    @foreach($all_role as $data)
                                        <tr>
                                            <td>{{$data->id}}</td>
                                            <td>{{$data->name}}</td>
                                            <td>
                                               <div class="permission-show">
                                                   @php $all_per = json_decode($data->permission) ?? []; @endphp
                                                   @foreach($all_per as $per)
                                                       <span class="text text-success">{{ucwords(str_replace('_',' ',$per))}}</span>
                                                   @endforeach
                                               </div>
                                            </td>
                                            <td>
                                                <x-delete-popover :url="route('admin.user.role.delete',$data->id)"/>
                                                <a href="#"
                                                   data-id="{{$data->id}}"
                                                   data-name="{{$data->name}}"
                                                   data-permission="{{$data->permission}}"
                                                   data-toggle="modal"
                                                   data-target="#user_edit_modal"
                                                   class="btn btn-xs btn-primary btn-sm mb-3 mr-1 user_edit_btn"
                                                >
                                                    <i class="ti-pencil"></i>
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-6  mt-5">
                <div class="card">
                    <div class="card-body">
                        <h4 class="header-title">{{__('Add New Admin Role')}}</h4>

                       <x-error-msg/>
                        <form action="{{route('admin.all.user.role')}}" method="post" enctype="multipart/form-data">
                            @csrf
                            <div class="form-group">
                                <label for="name">{{__('Role Name')}}</label>
                                <input type="text" class="form-control"  id="name" name="name" placeholder="{{__('Enter Role name')}}">
                            </div>
                            <div class="form-group">
                                <label for="permission"><strong>{{__('Permissions')}}</strong></label>
                                <div class="row">
                                    @foreach($permissions_by_module as $moduleName => $perms)
                                        <div class="col-12 mb-3">
                                            <div class="card border-light shadow-sm">
                                                <div class="card-header bg-light py-2 d-flex justify-content-between align-items-center">
                                                    <span class="mb-0 text-primary font-weight-bold" style="font-size: 13px;">{{ $moduleName }}</span>
                                                    <button type="button" class="btn btn-xs btn-outline-primary select-all-module" style="padding: 1px 5px; font-size: 10px;">{{ __('Check All') }}</button>
                                                </div>
                                                <div class="card-body py-2 px-3">
                                                    <div class="row">
                                                        @foreach($perms as $label => $value)
                                                            @if(is_array($value))
                                                                <div class="col-12 mt-2 mb-2">
                                                                    <div class="card border-light bg-light shadow-none">
                                                                        <div class="card-header py-1 px-3 d-flex justify-content-between align-items-center">
                                                                            <span class="mb-0 text-secondary font-weight-bold" style="font-size: 12px;">{{ $label }}</span>
                                                                            <button type="button" class="btn btn-xs btn-outline-secondary select-all-submodule" style="padding: 0px 4px; font-size: 9px;">{{ __('Check All') }}</button>
                                                                        </div>
                                                                        <div class="card-body py-2 px-3">
                                                                            <div class="row">
                                                                                @foreach($value as $subLabel => $subValue)
                                                                                    <div class="col-md-6 py-1">
                                                                                         <div class="custom-control custom-checkbox">
                                                                                             <input type="checkbox" name="permission[]" value="{{ $subValue }}" class="custom-control-input perm-checkbox sub-perm-checkbox" id="add_perm_{{ $subValue }}_{{ \Illuminate\Support\Str::slug($subLabel) }}">
                                                                                             <label class="custom-control-label text-secondary" for="add_perm_{{ $subValue }}_{{ \Illuminate\Support\Str::slug($subLabel) }}" style="font-size: 12px; font-weight: normal; cursor: pointer;">{{ $subLabel }}</label>
                                                                                         </div>
                                                                                    </div>
                                                                                @endforeach
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            @else
                                                                <div class="col-md-6 py-1">
                                                                     <div class="custom-control custom-checkbox">
                                                                         <input type="checkbox" name="permission[]" value="{{ $value }}" class="custom-control-input perm-checkbox" id="add_perm_{{ $value }}_{{ \Illuminate\Support\Str::slug($label) }}">
                                                                         <label class="custom-control-label text-secondary" for="add_perm_{{ $value }}_{{ \Illuminate\Support\Str::slug($label) }}" style="font-size: 12px; font-weight: normal; cursor: pointer;">{{ $label }}</label>
                                                                     </div>
                                                                </div>
                                                            @endif
                                                        @endforeach
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                                <div class="info-text">{{__('assign permission to role, which page can seen by the this role')}}</div>
                            </div>
                            <button type="submit" class="btn btn-primary mt-4 pr-4 pl-4">{{__('Add New Role')}}</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="user_edit_modal" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">{{__('Admin Role Edit')}}</h5>
                    <button type="button" class="close" data-dismiss="modal"><span>×</span></button>
                </div>
                <form action="{{route('admin.user.role.edit')}}" id="user_edit_modal_form" method="post" enctype="multipart/form-data">
                    <div class="modal-body">
                        <input type="hidden" name="admin_role_id" id="admin_role_id">
                        @csrf
                        <div class="form-group">
                            <label for="edit_name">{{__('Role Name')}}</label>
                            <input type="text" class="form-control"  id="edit_name" name="name" placeholder="{{__('Enter Role name')}}">
                        </div>
                        <div class="form-group">
                            <label for="edit_permission"><strong>{{__('Permissions')}}</strong></label>
                            <div class="row">
                                @foreach($permissions_by_module as $moduleName => $perms)
                                    <div class="col-md-6 mb-3">
                                        <div class="card border-light shadow-sm">
                                            <div class="card-header bg-light py-2 d-flex justify-content-between align-items-center">
                                                <span class="mb-0 text-primary font-weight-bold" style="font-size: 13px;">{{ $moduleName }}</span>
                                                <button type="button" class="btn btn-xs btn-outline-primary select-all-module" style="padding: 1px 5px; font-size: 10px;">{{ __('Check All') }}</button>
                                            </div>
                                            <div class="card-body py-2 px-3">
                                                <div class="row">
                                                    @foreach($perms as $label => $value)
                                                        @if(is_array($value))
                                                            <div class="col-12 mt-2 mb-2">
                                                                <div class="card border-light bg-light shadow-none">
                                                                    <div class="card-header py-1 px-3 d-flex justify-content-between align-items-center">
                                                                        <span class="mb-0 text-secondary font-weight-bold" style="font-size: 12px;">{{ $label }}</span>
                                                                        <button type="button" class="btn btn-xs btn-outline-secondary select-all-submodule" style="padding: 0px 4px; font-size: 9px;">{{ __('Check All') }}</button>
                                                                    </div>
                                                                    <div class="card-body py-2 px-3">
                                                                        <div class="row">
                                                                            @foreach($value as $subLabel => $subValue)
                                                                                <div class="col-12 py-1">
                                                                                     <div class="custom-control custom-checkbox">
                                                                                         <input type="checkbox" name="permission[]" value="{{ $subValue }}" class="custom-control-input perm-checkbox sub-perm-checkbox" id="edit_perm_{{ $subValue }}_{{ \Illuminate\Support\Str::slug($subLabel) }}">
                                                                                         <label class="custom-control-label text-secondary" for="edit_perm_{{ $subValue }}_{{ \Illuminate\Support\Str::slug($subLabel) }}" style="font-size: 12px; font-weight: normal; cursor: pointer;">{{ $subLabel }}</label>
                                                                                     </div>
                                                                                </div>
                                                                            @endforeach
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        @else
                                                            <div class="col-12 py-1">
                                                                 <div class="custom-control custom-checkbox">
                                                                     <input type="checkbox" name="permission[]" value="{{ $value }}" class="custom-control-input perm-checkbox" id="edit_perm_{{ $value }}_{{ \Illuminate\Support\Str::slug($label) }}">
                                                                     <label class="custom-control-label text-secondary" for="edit_perm_{{ $value }}_{{ \Illuminate\Support\Str::slug($label) }}" style="font-size: 12px; font-weight: normal; cursor: pointer;">{{ $label }}</label>
                                                                 </div>
                                                            </div>
                                                        @endif
                                                    @endforeach
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                            <div class="info-text">{{__('assign permission to role, which page can seen by the this role')}}</div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">{{__('Close')}}</button>
                        <button type="submit" class="btn btn-primary">{{__('Save changes')}}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

@endsection

@section('script')
    <script src="{{asset('assets/backend/js/jquery.nice-select.min.js')}}"></script>
    <script>
        $(document).ready(function () {

            $(document).on('click','.user_edit_btn',function(){
                var el = $(this);
                var form = $('#user_edit_modal_form');
                var permission = el.data('permission');
                form.find('#admin_role_id').val(el.data('id'));
                form.find('#edit_name').val(el.data('name'));
                
                // Clear previous checkboxes
                form.find('.perm-checkbox').prop('checked', false);
                
                // Populate current permission checkboxes
                $.each(permission,function (index,value) {
                    form.find('input[value="'+value+'"]').prop('checked', true);
                });
            });

            // Toggle select all in a module
            $(document).on('click', '.select-all-module', function(e) {
                e.preventDefault();
                var checkboxes = $(this).closest('.card').find('.perm-checkbox');
                var allChecked = true;
                checkboxes.each(function() {
                    if (!$(this).is(':checked')) {
                        allChecked = false;
                    }
                });
                checkboxes.prop('checked', !allChecked);
            });

            // Toggle select all in a sub-module
            $(document).on('click', '.select-all-submodule', function(e) {
                e.preventDefault();
                var checkboxes = $(this).closest('.card').find('.sub-perm-checkbox');
                var allChecked = true;
                checkboxes.each(function() {
                    if (!$(this).is(':checked')) {
                        allChecked = false;
                    }
                });
                checkboxes.prop('checked', !allChecked);
            });

            if($('.nice-select').length > 0){
                $('.nice-select').niceSelect();
            }
        });
    </script>
@endsection
