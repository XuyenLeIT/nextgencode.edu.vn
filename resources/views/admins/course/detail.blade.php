@extends('layouts.admin')

@section('title', 'Course Page')

@section('content')
    <div class="container">
        @if (!empty($success))
            <div class="alert alert-success">
                <strong>Success!</strong>{{ $success }}
            </div>
        @endif
        <div class="row">
            <a class="btn btn-primary mt-2 mb-2" href="{{ route('admin.course.index') }}">Back to List</a>
            <div class="col-lg-4">
                <h4>Course Detail</h4>
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">{{ $course->name }}</h4>
                        <p class="card-text">Duration: {{ $course->duration }}</p>
                        <p class="card-text">StartDate: {{ $course->startDate }}</p>
                        <img class="card-img-bottom" src="{{ asset($course->thumbnail) }}" alt="{{ $course->name }}"
                            style="max-height:200px;object-fit: contain">
                        @if (!$checkReference)
                            <a href="{{ route('admin.course.delete', $course->id) }}" class="btn btn-danger mt-2">Delete</a>
                        @endif

                    </div>
                </div>
            </div>
            <div class="col-lg-8">
                <div class="accordion accordion-flush" id="accordion-who-course">
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="heading-who-course-one">
                            <button class="accordion-button" type="button" data-bs-toggle="collapse"
                                data-bs-target="#who-course-one" aria-expanded="false" aria-controls="who-course-one">
                                Whose Course
                            </button>
                        </h2>
                        <div id="who-course-one" class="accordion-collapse collapse"
                            aria-labelledby="heading-who-course-one" data-bs-parent="#accordion-who-course">
                            <div class="accordion-body">
                                @if ($whoCourse != null)
                                    <h3>Who suitable this course</h3>
                                    <form action="{{ route('admin.whoCourse.update', $whoCourse) }}" method="POST"
                                        enctype="multipart/form-data">
                                        @csrf
                                        <input type="hidden" value="{{ $whoCourse->id }}" name="id">
                                        <input type="hidden" value="{{ $course->id }}" name="course_id">
                                        <div class="mb-3 mt-3">
                                            <label for="thumbnail" class="form-label">Thumbnail:</label>
                                            <input type="file" class="form-control" id="thumbnail"
                                                placeholder="Enter thumbnail" name="thumbnail">
                                        </div>
                                        <div class="mb-3 mt-3">
                                            <label for="thumbnail" class="form-label">Thumnail Image:</label>
                                            <input type="hidden" value="{{ $whoCourse->thumbnail }}"
                                                name="thumbnailExisted">
                                            <img src="/{{ $whoCourse->thumbnail }}" width="100" class="thumbnail" />
                                        </div>
                                        <div class="mb-3 mt-3">
                                            <label for="name" class="form-label">Status:</label>
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" id="checkCourse"
                                                    name="status" value="1"
                                                    {{ $whoCourse->status ? 'checked' : '' }}>
                                                <label class="form-check-label" for="checkCourse">Active</label>
                                            </div>
                                        </div>
                                        <div class="mb-3 mt-3">
                                            <label for="description" class="form-label">Description:</label>
                                            <textarea class="form-control" id="description" rows="10" placeholder="Enter description" name="description">{{ $whoCourse->description }}</textarea>
                                        </div>
                                        <button type="submit" class="btn btn-primary">Submit</button>
                                    </form>
                                @else
                                    <form action="{{ route('admin.whoCourse.create') }}" method="POST"
                                        enctype="multipart/form-data">
                                        @csrf
                                        <input type="hidden" value="{{ $course->id }}" name="course_id">
                                        <div class="mb-3 mt-3">
                                            <label for="thumbnail" class="form-label">Thumbnail:</label>
                                            <input type="file" class="form-control" id="thumbnail"
                                                placeholder="Enter thumbnail" name="thumbnail">
                                        </div>
                                        <div class="mb-3 mt-3">
                                            <label for="name" class="form-label">Status:</label>
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" id="checkCourse"
                                                    name="status" value="1" checked>
                                                <label class="form-check-label" for="checkCourse">Active</label>
                                            </div>
                                        </div>
                                        <div class="mb-3 mt-3">
                                            <label for="description" class="form-label">Description:</label>
                                            <textarea class="form-control" id="description" rows="10" placeholder="Enter description" name="description"></textarea>
                                        </div>
                                        <button type="submit" class="btn btn-primary">Submit</button>
                                    </form>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="heading-who-course-two">
                            <button class="accordion-button" type="button" data-bs-toggle="collapse"
                                data-bs-target="#who-course-two" aria-expanded="false" aria-controls="who-course-two">
                                Achive Course
                            </button>
                        </h2>
                        <div id="who-course-two" class="accordion-collapse collapse"
                            aria-labelledby="heading-who-course-two" data-bs-parent="#accordion-who-course">
                            <div class="accordion-body">
                                <div class="d-flex align-items-center justify-content-between">
                                    <h4>Course List</h4>
                                    <a class="btn btn-primary"
                                        href="{{ route('admin.achiveCourse.create', $course->id) }}">Create a new
                                        archive</a>
                                </div>
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th>Id</th>
                                            <th>Title</th>
                                            <th>Image</th>
                                            <th>Description</th>
                                            <th>Status</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($achivesCourse as $item)
                                            <tr>
                                                <td>{{ $item->id }}</td>
                                                <td>{{ $item->title }}</td>
                                                <td>
                                                    @if ($item->thumbnail)
                                                        <img src="{{ asset($item->thumbnail) }}"
                                                            alt="{{ $item->name }}" width="100">
                                                    @endif
                                                </td>
                                                <td><span class="achive-des">{{ $item->description }}</span></td>
                                                <td>
                                                    {{ $item->status }}
                                                </td>
                                                <td>
                                                    <a class="btn btn-warning"
                                                        href="{{ route('admin.achiveCourse.edit', $item->id) }}"><i
                                                            class="fa-solid fa-pen-to-square"></i></a>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="heading-who-course-three">
                            <button class="accordion-button" type="button" data-bs-toggle="collapse"
                                data-bs-target="#who-course-three" aria-expanded="false"
                                aria-controls="who-course-three">
                                Module Course
                            </button>
                        </h2>
                        <div id="who-course-three" class="accordion-collapse collapse"
                            aria-labelledby="heading-who-course-three" data-bs-parent="#accordion-who-course">
                            <div class="accordion-body">
                                <div class="d-flex align-items-center justify-content-between">
                                    <h4>Module Course List</h4>
                                    <a class="btn btn-primary"
                                        href="{{ route('admin.moduleCourse.create', $course->id) }}">Add a new module
                                        course</a>
                                </div>
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th>Id</th>
                                            <th>Title</th>
                                            <th>Status</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        {{-- @dd($modulesCourse); --}}
                                        @foreach ($modulesCourse as $item)
                                            <tr>
                                                <td>{{ $item->id }}</td>
                                                <td>{{ $item->title }}</td>
                                                <td>
                                                    {{ $item->status }}
                                                </td>
                                                <td>
                                                    <a class="btn btn-warning"
                                                        href="{{ route('admin.moduleCourse.edit', $item->id) }}"><i
                                                            class="fa-solid fa-pen-to-square"></i></a>
                                                    <a class="btn btn-info"
                                                        href="{{ route('admin.moduleOutline', $item->id) }}?course={{ $item->course_id }}"><i
                                                            class="fa-solid fa-sitemap"></i></a>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="heading-student-course-four">
                            <button class="accordion-button" type="button" data-bs-toggle="collapse"
                                data-bs-target="#student-course-four" aria-expanded="false"
                                aria-controls="student-course-four">
                                Student Register
                            </button>
                        </h2>
                        <div id="student-course-four" class="accordion-collapse collapse"
                            aria-labelledby="heading-who-course-three" data-bs-parent="#accordion-student-course">
                            <div class="accordion-body">
                                <div class="d-flex align-items-center justify-content-between">
                                    <h4>Student List</h4>
                                    {{-- <a class="btn btn-primary"
                                        href="{{ route('admin.moduleCourse.create', $course->id) }}">Add a new module
                                        course</a> --}}
                                </div>
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th>Id</th>
                                            <th>Name</th>
                                            <th>Email</th>
                                            <th>Phone</th>
                                            <th>Class</th>
                                            <th>Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($students as $item)
                                            @if ($item->role != 'admin' && $item->class == $course->class)
                                                <tr>
                                                    <td>{{ $item->id }}</td>
                                                    <td>{{ $item->name }}</td>
                                                    <td>
                                                        {{ $item->email }}
                                                    </td>
                                                    <td>
                                                        {{ $item->phone }}
                                                    </td>
                                                    <td>
                                                        {{ $item->class }}
                                                    </td>
                                                    <td>
                                                        @if ($item->status)
                                                            <a class="btn btn-success"
                                                                href="{{ route('admin.user.payUser', $item->id) }}"><i
                                                                    class="fa-solid fa-circle-check"></i></a>
                                                        @else
                                                            <a class="btn btn-warning"
                                                                href="{{ route('admin.user.payUser', $item->id) }}"><i
                                                                    class="fa-solid fa-circle-xmark"></i></a>
                                                        @endif

                                                    </td>
                                                </tr>
                                            @endif
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="heading-student-course-five">
                            <button class="accordion-button" type="button" data-bs-toggle="collapse"
                                data-bs-target="#student-course-five" aria-expanded="false"
                                aria-controls="student-course-five">
                                Des Course
                            </button>
                        </h2>
                        <div id="student-course-five" class="accordion-collapse collapse"
                            aria-labelledby="heading-who-course-five" data-bs-parent="#accordion-student-course">
                            <div class="accordion-body">
                                <div class="d-flex align-items-center justify-content-between">
                                    <h4>Des Course</h4>
                                </div>
                                @if ($desCourse)
                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <th>Id</th>
                                                <th>Des</th>
                                                <th>Status</th>
                                                <th>Course</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>{{ $desCourse->id }}</td>
                                                <td>{{ $desCourse->description }}</td>
                                                <td>{{ $desCourse->status }}</td>
                                                <td>
                                                    {{ $desCourse->course_id }}
                                                </td>
                                                <td>
                                                    <a class="btn btn-warning"
                                                        href="{{ route('admin.desCourse.edit', $desCourse->id) }}">Edit</a>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                @else
                                    <a class="btn btn-primary"
                                        href="{{ route('admin.desCourse.create', $course->id) }}">Add a new Des Course
                                        course</a>
                                @endif

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    </div>
    <script type="text/javascript">
        $('#description').summernote({
            tabsize: 2,
            height: 300
        });
        setTimeout(function() {
            // Closing the alert 
            $('.alert').alert('close');
            console.log("alo 123");
        }, 2000);
    </script>
@endsection
