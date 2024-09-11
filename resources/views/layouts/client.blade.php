<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'home page')</title>
    <link rel="icon" href="logo/edu.png" type="image/x-icon">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    {{-- Animate.css --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />
    {{-- flickity --}}
    <link rel="stylesheet" href="https://unpkg.com/flickity@2/dist/flickity.min.css">
    <script src="https://unpkg.com/flickity@2/dist/flickity.pkgd.min.js"></script>
    <!-- Including jQuery -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.js"></script>

    {{-- toast --}}
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.css">
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/toastify-js"></script>
    <!-- include summernote editor css/js -->
    <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.js"></script>
    {{-- font-awesome --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css"
        integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="{{ asset('css/root.css') }}">
    <link rel="stylesheet" href="{{ asset('css/client/app.css') }}">
</head>

<body>
    <div class="container-fluid">
        <div class="row">
            <div class="header fixed-top">
                <div class="logo-container">
                    <a href="{{ route('client.home') }}" style="text-decoration: none">
                        <div class="logo">
                            <span class="highlight">N</span>ext<span class="highlight">G</span>en<span
                                class="highlight">C</span>ode
                        </div>
                    </a>

                </div>
                <div class="header__search">
                    <div class="header-menu">
                        <a class="menu-item" href="{{ route('client.home') }}">Trang chủ</a>
                        <a class="menu-item" href="{{ route('client.knowledge') }}">Kiến thức</a>
                        <a class="menu-item" href="{{ route('client.feedback') }}">Cảm nhận học viên</a>
                    </div>
                </div>
            </div>
        </div>
        @if ($isHomeUrl)
            @if ($carausels->count() > 0)
                <div class="carousel-home" data-flickity='{ "freeScroll": true, "wrapAround": true,"autoPlay": true}'>
                    @foreach ($carausels as $key => $item)
                        @if ($item->status)
                            <div class="carousel-cell-home">
                                <div class="item-carousel">
                                    <div class="item-content">
                                        <h4>{{ $item->title }}</h4>
                                        <p>{{ $item->description }}</p>
                                        {{-- @dd($item->course->name) --}}
                                        @if ($item->course_id != 0)
                                            @php
                                                $slug = Str::slug($item->course->name);
                                            @endphp
                                            <a class="btn btn-info" href="{{ route('client.course', [$slug, $item->course_id]) }}">Tìm hiểu thêm</a>
                                        @endif

                                    </div>

                                    <img src="{{ $item->image }}" class="image-carausel" alt="...">
                                </div>
                            </div>
                        @endif
                    @endforeach
                </div>
            @endif
        @endif
        <main class="main-content">
            @yield('content')
        </main>
        <div class="phone-container">
            <a href="tel:0963236247" class="phone-number"><i class="fa-solid fa-phone me-1"></i> 0963 236 247</a>
        </div>
        <div class="footer lazy-content">
            <footer class="bg-body-tertiary text-center">
                <div class="text-center p-3" style="background-color: rgba(0, 0, 0, 0.05);">
                    © 2024 Copyright: NextGenCode
                </div>
            </footer>
        </div>
    </div>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            let lazyContents = document.querySelectorAll(".lazy-content");

            function lazyLoad() {
                lazyContents.forEach(function(content) {

                    let rect = content.getBoundingClientRect();
                    // Kiểm tra nếu phần tử .lazy-content gần với màn hình và chưa có lớp "loaded"
                    if (rect.top < window.innerHeight + 100 && !content.classList
                        .contains("loaded")) {
                        // Thêm class "loaded" để áp dụng hiệu ứng CSS
                        content.classList.add("loaded");
                    }
                });
            }

            window.addEventListener("scroll", lazyLoad);
            lazyLoad();
        });
    </script>
</body>

</html>
