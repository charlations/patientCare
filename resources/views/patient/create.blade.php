@extends('layouts.app')

@section('content')
<div class="container">
	<div class="row justify-content-center">
		<div class="col-md-8">
			<div class="card">
				<div class="card-header">
					{{ __('patientcare.newPatient') }}
				</div>
				<div class="card-body">
					<form method="POST" action="/patient">
						@csrf
						<div class="form-group row">
							<label for="name" class="col-md-4 col-form-label text-md-right">{{ __('patientcare.name') }}</label>
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
							<label for="lastNames" class="col-md-4 col-form-label text-md-right">{{ __('patientcare.lastNames') }}</label>
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
							<label for="birthdate" class="col-md-4 col-form-label text-md-right">{{ __('patientcare.birthdate') }}</label>
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
							<label for="gender" class="col-md-4 col-form-label text-md-right">{{ __('patientcare.gender') }}</label>
							<div class="col-md-6">
								<select class="form-control{{ $errors->has('gender') ? ' is-invalid' : '' }}" id="exampleFormControlSelect1" id="gender" name="gender" required>
									<option>{{ __('patientcare.select') }}</option>
									<option value="genderM" {{ old('gender') == 'genderM' ? 'selected' : ''}}>{{ __('patientcare.genderM') }}</option>
									<option value="genderF" {{ old('gender') == 'genderF' ? 'selected' : ''}}>{{ __('patientcare.genderF') }}</option>
									<option value="genderO" {{ old('gender') == 'genderO' ? 'selected' : ''}}>{{ __('patientcare.genderO') }}</option>
								</select>
								@if ($errors->has('gender'))
									<span class="invalid-feedback" role="alert">
										<strong>{{ $errors->first('gender') }}</strong>
									</span>
								@endif
							</div>
						</div>

						<div class="form-group row">
							<label for="email" class="col-md-4 col-form-label text-md-right">{{ __('patientcare.email') }}</label>
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
							<label for="idInsurance" class="col-md-4 col-form-label text-md-right">{{ __('patientcare.insurance') }}</label>
							<div class="col-md-6">
								<select class="form-control{{ $errors->has('idInsurance') ? ' is-invalid' : '' }}" id="idInsurance" name="idInsurance" required>
									<option>{{ __('patientcare.select') }}</option>
									@foreach ($insurances as $insurance)
										<option value="{{ $insurance->id }}" {{ old('idInsurance') == $insurance->id ? 'selected' : ''}}>
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
							<div class="col-md-1">
								<button type="button" class="btn btn-primary btn-icon" data-toggle="modal" data-target="#insuranceModal">
									<i class="fas fa-plus"></i>
								</button>
							</div>
						</div>

						<div class="form-group row mb-0">
							<div class="col-md-6 offset-md-4">
								<a href="/patient"><button type="button" class="btn btn-secondary">{{ __('patientcare.cancel') }}</button></a>
								<button type="submit" class="btn btn-primary" id="submitButton">{{ __('patientcare.create') }}</button>
							</div>
						</div>
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
        <h5 class="modal-title" id="modalTitle">{{ __('patientcare.insurance') }}</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
			<form method="POST" action="/insurance" id="insuranceForm">
      	<div class="modal-body">
					@csrf
					<div style="display: none;">
					<input id="patientname" name="name" type="text">
					<input id="patientlastNames" name="lastNames" type="text">
					<input id="patientbirthdate" name="birthdate" type="text">
					<input id="patientgender" name="gender" type="text">
					<input id="patientemail" name="email" type="text">
					</div>
					<div class="form-group row">
						<label for="insuranceName" class="col-md-4 col-form-label text-md-right">{{ __('patientcare.insuranceName') }}</label>

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
						<label for="notes" class="col-md-4 col-form-label text-md-right">{{ __('patientcare.notes') }}</label>

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
					<button type="button" class="btn btn-secondary" data-dismiss="modal">{{ __('patientcare.cancel') }}</button>
					<button type="submit" class="btn btn-primary" id="submitButton">{{ __('patientcare.create') }}</button>
				</div>
			</form>
    </div>
  </div>
</div>
@stop
@section('script')
<script>
	$('#name').change(function() {
    $('#patientname').val($(this).val());
	});
	$('#lastNames').change(function() {
    $('#patientlastNames').val($(this).val());
	});
	$('#birthdate').change(function() {
    $('#patientbirthdate').val($(this).val());
	});
	$('#gender').change(function() {
    $('#patientgender').val($(this).val());
	});
	$('#email').change(function() {
    $('#patientemail').val($(this).val());
	});
</script>
@endsection