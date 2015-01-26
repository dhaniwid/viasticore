<script src="{{ asset('packages/mrjuliuss/syntara/assets/js/dashboard/booking.js') }}"></script>
{{ Form::open(array('route' => 'newBooking', 'id' => 'create-booking-form', 'method' => 'POST')) }}
<div class="box-reg">
    <div class="clear"></div>    
        <div class="header-title">{{trans('syntara::bookings.bookingDetail')}}</p></div>
        <div class="item-booking">            
            <!-- Room Image -->
            <div class="grid-25 tablet-grid-25 mobile-grid-25 grid-parent">
                <img src="{{$booking->roomimage_description}}" height="150px" width='220px'/>  
            </div>
            <!-- Room Name -->
            <div class="grid-35 tablet-grid-35 mobile-grid-35 grid-parent">                
                <ul class="detail-book">
                    <li class="place">
                        <div class="room-name" style="height: 50px">{{$booking->roomtype_name}}</div>
                    </li>
                    <li class='time'>
                        <div class='time'>{{$booking->check_in}} - {{$booking->check_out}}</div>
                        <input type='hidden' name='checkIn' value='{{$booking->check_in}}'>
                        <input type='hidden' name='checkOut' value='{{$booking->check_out}}'>
                        <input type='hidden' name='nightStay' value='{{$booking->night}}'>
                        <input type='hidden' name='numberOfRoom' value='{{$booking->number_of_room}}'>
                        <input type='hidden' name='numberOfGuest' value='{{$booking->occupancy_id}}'>
                    </li>
                    <li class="passenger">
                        <div class='passenger'>{{$booking->occupancy_description}} Room |
                            {{$booking->night}} Night Stay | {{$booking->number_of_room}} Room</div><br>                         
                    </li>
                </ul>                
            </div>               
            
            <!-- Room Price & Surcharges -->
            <!-- Grand Total -->
            <div class="clear"></div>
            <div class="grid-100 tablet-grid-100 mobile-grid-100">
                <table>
                    <colgroup>
                        <col width="15%">
                        <col width="75%">
                        <col width="10%">
                    </colgroup>
                    <tr>
                        <td style="text-align: right;padding-right: 10px;height: 40px">{{trans('syntara::bookings.price')}}</td>
                        <td><div class="dashed-line"></div></td>
                        <td style="text-align: right;padding-left: 10px"><div class="nom">@currency($booking->roomprice_rate, 'IDR')</div></td>
                        <input type='hidden' name='totalprice' value='{{$booking->roomprice_rate}}'>
                    </tr>
                    <tr>
                        <td style="text-align: right;padding-right: 10px;height: 25px">{{trans('syntara::bookings.service')}}</td>
                        <td><div class="dashed-line"></div></td>
                        <td style="text-align: right;padding-left: 10px"><div class="nom">@currency(0, 'IDR')</div></td>
                    </tr>
                    <tr>
                        <td colspan="3"><div class="total-price">TOTAL @currency($booking->roomprice_rate, 'IDR')<div class="sh-button"></div></div></td>
                    </tr>
                </table>
                <div class="clear"></div>
            </div>   
            <!-- End of Room Price & Surcharges -->
            <!-- End of Grand Total -->
        </div>
        <!-- Guest Detail -->                
        <div class="detail-title">
            <p class="title-block"><span class="triangle"></span>{{trans('syntara::bookings.guestDetail')}}</p></div>
        <div class="guest-detail">
            <div class="grid-20 tablet-grid-35 mobile-grid-100 form-group">
                <label>{{trans('syntara::bookings.title')}}</label><br>
                {{Form::select('title', array('default' => null, 'Mr' => 'Mr', 'Mrs' => 'Mrs', 'Ms' => 'Ms'), null, array('class' => 'form-control'))}}
            </div>            
            <div class="grid-40 tablet-grid-35 mobile-grid-100 form-group" >
                <label>{{trans('syntara::bookings.name')}}</label><br>
                <input type="text" class="form-control" name="name" placeholder="{{trans('syntara::bookings.name')}}">                
            </div>
            <div class="grid-40 tablet-grid-35 mobile-grid-100 form-group">
                <label>{{trans('syntara::bookings.nationality')}}</label><br>
                <input type="text" class="form-control" name="nationality" placeholder="{{trans('syntara::bookings.nationality')}}">                
            </div>
            <div class="prefix-20 grid-40 tablet-grid-35 mobile-grid-100 form-group">
                <label>{{trans('syntara::bookings.email')}}</label><br>
                <input type="text" class="form-control" name="email" placeholder="{{trans('syntara::bookings.email')}}">
            </div>
            <div class="grid-40 tablet-grid-35 mobile-grid-100 form-group">
                <label>{{trans('syntara::bookings.phoneNo')}}</label><br>
                <input type="text" class="form-control" name="phoneNo" placeholder="{{trans('syntara::bookings.phoneNo')}}">
            </div>
            <div class="clear"></div>
        </div>     
<!--        <div class="col-lg-6">
            <div class="form-group">
                {{ Form::submit('Process Payment', array('class' => 'btn btn-primary')) }}
            </div>
        </div>  -->
        <div class="clear"></div>
        <!-- Payment Method -->    
        <!-- Choose Payment Method -->
        <div id='payment-method'>
        <div class="clear"></div>        
        <div class="detail-title">
            <p class="title-block"><span class="triangle"></span>{{trans('syntara::bookings.choose')}}</p></div>
        <div class="item-booking">   
            <div class="choose-payment">
                <div class="box-check"><div class="checklist-green"></div>
                    <span id='paymentSpan'>{{trans('syntara::bookings.payments.bankTransfer')}}</span>
                    <input type='hidden' id='paymentType' name='paymentType' value='{{trans('syntara::bookings.payments.bankTransfer')}}'>
                </div>
                <span>:</span>
                <ul>
                    <li class='active'><a href="#" class="method-banktransfer" title="Bank Transfer"></a><div class="payment-nav"></div></li>
                    <li><a href="#" class="method-visa" title="Visa"></a><div class="payment-nav"></div></li>
                    <li><a href="#" class="method-mastercard" title="MasterCard"></a><div class="payment-nav"></div></li>
                    <li><a href="#" class="method-klikbca" title="Klik BCA"></a><div class="payment-nav"></div></li>
                    <li><a href="#" class="method-bcaklikpay" title="BCA KlikPay"></a><div class="payment-nav"></div></li>
                    <li><a href="#" class="method-epaybri" title="Epay BRI"></a><div class="payment-nav"></div></li>
                    <li><a href="#" class="method-cimbclicks" title="CIMB Clicks"></a><div class="payment-nav"></div></li>
                </ul>
                <div class="clear"></div>
            </div>
            <!-- Bank Transfer -->
            <div class="sectioning section-banktransfer">
                <div class="payment-detail">
                    <div class="det-title">{{trans('syntara::bookings.payments.detail')}}</div>
                    <p style="text-align: center; font-weight: bold;">Total biaya yang harus dibayar setelah dikonversi adalah @currency($booking->roomprice_rate, 'IDR')</p>
                    <div class="clear"></div>
                    <div class="grid-30 tablet-grid-30 mobile-grid-100">
                        &nbsp;
                    </div>
                    <div class="grid-40 tablet-grid-40 mobile-grid-100" style="position: relative;">
                        <div class="secure-text">100% Secured Transaction</div>
                        <input type="submit" value="Process Payment" class="process-payment" style="margin: 0;" />
                        <div class="sh-button" style="margin: 31px 0 0 0;"></div>
                    </div>
                    <div class="grid-30 tablet-grid-30 mobile-grid-100">
                        &nbsp;
                    </div>
                </div>
                <div class="clear"></div>
            </div>
            <div class="clear"></div>
            <!-- Visa -->
            <div class="sectioning section-visa" style="display: none;">
                <div class="payment-detail">
                    <div class="det-title">{{trans('syntara::bookings.payments.detail')}}</div>
                    <ul class="form-payment">
                        <li class="holder-name">
                            <label>{{trans('syntara::bookings.payments.holderName')}}<strong>*</strong></label>
                            <span>:</span>
                            <input type="text" name='firstNameCard' placeholder="First Name" /><input name='lastNameCard' type="text" placeholder="Last Name" /><br /><em>* Card holder name must be exactly as it is displayed on your card</em>
                            <div class="clear"></div>
                        </li>
                        <li class="card-number">
                            <label>{{trans('syntara::bookings.payments.cardNumber')}}<strong>*</strong></label>
                            <span>:</span>
                            <input type="text" name='cardNumber' placeholder="{{trans('syntara::bookings.payments.cardNumber')}}" />
                            <div class="thumb visa-num"></div>
                            <div class="clear"></div>
                        </li>
                        <li class="expiration">
                            <label>{{trans('syntara::bookings.payments.expDate')}}<strong>*</strong></label>
                            <span>:</span>
                            <div class="custom-select">
                                <select>
                                    <option>Month</option>
                                    <option>0</option>
                                    <option>1</option>
                                    <option>2</option>
                                    <option>3</option>
                                </select>
                            </div>
                            <div class="custom-select">
                                <select>
                                    <option>Year</option>
                                    <option>0</option>
                                    <option>1</option>
                                    <option>2</option>
                                    <option>3</option>
                                </select>
                            </div>
                            <div class="clear"></div>
                        </li>
                        <li class="security-code">
                            <label>{{trans('syntara::bookings.payments.securityCode')}}<strong>*</strong></label>
                            <span>:</span>
                            <input type="text" name='cardSecurityCode' placeholder="{{trans('syntara::bookings.payments.securityCode')}}" />
                            <div class="card-sample"></div><a href="#">Last 3-digits on the back of your card</a>
                            <div class="clear"></div>
                        </li>
                        <li class="email">
                            <label>{{trans('syntara::bookings.payments.email')}}</label>
                            <span>:</span>
                            <input type="text" name='paymentEmail' placeholder="{{trans('syntara::bookings.payments.email')}}" />
                            <div class="clear"></div>
                        </li>
                    </ul>
                </div>
                <div class="clear"></div>
                <!-- Card Billing Address -->
                <div class="ticker-item">Card Billing Address</div>
                <div class="payment-detail">
                    <ul class="form-payment">
                        <li>
                            <label>Country<strong>*</strong></label>
                            <span>:</span>
                            <div class="custom-select">
                                <select>
                                    <option>Select Your Country</option>
                                    <option>0</option>
                                    <option>1</option>
                                    <option>2</option>
                                    <option>3</option>
                                </select>
                            </div>
                            <div class="clear"></div>
                        </li>
                        <li>
                            <label>Street Address<strong>*</strong></label>
                            <span>:</span>
                            <textarea name='streetAddress' placeholder="Street Address"></textarea>
                            <div class="clear"></div>
                        </li>
                        <li>
                            <label>City / Town / Village<strong>*</strong></label>
                            <span>:</span>
                            <input name='city' type="text" placeholder="City / Town / Village" />
                            <div class="clear"></div>
                        </li>
                        <li class="state-input">
                            <label>State<strong>*</strong></label>
                            <span>:</span>
                            <div class="custom-select">
                                <select>
                                    <option>No US / Canada</option>
                                    <option>0</option>
                                    <option>1</option>
                                    <option>2</option>
                                    <option>3</option>
                                </select>
                            </div>
                            <div class="clear"></div>
                        </li>
                        <li class="postcode-input">
                            <label>Post Code<strong>*</strong></label>
                            <span>:</span>
                            <input name='postCode' type="text" placeholder="Post Code" />
                            <div class="clear"></div>
                        </li>
                    </ul>
                    <div class="grid-25 tablet-grid-30 mobile-grid-50 grid-parent">
                        <a href="#" class="learn-visa">Learn More</a>
                    </div>
                    <div class="grid-25 tablet-grid-30 mobile-grid-50 grid-parent">
                        <a href="#" class="learn-mater">Learn More</a>
                    </div>
                    <div class="grid-50 tablet-grid-40 mobile-grid-100" style="position: relative;">
                        <div class="secure-text">100% Secured Transaction</div>
                        <input type="submit" value="Process Payment" class="process-payment" />
                        <div class="sh-button" style="margin: 31px 0 0 0;"></div>
                    </div>
                    <div class="important-info">
                        <p class="im-title">Important Information</p>
                        <p>To help prevent unauthorized use of Visa & MasterCards online, <strong>Hotel X participates in Verified by Visa and MasterCard SecureCode</strong>. When you click the "Process Payment" button, you may receive a Verified by Visa or MasterCard SecureCode message from your cards issuer. If your card or issuer does not participate in the program, you will be returned to our secure checkout to complete your order. Mastercard SecureCode Please wait while the transaction being processed. Do not click the back button or close the window. Also please make sure that you’re using browser above Internet Explorer 6 and have Javascript enabled.</p>
                        <p>If you agree with terms & conditions and privacy policies , please click the "Process Payment" button to confirm the booking.</p>
                    </div>
                </div>
            </div>
            <!-- MasterCard -->
            <div class="sectioning section-mastercard" style="display: none;">
                <div class="payment-detail">
                    <div class="det-title">Payment Detail</div>
                    <ul class="form-payment">
                        <li class="holder-name">
                            <label>Card Holder Name<strong>*</strong></label>
                            <span>:</span>
                            <input name='cardFirstName' type="text" placeholder="First Name" /><input name='cardLastName' type="text" placeholder="Last Name" /><br /><em>* Card holder name must be exactly as it is displayed on your card</em>
                            <div class="clear"></div>
                        </li>
                        <li class="card-number">
                            <label>{{trans('syntara::bookings.payments.cardNumber')}}<strong>*</strong></label>
                            <span>:</span>
                            <input name='cardNumber' type="text" placeholder="{{trans('syntara::bookings.payments.cardNumber')}}" />
                            <div class="thumb master-num"></div>
                            <div class="clear"></div>
                        </li>
                        <li class="expiration">
                            <label>{{trans('syntara::bookings.payments.expDate')}}<strong>*</strong></label>
                            <span>:</span>
                            <div class="custom-select">
                                <select>
                                    <option>Month</option>
                                    <option>0</option>
                                    <option>1</option>
                                    <option>2</option>
                                    <option>3</option>
                                </select>
                            </div>
                            <div class="custom-select">
                                <select>
                                    <option>Year</option>
                                    <option>0</option>
                                    <option>1</option>
                                    <option>2</option>
                                    <option>3</option>
                                </select>
                            </div>
                            <div class="clear"></div>
                        </li>
                        <li class="security-code">
                            <label>{{trans('syntara::bookings.payments.securityCode')}}<strong>*</strong></label>
                            <span>:</span>
                            <input name='securityCode' type="text" placeholder="{{trans('syntara::bookings.payments.securityCode')}}" />
                            <div class="card-sample"></div><a href="#">Last 3-digits on the back of your card</a>
                            <div class="clear"></div>
                        </li>
                        <li class="email">
                            <label>{{trans('syntara::bookings.payments.email')}}</label>
                            <span>:</span>
                            <input name='paymentEmail' type="text" placeholder="{{trans('syntara::bookings.payments.email')}}" />
                            <div class="clear"></div>
                        </li>
                    </ul>
                </div>
                <!-- Card Billing Address -->
                <div class="ticker-item">Card Billing Address</div>
                    <ul class="form-payment">
                        <li>
                            <label>Country<strong>*</strong></label>
                            <span>:</span>
                            <div class="custom-select">
                                <select>
                                    <option>Select Your Country</option>
                                    <option>0</option>
                                    <option>1</option>
                                    <option>2</option>
                                    <option>3</option>
                                </select>
                            </div>
                            <div class="clear"></div>
                        </li>
                        <li>
                            <label>Street Address<strong>*</strong></label>
                            <span>:</span>
                            <textarea name='streetAddress' placeholder="Street Address"></textarea>
                            <div class="clear"></div>
                        </li>
                        <li>
                            <label>City / Town / Village<strong>*</strong></label>
                            <span>:</span>
                            <input name='city' type="text" placeholder="City / Town / Village" />
                            <div class="clear"></div>
                        </li>
                        <li class="state-input">
                            <label>State<strong>*</strong></label>
                            <span>:</span>
                            <div class="custom-select">
                                <select>
                                    <option>No US / Canada</option>
                                    <option>0</option>
                                    <option>1</option>
                                    <option>2</option>
                                    <option>3</option>
                                </select>
                            </div>
                            <div class="clear"></div>
                        </li>
                        <li class="postcode-input">
                            <label>Post Code<strong>*</strong></label>
                            <span>:</span>
                            <input name='postCode' type="text" placeholder="Post Code" />
                            <div class="clear"></div>
                        </li>
                    </ul>
                    <div class="grid-25 tablet-grid-30 mobile-grid-50 grid-parent">
                        <a href="#" class="learn-visa">Learn More</a>
                    </div>
                    <div class="grid-25 tablet-grid-30 mobile-grid-50 grid-parent">
                        <a href="#" class="learn-mater">Learn More</a>
                    </div>
                    <div class="grid-50 tablet-grid-40 mobile-grid-100" style="position: relative;">
                        <div class="secure-text">100% Secured Transaction</div>
                        <input type="submit" value="Process Payment" class="process-payment" />
                        <div class="sh-button" style="margin: 31px 0 0 0;"></div>
                    </div>
                    <div class="important-info">
                        <p class="im-title">Important Information</p>
                        <p>To help prevent unauthorized use of Visa & MasterCards online, <strong>Hotel X participates in Verified by Visa and MasterCard SecureCode</strong>. When you click the "Process Payment" button, you may receive a Verified by Visa or MasterCard SecureCode message from your cards issuer. If your card or issuer does not participate in the program, you will be returned to our secure checkout to complete your order. Mastercard SecureCode Please wait while the transaction being processed. Do not click the back button or close the window. Also please make sure that you’re using browser above Internet Explorer 6 and have Javascript enabled.</p>
                        <p>If you agree with terms & conditions and privacy policies , please click the "Process Payment" button to confirm the booking.</p>
                    </div>
            </div>
            <!-- KlikBCA -->
            <div class="sectioning section-klikbca" style="display: none;">
                <div class="payment-detail">
                    <div class="det-title">Payment Detail</div>
                    <ul class="form-payment">
                        <li>
                            <label>ID Klik BCA<strong>*</strong></label>
                            <span>:</span>
                            <input name="idKlikBCA" type="text" placeholder="ID Klik BCA" />
                            <div class="clear"></div>
                        </li>
                    </ul>
                    <div class="grid-30 tablet-grid-30 mobile-grid-100">
                        &nbsp;
                    </div>
                    <div class="grid-40 tablet-grid-40 mobile-grid-100" style="position: relative;">
                        <div class="secure-text">100% Secured Transaction</div>
                        <input type="submit" value="Process Payment" class="process-payment" style="margin: 0;" />
                        <div class="sh-button" style="margin: 31px 0 0 0;"></div>
                    </div>
                    <div class="grid-30 tablet-grid-30 mobile-grid-100">
                        &nbsp;
                    </div>
                </div>
                <div class="clear"></div>
                <div class="ket-payment">
                    <div class="ket-title">Silahkan ikuti langkah ini untuk menyelesaikan pembayaran Anda</div>
                    <ul>
                        <li>ID User KlikBCA yang diisikan merupakan ID KlikBCA yang masih aktif.</li>
                        <li>Mohon lakukan pembayaran melalui KlikBCA (www.klikbca.com) dengan menggunakan ID KlikBCA yang sama.</li>
                        <li>Pembayaran harus dilakukan dalam waktu 60 menit setelah pemesanan.</li>
                        <li>Transaksi ini akan dibatalkan (kadaluarsa) jika Anda tidak melakukan pembayaran dalam jangka waktu yang ditentukan.</li>
                        <li>Setelah Anda menyelesaikan pembayaran, Anda akan menerima e-mail dalam waktu 5 menit yang berisi voucher hotel.</li>
                    </ul>
                </div>
            </div>
            <!-- KlikPay BCA -->
            <div class="sectioning section-bcaklikpay" style="display: none;">
                <div class="payment-detail">
                    <div class="det-title">Payment Detail</div>
                    <ul class="form-payment">
                        <li>
                            <label>Jenis KlikPay BCA</label>
                            <span>:</span>
                            <label for="klik-bayar">Bayar Penuh</label><input type="radio" checked="checked" name="radio-flight" id="klik-bayar" />
                            <label for="klik-cicil">Cicilan</label><input type="radio" name="radio-flight" id="klik-cicil" />
                            <div class="clear"></div>
                        </li>
                        <li>
                            <label>&nbsp;</label><span>&nbsp;</span>
                            <div class="custom-select">
                                <select>
                                    <option>03 Months (0%)</option>
                                    <option>06 Months (0%)</option>
                                    <option>12 Months (0%)</option>
                                </select>
                            </div>
                            <div class="clear"></div>
                        </li>
                    </ul>
                    <p style="text-align: center; font-weight: bold;">Total biaya yang harus dibayar setelah dikonversi adalah @currency($booking->roomprice_rate, 'IDR')</p>
                    <div class="grid-30 tablet-grid-30 mobile-grid-100">
                        &nbsp;
                    </div>
                    <div class="grid-40 tablet-grid-40 mobile-grid-100" style="position: relative;">
                        <div class="secure-text">100% Secured Transaction</div>
                        <input type="submit" value="Process Payment" class="process-payment" style="margin: 0;" />
                        <div class="sh-button" style="margin: 31px 0 0 0;"></div>
                    </div>
                    <div class="grid-30 tablet-grid-30 mobile-grid-100">
                        &nbsp;
                    </div>
                </div>
                <div class="clear"></div>

                <div class="ket-payment">
                    <div class="ket-title">Silahkan ikuti langkah ini untuk menyelesaikan pembayaran Anda</div>
                    <ul>
                        <li>ID User KlikBCA yang diisikan merupakan ID KlikBCA yang masih aktif.</li>
                        <li>Mohon lakukan pembayaran melalui KlikBCA (www.klikbca.com) dengan menggunakan ID KlikBCA yang sama.</li>
                        <li>Pembayaran harus dilakukan dalam waktu 60 menit setelah pemesanan.</li>
                        <li>Transaksi ini akan dibatalkan (kadaluarsa) jika Anda tidak melakukan pembayaran dalam jangka waktu yang ditentukan.</li>
                        <li>Setelah Anda menyelesaikan pembayaran, Anda akan menerima e-mail dalam waktu 5 menit yang berisi voucher hotel.</li>
                    </ul>
                </div>
            </div>
            <!-- ePayBRI -->
            <div class="sectioning section-epaybri" style="display: none;">
                <div class="payment-detail">
                    <div class="det-title">Payment Detail</div>
                    <p style="text-align: center; font-weight: bold;">Total biaya yang harus dibayar setelah dikonversi adalah @currency($booking->roomprice_rate, 'IDR')</p>
                    <div class="grid-30 tablet-grid-30 mobile-grid-100">
                        &nbsp;
                    </div>
                    <div class="grid-40 tablet-grid-40 mobile-grid-100" style="position: relative;">
                        <div class="secure-text">100% Secured Transaction</div>
                        <input type="submit" value="Process Payment" class="process-payment" style="margin: 0;" />
                        <div class="sh-button" style="margin: 31px 0 0 0;"></div>
                    </div>
                    <div class="grid-30 tablet-grid-30 mobile-grid-100">
                        &nbsp;
                    </div>
                </div>
                <div class="clear"></div>
            </div>
            <!-- CIMBClicks -->
            <div class="sectioning section-cimbclicks" style="display: none;">
                <div class="payment-detail">
                    <div class="det-title">Payment Detail</div>
                    <p style="text-align: center; font-weight: bold;">Total biaya yang harus dibayar setelah dikonversi adalah @currency($booking->roomprice_rate, 'IDR')</p>
                    <div class="grid-30 tablet-grid-30 mobile-grid-100">
                        &nbsp;
                    </div>
                    <div class="grid-40 tablet-grid-40 mobile-grid-100" style="position: relative;">
                        <div class="secure-text">100% Secured Transaction</div>
                        <input type="submit" value="Process Payment" class="process-payment" style="margin: 0;" />
                        <div class="sh-button" style="margin: 31px 0 0 0;"></div>
                    </div>
                    <div class="grid-30 tablet-grid-30 mobile-grid-100">
                        &nbsp;
                    </div>
                </div>
                <div class="clear"></div>
                <div class="ket-payment">
                    <div class="ket-title">Silahkan ikuti langkah ini untuk menyelesaikan pembayaran Anda</div>
                    <ul>
                        <li>Semua transaksi dengan CIMB Clicks akan dikonversi menjadi Rupiah</li>
                        <li>Melakukan pembayaran selambat-lambatnya 1 jam setelah pemesanan Anda.</li>
                        <li>Transaksi Anda akan dibatalkan (kadaluarsa) jika Anda tidak membayar dalam batas waktu yang ditentukan.</li>
                    </ul>
                </div>
            </div> 
    </div>
        </div>
</div>
{{Form::close()}}