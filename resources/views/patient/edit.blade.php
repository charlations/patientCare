@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
									{{ __('patientcare.editPatient') }}
								</div>
								<form method="POST" action="/patient/{{ $patient->id }}">
									@csrf
									@method("PATCH")
									<div class="card-body">
										<div class="form-group row">
											<label for="name" class="col-md-4 col-form-label text-md-right">{{ __('patientcare.name') }}</label>

											<div class="col-md-6">
												<input id="name" type="text" class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" name="name" value="{{ $patient->name }}" required autofocus>

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
												<input id="lastNames" type="text" class="form-control{{ $errors->has('lastNames') ? ' is-invalid' : '' }}" name="lastNames" value="{{ $patient->lastNames }}" required autofocus>

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
												<input id="birthdate" type="date" class="form-control{{ $errors->has('birthdate') ? ' is-invalid' : '' }}" name="birthdate" value="{{ $patient->birthdate }}" required autofocus>

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
													<option value="genderM" {{ $patient->gender == 'genderM' ? 'selected' : ''}}>{{ __('patientcare.genderM') }}</option>
													<option value="genderF" {{ $patient->gender == 'genderF' ? 'selected' : ''}}>{{ __('patientcare.genderF') }}</option>
													<option value="genderO" {{ $patient->gender == 'genderO' ? 'selected' : ''}}>{{ __('patientcare.genderO') }}</option>
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
												<input id="email" type="text" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ $patient->email }}" required autofocus>

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

												<select class="form-control{{ $errors->has('idInsurance') ? ' is-invalid' : '' }}" id="exampleFormControlSelect1" id="idInsurance" name="idInsurance" required>
													<option>{{ __('patientcare.select') }}</option>
													@foreach ($insurances as $insurance)
														<option value="{{ $insurance->id }}" {{ $patient->idInsurance == $insurance->id ? 'selected' : ''}}>
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
											<a href="/patient/create">
												<button type="button" class="btn btn-primary btn-icon" data-toggle="modal" data-target="#insuranceModal">
													<i class="fas fa-plus"></i>
												</button>
											</a>
											</div>
										</div>
									</div>
									<div class="card-body">
										@foreach ($medHistList as $medHistory)
										<div class="form-group row">
											<label for="{{ $medHistory->id }}" class="col-md-4 col-form-label text-md-right">{{ $medHistory->name }}</label>

											<div class="col-md-6">
												<textarea id="{{ $medHistory->id }}"  class="form-control{{ $errors->has('$medHistory->id') ? ' is-invalid' : '' }}" name="{{ $medHistory->id }}">{{ $medHistory->histRecord }}</textarea>

												@if ($errors->has('$medHistory->id'))
													<span class="invalid-feedback" role="alert">
														<strong>{{ $errors->first('$medHistory->id') }}</strong>
													</span>
												@endif
											</div>
										</div>
										@endforeach
									</div>
									<div class="card-body">
										<a href="/patient"><button type="button" class="btn btn-secondary">{{ __('patientcare.cancel') }}</button></a>
										<button type="submit" class="btn btn-primary" id="submitButton">{{ __('patientcare.edit') }}</button>
									</div>
								</form>
            </div>
        </div>
    </div>
</div>
@stop
@section('script')
<script>
	$(document).on("show.bs.modal", '#insuranceDeleteModal', function (e) {
		var id = $(e.relatedTarget).data('id');
		$('#insuranceDeleteForm').attr('action', '/insurance/'+id);
		$("#insuranceDeleteName").html($(e.relatedTarget).data('name'));
		console.log(id+" - "+$(e.relatedTarget).data('name'))
	});
</script>
@endsection