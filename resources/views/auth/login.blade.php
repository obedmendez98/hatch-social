<html>
   <head>
	     <link rel="stylesheet" type="text/css" 
     href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
      <style>
         @import  url('https://fonts.googleapis.com/css?family=Poppins');
         /* BASIC */
         html {
         background-color: #56baed;
         }
         body {
         font-family: "Poppins", sans-serif;
         height: 100vh;
         }
         a {
         color: #92badd;
         display:inline-block;
         text-decoration: none;
         font-weight: 400;
         }
         h2 {
         text-align: center;
         font-size: 16px;
         font-weight: 600;
         text-transform: uppercase;
         display:inline-block;
         margin: 40px 8px 10px 8px;
         color: #cccccc;
         }
         /* STRUCTURE */
         .wrapper {
         display: flex;
         align-items: center;
         flex-direction: column;
         justify-content: center;
         width: 100%;
         min-height: 100%;
         padding: 20px;
         }
         #formContent {
         -webkit-border-radius: 10px 10px 10px 10px;
         border-radius: 10px 10px 10px 10px;
         background: #fff;
         padding: 30px;
         width: 90%;
         max-width: 450px;
         position: relative;
         padding: 0px;
         -webkit-box-shadow: 0 30px 60px 0 rgba(0,0,0,0.3);
         box-shadow: 0 30px 60px 0 rgba(0,0,0,0.3);
         text-align: center;
         }
         #formFooter {
         background-color: #f6f6f6;
         border-top: 1px solid #dce8f1;
         padding: 25px;
         text-align: center;
         -webkit-border-radius: 0 0 10px 10px;
         border-radius: 0 0 10px 10px;
         }
         /* TABS */
         h2.inactive {
         color: #cccccc;
         }
         h2.active {
         color: #0d0d0d;
         border-bottom: 2px solid #5fbae9;
         }
         /* FORM TYPOGRAPHY*/
         input[type=button], input[type=submit], input[type=reset]  {
         background-color: #56baed;
         border: none;
         color: white;
         padding: 15px 80px;
         text-align: center;
         text-decoration: none;
         display: inline-block;
         text-transform: uppercase;
         font-size: 13px;
         -webkit-box-shadow: 0 10px 30px 0 rgba(95,186,233,0.4);
         box-shadow: 0 10px 30px 0 rgba(95,186,233,0.4);
         -webkit-border-radius: 5px 5px 5px 5px;
         border-radius: 5px 5px 5px 5px;
         margin: 5px 20px 40px 20px;
         -webkit-transition: all 0.3s ease-in-out;
         -moz-transition: all 0.3s ease-in-out;
         -ms-transition: all 0.3s ease-in-out;
         -o-transition: all 0.3s ease-in-out;
         transition: all 0.3s ease-in-out;
         }
         input[type=button]:hover, input[type=submit]:hover, input[type=reset]:hover  {
         background-color: #39ace7;
         }
         input[type=button]:active, input[type=submit]:active, input[type=reset]:active  {
         -moz-transform: scale(0.95);
         -webkit-transform: scale(0.95);
         -o-transform: scale(0.95);
         -ms-transform: scale(0.95);
         transform: scale(0.95);
         }
         input[type=email] {
         background-color: #f6f6f6;
         border: none;
         color: #0d0d0d;
         padding: 15px 32px;
         text-align: center;
         text-decoration: none;
         display: inline-block;
         font-size: 16px;
         margin: 5px;
         width: 85%;
         border: 2px solid #f6f6f6;
         -webkit-transition: all 0.5s ease-in-out;
         -moz-transition: all 0.5s ease-in-out;
         -ms-transition: all 0.5s ease-in-out;
         -o-transition: all 0.5s ease-in-out;
         transition: all 0.5s ease-in-out;
         -webkit-border-radius: 5px 5px 5px 5px;
         border-radius: 5px 5px 5px 5px;
         }
         input[type=email]:focus {
         background-color: #fff;
         border-bottom: 2px solid #5fbae9;
         }
         input[type=email]:placeholder {
         color: #cccccc;
         }
         input[type=password] {
         background-color: #f6f6f6;
         border: none;
         color: #0d0d0d;
         padding: 15px 32px;
         text-align: center;
         text-decoration: none;
         display: inline-block;
         font-size: 16px;
         margin: 5px;
         width: 85%;
         border: 2px solid #f6f6f6;
         -webkit-transition: all 0.5s ease-in-out;
         -moz-transition: all 0.5s ease-in-out;
         -ms-transition: all 0.5s ease-in-out;
         -o-transition: all 0.5s ease-in-out;
         transition: all 0.5s ease-in-out;
         -webkit-border-radius: 5px 5px 5px 5px;
         border-radius: 5px 5px 5px 5px;
         }
         input[type=password]:focus {
         background-color: #fff;
         border-bottom: 2px solid #5fbae9;
         }
         input[type=password]:placeholder {
         color: #cccccc;
         }
         /* ANIMATIONS */
         /* Simple CSS3 Fade-in-down Animation */
         .fadeInDown {
         -webkit-animation-name: fadeInDown;
         animation-name: fadeInDown;
         -webkit-animation-duration: 1s;
         animation-duration: 1s;
         -webkit-animation-fill-mode: both;
         animation-fill-mode: both;
         }
         @-webkit-keyframes fadeInDown {
         0% {
         opacity: 0;
         -webkit-transform: translate3d(0, -100%, 0);
         transform: translate3d(0, -100%, 0);
         }
         100% {
         opacity: 1;
         -webkit-transform: none;
         transform: none;
         }
         }
         @keyframes  fadeInDown {
         0% {
         opacity: 0;
         -webkit-transform: translate3d(0, -100%, 0);
         transform: translate3d(0, -100%, 0);
         }
         100% {
         opacity: 1;
         -webkit-transform: none;
         transform: none;
         }
         }
         /* Simple CSS3 Fade-in Animation */
         @-webkit-keyframes fadeIn { from { opacity:0; } to { opacity:1; } }
         @-moz-keyframes fadeIn { from { opacity:0; } to { opacity:1; } }
         @keyframes  fadeIn { from { opacity:0; } to { opacity:1; } }
         .fadeIn {
         opacity:0;
         -webkit-animation:fadeIn ease-in 1;
         -moz-animation:fadeIn ease-in 1;
         animation:fadeIn ease-in 1;
         -webkit-animation-fill-mode:forwards;
         -moz-animation-fill-mode:forwards;
         animation-fill-mode:forwards;
         -webkit-animation-duration:1s;
         -moz-animation-duration:1s;
         animation-duration:1s;
         }
         .fadeIn.first {
         -webkit-animation-delay: 0.4s;
         -moz-animation-delay: 0.4s;
         animation-delay: 0.4s;
         }
         .fadeIn.second {
         -webkit-animation-delay: 0.6s;
         -moz-animation-delay: 0.6s;
         animation-delay: 0.6s;
         }
         .fadeIn.third {
         -webkit-animation-delay: 0.8s;
         -moz-animation-delay: 0.8s;
         animation-delay: 0.8s;
         }
         .fadeIn.fourth {
         -webkit-animation-delay: 1s;
         -moz-animation-delay: 1s;
         animation-delay: 1s;
         }
         /* Simple CSS3 Fade-in Animation */
         .underlineHover:after {
         display: block;
         left: 0;
         bottom: -10px;
         width: 0;
         height: 2px;
         background-color: #56baed;
         content: "";
         transition: width 0.2s;
         }
         .underlineHover:hover {
         color: #0d0d0d;
         }
         .underlineHover:hover:after{
         width: 100%;
         }
         /* OTHERS */
         *:focus {
         outline: none;
         }
         #icon {
         width:60%;
         }
         * {
         box-sizing: border-box;
         }
      </style>
      <style>.phpdebugbar pre.sf-dump .sf-dump-compact, .sf-dump-str-collapse .sf-dump-str-collapse, .sf-dump-str-expand .sf-dump-str-expand { display: none; }</style>
      <style></style>
   </head>
   <body style="margin-bottom: 37px;">
      <div class="wrapper fadeInDown">
         <div id="formContent">
            <!-- Tabs Titles -->
            <h2 class="active"> ADMIN Sign Inss </h2>            <!-- Icon -->
      
            <!-- Login Form -->
            <form method="post" action="{{route('admin_post')}}">
                @csrf
                <input type="email" id="email" class="fadeIn third" name="email" placeholder="Email">
               <input type="password" id="password" class="fadeIn third" name="password" placeholder="Password">
               <input type="submit" class="fadeIn fourth" value="Log In">
            </form>
            <!-- Remind Passowrd -->
            <div id="formFooter">
               <a class="underlineHover" href="{{url('password/reset')}}">Forgot Password?</a>
            </div>
         </div>
      </div>
      <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.2.1/js/bootstrap.min.js"></script>
      <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
      <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
<script>
  @if(Session::has('success'))
  toastr.options =
  {
  	"closeButton" : true,
  	"progressBar" : true
  }
  		toastr.success("{{ session('success') }}");
  @endif

  @if(Session::has('error'))
  toastr.options =
  {
  	"closeButton" : true,
  	"progressBar" : true
  }
  		toastr.error("{{ session('error') }}");
  @endif


</script>
   </body>
</html>