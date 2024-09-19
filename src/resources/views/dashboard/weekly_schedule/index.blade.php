@extends('dashboard.layout.master')
@section('title', 'برنامه هفتگی')
@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="card">
                <div class="card-body">
                    <div class="row justify-content-between mb-5">
                        <div class="col-md-2 text-center">
                            <a class="btn btn-secondary" href="{{route('admin.schedule-weekly.index', ['week' => $current_week-1])}}">
                                👉هفته قبل
                            </a>
                        </div>
                        <div class="col-md-2 text-center">
                            <a class="btn btn-secondary" href="{{route('admin.schedule-weekly.index', ['week' => 0])}}">
                                هفته کنونی
                            </a>
                        </div>
                        <div  class="col-md-2 text-center">
                            <a class="btn btn-secondary" href="{{route('admin.schedule-weekly.index', ['week' => $current_week+1])}}">
                                هفته بعد👈
                            </a>
                        </div>
                    </div>

                    <div class="row">
                        <?php
                        // Prepare data for table rows
                        $classesPerDay = [];
                        $maxClassesPerDay = 0;
                        foreach ($datesOfWeek as $date) {
                            $dateKey = $date->format('Y-m-d');
                            $classes = $classesByDate->get($dateKey, collect())->values();
                            $classesPerDay[$dateKey] = $classes;
                            $maxClassesPerDay = max($maxClassesPerDay, $classes->count());
                        }
                        ?>
                        <div class="table-responsive text-center">
                            <table class="table calendar-table">
                                <thead>
                                <tr>
                                    @foreach($datesOfWeek as $date)
                                            <?php
                                            $isToday = $date->isToday();
                                            ?>
                                        <th class="{{ $isToday ? 'bg-success' : '' }}">
                                            <div>{{ \Morilog\Jalali\Jalalian::forge($date)->format('%A') }}</div>
                                            <div>{{ \Morilog\Jalali\Jalalian::forge($date)->format('d/%B') }}</div>
                                        </th>
                                    @endforeach
                                </tr>
                                </thead>
                                <tbody>
                                @for ($i = 0; $i < $maxClassesPerDay; $i++)
                                    <tr>
                                        @foreach($datesOfWeek as $date)
                                                <?php
                                                $dateKey = $date->format('Y-m-d');
                                                $classes = $classesPerDay[$dateKey];
                                                $class = $classes->get($i);
                                                $isToday = $date->isToday();
                                                ?>
                                            <td class="{{ $isToday ? 'bg-success' : '' }}" >
                                                @if($class)
                                                    <div class="class-item">
                                                        <div class="class-name">{{ $class->product->name }}</div>
                                                        <div class="class-time" style="font-size: 0.8rem">{{ \Morilog\Jalali\Jalalian::forge($class->holding_date)->format('H:i') }}</div>

                                                        <select class="form-control mb-2 status-select" name="status" data-class-id="{{ $class->id }}" data-course-id="{{ $class->course_id }}"  aria-label="Status for {{ $class->name }}">
                                                            @foreach(\App\Models\Classes::statuses as $status => $status_label)
                                                                <option value="{{$status}}" {{$class->status->value == $status ? 'selected' : null}}>{{$status_label}} </option>
                                                            @endforeach
                                                        </select>

                                                        <textarea
                                                            style="resize:none; overflow-y:hidden; height: 10rem; font-size: 0.8rem"
                                                            class="form-control studio-description-textarea"
                                                            data-class-id="{{ $class->id }}"
                                                            data-course-id="{{ $class->course_id }}"
                                                            placeholder="توضیحات استودیو">{{ $class->studio_description }}</textarea>

                                                        <div class="btn-toolbar mt-3" role="toolbar" aria-label="Toolbar with button groups">
                                                            <div class="btn-group mr-2" role="group" aria-label="First group">
                                                                <a  class="btn btn-danger text-white btn-sm" title="ورود به کلاسینو کانکت">
                                                                    <i class="fas fa-closed-captioning"></i>
                                                                </a>
                                                                <a class="btn btn-warning text-white btn-sm" title="ورود به کلاسینو کانکت ادمین">
                                                                    <i class="fas fa-user-cog"></i>
                                                                </a>
                                                                <a href="{{route('admin.classes.edit', ['course' => $class->course_id, 'classes' => $class->id])}}" target="_blank" class="btn btn-primary text-white btn-sm" title="ویرایش کلاس">
                                                                    <i class="fas fa-edit"></i>
                                                                </a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                @else

                                                @endif
                                            </td>
                                        @endforeach
                                    </tr>
                                @endfor
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('vendor-script')
    @vite(['resources/assets/js/weeklySchedule.js',])
@endsection
