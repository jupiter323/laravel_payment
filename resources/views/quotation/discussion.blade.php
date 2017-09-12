		@foreach($quotation->QuotationDiscussion->where('reply_id',null)->sortByDesc('created_at')->all() as $quotation_discussion)

			<?php $token = uniqid(); ?>
			<div class="box-info">
				<div style="width:60px; float:left; margin-bottom: 15px;">
					{!! getAvatar($quotation_discussion->user_id,45) !!}
				</div>
				<div>
					<strong>{{$quotation_discussion->User->full_name}}</strong>
					<br />{{$quotation_discussion->User->designation_with_department}}
					<p class="timeinfo pull-right"><i class="fa fa-clock-o"></i> {{showDateTime($quotation_discussion->created_at)}}</p>
				</div>	
				<div class="clear"></div>	
				<p>{{$quotation_discussion->comment}}</p>
				<div class="custom-scrollbar" style="max-height: 150px;" id="reply_{{$token}}" data-image-size="40">
					<ul class="media-list">
						@foreach($quotation_discussion->Reply->all() as $quotation_discussion_reply)
						  <li class="media">
							<a class="pull-left" href="#">
							  {!! getAvatar($quotation_discussion_reply->user_id,40) !!}
							</a>
							<div class="media-body">
							  <h4 class="media-heading"><a href="#">{!! $quotation_discussion_reply->User->full_name !!}</a> <small>{!! showDateTime($quotation_discussion_reply->created_at) !!}</small></h4>
							  {!! $quotation_discussion_reply->comment !!}
							</div>
						  </li>
						@endforeach
					</ul>
				</div>
				<div style="margin-top: 10px;"></div>
				<div class="form-group">
					{!! Form::textarea('comment_'.$token,'',['size' => '30x1', 'class' => 'form-control', 'placeholder' => trans('messages.reply'),"data-show-counter" => 1,"data-limit" => config('config.textarea_limit'),'data-autoresize' => 1,'id' => 'comment_'.$token])!!}
					<span class="countdown"></span>
				</div>
				<div class="form-group">
					<a href="#" data-token="{{$token}}" data-quotation-discussion-id="{{$quotation_discussion->id}}" data-url="/quotation-discussion-reply" class="quotation-discussion-reply-button btn btn-primary btn-sm pull-right">{{trans('messages.post')}}</a>
				</div>
			</div>

		@endforeach