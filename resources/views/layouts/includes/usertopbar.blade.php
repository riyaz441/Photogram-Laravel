@php
    use App\Models\Profile;
    use App\Models\Signup;
    $user = Profile::where('userid', session('user_id'))->first();
    $user_profile_update = Signup::where('id', session('user_id'))->first();
@endphp

{{-- new header --}}
<header class="text-body-secondary bg-info-subtle py-2" data-bs-theme="dark">
    <div class="container">
        <div class="d-flex flex-wrap align-items-center justify-content-center justify-content-lg-start">
            <a href="/homeview" class="navbar-brand d-flex align-items-center">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="none" stroke="currentColor"
                    stroke-linecap="round" stroke-linejoin="round" stroke-width="2" aria-hidden="true" class="me-2"
                    viewBox="0 0 24 24">
                    <path d="M23 19a2 2 0 0 1-2 2H3a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h4l2-3h6l2 3h4a2 2 0 0 1 2 2z" />
                    <circle cx="12" cy="13" r="4" />
                </svg>
                <strong>Photogram</strong>
            </a>

            <ul class="nav col-12 col-lg-auto me-lg-auto mb-2 justify-content-center mb-md-0">
            </ul>

            <!-- Navbar Search-->
            <form action="/search" method="post" id="search" class="col-12 col-lg-auto mb-3 mt-1 mb-lg-0 me-lg-3"
                role="search">
                <input type="search" name="search" id="searchbox" placeholder="Search for..." class="form-control"
                    aria-label="Search" autocomplete="off">
                {{-- <input class="form-control" type="text" name="search" id="searchbox" placeholder="Search for..."
                        aria-label="Search for..." aria-describedby="btnNavbarSearch" autocomplete="off" /> --}}
                <ul id="searchResults"></ul>
                @csrf
            </form>

            <div class="dropdown text-end">
                <a href="#" class="d-block link-body-emphasis text-decoration-none dropdown-toggle"
                    data-bs-toggle="dropdown" aria-expanded="false">
                    <img src="{{ asset($user->profile_photo ?? '../assets/brand/person.svg') }}" alt="mdo"
                        width="40" height="40" class="rounded-circle">
                </a>
                <ul class="dropdown-menu text-small">
                    @if ($user_profile_update->profile_update_status == 0)
                        <li><a href="#" class="dropdown-item text-white" data-bs-toggle="modal"
                                data-bs-target="#exampleModal">Profile</a></li>
                    @endif
                    @if ($user_profile_update->profile_update_status == 1)
                        <li><a href="#" class="dropdown-item text-white" data-bs-toggle="modal"
                                data-bs-target="#exampleModalUpdate">Profile Update</a></li>
                    @endif

                    <li><a href="/viewprofile/{{ $user_profile_update->username }}"
                            class="dropdown-item text-white">View
                            Profile</a></li>
                    <li><a href="#" class="dropdown-item text-white" data-bs-toggle="modal"
                            data-bs-target="#exampleModalFeedback">Feedback</a></li>
                    <li>
                        <hr class="dropdown-divider">
                    </li>
                    <li><a href="/logout" class="dropdown-item text-white">Logout</a></li>
                </ul>
            </div>
        </div>
    </div>
</header>
