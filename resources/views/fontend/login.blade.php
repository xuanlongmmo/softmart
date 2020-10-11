@extends('fontend.base')
@section('content')
    @if(session('thongbao'))
        <div class = "alert alert-success">
            {{ session('thongbao') }}
        </div>
    @endif
    <div class="container mt-5 mb-5">
        <form action="{{route("plogin")}}" method="post">
            @csrf
            <h1>Thông Tin Đăng Nhập</h1>
            <div class="text-center box">
                <div class="card-1">

                    <!-- the text-input class will be used as parent for input styling -->
                    <div class="text-input">
                        <input id="username" name = "username" type="text" placeholder="Username" autocomplete="off" required />
                        <label for="username">Username</label>
                    </div>
                    <div class="text-input">
                        <input id="password" name = "password" type="password" placeholder="Password" autocomplete="off"  />
                        <label for="password">Password</label>
                    </div>
                    <div class="cart-button">
                        <button type="submit" class="btn btn-primary">Submit</button>
                        <button type="button" class="btn btn-primary"><a href="register">Đăng Ký</a></button><br>
                        <a href="{{ route('resetpass') }}">Quên mật khẩu ?</a>
                    </div>
                    <div style="margin-top: 10px" class="social-auth-links text-center mb-3">
                        <a class="btn btn-block btn-danger" href="{{ route('logingg') }}">
                            <i class="fa fa-google" aria-hidden="true"> Signin using Google+</i>
                        </a>
                    </div>
                    <div style="margin-top: 10px" class="social-auth-links text-center mb-3">
                        <a class="btn btn-block btn-primary" href="{{ url('/auth/redirect/facebook') }}">
                            <i class="fa fa-facebook" aria-hidden="true"> Login with Facebook</i>
                        </a>
                    </div>
                </div>
            </div>
        </form>
    </div>
@endsection
@section('js')
    <script type="text/javascript">
        function openNav() {
            document.getElementById("mySidepanel").style.width = "250px";
        }

        function closeNav() {
            document.getElementById("mySidepanel").style.width = "0";
        }
    </script>
    <script>
        /* Loop through all dropdown buttons to toggle between hiding and showing its dropdown content - This allows the user to have multiple dropdowns without any conflict */
        var dropdown = document.getElementsByClassName("dropdown-btn");
        var i;

        for (i = 0; i < dropdown.length; i++) {
            dropdown[i].addEventListener("click", function() {
                this.classList.toggle("active-1");
                var dropdownContent = this.nextElementSibling;
                if (dropdownContent.style.display === "block") {
                    dropdownContent.style.display = "none";
                } else {
                    dropdownContent.style.display = "block";
                }
            });
        }
    </script>
    <script>
        window.fbAsyncInit = function() {
          FB.init({
            appId            : '270175497422193',
            autoLogAppEvents : true,
            xfbml            : true,
            version          : 'v7.0'
          });
        };
      
        (function(d, s, id){
           var js, fjs = d.getElementsByTagName(s)[0];
           if (d.getElementById(id)) {return;}
           js = d.createElement(s); js.id = id;
           js.src = "https://connect.facebook.net/en_US/sdk.js";
           fjs.parentNode.insertBefore(js, fjs);
         }(document, 'script', 'facebook-jssdk'));
    </script>
@endsection
