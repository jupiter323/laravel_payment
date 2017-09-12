
						    	<div class="row">
									<div class="col-md-12">
										<div class="box-info">
											<?php echo Form::open(['route' => 'configuration.store','role' => 'form', 'class'=>'form-horizontal quotation-config-form','id' => 'quotation-config-form','data-no-form-clear' => 1]); ?>

												<div class="col-md-6">
													<div class="form-group">
														<?php echo Form::label('random_quotation_reference_number',trans('messages.random').' '.trans('messages.reference').' '.trans('messages.number'),['class' => ' control-label']); ?>

														<div class="checkbox">
										                	<input name="random_quotation_reference_number" type="checkbox" class="switch-input" data-size="mini" data-on-text="Yes" data-off-text="No" value="1" <?php echo e((config('config.random_quotation_reference_number') == 1) ? 'checked' : ''); ?> data-off-value="0">
										                </div>
													</div>
													<div class="form-group">
														<?php echo Form::label('quotation_prefix',trans('messages.quotation').' '.trans('messages.prefix'),[]); ?>

														<?php echo Form::input('text','quotation_prefix',(config('config.quotation_prefix')) ? : '',['class'=>'form-control','placeholder'=>trans('messages.quotation'),' '.trans('messages.prefix')]); ?>

													</div>
													<div class="form-group">
														<?php echo Form::label('quotation_number_digit',trans('messages.quotation').' '.trans('messages.number').' '.trans('messages.digit'),[]); ?>

														<?php echo Form::input('number','quotation_number_digit',(config('config.quotation_number_digit')) ? : '',['class'=>'form-control','placeholder'=>trans('messages.quotation').' '.trans('messages.number').' '.trans('messages.digit')]); ?>

													</div>
													<div class="form-group">
														<?php echo Form::label('quotation_start_number',trans('messages.quotation').' '.trans('messages.start').' '.trans('messages.number'),[]); ?>

														<?php echo Form::input('number','quotation_start_number',(config('config.quotation_start_number')) ? : '',['class'=>'form-control','placeholder'=>trans('messages.quotation').' '.trans('messages.start').' '.trans('messages.number')]); ?>

													</div>
												  	<?php echo Form::submit(trans('messages.save'),['class' => 'btn btn-primary pull-right']); ?>

												</div>
											<?php echo Form::close(); ?>

										</div>
									</div>
								</div>