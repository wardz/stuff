@extends('layouts.app')

@section('title', 'Your projects')

@section('content')
	<div class="container">
		<div class="row">
			<h3>Your projects</h3>

			@if (session('status'))
				<h5>{!! session('status') !!}</h5>
			@endif

			<div class="row">
				<div class="col s6">
					<a href="{{ action('ProjectController@create') }}" class="btn waves-effect waves-light">Create new
						<i class="material-icons right">note_add</i>
					</a>
				</div>
			</div>

			@if (isset($projects))
				<table class="bordered highlight">
					<thead>
						<tr>
							<th data-field="name">Name</th>
							<th data-field="tags">Tags</th>
							<th data-field="date">Last change</th>
						</tr>
					</thead>

					<tbody>
						@foreach($projects as $project)
							<tr onclick="window.location = '{{ action('ProjectController@show', $project->getSlug()) }}'">
								<td>
									{{ $project->name }}
								</td>

								<td>
									@foreach ($project->tag_list_name as $tag)
										<div class="chip">
											{{ $tag }}
										</div>
									@endforeach
								</td>

								<td>{{ $project->updated_at }}</td>
							</tr>
						@endforeach
					</tbody>
				</table>
			@else
				<p class="grey text-lighten-4">No projects created yet :(</p>
			@endif
		</div>

		@if (isset($projects))
			{!! $projects->links() !!}
		@endif
	</div>
@endsection
