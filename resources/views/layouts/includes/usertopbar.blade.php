@php
    use App\Models\Profile;
    use App\Models\Signup;
    $user = Profile::where('userid', session('user_id'))->first();
    $user_profile_update = Signup::where('id', session('user_id'))->first();
@endphp
<header data-bs-theme="dark">
    <div class="collapse" id="navbarHeader">
        <div class="container text-center">
            <div class="row">
                <div class="col-sm-4 py-4">
                    <h4>About</h4>
                    <p class="text-body-secondary">{{ $user->about ?? '' }}</p>
                </div>
                <div class="col-sm-4 py-4">
                    <h4>Contact</h4>
                    <ul class="list-unstyled">

                        @if ($user_profile_update->profile_update_status == 0)
                            <li><a href="#" class="text-white" data-bs-toggle="modal"
                                    data-bs-target="#exampleModal">Profile</a></li>
                        @endif
                        @if ($user_profile_update->profile_update_status == 1)
                            <li><a href="#" class="text-white" data-bs-toggle="modal"
                                    data-bs-target="#exampleModalUpdate">Profile Update</a></li>
                        @endif

                        <li><a href="/viewprofile/{{ $user_profile_update->username }}" class="text-white">View
                                Profile</a></li>
                        <li><a href="#" class="text-white" data-bs-toggle="modal"
                                data-bs-target="#exampleModalFeedback">Feedback</a></li>
                        <li><a href="/logout" class="text-white">Logout</a></li>
                    </ul>
                </div>
                <div class="col-sm-4 py-4">
                    <img src="{{ asset($user->profile_photo ?? '../assets/brand/person.svg') }}" class="rounded"
                        height="100" width="100" alt="profile picture">
                </div>
            </div>

            <!-- Navbar Search-->
            <form action="/search" method="post" id="search"
                class="d-none d-md-inline-block form-inline ms-auto me-0 me-md-3 my-2 my-md-0">
                <div class="input-group">
                    <div class="input-group input-group-lg">
                        <span class="input-group-text" id="inputGroup-sizing-lg"><svg xmlns="http://www.w3.org/2000/svg"
                                width="16" height="16" fill="currentColor" class="bi bi-search"
                                viewBox="0 0 16 16">
                                <path
                                    d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001c.03.04.062.078.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1.007 1.007 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0z" />
                            </svg></span>
                        <input type="text" name="search" id="searchbox" placeholder="Search for..."
                            class="form-control" aria-label="Sizing example input"
                            aria-describedby="inputGroup-sizing-lg" autocomplete="off">
                    </div>
                    {{-- <input class="form-control" type="text" name="search" id="searchbox" placeholder="Search for..."
                        aria-label="Search for..." aria-describedby="btnNavbarSearch" autocomplete="off" /> --}}
                    <ul id="searchResults"></ul>
                </div>
                @csrf
            </form>

        </div>
    </div>
    <div class="navbar navbar-dark bg-dark shadow-sm">
        <div class="container">
            <a href="/homeview" class="navbar-brand d-flex align-items-center">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="none"
                    stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    aria-hidden="true" class="me-2" viewBox="0 0 24 24">
                    <path d="M23 19a2 2 0 0 1-2 2H3a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h4l2-3h6l2 3h4a2 2 0 0 1 2 2z" />
                    <circle cx="12" cy="13" r="4" />
                </svg>
                <strong>Photogram</strong>
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarHeader"
                aria-controls="navbarHeader" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
        </div>
    </div>
</header>
