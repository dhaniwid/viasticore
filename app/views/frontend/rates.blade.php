<html>
    <head>
        <title>Welcome to Hotel X</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1" />
        <meta name="description" content="Dapatkan diskon & Promo Harga Hotel termurah di kota-kota di Indonesia dan dunia. Booking Hotel cepat ga pake ribet hanya di Ticktab.com telp. +622171117777" />
        <meta name="keywords" content="Promo Hotel Murah, Diskon Hotel, Booking Hotel Online, Hotel di Bandung, Hotel di Jakarta, Hotel di Bali, Hotel di Yogyakarta, Hotel di Medan, Hotel di Puncak Bogor" />
        
        <link type="text/css" rel="stylesheet" href="assets/css/reset.css" />
        <link type="text/css" rel="stylesheet" href="assets/css/unsemantic-grid-responsive-tablet.min.css" />
        <link type="text/css" rel="stylesheet" href="assets/css/jquery-ui.min.css" />
        <link type="text/css" rel="stylesheet" href="assets/css/jquery.ui.theme.min.css" />
        <link type="text/css" rel="stylesheet" href="assets/css/flexslider.min.css" />
        <link type="text/css" rel="stylesheet" href="assets/css/jquery.customInput.css" />
        <link type="text/css" rel="stylesheet" href="assets/css/ticktab.main-1.0.css" />
        <link type="text/css" rel="stylesheet" href="assets/css/ticktab.home-1.0.css" />
    </head>
    <body>
        <div class="back-white" style="display: none;">
            <div class="popup" id="loginin" style="display: none;">
                <div class="content-pop">
                    <div class="title-pop">
                        <span>Member Login</span>
                        <div class="login-other">
                            <a href="#" id="go-to-forget">Forget Password</a> &bull; <a href="#">Sign Up</a>
                        </div>
                    </div>
                    <ul class="form-pop" id="form-login">
                        <li>
                            <label>Email</label><br />
                            <input type="text" placeholder="Your email" />
                        </li>
                        <li>
                            <label>Password</label><br />
                            <input type="password" placeholder="Your password" /><input type="submit" value="Login" />
                        </li>
                    </ul>
                    <ul class="form-pop" id="form-forget" style="display: none;">
                        <li>
                            <label>Email</label><br />
                            <input type="text" placeholder="Your email" class="forget-pass" /><input type="submit" value="Process" />
                        </li>
                    </ul>
                </div>
                <a href="#" class="close-pop">Close</a>
            </div>
        </div>
        <div class="orange-line-up"></div>
        <div class="white-line-up"></div>
        <div class="header">
            <div class="grid-container">
                <div class="grid-100 tablet-grid-100 mobile-grid-100">
                    <ul class="setting-nav">
                        <li>
                            <div class="orange-left"></div>
                            <a href="#"><div class="icon-user"></div><div class="nav-arrow-down"></div> My Account</a>
                            <ul style="display: none;">
                                <li><a href="#">Sign Up</a></li>
                                <li><a href="#" id="open-login">Log In</a></li>
                            </ul>
                        </li>
                        <li>
                            <a href="#"><div class="flagging english"></div><div class="nav-arrow-down"></div> EN</a>
                            <ul style="display: none;">
                                <li><a href="#"><div class="flagging indonesia"></div> ID</a></li>
                            </ul>
                        </li>
                        <li>
                            <div class="orange-right"></div>
                            <a href="#"><div class="nav-arrow-down"></div>IDR</a>
                            <ul style="display: none;">
                                <li><a href="#">USD</a></li>
                                <li><a href="#">EUR</a></li>
                                <li><a href="#">GBP</a></li>
                                <li><a href="#">SGD</a></li>
                            </ul>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        
        <div class="grid-container">
                <div class="box-reg main-slider">
                    <div class="loading" id="loading-main" style="margin-top: 140px; margin-bottom: 140px;"></div>
                    <ul class="slides">
                        <li>
                            <a href="#">
                                <img src="img/hotel-1.jpg" />
                            </a>
                        </li>
                        <li>
                            <a href="#">
                                <img src="img/hotel-2.jpg" />
                            </a>
                        </li>
                        <li>
                            <a href="#">
                                <img src="img/hotel-3.jpg" />
                            </a>
                        </li>
                    </ul>
                    <div class="bullet-place"></div>
                </div>
            <div class="grid-100 tablet-grid-100 mobile-grid-100">
                <div class="grid-100 tablet-grid-100 mobile-grid-100 search-box">
                    <ul class="nav-search">
                        <li><a href="#" class="nav-hotel on-open"><span><em>Reservation</em></span></a></li>
                    </ul>
                    <div class="clear"></div>
                    <div class="search-form">
                        <div class="search-field hotel-field">
                            <div class="text-field">Your Reservation</div>                            
                            <div class="grid-20 tablet-grid-30 mobile-grid-100 grid-parent inputan inputan-first-tablet">
                                <label>Check-in</label><br />
                                <input type="text" placeholder="Check-in" class="form-control datepicker" id="checkin" />
                            </div>
                            <div class="grid-20 tablet-grid-30 mobile-grid-100 grid-parent inputan">
                                <label>Check-out</label><br />
                                <input type="text" placeholder="Check-out" class="form-control datepicker" id="checkout" />
                            </div>
                            <div class="grid-25 tablet-grid-40 mobile-grid-100 grid-parent inputan-last">
                                <br><br>
                                <input type="submit" value="BOOK NOW" />
                                <div class="sh-button"></div>
                            </div>
                            <div class="clear"></div>
                        </div>                        
                    </div>
                </div>
            </div>
        </div>
        <br />
        <div class="footer-up"></div>
        <div class="footer-mid-out">
            <div class="line-footer-mid-out"></div>
        </div>
        <div class="footer-down">
            <div class="line-footer-down-one"></div>
            <div class="line-footer-down-two"></div>
            Copyrights &copy; 2014 Hotel X All rights reserved.
        </div>
        
        <script type="text/javascript" src="assets/js/jquery-2.1.1.min.js"></script>
        <script type="text/javascript" src="assets/js/jquery-ui.min.js"></script>
        <script type="text/javascript" src="assets/js/jquery.flexslider-min.js"></script>
        <script type="text/javascript" src="assets/js/jquery.customInput.js"></script>
        <script type="text/javascript" src="assets/js/ticktab.main-1.0.js"></script>
        <script type="text/javascript" src="assets/js/ticktab.home-1.0.js"></script>
        <script type="text/javascript" src="assets/js/main.js"></script>
    </body>
</html>