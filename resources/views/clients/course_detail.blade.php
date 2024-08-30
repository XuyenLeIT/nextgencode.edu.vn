@extends('layouts.client')
<link rel="stylesheet" href="{{ asset('css/client/course.css') }}">
@section('title', 'Home Page')

@section('content')
    <div class="container">
        @if ($course->DesCourse)
            <div class="des-course row gx-5 lazy-content">
                <h4>{{ $course->DesCourse->title }}</h4>
                <p>{!! $course->DesCourse->description !!}</p>
            </div>
        @endif
        @if ($course->whoCourse)
            <div class="who-course row gx-5 lazy-content">
                <div class="col-md-4">
                    <img class="course-img" src="/{{ $course->whoCourse->thumbnail }}" />
                </div>
                <div class="col-md-8">
                    <h4 class="animate__animated animate__backInDown">PHÙ HỢP CHO NHỮNG NGƯỜI HỌC TỪ ĐẦU</h4>
                    <p>{!! $course->whoCourse->description !!}</p>
                </div>
            </div>
        @endif
        @if ($course->achivesCourse->count() > 0)
            <div class="achive-course row lazy-content">
                <h4 class="text-center mt-2 mb-2">HOÀN THÀNH KHÓA HỌC, BẠN SẼ NHẬN ĐƯỢC GÌ?</h4>
                <div class="row gx-4 gy-3">
                    @foreach ($course->achivesCourse as $item)
                        <div class="course__achive_item col-md-6">
                            <div class="achive-item animate__animated animate__pulse">
                                <h6>{{ $item->title }}</h6>
                                <div class="achive-item-des">
                                    <img class="achive-img" src="/{{ $item->thumbnail }}" />
                                    <p>{{ $item->description }}</p>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif
        <div class="row mt-3">
            <div class="sumarize-time">
                <div class="time-month">
                    <span><i class="fa-solid fa-clock"></i></span>
                    <span>Thời lượng:
                        {{ $course->duration * $course->dayweek * 4 * $course->hourday }}h({{ $course->duration }}
                        tháng)</span>
                </div>
                <div class="time-week">
                    <span><i class="fa-solid fa-calendar-days"></i></span>
                    <span> Thời gian học: {{ $course->dayweek }} buổi/tuần</span>
                </div>
                <div class="quantity-student">
                    <span><i class="fa-solid fa-people-group"></i></span>
                    <span>Số lượng học viên: {{ $course->stunumber }}</span>
                </div>
            </div>
        </div>
        @if ($course->modulesCourse->count() > 0)
            <div class="container mt-4 lazy-content outline-container">
                <h4 class="text-center">Đề cương khóa học</h4>
                <div class="row">
                    @foreach ($course->modulesCourse->sortBy('stt') as $item)
                        <div class="accordion accordion-flush" id="accordionFlushContentOutline">
                            <div class="accordion-item">
                                <h2 class="accordion-header" id="flush-heading-parent-{{ $item->id }}">
                                    <button class="accordion-button collapsed border border-primary" type="button"
                                        data-bs-toggle="collapse"
                                        data-bs-target="#flush-collapse-parent-{{ $item->id }}" aria-expanded="false"
                                        aria-controls="flush-collapse-parent-{{ $item->id }}">
                                        {{ $item->title }}
                                    </button>
                                </h2>
                                <div id="flush-collapse-parent-{{ $item->id }}" class="accordion-collapse collapse"
                                    aria-labelledby="flush-heading-parent-{{ $item->id }}"
                                    data-bs-parent="#accordionFlushContentOutline">
                                    <div class="accordion-body">
                                        @if ($item->outlines->count() > 0)
                                            @foreach ($item->outlines as $key => $outline)
                                                <div class="accordion accordion-flush" id="accordionFlushOutline">
                                                    <div class="accordion-item">
                                                        <h2 class="accordion-header"
                                                            id="flush-heading-{{ $key }}">
                                                            <button class="accordion-button collapsed border border-warning"
                                                                type="button" data-bs-toggle="collapse"
                                                                data-bs-target="#flush-collapse-{{ $outline->id }}"
                                                                aria-expanded="false"
                                                                aria-controls="flush-collapse-{{ $outline->id }}">
                                                                {{ $outline->title }}
                                                            </button>
                                                        </h2>
                                                        <div id="flush-collapse-{{ $outline->id }}"
                                                            class="accordion-collapse collapse"
                                                            aria-labelledby="flush-heading-{{ $key }}"
                                                            data-bs-parent="#accordionFlushOutline">
                                                            <div class="accordion-body">{!! $outline->description !!}</div>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endforeach
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
                <button type="button"
                class="btn-register btn btn-primary d-flex m-auto mt-3 animate__animated animate__shakeX"
                data-bs-toggle="modal" data-bs-target="#myModal">
                Đăng ký khóa học này
            </button>
            </div>            
            <!-- The Modal -->
            <div class="modal fade" id="myModal">
                <div class="modal-dialog modal-lg">
                    <div class="loading_none">
                        <button class="btn btn-success" type="button" disabled>
                            <span class="spinner-grow spinner-grow-sm" role="status" aria-hidden="true"></span>
                            Hệ thống đang xử lý...
                        </button>
                    </div>
                    <div class="modal-content">
                        <!-- Modal Header -->
                        <div class="modal-header">
                            <h4 class="modal-title">Khóa học {{ $course->name }}</h4>
                            <button type="button" class="btn-close btn-close" data-bs-dismiss="modal"></button>
                        </div>
                        <!-- Modal body -->
                        <div class="modal-body">
                            <div class="modal-body-content">
                                <div class="modal-body-item-one">
                                    <form id="user_course">
                                        <div class="mb-3 mt-3">
                                            <label for="name" class="form-label">Name:</label>
                                            <input type="text" class="form-control" id="name"
                                                placeholder="Họ và tên" name="name">
                                            <p id="error-name" class="text-danger"></p>
                                        </div>
                                        <div class="mb-3 mt-3">
                                            <label for="email" class="form-label">Email:</label>
                                            <input type="text" class="form-control" id="email"
                                                placeholder="Nhập email" name="email">
                                            <p id="error-email" class="text-danger"></p>
                                        </div>
                                        <div class="mb-3 mt-3">
                                            <label for="phone" class="form-label">Phone:</label>
                                            <input type="text" class="form-control" id="phone"
                                                placeholder="Số điện thoại" name="phone">
                                            <p id="error-phone" class="text-danger"></p>
                                        </div>
                                        <button type="submit" class="btn btn-primary btn-submit">Submit</button>
                                    </form>
                                </div>
                                <div class="modal-body-item-two">
                                    <img class="modal-item-image"
                                        src="https://i.pinimg.com/originals/3a/25/e7/3a25e78a680f8a93682e9d671ebe503e.gif" />
                                </div>
                            </div>
                        </div>
                        <!-- Modal footer -->
                        <div class="modal-footer">
                            <button type="button" class="btn-close-footer btn btn-danger"
                                data-bs-dismiss="modal">Close</button>
                        </div>
                    </div>
                </div>
            </div>

    </div>
    @endif
    <script>
        let course = @json($course);
        console.log(course.id); // Kiểm tra giá tr
        const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
        // Create User
        document.getElementById('user_course').addEventListener('submit', function(event) {
            let name = document.getElementById('name');
            let email = document.getElementById('email');
            let phone = document.getElementById('phone');
            let loading = document.querySelector(".loading_none");
            let btnSubmit = document.querySelector(".btn-submit");
            let btnClose = document.querySelector(".btn-close");
            let btnCloseFooter = document.querySelector(".btn-close-footer");

            loading.classList.add("loading__active");
            btnSubmit.setAttribute("disabled", true);
            btnClose.setAttribute("disabled", true);
            btnCloseFooter.setAttribute("disabled", true);
            event.preventDefault();
            axios.post('/users', {
                    name: name.value,
                    email: email.value,
                    password: "coderX@123",
                    phone: phone.value,
                    course_id: course.id,
                    status: false,
                    class: course.class
                }, {
                    headers: {
                        'X-CSRF-TOKEN': csrfToken
                    }
                }).then(response => {
                    console.log(response);
                    Toastify({
                        text: "Register course successfully",
                        style: {
                            background: "green"
                        },
                        duration: 3000

                    }).showToast();
                    this.reset();
                    let modal = bootstrap.Modal.getInstance(document.getElementById('myModal'));
                    modal.hide();
                    loading.classList.remove("loading__active");
                    btnSubmit.removeAttribute("disabled");
                    btnClose.removeAttribute("disabled");
                    btnCloseFooter.removeAttribute("disabled");
                })
                .catch(err => {
                    loading.classList.remove("loading__active");
                    btnSubmit.removeAttribute("disabled");
                    btnClose.removeAttribute("disabled");
                    btnCloseFooter.removeAttribute("disabled");
                    if (err.response.status == 400) {
                        let errors = err.response.data.errors;
                        console.log("errors: ",errors);
                        
                        errors.forEach(error => {
                            let errorMessage = document.getElementById(`error-${error.field}`);
                            if (errorMessage) {
                                errorMessage.textContent = error.message;
                            }
                        });
                    } else {
                        Toastify({
                            text: "Opp something went wrong.Try again!!",
                            style: {
                                background: "red"
                            },
                            duration: 3000

                        }).showToast();
                    }
                });
        });

        setTimeout(function() {
            // Closing the alert 
            $('.alert').alert('close');
        }, 2000);
    </script>
@endsection
