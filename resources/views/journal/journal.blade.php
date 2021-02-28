@extends('templates.main-template')
@section('content')
    <?php
    $coursesIDs = array();
    foreach ($tasks as $task) {
        $coursesIDs[] = $task->course_id;
    }
    $coursesIDs = array_unique($coursesIDs);
    $coursesNames = array();
    foreach ($courses as $course) {
        $coursesNames[$course->id] = $course->name;
    }
    $coursesNames = array_unique($coursesNames);
    ?>
    <div class="journal-wrap">
        @foreach($coursesIDs as $course)
            <div class="journal-course">
                <h4>{{$coursesNames[$course]}}</h4>
                @foreach($tasks as $task)
                    @foreach($answers as $answer)
                        @if($course == $task->course_id && $task->id == $answer->task_id)
                            <div class="journal-task-block">
                                <div class="journal-task-link">
                                    <p><a href="{{ route('task.show', [$task->id]) }}">{{ $task->title }}</a></p>
                                </div>
                                <div class="journal-rating">
                                    <p>&nbsp[{{ $answer->rating }}]</p>
                                </div>
                            </div>
                        @endif
                    @endforeach
                @endforeach
            </div>
        @endforeach
    </div>
@endsection
