                    <div class="row">
                        <div class="col-md-4  col-md-offset-3" style="margin-top:20px;margin-bottom:20px;">{!! getAvatar($user->id,150) !!}</div>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-stripped table-hover show-table">
                            <tbody>
                                <tr>
                                    <th>{{trans('messages.name')}}</th>
                                    <td>{{$user->full_name}}</td>
                                </tr>
                                <tr>
                                    <th>{{trans('messages.status')}}</th>
                                    <td>{{toWord($user->status)}}</td>
                                </tr>
                                @if($type == 'staff')
                                <tr>
                                    <th>{{trans('messages.role')}}</th>
                                    <td>
                                        @foreach($user->roles as $role)
                                            {{ucfirst($role->name)}}<br />
                                        @endforeach
                                    </td>
                                </tr>
                                <tr>
                                    <th>{{trans('messages.designation')}}</th>
                                    <td>{{$user->designation_with_department}}</td>
                                </tr>
                                @else
                                <tr>
                                    <th>{{trans('messages.company')}}</th>
                                    <td>{{($user->Profile->Company) ? $user->Profile->Company->name : ''}}</td>
                                </tr>
                                <tr>
                                    <th>{{trans('messages.group')}}</th>
                                    <td>
                                        <ol>
                                        @foreach($user->CustomerGroup as $group)
                                            <li>{{$group->name}}</li>
                                        @endforeach
                                        </ol>
                                    </td>
                                </tr>
                                @endif
                                <tr>
                                    <th>{{trans('messages.email')}}</th>
                                    <td>{{$user->email}}</td>
                                </tr>
                                @if(!config('config.login'))
                                <tr>
                                    <th>{{trans('messages.username')}}</th>
                                    <td>{{$user->username}}</td>
                                </tr>
                                @endif
                                <tr>
                                    <th>{{trans('messages.signup').' '.trans('messages.date')}}</th>
                                    <td>{{showDate($user->created_at)}}</td>
                                </tr>
                                <tr>
                                    <th>{{trans('messages.last').' '.trans('messages.login')}}</th>
                                    <td>{{showDateTime($user->last_login)}}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    @if(Auth::user()->id == $user->id)
                        <div class="row" style="padding:10px;">
                            <div class="col-md-6">
                                <a href="#" data-href="/change-password" data-toggle="modal" data-target="#myModal" class="btn btn-block btn-primary">{{trans('messages.change').' '.trans('messages.password')}}</a>
                            </div>
                            <div class="col-md-6">
                                <a href="#" onclick="event.preventDefault();
                                document.getElementById('logout-form').submit();" class="btn btn-block btn-danger">{{trans('messages.logout')}}</a>
                            </div>
                        </div>
                    @endif