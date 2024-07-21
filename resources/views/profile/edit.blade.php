<x-app-layout>
    <div class="pt-5 pb-5">
        <div class="container">
            <div class="card">
                <div class="card-body table-responsive">
                    <div class="row gap-3">
                        <div class="col-md-12">
                            <div class="max-w-xl">
                                @include('profile.partials.update-profile-information-form')
                            </div>

                        </div>
                        {{-- <div class="col-md-12">
                            <div class="max-w-xl">
                                @include('profile.partials.update-password-form')
                            </div>
                        </div> --}}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>