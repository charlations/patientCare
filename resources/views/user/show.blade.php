@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
									{{ __('myProfile') }}
									<div class="pull-right">
										<button type="button" class="btn btn-primary btn-icon" data-toggle="modal" data-target="#insuranceModal">
										<i class="fas fa-plus"></i>
										</button>
									</div>
								</div>
								

                <div class="card-body">
								<div class="list-group">
									<a href="#" class="list-group-item list-group-item-action">
										<strong>{{ __('name') }}: </strong>{{ $user->name }} {{ $user->lastNames }}
									</a>
									<a href="#" class="list-group-item list-group-item-action">
										<strong>{{ __('emal') }}: </strong>{{ $user->email }}
									</a>
									<a href="#" class="list-group-item list-group-item-action">
										<strong>{{ __('futureAppointments') }}</strong><span class="badge badge-primary badge-pill pull-right">2</span>
									</a>
								</div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- CREATE / UPDATE MODAL -->
<div class="modal" id="insuranceModal" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modalTitle">{{ __('Insurance') }}</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
			<form method="POST" action="/insurance" id="insuranceForm">
      	<div class="modal-body">
					@csrf
					<div id="formMethod"></div>
					<div class="form-group row">
						<label for="insuranceName" class="col-md-4 col-form-label text-md-right">{{ __('InsuranceName') }}</label>

						<div class="col-md-6">
							<input id="insuranceName" type="text" class="form-control{{ $errors->has('insuranceName') ? ' is-invalid' : '' }}" name="insuranceName" value="{{ old('insuranceName') }}" required autofocus>

							@if ($errors->has('insuranceName'))
								<span class="invalid-feedback" role="alert">
									<strong>{{ $errors->first('insuranceName') }}</strong>
								</span>
							@endif
						</div>
					</div>

					<div class="form-group row">
						<label for="notes" class="col-md-4 col-form-label text-md-right">{{ __('Notes') }}</label>

						<div class="col-md-6">
							<textarea id="notes" type="text" class="form-control{{ $errors->has('notes') ? ' is-invalid' : '' }}" name="notes" value="{{ old('notes') }}" autofocus></textarea>

							@if ($errors->has('notes'))
								<span class="invalid-feedback" role="alert">
									<strong>{{ $errors->first('notes') }}</strong>
								</span>
							@endif
						</div>
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-secondary" data-dismiss="modal">{{ __('cancel') }}</button>
					<button type="submit" class="btn btn-primary" id="submitButton">{{ __('create') }}</button>
				</div>
			</form>
    </div>
  </div>
</div>
<!-- DELETE MODAL -->
<div class="modal" id="insuranceDeleteModal" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modalTitle">{{ __('delete') }} {{ __('insurance') }}</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
			<form method="POST" action="/insurance" id="insuranceDeleteForm">
				@csrf
				@method("DELETE")
				<div class="modal-body">
					<h3>{{ __('¿') }}{{ __('areYouSure') }}?</h3>
					<h5>{{ __('¿') }}{{ __('delete') }} <span id="insuranceDeleteName"></span>?
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-secondary" data-dismiss="modal">{{ __('cancel') }}</button>
					<button type="submit" class="swal-button swal-button--confirm swal-button--danger" tabindex="0">{{ __('delete') }}</button>
				</div>
			</form>
    </div>
  </div>
</div>
@stop
@section('script')
<script>
	$(document).on("show.bs.modal", '#insuranceModal', function (e) {
		var id = $(e.relatedTarget).data('id');
		if(id != undefined) {
			$('#insuranceForm').attr('action', '/insurance/'+id);
			$("#formMethod").html('{{ method_field("PATCH") }}');
			$("#submitButton").html('{{ __("Update") }}');
		}
		var button = $(e.relatedTarget)
		var id = button.data('id');
		var name = button.data('name');
		var notes = button.data('notes');
		console.log(id + " - " + name + ": " + notes);
		$("#insuranceName").val($(e.relatedTarget).data('name'));
		$("#notes").html($(e.relatedTarget).data('notes'));
	});
	$(document).on("show.bs.modal", '#insuranceDeleteModal', function (e) {
		var id = $(e.relatedTarget).data('id');
		$('#insuranceDeleteForm').attr('action', '/insurance/'+id);
		$("#insuranceDeleteName").html($(e.relatedTarget).data('name'));
		console.log(id+" - "+$(e.relatedTarget).data('name'))
	});
</script>
@endsection