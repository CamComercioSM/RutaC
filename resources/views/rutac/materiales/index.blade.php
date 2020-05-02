@extends('rutac.app')

@section('title','RutaC | Materiales de ayuda')

@section('app-content')
	<div class="container">
		<div class="row justify-content-center">
			<div class="col-md-12">
				<div class="card card-default">
					<div class="card-header d-flex justify-content-between">
						<h5>Materiales de ayuda</h5>
					</div>
					<div class="card-body" style="padding: 0px;">
						<b-card no-body>
							<b-tabs card>
								<b-tab title="Videos" active>
									<b-card-text>
										@include('rutac.materiales.__videos2')
									</b-card-text>
								</b-tab>
								<b-tab title="Documentos">
									<b-card-text>
										@include('rutac.materiales.__documentos')
									</b-card-text>
								</b-tab>
							</b-tabs>
						</b-card>
					</div>
				</div>
			</div>
		</div>
	</div>
@endsection
