@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
									{{ __('newPatient') }}
								</div>
								

                <div class="card-body">
									<form method="POST" action="/patient">
										@csrf
										<div class="form-group row">
											<label for="name" class="col-md-4 col-form-label text-md-right">{{ __('name') }}</label>

											<div class="col-md-6">
												<input id="name" type="text" class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" name="name" value="{{ old('name') }}" required autofocus>

												@if ($errors->has('name'))
													<span class="invalid-feedback" role="alert">
														<strong>{{ $errors->first('name') }}</strong>
													</span>
												@endif
											</div>
										</div>

										<div class="form-group row">
											<label for="lastNames" class="col-md-4 col-form-label text-md-right">{{ __('lastNames') }}</label>

											<div class="col-md-6">
												<input id="lastNames" type="text" class="form-control{{ $errors->has('lastNames') ? ' is-invalid' : '' }}" name="lastNames" value="{{ old('lastNames') }}" required autofocus>

												@if ($errors->has('lastNames'))
													<span class="invalid-feedback" role="alert">
														<strong>{{ $errors->first('lastNames') }}</strong>
													</span>
												@endif
											</div>
										</div>

										<div class="form-group row">
											<label for="birthdate" class="col-md-4 col-form-label text-md-right">{{ __('birthdate') }}</label>

											<div class="col-md-6">
												<input id="birthdate" type="date" class="form-control{{ $errors->has('birthdate') ? ' is-invalid' : '' }}" name="birthdate" value="{{ old('birthdate') }}" required autofocus>

												@if ($errors->has('birthdate'))
													<span class="invalid-feedback" role="alert">
														<strong>{{ $errors->first('birthdate') }}</strong>
													</span>
												@endif
											</div>
										</div>

										<div class="form-group row">
											<label for="gender" class="col-md-4 col-form-label text-md-right">{{ __('gender') }}</label>

											<div class="col-md-6">

												<select class="form-control{{ $errors->has('gender') ? ' is-invalid' : '' }}" id="exampleFormControlSelect1" id="gender" name="gender" required>
													<option>{{ __('select') }}</option>
													<option value="Hombre" {{ old('gender') == 'Hombre' ? 'selected' : ''}}>Hombre</option>
													<option value="Mujer" {{ old('gender') == 'Mujer' ? 'selected' : ''}}>Mujer</option>
													<option value="Otro" {{ old('gender') == 'Otro' ? 'selected' : ''}}>Otro</option>
												</select>

												@if ($errors->has('gender'))
													<span class="invalid-feedback" role="alert">
														<strong>{{ $errors->first('gender') }}</strong>
													</span>
												@endif
											</div>
										</div>

										<div class="form-group row">
											<label for="email" class="col-md-4 col-form-label text-md-right">{{ __('email') }}</label>

											<div class="col-md-6">
												<input id="email" type="text" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ old('email') }}" required autofocus>

												@if ($errors->has('email'))
													<span class="invalid-feedback" role="alert">
														<strong>{{ $errors->first('email') }}</strong>
													</span>
												@endif
											</div>
										</div>

										<div class="form-group row">
											<label for="idInsurance" class="col-md-4 col-form-label text-md-right">{{ __('idInsurance') }}</label>

											<div class="col-md-6">

												<select class="form-control{{ $errors->has('idInsurance') ? ' is-invalid' : '' }}" id="exampleFormControlSelect1" id="idInsurance" name="idInsurance" required>
													<option>{{ __('select') }}</option>
													@foreach ($insurances as $insurance)
														<option value="{{ $insurance->id }}" {{ old('idInsurance') == '1' ? 'selected' : ''}}>
															{{ $insurance->insuranceName }}
														</option>
													@endforeach
												</select>

												@if ($errors->has('idInsurance'))
													<span class="invalid-feedback" role="alert">
														<strong>{{ $errors->first('idInsurance') }}</strong>
													</span>
												@endif
											</div>
										</div>

										<a href="/patient"><button type="button" class="btn btn-secondary">{{ __('cancel') }}</button></a>
										<button type="submit" class="btn btn-primary" id="submitButton">{{ __('create') }}</button>
									</form>
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
							<textarea id="notes" type="text" class="form-control{{ $errors->has('notes') ? ' is-invalid' : '' }}" name="notes" autofocus>{{ old('notes') }}</textarea>

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