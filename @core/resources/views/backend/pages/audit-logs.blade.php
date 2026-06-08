@extends('backend.admin-master')
@section('site-title')
    {{__('Audit Trail')}}
@endsection
@section('content')
    <div class="col-lg-12 col-ml-12 padding-bottom-30">
        <div class="row">
            <div class="col-lg-12">
                <div class="margin-top-40"></div>
                <x-error-msg/>
                <x-flash-msg/>
            </div>
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <h4 class="header-title">{{__('Audit Trail — Search & Filter')}}</h4>
                        <form action="{{route('admin.audit.logs.all')}}" method="get">
                            <div class="row">
                                <div class="col-lg-2">
                                    <div class="form-group">
                                        <label>{{__('Actor')}}</label>
                                        <input type="text" name="actor_name" value="{{$filters['actor_name'] ?? ''}}" class="form-control" placeholder="{{__('Name / username')}}">
                                    </div>
                                </div>
                                <div class="col-lg-2">
                                    <div class="form-group">
                                        <label>{{__('Action')}}</label>
                                        <input type="text" name="action" value="{{$filters['action'] ?? ''}}" class="form-control" placeholder="{{__('e.g. auth.login')}}">
                                    </div>
                                </div>
                                <div class="col-lg-2">
                                    <div class="form-group">
                                        <label>{{__('Subject Type')}}</label>
                                        <select name="subject_type" class="form-control">
                                            <option value="">{{__('All')}}</option>
                                            @foreach($subject_types as $type)
                                                <option value="{{$type}}" @if(($filters['subject_type'] ?? '') == $type) selected @endif>{{class_basename($type)}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-2">
                                    <div class="form-group">
                                        <label>{{__('Level')}}</label>
                                        <select name="level" class="form-control">
                                            <option value="">{{__('All')}}</option>
                                            @foreach(['info','warning','error'] as $level)
                                                <option value="{{$level}}" @if(($filters['level'] ?? '') == $level) selected @endif>{{ucfirst($level)}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-2">
                                    <div class="form-group">
                                        <label>{{__('Start Date')}}</label>
                                        <input type="date" name="start_date" value="{{$filters['start_date'] ?? ''}}" class="form-control">
                                    </div>
                                </div>
                                <div class="col-lg-2">
                                    <div class="form-group">
                                        <label>{{__('End Date')}}</label>
                                        <input type="date" name="end_date" value="{{$filters['end_date'] ?? ''}}" class="form-control">
                                    </div>
                                </div>
                            </div>
                            <button type="submit" class="btn btn-primary">{{__('Filter')}}</button>
                            <a href="{{route('admin.audit.logs.all')}}" class="btn btn-secondary">{{__('Reset')}}</a>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <h4 class="header-title">{{__('Audit Trail')}}</h4>
                        <div class="table-wrap">
                            <table class="table table-bordered">
                                <thead>
                                <th>{{__('When (UTC)')}}</th>
                                <th>{{__('Actor')}}</th>
                                <th>{{__('Action')}}</th>
                                <th>{{__('Subject')}}</th>
                                <th>{{__('Level')}}</th>
                                <th>{{__('IP Address')}}</th>
                                <th>{{__('Description')}}</th>
                                <th>{{__('Details')}}</th>
                                </thead>
                                <tbody>
                                @forelse($logs as $log)
                                    <tr>
                                        <td>{{$log->created_at?->format('d M Y, H:i:s')}}</td>
                                        <td>
                                            @if($log->actor_name)
                                                {{$log->actor_name}} <span class="text-muted">({{$log->actor_guard ?? '—'}})</span>
                                            @else
                                                <span class="text-muted">{{__('System / Guest')}}</span>
                                            @endif
                                        </td>
                                        <td><code>{{$log->action}}</code></td>
                                        <td>
                                            @if($log->subject_type)
                                                {{class_basename($log->subject_type)}} #{{$log->subject_id}}
                                            @else
                                                —
                                            @endif
                                        </td>
                                        <td>
                                            <span class="badge @if($log->level == 'error') badge-danger @elseif($log->level == 'warning') badge-warning @else badge-info @endif">
                                                {{ucfirst($log->level)}}
                                            </span>
                                        </td>
                                        <td>{{$log->ip_address}}</td>
                                        <td>{{\Illuminate\Support\Str::limit($log->description, 60)}}</td>
                                        <td>
                                            <a href="#" data-toggle="modal" data-target="#audit_log_details_modal" class="btn btn-xs btn-primary btn-sm view_audit_log_btn"
                                               data-id="{{$log->id}}">
                                                <i class="ti-eye"></i>
                                            </a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="8" class="text-center">{{__('No audit log entries found')}}</td>
                                    </tr>
                                @endforelse
                                </tbody>
                            </table>
                        </div>
                        {{$logs->links()}}
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="audit_log_details_modal" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">{{__('Audit Log Entry')}}</h5>
                    <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
                </div>
                <div class="modal-body">
                    <pre id="audit_log_details_body" style="white-space: pre-wrap; word-break: break-word;"></pre>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script>
        $(document).on('click', '.view_audit_log_btn', function (e) {
            e.preventDefault();
            var id = $(this).data('id');
            $('#audit_log_details_body').text('{{__("Loading...")}}');
            $.ajax({
                url: '{{url("admin-home/audit-logs")}}/' + id,
                type: 'GET',
                success: function (response) {
                    $('#audit_log_details_body').text(JSON.stringify(response.log, null, 2));
                }
            });
        });
    </script>
@endsection
