<?php

if( !function_exists("permissions") ) {
    function permissions($name)
    {

        if (Auth::user()->functions->where('func_name', $name)->where('org_id', Auth::user()->org_id)->isEmpty()) {
            $status = 0;
        } else {
            $status = 1;
        }

        return $status;
    }
}

function times($default = null)
{
    $times = '
                <option value="1"> 12:00 AM : 12:30 AM</option>
                <option value="2"> 12:30 AM : 01:00 AM</option>
                <option value="3"> 01:00 AM : 01:30 AM</option>
                <option value="4"> 01:30 AM : 02:00 AM</option>
                <option value="5"> 02:00 AM : 02:30 AM</option>
                <option value="6"> 02:30 AM : 03:00 AM</option>
                <option value="7"> 03:00 AM : 03:30 AM</option>
                <option value="8"> 03:30 AM : 04:00 AM</option>
                <option value="9"> 04:00 AM : 04:30 AM</option>
                <option value="10"> 04:30 AM : 05:00 AM</option>
                <option value="11"> 05:00 AM : 05:30 AM</option>
                <option value="12"> 05:30 AM : 06:00 AM</option>
                <option value="13"> 06:00 AM : 06:30 AM</option>
                <option value="14"> 06:30 AM : 07:00 AM</option>
                <option value="15"> 07:00 AM : 07:30 AM</option>
                <option value="16"> 07:30 AM : 08:00 AM</option>
                <option value="17"> 08:00 AM : 08:30 AM</option>
                <option value="18"> 08:30 AM : 09:00 AM</option>
                <option value="19"> 09:00 AM : 09:30 AM</option>
                <option value="20"> 09:30 AM : 10:00 AM</option>
                <option value="21"> 10:00 AM : 10:30 AM</option>
                <option value="22"> 10:30 AM : 11:00 AM</option>
                <option value="23"> 11:00 AM : 11:30 AM</option>
                <option value="24"> 11:30 AM : 12:00 AM</option>
                <option value="25"> 12:00 PM : 12:30 PM</option>
                <option value="26"> 12:30 PM : 01:00 PM</option>
                <option value="27"> 01:00 PM : 01:30 PM</option>
                <option value="28"> 01:30 PM : 02:00 PM</option>
                <option value="29"> 02:00 PM : 02:30 PM</option>
                <option value="30"> 02:30 PM : 03:00 PM</option>
                <option value="31"> 03:00 PM : 03:30 PM</option>
                <option value="32"> 03:30 PM : 04:00 PM</option>
                <option value="33"> 04:00 PM : 04:30 PM</option>
                <option value="34"> 04:30 PM : 05:00 PM</option>
                <option value="35"> 05:00 PM : 05:30 PM</option>
                <option value="36"> 05:30 PM : 06:00 PM</option>
                <option value="37"> 06:00 PM : 06:30 PM</option>
                <option value="38"> 06:30 PM : 07:00 PM</option>
                <option value="39"> 07:00 PM : 07:30 PM</option>
                <option value="40"> 07:30 PM : 08:00 PM</option>
                <option value="41"> 08:00 PM : 08:30 PM</option>
                <option value="42"> 08:30 PM : 09:00 PM</option>
                <option value="43"> 09:00 PM : 09:30 PM</option>
                <option value="44"> 09:30 PM : 10:00 PM</option>
                <option value="45"> 10:00 PM : 10:30 PM</option>
                <option value="46"> 10:30 PM : 11:00 PM</option>
                <option value="47"> 11:00 PM : 11:30 PM</option>
                <option value="48"> 11:30 PM : 12:00 PM</option>
            ';
    $default = ' value="' . $default . '"';


    $times = str_replace($default, $default . ' selected="selected"', $times);
    return $times;
}

function convertDate($date)
{
    if (!empty($date)) {
        $date_array = explode("/", $date); // split the array
        $var_day = $date_array[0]; //day seqment
        $var_month = $date_array[1]; //month segment
        $var_year = $date_array[2]; //year segment
        return "$var_year-$var_day-$var_month";
    }

}
if( !function_exists("get_invoice_number") ) {
    function get_invoice_number(){

        $current_invoice_code=App\InvoiceSetup::where('type',3)->where('org_id',Auth::user()->org_id)->value('value');
        $invoice_no_internal=App\CustomerHead::where('org_id',Auth::user()->org_id)->where('invoice_code', 'like', '%'.$current_invoice_code.'%')->orderBy('invoice_no','desc')->first()->invoice_no;
        $invoice_no_extranal=App\externalReq::where('org_id',Auth::user()->org_id)->where('invoice_code', 'like', '%'.$current_invoice_code.'%')->orderBy('invoice_no','desc')->first()->invoice_no;
        $invoice_bookings=App\Booking::where('org_id',Auth::user()->org_id)->where('invoice_code', 'like', '%'.$current_invoice_code.'%')->orderBy('invoice_no','desc')->first()->invoice_no;
        if($invoice_no_internal==null && $invoice_no_extranal==null && $invoice_bookings==null) {
            $sart_invoice_no=App\InvoiceSetup::where('type',4)->where('org_id',Auth::user()->org_id)->value('value');
            if($sart_invoice_no==null){
                $sart_invoice_no=1;
            }
            $invoice_no=$sart_invoice_no;
        }

        else{
            $invoice_no=max($invoice_no_internal,$invoice_no_extranal,$invoice_bookings)+1;
        }
        return array('invoice_no'=>$invoice_no,
            'invoice_code'=>$current_invoice_code
        );
    }
}

function availableTimes2($time_ids = null, $is_array = true)
{
    $times = [];
    // $times[0] = null;
    $times[1] = "12:00";
    $times[2] = "12:30";
    $times[3] = "01:00";
    $times[4] = "01:30";
    $times[5] = "02:00";
    $times[6] = "02:30";
    $times[7] = "03:00";
    $times[8] = "03:30";
    $times[9] = "04:00";
    $times[10] = "04:30";
    $times[11] = "05:00";
    $times[12] = "05:30";
    $times[13] = "06:00";
    $times[14] = "06:30";
    $times[15] = "07:00";
    $times[16] = "07:30";
    $times[17] = "08:00";
    $times[18] = "08:30";
    $times[19] = "09:00";
    $times[20] = "09:30";
    $times[21] = "10:00";
    $times[22] = "10:30";
    $times[23] = "11:00";
    $times[24] = "11:30";
    $times[25] = "13:00";
    $times[26] = "13:30";
    $times[27] = "14:00";
    $times[28] = "14:30";
    $times[29] = "15:00";
    $times[30] = "15:30";
    $times[31] = "16:00";
    $times[32] = "16:30";
    $times[33] = "17:00";
    $times[34] = "17:30";
    $times[35] = "18:00";
    $times[36] = "18:30";
    $times[37] = "19:00";
    $times[38] = "19:30";
    $times[39] = "20:00";
    $times[40] = "20:30";
    $times[41] = "21:00";
    $times[42] = "21:30";
    $times[43] = "22:00";
    $times[44] = "22:30";
    $times[45] = "23:00";
    $times[46] = "23:30";
    $times[47] = "24:00 ";


    if ($is_array == false) {
        return $times[$time_ids];
    }
    $availableTimes = [];
    foreach ($time_ids as $id) {
        $availableTimes[$id] = $times[$id];
    }
    return $availableTimes;
}

function availableTimes($time_ids = null, $is_array = true)
{
    $times = [];
    $times[0] = null;
    $times[1] = "12:00 AM : 12:30 AM";
    $times[2] = "12:30 AM : 01:00 AM";
    $times[3] = "01:00 AM : 01:30 AM";
    $times[4] = "01:30 AM : 02:00 AM";
    $times[5] = "02:00 AM : 02:30 AM";
    $times[6] = "02:30 AM : 03:00 AM";
    $times[7] = "03:00 AM : 03:30 AM";
    $times[8] = "03:30 AM : 04:00 AM";
    $times[9] = "04:00 AM : 04:30 AM";
    $times[10] = "04:30 AM : 05:00 AM";
    $times[11] = "05:00 AM : 05:30 AM";
    $times[12] = "05:30 AM : 06:00 AM";
    $times[13] = "06:00 AM : 06:30 AM";
    $times[14] = "06:30 AM : 07:00 AM";
    $times[15] = "07:00 AM : 07:30 AM";
    $times[16] = "07:30 AM : 08:00 AM";
    $times[17] = "08:00 AM : 08:30 AM";
    $times[18] = "08:30 AM : 09:00 AM";
    $times[19] = "09:00 AM : 09:30 AM";
    $times[20] = "09:30 AM : 10:00 AM";
    $times[21] = "10:00 AM : 10:30 AM";
    $times[22] = "10:30 AM : 11:00 AM";
    $times[23] = "11:00 AM : 11:30 AM";
    $times[24] = "11:30 AM : 12:00 AM";
    $times[25] = "12:00 PM : 12:30 PM";
    $times[26] = "12:30 PM : 01:00 PM";
    $times[27] = "01:00 PM : 01:30 PM";
    $times[28] = "01:30 PM : 02:00 PM";
    $times[29] = "02:00 PM : 02:30 PM";
    $times[30] = "02:30 PM : 03:00 PM";
    $times[31] = "03:00 PM : 03:30 PM";
    $times[32] = "03:30 PM : 04:00 PM";
    $times[33] = "04:00 PM : 04:30 PM";
    $times[34] = "04:30 PM : 05:00 PM";
    $times[35] = "05:00 PM : 05:30 PM";
    $times[36] = "05:30 PM : 06:00 PM";
    $times[37] = "06:00 PM : 06:30 PM";
    $times[38] = "06:30 PM : 07:00 PM";
    $times[39] = "07:00 PM : 07:30 PM";
    $times[40] = "07:30 PM : 08:00 PM";
    $times[41] = "08:00 PM : 08:30 PM";
    $times[42] = "08:30 PM : 09:00 PM";
    $times[43] = "09:00 PM : 09:30 PM";
    $times[44] = "09:30 PM : 10:00 PM";
    $times[45] = "10:00 PM : 10:30 PM";
    $times[46] = "10:30 PM : 11:00 PM";
    $times[47] = "11:00 PM : 11:30 PM";
    $times[48] = "11:30 PM : 12:00 PM";

    if ($is_array == false) {
        return $times[$time_ids];
    }
    $availableTimes = [];
    foreach ($time_ids as $id) {
        $availableTimes[$id] = $times[$id];
    }
    return $availableTimes;
}
function missed_time_id($curret_time)
{

    if($curret_time>=strtotime("12:00 am") && $curret_time<strtotime("12:30 am")){
        return 1;
    }
    elseif($curret_time>strtotime("12:30 am") && $curret_time<strtotime("1:00 am")){
        return 2;
    }
    elseif($curret_time>strtotime("1:00 am") && $curret_time<strtotime("1:30 am")){
        return 3;
    }
    elseif($curret_time>strtotime("1:30 am") && $curret_time<strtotime("2:00 am")){
        return 4;
    }
    elseif($curret_time>strtotime("2:00 am") && $curret_time<strtotime("2:30 am")){
        return 5;
    }
    elseif($curret_time>strtotime("2:30 am") && $curret_time<strtotime("3:00 am")){
        return 6;
    }
    elseif($curret_time>strtotime("3:00 am") && $curret_time<strtotime("3:30 am")){
        return 7;
    }
    elseif($curret_time>strtotime("3:30 am") && $curret_time<strtotime("4:00 am")){
        return 8;
    }
    elseif($curret_time>strtotime("4:00 am") && $curret_time<strtotime("4:30 am")){
        return 9;
    }
    elseif($curret_time>strtotime("4:30 am") && $curret_time<strtotime("5:00 am")){
        return 10;
    }
    elseif($curret_time>strtotime("5:00 am")  && $curret_time<strtotime("5:30 am")){
        return 11;
    }
    elseif($curret_time>strtotime("5:30 am") && $curret_time<strtotime("6:00 am")){
        return 12;
    }
    elseif($curret_time>strtotime("6:00 am") && $curret_time<strtotime("6:30 am")){
        return 13;
    }
    elseif($curret_time>strtotime("6:30 am") && $curret_time<strtotime("7:00 am")){
        return 14;
    }
    elseif($curret_time>strtotime("7:00 am") && $curret_time<strtotime("7:30 am")){
        return 15;
    }
    elseif($curret_time>strtotime("7:30 am") && $curret_time<strtotime("8:00 am")){
        return 16;
    }
    elseif($curret_time>strtotime("8:00 am") && $curret_time<strtotime("8:30 am")){
        return 17;
    }
    elseif($curret_time>strtotime("8:30 am")&& $curret_time<strtotime("9:00 am")){
        return 18;
    }
    elseif($curret_time>strtotime("9:00 am") && $curret_time<strtotime("9:30 am")){
        return 19;
    }
    elseif($curret_time>strtotime("9:30 am") && $curret_time<strtotime("10:00 am")){
        return 20;
    }
    elseif($curret_time>strtotime("10:00 am")&& $curret_time<strtotime("10:30 am")){
        return 21;
    }
    elseif($curret_time>strtotime("10:30 am") && $curret_time<strtotime("11:00 am")){
        return 22;
    }
    elseif($curret_time>strtotime("11:00 am") && $curret_time<strtotime("11:30 am")){
        return 23;
    }
    elseif($curret_time>strtotime("11:30 am") && $curret_time<strtotime("12:00 am")){
        return 24;
    }
    elseif($curret_time>strtotime("12:00 am") && $curret_time<strtotime("12:30 pm")){
        return 25;
    }
    elseif($curret_time>strtotime("12:30 pm") && $curret_time<strtotime("1:00 pm")){
        return 26;
    }
    elseif($curret_time>strtotime("1:00 pm") && $curret_time<strtotime("1:30 pm")){
        return 27;
    }
    elseif($curret_time>strtotime("1:30 pm") && $curret_time<strtotime("2:00 pm")){
        return 28;
    }
    elseif($curret_time>strtotime("2:00 pm") && $curret_time<strtotime("2:30 pm")){
        return 29;
    }
    elseif($curret_time>strtotime("2:30 pm") && $curret_time<strtotime("3:00 pm")){
        return 30;
    }
    elseif($curret_time>strtotime("3:00 pm") && $curret_time<strtotime("3:30 pm")){
        return 31;
    }
    elseif($curret_time>strtotime("3:30 pm") && $curret_time<strtotime("4:00 pm")){
        return 32;
    }
    elseif($curret_time>strtotime("4:00 pm") && $curret_time<strtotime("4:30 pm")){
        return 33;
    }
    elseif($curret_time>strtotime("4:30 pm") && $curret_time<strtotime("5:00 pm")){
        return 34;
    }
    elseif($curret_time>strtotime("5:00 pm") && $curret_time<strtotime("5:30 pm")){
        return 35;
    }
    elseif($curret_time>strtotime("5:30 pm") && $curret_time<strtotime("6:00 pm")){
        return 36;
    }
    elseif($curret_time>strtotime("6:00 pm") && $curret_time<strtotime("6:30 pm")){
        return 37;
    }
    elseif($curret_time>strtotime("6:30 pm") && $curret_time<strtotime("7:00 pm")){
        return 38;
    }
    elseif($curret_time>strtotime("7:00 pm") && $curret_time<strtotime("7:30 pm")){
        return 39;
    }
    elseif($curret_time>strtotime("7:30 pm") && $curret_time<strtotime("8:00 pm")){
        return 40;
    }
    elseif($curret_time>strtotime("8:00 pm") && $curret_time<strtotime("8:30 pm")){
        return 41;
    }
    elseif($curret_time>strtotime("8:30 pm") && $curret_time<strtotime("9:00 pm")){
        return 42;
    }
    elseif($curret_time>strtotime("9:00 pm") && $curret_time<strtotime("9:30 pm")){
        return 43;
    }
    elseif($curret_time>strtotime("9:30 pm")&& $curret_time<strtotime("10:00 pm")){
        return 44;
    }
    elseif($curret_time>strtotime("10:00 pm") && $curret_time<strtotime("10:30 pm")){
        return 45;
    }
    elseif($curret_time>strtotime("10:30 pm") && $curret_time<strtotime("11:00 pm")){
        return 46;
    }
    elseif($curret_time>strtotime("11:00 pm") && $curret_time<strtotime("11:30 pm") ){
        return 47;
    }
    elseif($curret_time>strtotime("11:30 pm") && $curret_time<strtotime("12:00 pm")){
        return 48;
    }
    else{
        return 0;
    }
}

function period_id($time)
{

    if($time=="12:00"){
        return 47;
    }
    elseif($time=="12:30"){
        return 48;
    }
    elseif($time=="01:00"){
        return 3;
    }
    elseif($time=="01:30"){
        return 4;
    }
    elseif($time=="02:00"){
        return 5;
    }
    elseif($time=="02:30"){
        return 6;
    }
    elseif($time=="03:00"){
        return 7;
    }
    elseif($time=="03:30"){
        return 8;
    }
    elseif($time=="04:00"){
        return 9;
    }
    elseif($time=="04:30"){
        return 10;
    }
    elseif($time=="05:00"){
        return 11;
    }
    elseif($time=="05:30"){
        return 12;
    }
    elseif($time=="06:00"){
        return 13;
    }
    elseif($time=="06:30"){
        return 14;
    }
    elseif($time=="07:00"){
        return 15;
    }
    elseif($time=="07:30"){
        return 16;
    }
    elseif($time=="08:00"){
        return 17;
    }
    elseif($time=="08:30"){
        return 18;
    }
    elseif($time=="09:00"){
        return 19;
    }
    elseif($time=="09:30"){
        return 20;
    }
    elseif($time=="10:00"){
        return 21;
    }
    elseif($time=="10:30"){
        return 22;
    }
    elseif($time=="11:00"){
        return 23;
    }
    elseif($time=="11:30"){
        return 24;
    }
    elseif($time=="13:00"){
        return 24;
    }
    elseif($time=="13:30"){
        return 25;
    }
    elseif($time=="14:00"){
        return 26;
    }
    elseif($time=="14:30"){
        return 27;
    }
    elseif($time=="15:00"){
        return 28;
    }
    elseif($time=="15:30"){
        return 29;
    }
    elseif($time=="16:00"){
        return 30;
    }
    elseif($time=="16:30"){
        return 31;
    }
    elseif($time=="17:00"){
        return 32;
    }
    elseif($time=="17:30"){
        return 33;
    }
    elseif($time=="18:00"){
        return 34;
    }
    elseif($time=="18:30"){
        return 35;
    }
    elseif($time=="19:00"){
        return 36;
    }
    elseif($time=="19:30"){
        return 37;
    }
    elseif($time=="20:00"){
        return 38;
    }
    elseif($time=="20:30"){
        return 39;
    }
    elseif($time=="21:00"){
        return 40;
    }
    elseif($time=="21:30"){
        return 41;
    }
    elseif($time=="22:00"){
        return 42;
    }
    elseif($time=="22:30"){
        return 43;
    }
    elseif($time=="23:00"){
        return 44;
    }
    elseif($time=="23:30"){
        return 45;
    }
    elseif($time=="24:00"){
        return 1;
    }
    elseif($time=="24:30"){
        return 2;
    }
    else{
        return 0;
    }
}

function time_from_id($id)
{

    if($id==1){
        return "12:00 AM";
    }
    elseif($id==2){
        return "12:30 AM";
    }
    elseif($id==3){
        return "01:00 AM";
    }
    elseif($id==4){
        return "01:30 AM";
    }
    elseif($id==5){
        return "02:00 AM";
    }
    elseif($id==6){
        return "02:30 AM";
    }
    elseif($id==7){
        return "03:00 AM";
    }
    elseif($id==8){
        return "03:30 AM";
    }
    elseif($id==9){
        return "04:00 AM";
    }
    elseif($id==10){
        return "04:30 AM";
    }
    elseif($id==11){
        return "05:00 AM";
    }
    elseif($id==12){
        return "05:30 AM";
    }
    elseif($id==13){
        return "06:00 AM";
    }
    elseif($id==14){
        return "06:30 AM";
    }
    elseif($id==15){
        return "07:00 AM";
    }
    elseif($id==16){
        return "07:30 AM";
    }
    elseif($id==17){
        return "08:00 AM";
    }
    elseif($id==18){
        return "08:30 AM";
    }
    elseif($id==19){
        return "09:00 AM";
    }
    elseif($id==20){
        return "09:30 AM";
    }
    elseif($id==21){
        return "10:00 AM";
    }
    elseif($id==22){
        return "10:30 AM";
    }
    elseif($id==23){
        return "11:00 AM";
    }
    elseif($id==24){
        return "11:30 AM";
    }
    elseif($id==25){
        return "1:00 PM";
    }
    elseif($id==26){
        return "1:30 PM";
    }
    elseif($id==27){
        return "2:00 PM";
    }
    elseif($id==28){
        return "2:30 PM";
    }
    elseif($id==29){
        return "3:00 PM";
    }
    elseif($id==30){
        return "3:30 PM";
    }
    elseif($id==31){
        return "4:00 PM";
    }
    elseif($id==32){
        return "4:30 PM";
    }
    elseif($id==33){
        return "5:00 PM";
    }
    elseif($id==34){
        return "5:30 PM";
    }
    elseif($id==35){
        return "6:00 PM";
    }
    elseif($id==36){
        return "6:30 PM";
    }
    elseif($id==37){
        return "7:00 PM";
    }
    elseif($id==38){
        return "7:30 PM";
    }
    elseif($id==39){
        return "8:00 PM";
    }
    elseif($id==40){
        return "8:30 PM";
    }
    elseif($id==41){
        return "9:00 PM";
    }
    elseif($id==42){
        return "9:30 PM";
    }
    elseif($id==43){
        return "10:00 PM";
    }
    elseif($id==44){
        return "10:30 PM";
    }
    elseif($id==45){
        return "11:00 PM";
    }
    elseif($id==46){
        return "11:30 pm";
    }
    elseif($id==47){
        return "12:00 PM";
    }
    elseif($id==48){
        return "12:30 PM";
    }
    else{
        return 0;
    }
}

function time_from_id2($id){
    if($id==47){
        return "12:00";
    }
    elseif($id==48){
        return "12:30";
    }
    elseif($id==3){
        return "01:00";
    }
    elseif($id==4){
        return "01:30";
    }
    elseif($id==5){
        return "02:00";
    }
    elseif($id==6){
        return "02:30";
    }
    elseif($id==7){
        return "03:00";
    }
    elseif($id==8){
        return "03:30";
    }
    elseif($id==9){
        return "04:00";
    }
    elseif($id==10){
        return "04:30";
    }
    elseif($id==11){
        return "05:00";
    }
    elseif($id==12){
        return "05:30";
    }
    elseif($id==13){
        return "06:00";
    }
    elseif($id==14){
        return "06:30";
    }
    elseif($id==15){
        return "07:00";
    }
    elseif($id==16){
        return "07:30";
    }
    elseif($id==17){
        return "08:00";
    }
    elseif($id==18){
        return "08:30";
    }
    elseif($id==19){
        return "09:00";
    }
    elseif($id==20){
        return "09:30";
    }
    elseif($id==21){
        return "10:00";
    }
    elseif($id==22){
        return "10:30";
    }
    elseif($id==23){
        return "11:00";
    }
    elseif($id==24){
        return "11:30";
    }
    elseif($id==25){
        return "13:00";
    }
    elseif($id==26){
        return "13:30";
    }
    elseif($id==27){
        return "14:00";
    }
    elseif($id==28){
        return "14:30";
    }
    elseif($id==29){
        return "15:00";
    }
    elseif($id==30){
        return "15:30";
    }
    elseif($id==31){
        return "16:00";
    }
    elseif($id==32){
        return "16:30";
    }
    elseif($id==33){
        return "17:00";
    }
    elseif($id==34){
        return "17:30";
    }
    elseif($id==35){
        return "18:00";
    }
    elseif($id==36){
        return "18:30 PM";
    }
    elseif($id==37){
        return "19:00";
    }
    elseif($id==38){
        return "19:30";
    }
    elseif($id==39){
        return "20:00";
    }
    elseif($id==40){
        return "20:30";
    }
    elseif($id==41){
        return "21:00";
    }
    elseif($id==42){
        return "21:30";
    }
    elseif($id==43){
        return "22:00";
    }
    elseif($id==44){
        return "22:30";
    }
    elseif($id==45){
        return "23:00";
    }
    elseif($id==46){
        return "23:30";
    }
    elseif($id==1){
        return "24:00";
    }
    elseif($id==2){
        return "24:30";
    }
    else{
        return 0;
    }
}
if( !function_exists("cat_price") ) {
    function cat_price($cat_id)
    {

        $price_details=[];
        $today_date=date('Y-m-d');
        $dayName =Carbon\Carbon::parse($today_date)->format('l');
        $now_time=date("H:i:s");

        $day = getDayNumber($dayName);
        $offer_ids=App\OfferDays::where('org_id',Auth::user()->org_id)
            ->pluck('offer_id');

        $offer_id=App\Offers::where('org_id',Auth::user()->org_id)
            ->whereIn('id',$offer_ids)
            ->where('cat_id',$cat_id)
            ->where('org_id',Auth::user()->org_id)
            ->where('active',1)
            ->first();


        if($offer_id!=null){
            $general_offer_days_check=App\OfferDays::where('org_id',Auth::user()->org_id)
                ->where('offer_id',$offer_id->id)

                ->first();


        }
        else{
            $general_offer_days_check=null;
        }



        $offers_check=App\Offers::where('org_id',Auth::user()->org_id)
            ->where('cat_id',$cat_id)
            ->where('org_id',Auth::user()->org_id)
            ->where('date_from','<=',$today_date)
            ->where('date_to','>=',$today_date)
            ->where('active',1)
            ->first();
        $price = App\PriceList::where('cat_id',$cat_id)
            ->where('org_id',Auth::user()->org_id)
            ->where('date', '<=',$today_date)
            ->orderBy('date','desc')
            ->where('active',1)
            ->first();
        if($general_offer_days_check!=null){
            $offer_days_check=App\OfferDays::where('org_id',Auth::user()->org_id)

                ->where('offer_dt_from','<=',$today_date)
                ->where('offer_dt_to','>=',$today_date)
                ->where('day',$day)
                ->where('time_from','<=',$now_time)
                ->where('time_to','>=',$now_time)
                ->where('offer_id',$general_offer_days_check->offer_id)
                ->first();
            if($offer_days_check!=null){
                $price_check=App\Offers::where('org_id',Auth::user()->org_id)
                    ->where('id',$offer_days_check->offer_id)
                    ->where('cat_id',$cat_id)
                    ->where('org_id',Auth::user()->org_id)
                    ->where('active',1)
                    ->first();
                if($price_check!=null){
                    $catPrice = $price_check->offer_price;
                    $catTax = $price_check->offer_price - $offer->discount_price;
                    $taxId = $price->tax;
                    $original_price=$price->final_price;

                    return array(

                        'catPrice'   => Decimalpoint($catPrice),
                        'catTax'   => Decimalpoint($catTax),
                        'taxId'   => $taxId,
                        'original_price' =>Decimalpoint($original_price) ,
                    );

                }

            }
            else{
                if ($price!=null) {
                    $catPrice = $price->final_price;

                    $catTax = $price->final_price - $price->price;
                    $taxId = $price->tax;
                    $original_price=$price->final_price;
                    return array(

                        'catPrice'   => Decimalpoint($catPrice),
                        'catTax'   => Decimalpoint($catTax),
                        'taxId'   => $taxId,
                        'original_price' =>Decimalpoint($original_price) ,
                    );
                }else{

                    return array();
                }
            }
        }  elseif($offers_check!=null){
            $catPrice = $offers_check->offer_price;
            $catTax = $offers_check->offer_price - $offers_check->discount_price;
            $taxId = $price->tax;
            $original_price=$price->final_price;
            return array(

                'catPrice'   => Decimalpoint($catPrice),
                'catTax'   => Decimalpoint($catTax),
                'taxId'   => $taxId,
                'original_price' =>Decimalpoint($original_price) ,
            );
        }
        else{
            if ($price!=null) {
                $catPrice = $price->final_price;
                $catTax = $price->final_price - $price->price;
                $taxId = $price->tax;
                $original_price=$price->final_price;
                return array(

                    'catPrice'   => Decimalpoint($catPrice),
                    'catTax'   => Decimalpoint($catTax),
                    'taxId'   => $taxId,
                    'original_price' =>Decimalpoint($original_price) ,
                );
            }else{

                return array();
            }
        }

    }
}
if( !function_exists("front_cat_price") ) {
    function front_cat_price($cat_id,$org_id)
    {

        $price_details=[];
        $today_date=date('Y-m-d');
        $dayName =Carbon\Carbon::parse($today_date)->format('l');
        $now_time=date("H:i:s");

        $day = getDayNumber($dayName);
        $offer_ids=App\OfferDays::where('org_id',$org_id)
            ->pluck('offer_id');

        $offer_id=App\Offers::where('org_id',$org_id)
            ->whereIn('id',$offer_ids)
            ->where('cat_id',$cat_id)
            ->where('active',1)
            ->first();


        if($offer_id!=null){
            $general_offer_days_check=App\OfferDays::where('org_id',$org_id)
                ->where('offer_id',$offer_id->id)
                ->first();


        }
        else{
            $general_offer_days_check=null;
        }



        $offers_check=App\Offers::where('org_id',$org_id)
            ->where('cat_id',$cat_id)
            ->where('org_id',$org_id)
            ->where('date_from','<=',$today_date)
            ->where('date_to','>=',$today_date)
            ->where('active',1)
            ->first();
        $price = App\PriceList::where('cat_id',$cat_id)
            ->where('org_id',$org_id)
            ->where('date', '<=',$today_date)
            ->orderBy('date','desc')
            ->where('active',1)
            ->first();
        if($general_offer_days_check!=null){
            $offer_days_check=App\OfferDays::where('org_id',$org_id)
                ->where('offer_dt_from','<=',$today_date)
                ->where('offer_dt_to','>=',$today_date)
                ->where('day',$day)
                ->where('time_from','<=',$now_time)
                ->where('time_to','>=',$now_time)
                ->where('offer_id',$general_offer_days_check->offer_id)
                ->first();

            if($offer_days_check!=null){
                $price_check=App\Offers::where('org_id',$org_id)
                    ->where('id',$offer_days_check->offer_id)
                    ->where('cat_id',$cat_id)
                    ->where('org_id',$org_id)
                    ->where('active',1)
                    ->first();

                if($price_check!=null){

                    $catPrice = $price_check->offer_price;

                    $catTax = $price_check->offer_price - $offer->discount_price;
                    $taxId = $price->tax;
                    $original_price=$price->final_price;

                    return array(

                        'catPrice'   => Decimalpoint($catPrice),
                        'catTax'   => Decimalpoint($catTax),
                        'taxId'   => $taxId,
                        'original_price' =>Decimalpoint($original_price) ,
                    );

                }

            }
            else{
                if ($price!=null) {
                    $catPrice = $price->final_price;

                    $catTax = $price->final_price - $price->price;
                    $taxId = $price->tax;
                    $original_price=$price->final_price;
                    return array(

                        'catPrice'   => Decimalpoint($catPrice),
                        'catTax'   => Decimalpoint($catTax),
                        'taxId'   => $taxId,
                        'original_price' =>Decimalpoint($original_price) ,
                    );
                }else{

                    return array();
                }
            }
        }  elseif($offers_check!=null){
            $catPrice = $offers_check->offer_price;
            $catTax = $offers_check->offer_price - $offers_check->discount_price;
            $taxId = $price->tax;
            $original_price=$price->final_price;
            return array(

                'catPrice'   => Decimalpoint($catPrice),
                'catTax'   => Decimalpoint($catTax),
                'taxId'   => $taxId,
                'original_price' =>Decimalpoint($original_price) ,
            );
        }
        else{
            if ($price!=null) {
                $catPrice = $price->final_price;
                $catTax = $price->final_price - $price->price;
                $taxId = $price->tax;
                $original_price=$price->final_price;
                return array(

                    'catPrice'   => Decimalpoint($catPrice),
                    'catTax'   => Decimalpoint($catTax),
                    'taxId'   => $taxId,
                    'original_price' =>Decimalpoint($original_price) ,
                );
            }else{

                return array();
            }
        }

    }
}

function getDayNumber($dayName)
{
    $day = "";
    if ($dayName == 'Saturday') {
        $day = "1";
    } else if ($dayName == 'Sunday') {
        $day = "2";
    } else if ($dayName == 'Monday') {
        $day = "3";
    } else if ($dayName == 'Tuesday') {
        $day = "4";
    } else if ($dayName == 'Wednesday') {
        $day = "5";
    } else if ($dayName == 'Thursday') {
        $day = "6";
    } else if ($dayName == 'Friday') {
        $day = "7";
    }
    return $day;
}

function getDayNameArabic($dayName)
{
    $day = "";
    if ($dayName == '1') {
        $day = "السبت";
    } else if ($dayName == '2') {
        $day = "الاحد";
    } else if ($dayName == '3') {
        $day = "الاثنين";
    } else if ($dayName == '4') {
        $day = "الثلاثاء";
    } else if ($dayName == '5') {
        $day = "الاربعاء";
    } else if ($dayName == '6') {
        $day = "الخميس";
    } else if ($dayName == '7') {
        $day = "الجمعة";
    }
    return $day;
}

function getDayName($dayName){
    $day = "";
    if($dayName == '1'){
        $day = "Saturday";
    }
    else if($dayName == '2'){
        $day = "Sunday";
    }
    else if($dayName == '3'){
        $day = "Monday";
    }
    else if($dayName == '4'){
        $day = "Tuesday";
    }
    else if($dayName == '5'){
        $day = "Wednesday";
    }
    else if($dayName == '6'){
        $day = "Thursday";
    }
    else if($dayName == '7'){
        $day = "Friday";
    }
    return $day;
}



if( !function_exists("Dateformat") ){
    function Dateformat($value){
        $organization = App\org::where('owner_url', explode('/',url()->current())[2] )->first();
        return date(App\Settings::where(['key' => 'date', 'org_id' => $organization->id])->value('value'), strtotime($value));
    }
}

if( !function_exists("Decimalplace") ){
    function Decimalplace($value){
        app()->getLocale() == 'ar' ? $name = 'name' : $name = 'name_en';
        $organization = App\org::where('owner_url', explode('/',url()->current())[2] )->first();
        $currency = App\Currency::where('id', App\org::where('id', $organization->id)->value('currency'))->value($name);
        $currency = $currency != '' ? $currency : '';
        return round($value, App\Settings::where(['key' => 'decimal_place', 'org_id' => $organization->id])->value('value')).' '. $currency;
    }
}

//ghada number formate
if( !function_exists("Decimalpoint") ){
    function Decimalpoint($value){

        return round($value, App\Settings::where(['key' => 'decimal_place', 'org_id' =>  Auth::user()->org_id])->value('value'));
    }
}





if( !function_exists("Decimalplace_c") ){
    function Decimalplace_c($value){
        app()->getLocale() == 'ar' ? $name = 'name' : $name = 'name_en';
        $currency = App\Currency::where('id', App\org::where('id', Auth::guard('customers')->user()->org_id)->value('currency'))->value($name);
        $currency = $currency != '' ? $currency : '';
        return number_format(round($value, App\Settings::where(['key' => 'decimal_place', 'org_id' => \Auth::guard('customers')->user()->org_id])->value('value'))).' '. $currency;
    }
}


if( !function_exists("whois") ){
    function whois($value){
        $curl = curl_init();
        $ip = getenv('HTTP_CLIENT_IP') ?: getenv('HTTP_X_FORWARDED_FOR') ?: getenv('HTTP_X_FORWARDED') ?: getenv('HTTP_FORWARDED_FOR') ?: getenv('HTTP_FORWARDED') ?: getenv('REMOTE_ADDR');
        curl_setopt_array($curl, array(
            CURLOPT_URL => "http://www.geoplugin.net/json.gp?ip=$ip",
            CURLOPT_RETURNTRANSFER => 1,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "GET",
        ));

        $response = json_decode(curl_exec($curl), true);
        curl_close($curl);
        return $response{$value};
    }
}

function ipToCountry(){

    $ip = getenv('HTTP_CLIENT_IP') ?: getenv('HTTP_X_FORWARDED_FOR') ?: getenv('HTTP_X_FORWARDED') ?: getenv('HTTP_FORWARDED_FOR') ?: getenv('HTTP_FORWARDED') ?: getenv('REMOTE_ADDR');
    $access_key = 'd8a556790e33bed8e6b583e20e1c8443';

    // Initialize CURL:
    $ch = curl_init('http://api.ipstack.com/'.$ip.'?access_key='.$access_key.'');
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

    // Store the data:
    $json = curl_exec($ch);
    curl_close($ch);

    // Decode JSON response:
    $api_result = json_decode($json, true);

    // Output the "capital" object inside "location"
    return $api_result ;

}


if( !function_exists("Invoice_setup") ){
    function Invoice_setup($value){
        $organization = App\org::where('owner_url', explode('/',url()->current())[2] )->first();
        if(Auth::guard('customers')->check()){
            return App\InvoiceSetup::where(['type' => $value, 'org_id' => $organization->id])->value('value');
        }elseif(Auth::guest()){
            return App\InvoiceSetup::where(['type' => $value, 'org_id' => $organization->id])->value('value');
        }else{
            return App\InvoiceSetup::where(['type' => $value, 'org_id' => $organization->id])->value('value');
        }
    }
}


if( !function_exists("Invoice_status") ){
    function Invoice_status($value){

        $status = 0; $total_transactions = 0; $total_paid = 0; $delayed = 0;
        foreach ($list = App\CustomerHead::where(['id' => $value, 'org_id' => \Auth::user()->org_id])->with('transactions')->whereNotNull('cust_id')->get() as $v){
            foreach ($v->transactions as $key => $v2) {
                $total_transactions += $v2->price * $v2->quantity * $v2->req_flag;
            }

            foreach (App\PermissionReceivingPayments::where(['customer_req_id' => $value])->get() as $key => $v3) {
                $total_paid += $v3->pay_amount;
            }
            if($v->due_date == 0){
                $delayed = 1;
            }else {
                if ($v->due_date != null && date('Y-m-d', strtotime($v->date . "" . $v->due_date . " days")) < date('Y-m-d')) {
                    $delayed = 1;
                }
            }
        }

        if(count($list) != 0) {
            //Invoice status
            if ($total_paid == 0) { //Unpaid
                $status = 0;
            }
            if (abs($total_transactions) == $total_paid) { //Paid
                $status = 1;
            }
            if (abs($total_transactions) > $total_paid && $total_paid > 0) { //Partly driven
                $status = 2;
            }
            if(abs($total_transactions) < $total_paid) { //Prepaid
                $status = 3;
            }
            if($total_paid == 0 && $delayed == 1) { //Delayed
                $status = 4;
            }
            return $status;
        }else{
            return 'invoice does not exist';
        }
    }
}


if( !function_exists("ActivityLabel") ){
    function ActivityLabel($value){
        return App\ActivityLabelSetup::where([ 'type' => $value, 'activity_id' => App\org::where(['id' => Auth::user()->org_id])->value('activity_id')])->first();
    }
}

function SplitTime($StartTime, $EndTime, $Duration = "30"){
    $ReturnArray  = array ();// Define output
    $StartTime    = strtotime ($StartTime); //Get Timestamp
    $EndTime      = strtotime ($EndTime); //Get Timestamp
    $AddMins      = $Duration * 60;
    while ($StartTime <= $EndTime) //Run loop
    {
        $ReturnArray[]  = date ("G:i", $StartTime);
        $StartTime      += $AddMins; //Endtime check
    }
    return $ReturnArray;
}

function checkDetails($id, $type){
    if($type == 'internal') {
        foreach(App\CategoryDetails::where(['catsub_id' => $id])->get() as $value){
            $ids[] = $value->cat_id;
        }
        return App\Transactions::whereIn('cat_id', $ids)->sum(\DB::raw('quantity * req_flag'));
    }
    if($type == 'external') {

        foreach(App\CategoryDetails::where(['catsub_id' => $id])->get() as $value){
            $ids[] = $value->cat_id;
        }

        return App\externalReq::join('external_trans', function ($join) {
            $join->on('external_req.id', '=', 'external_trans.external_req_id')->where('external_req.confirm', 'd');
        })->select('external_trans.*')->whereIn('cat_id', $ids)->sum(\DB::raw('quantity * reg_flag'));
    }
    if($type == 'damaged') {

        foreach(App\CategoryDetails::where(['catsub_id' => $id])->get() as $value){
            $ids[] = $value->cat_id;
        }

        return App\Transactions::whereIn('cat_id', $ids)->where(['description' => 'تالف' ])->sum(\DB::raw('quantity * req_flag'));
    }
}
function UsagePresent($id, $date){
    $reserved = 0; $cat_num = 0;
    foreach (App\Category::where([ 'org_id' => Auth::user()->org_id, 'property_id' => $id  ])->get() as $value) {
        $reserved += App\Bookings::join('booking_detail', 'bookings.id', '=', 'booking_detail.book_id')->where(['booking_detail.cat_id' => $value->id, 'booking_detail.room_status' => 'y', 'bookings.org_id' => Auth::user()->org_id])->whereRaw('? between bookings.book_from and bookings.book_to', [ $date ])->count();
        $cat_num += App\CategoryNum::join('closing_dates_list', 'closing_dates_list.category_num_id', '=' , 'category_num.id')->where('category_num.cat_id', $value->id)->whereRaw('? between closing_dates_list.date_from and closing_dates_list.date_to', [ $date ])->count();
    }
    if($reserved != '' && $cat_num != ''){
        return ['reserved' => $reserved, 'available' => $cat_num];
        return round($reserved / $cat_num * 100);
    }
}

function AvailableRooms($id, $date){
    $reserved = 0; $cat_num = 0;
    foreach (App\Category::where([ 'org_id' => Auth::user()->org_id, 'property_id' => $id  ])->get() as $value) {
        $cat_num += (App\CategoryNum::where('cat_id', $value->id)->count() - App\CategoryNum::join('closing_dates_list', 'closing_dates_list.category_num_id', '=' , 'category_num.id')->where('category_num.cat_id', $value->id)->whereRaw('? between closing_dates_list.date_from and closing_dates_list.date_to', [ $date ])->count());
        $reserved += App\BookingDetails::where(['cat_id' => $value->id, 'room_status' => 'y'])->join('bookings', 'bookings.id', '=', 'booking_detail.book_id')->whereRaw('? between book_from and book_to', [ $date ])->whereNotNull('booking_detail.checkin_dt')->whereNull('booking_detail.checkout_dt')->count();
    }

    return ['reserved' => $reserved, 'available' => $cat_num];
}

function customer_requests($id,$date_from=null,$date_to=null){

    $getsearch = DB::select('select main.cust_id, main.name,main.name_en, sum(main.requests) as requests, sum(main.payments) as payments from (SELECT R.cust_id, c.name,c.name_en, ( SELECT SUM(t.price*t.quantity*t.req_flag) FROM transactions AS t WHERE R.id = t.cust_req_id) requests , ( SELECT SUM(p.pay_amount*p.pay_flag) FROM permission_receiving_payments as p WHERE R.id = p.customer_req_id ) payments FROM customers c, `customer_req_head` as R WHERE c.`org_id` = '.Auth::user()->org_id.'  AND c.active=1 AND R.date >=  "'.$date_from.'" AND   R.date <=  "'.$date_to.'"     AND c.id = R.cust_id   order by R.cust_id,R.id) As main where main.cust_id='.$id.' group by main.cust_id, main.name');


    $extra_head=App\externalReq::where(['cust_id'=>$id,'org_id'=> Auth::User()->org_id])->whereBetween('request_dt', [$date_from ,$date_to])->whereNotIn('confirm', ['c'])->get();

    $total_paid=0;
    $total_request=0;
    foreach ( $extra_head as  $value) {
        $reuest_details=App\externalTrans::where(['org_id'=> Auth::User()->org_id,'external_req_id'=>$value->id])->get();
        foreach ($reuest_details  as  $reuest_detail) {
            $total_request +=$reuest_detail->final_price * $reuest_detail->quantity * $reuest_detail->reg_flag;
            if($value->confirm =='d' || $value->confirm =='x' || $value->confirm =='yx' ){
                $total_paid +=$reuest_detail->final_price * $reuest_detail->quantity* $reuest_detail->reg_flag;
            }
        }

        $value->total=Decimalpoint($total_request);
        $value->paid=Decimalpoint($total_paid);
    }


    $all_requests= $getsearch[0]->requests + $value->total;
    $all_pay = $value->paid + $getsearch[0]->payments;


    return array(
        'all_requests'=>$all_requests,
        'all_pay'=>$all_pay);
}