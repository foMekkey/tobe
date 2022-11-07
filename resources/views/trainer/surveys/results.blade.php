@extends('backend.layouts.app')

@section('content')
    @include('errors.messages')

    <div class="kt-portlet kt-portlet--tabs">
        <div class="kt-portlet__head">
            <div class="kt-portlet__head-label">
                <h3 class="kt-portlet__head-title">
                    {{ __('pages.surveys-results') }}
                </h3>
            </div>
        </div>

        <div class="kt-portlet__body">
            <div class="kt-portlet__body">
                <table class="table table-striped table-bordered">
                    <thead>
                        <tr>
                            <th width="25%">{{ __('pages.question') }}</th>
                            <th width="75%">{{ __('pages.answer') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($questions as $question)
                        <tr>
                            <td>{{ $question->question }}</td>
                            <td>
                                @foreach ($answersPerQuestions[$question->id] as $answer => $count)
                                    @if($survey->is_day_star && $question->type != 1)
                                        {{ $courseUsers[$answer] ?? '' }}
                                    @else
                                        {{ $answer }}
                                    @endif
                                    &nbsp;&nbsp;<span class="kt-badge kt-badge--primary">{{ $count }}</span><br/>
                                @endforeach
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
