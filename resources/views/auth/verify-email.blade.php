   <!DOCTYPE html>
   <html lang="en">

   <head>
       <meta charset="UTF-8">
       <meta name="viewport" content="width=device-width, initial-scale=1.0">
       <meta http-equiv="X-UA-Compatible" content="ie=edge">
       <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
           integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
       <title>Verify Email</title>
   </head>

   <body>
       <div class="container">
           <div class="row d-flex justify-content-center align-items-center min-vh-100">
               <div class="col-md-6">
                   <div class="card">
                       <div class="card-body">
                           <div class="mb-4 text-center">
                               {{ __('Thanks for signing up! Before getting started, could you verify your email address by clicking on the link we just emailed to you? If you didn\'t receive the email, we will gladly send you another.') }}
                           </div>

                           @if (session('status') == 'verification-link-sent')
                               <div class="mb-4 fw-semibold text-center">
                                   {{ __('A new verification link has been sent to the email address you provided during registration.') }}
                               </div>
                           @endif

                           <div class="mt-4 text-center">
                               <form method="POST" action="{{ route('verification.send') }}">
                                   @csrf

                                   <div>
                                       <button type="submit" class="btn btn-primary">
                                           {{ __('Resend Verification Email') }}
                                       </button>
                                   </div>
                               </form>
                           </div>
                       </div>
                   </div>
               </div>
           </div>
       </div>
       <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
           integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
       </script>
   </body>

   </html>
