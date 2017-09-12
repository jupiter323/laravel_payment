			<div class="col-sm-6">
                  <div class="row">
						<div class="form-group">
							<div class="col-sm-12" ><?php echo Form::label('id',trans('messages.company'),[]); ?></div>
<div class="col-sm-12" >					
<div class="btn-group col-sm-12" role="group" aria-label="Button group with nested dropdown" style="padding-left:0px;padding-right:0px;">
<div class="btn-group col-sm-10" style="padding-left:0px;padding-right:0px;">
<?php echo Form::select('id',$company,['class'=>'form-control show-tick','title'=>trans('messages.company')]); ?></div>
<a class="btn btn-success btn-md col-sm-2" id="add-invoice-tax" data-toggle="modal" data-target="#myModal" data-href="/user/create" ><i class="fa fa-plus" aria-hidden="true"></i>
</a></div>
</div></div></div>

 