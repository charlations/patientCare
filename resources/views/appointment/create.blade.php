@extends('layouts.app')

@section('content')
<div class="container">
	<div class="row justify-content-center">
		<div class="col-md-8">
			<div class="card">
				<div class="card-header">{{ __('patientcare.newAppointment') }} - {{ $patient->name }} {{ $patient->lastNames }}</div>

				<div class="card-body">
						
					<form method="POST" action="/patient/{{ $patient->id }}/appointment">
						@csrf

						<div class="form-group row">
							<label for="symptoms" class="col-md-4 col-form-label text-md-right">{{ __('patientcare.symptoms') }}</label>

							<div class="col-md-6">
								<textarea id="symptoms" class="form-control{{ $errors->has('symptoms') ? ' is-invalid' : '' }}" name="symptoms" autofocus></textarea>

								@if ($errors->has('symptoms'))
									<span class="invalid-feedback" role="alert">
										<strong>{{ $errors->first('symptoms') }}</strong>
									</span>
								@endif
							</div>
						</div>
						<div class="form-group row">
						</div>
						<div class="row">
							<div class="col-md-4">
							</div>
							<div class="form-group col-md-2">
								<label for="heartrate">{{ __('patientcare.heartrate') }}</label>
								<input id="heartrate" type="text" class="form-control{{ $errors->has('heartrate') ? ' is-invalid' : '' }}" name="heartrate" autofocus>
								@if ($errors->has('heartrate'))
									<span class="invalid-feedback" role="alert">
										<strong>{{ $errors->first('heartrate') }}</strong>
									</span>
								@endif
							</div>
							<div class="form-group col-md-2">
								<label for="bloodpressure">{{ __('patientcare.bloodpressure') }}</label>
								<input id="bloodpressure" type="text" class="form-control{{ $errors->has('bloodpressure') ? ' is-invalid' : '' }}" name="bloodpressure" autofocus>
								@if ($errors->has('bloodpressure'))
									<span class="invalid-feedback" role="alert">
										<strong>{{ $errors->first('bloodpressure') }}</strong>
									</span>
								@endif
							</div>
							<div class="form-group col-md-2">
								<label for="temp">{{ __('patientcare.temp') }}</label>
								<input id="temp" type="text" class="form-control{{ $errors->has('temp') ? ' is-invalid' : '' }}" name="temp" placeholder="°{{ __('patientcare.tempUnit') }}" autofocus>
								@if ($errors->has('temp'))
									<span class="invalid-feedback" role="alert">
										<strong>{{ $errors->first('temp') }}</strong>
									</span>
								@endif
							</div>
						</div>
						<div class="row">
							<div class="col-md-4">
							</div>
							<div class="form-group col-md-2">
								<label for="weight">{{ __('patientcare.weight') }}</label>
								<input id="weight" type="text" class="form-control{{ $errors->has('weight') ? ' is-invalid' : '' }}" name="weight" placeholder="{{ __('patientcare.weightUnit') }}" autofocus>
								@if ($errors->has('weight'))
									<span class="invalid-feedback" role="alert">
										<strong>{{ $errors->first('weight') }}</strong>
									</span>
								@endif
							</div>
							<div class="form-group col-md-2">
								<label for="height">{{ __('patientcare.height') }}</label>
								<input id="height" type="text" class="form-control{{ $errors->has('height') ? ' is-invalid' : '' }}" name="height" placeholder="{{ __('patientcare.heightUnit') }}" autofocus>
								@if ($errors->has('height'))
									<span class="invalid-feedback" role="alert">
										<strong>{{ $errors->first('height') }}</strong>
									</span>
								@endif
							</div>
							<div class="form-group col-md-2">
								<label for="bmi">{{ __('patientcare.bmi') }}</label>
								<input id="bmi" type="text" class="form-control" name="bmi" readonly>
							</div>
						</div>
						<div class="form-group row">
							<label for="exploration" class="col-md-4 col-form-label text-md-right">{{ __('patientcare.exploration') }}</label>

							<div class="col-md-6">
								<textarea id="exploration" class="form-control{{ $errors->has('exploration') ? ' is-invalid' : '' }}" name="exploration"></textarea>

								@if ($errors->has('exploration'))
									<span class="invalid-feedback" role="alert">
										<strong>{{ $errors->first('exploration') }}</strong>
									</span>
								@endif
							</div>
						</div>
						<div class="form-group row">
							<label for="prevStudies" class="col-md-4 col-form-label text-md-right">{{ __('patientcare.prevStudies') }}</label>

							<div class="col-md-6">
								<textarea id="prevStudies" class="form-control{{ $errors->has('prevStudies') ? ' is-invalid' : '' }}" name="prevStudies"></textarea>

								@if ($errors->has('prevStudies'))
									<span class="invalid-feedback" role="alert">
										<strong>{{ $errors->first('prevStudies') }}</strong>
									</span>
								@endif
							</div>
						</div>
						<div class="form-group row">
							<label for="diagnosis" class="col-md-4 col-form-label text-md-right">{{ __('patientcare.diagnosis') }}</label>

							<div class="col-md-6">
								<input id="diagnosis" type="text" class="form-control{{ $errors->has('diagnosis') ? ' is-invalid' : '' }}" name="diagnosis" required autofocus>

								@if ($errors->has('diagnosis'))
									<span class="invalid-feedback" role="alert">
										<strong>{{ $errors->first('diagnosis') }}</strong>
									</span>
								@endif
							</div>
						</div>
						<div class="form-group row">
							<label for="treatment" class="col-md-4 col-form-label text-md-right">{{ __('patientcare.treatment') }}</label>

							<div class="col-md-6">
								<textarea id="treatment" class="form-control{{ $errors->has('treatment') ? ' is-invalid' : '' }}" name="treatment"></textarea>

								@if ($errors->has('treatment'))
									<span class="invalid-feedback" role="alert">
										<strong>{{ $errors->first('treatment') }}</strong>
									</span>
								@endif
							</div>
						</div>

						<div class="form-group row mb-0">
							<div class="col-md-8 offset-md-4">
								<a href="/patient/{{ $patient->id }}"><button type="button" class="btn btn-secondary">{{ __('patientcare.cancel') }}</button></a>
								<button type="submit" class="btn btn-primary" id="submitButton">{{ __('patientcare.create') }}</button>
							</div>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
</div>
@endsection
