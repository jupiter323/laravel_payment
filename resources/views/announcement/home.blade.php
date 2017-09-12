
            <div class="col-sm-6">
                <div class="box-info">
                    <h2><strong>{!! trans('messages.announcement') !!}</strong> </h2>
                    <div class="custom-scrollbar">
                    @if(count($announcements))
                        @foreach($announcements as $announcement)
                            <div class="the-notes info">
                                <h4><a href="#" data-href="/announcement/{{$announcement->id}}" data-toggle="modal" data-target="#myModal">{!! $announcement->title !!}</a></h4>
                                <span style="color:green;"><i class="fa fa-clock-o"></i> {!! showDateTime($announcement->created_at) !!}</span>
                                <p class="time pull-right" style="text-align:right;">{!! trans('messages.by').' '.$announcement->User->full_name.'<br />'.$announcement->User->designation_with_department !!}</p>
                            </div>
                        @endforeach
                    @else
                        @include('global.notification',['type' => 'danger','message' => trans('messages.no_data_found')])
                    @endif
                    </div>
                </div>
            </div>