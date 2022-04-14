<?php

namespace App\Http\Controllers\Student\Registration;

use App\Http\Controllers\Controller;
use App\Http\Resources\CalendarResource;
use App\Http\Resources\PaymentResource;
use App\Http\Resources\RegisterSubjectResource;
use App\Http\Resources\TuitionResource;
use App\Models\Calendar;
use App\Models\Payment;
use App\Models\RegisterSubject;
use App\Models\Student;
use App\Models\Tuition;
use Exception;
use Illuminate\Http\Request;

class PayTuitionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($student_id)
    {
        $student = Student::find($student_id);
        $tuition = Tuition::where('tuition_course', $student->student_course)->where('tuition_major', $student->student_major)
            ->where('tuition_faculty', $student->student_faculty)->get();
        return TuitionResource::collection($tuition);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function calendar_paytuition($student_id)
    {
        $find = Student::find($student_id);
        $joins = Calendar::join('tbl_course', 'tbl_course.course_id', '=', 'tbl_calendar.raw')
            ->join('tbl_major', 'tbl_major.major_id', '=', 'tbl_calendar.body')
            ->where('tbl_course.course_id', $find->student_course)
            ->where('tbl_major.major_id', $find->student_major)
            ->where('tbl_calendar.calendarId', 5)->get();

        return CalendarResource::collection($joins);
    }

    public function subject_paytuition($student_id, $semester)
    {
        $joins = RegisterSubject::join('tbl_student', 'tbl_student.student_id', '=', 'tbl_register_subject.register_subject_student')
            ->join('tbl_calendar_subject', 'tbl_calendar_subject.calendar_subject_id', '=', 'tbl_register_subject.register_subject_program')
            ->join('tbl_subject', 'tbl_subject.subject_id', '=', 'tbl_calendar_subject.subject_id')
            ->join('tbl_course', 'tbl_course.course_id', '=', 'tbl_student.student_course')
            ->join('tbl_faculty', 'tbl_faculty.faculty_id', '=', 'tbl_student.student_faculty')
            ->join('tbl_major', 'tbl_major.major_id', '=', 'tbl_student.student_major')
            ->join('tbl_class', 'tbl_class.class_id', '=', 'tbl_student.student_class')
            ->where('tbl_register_subject.register_subject_student', $student_id)
            ->where('tbl_register_subject.register_subject_semester', $semester)->get();
        return RegisterSubjectResource::collection($joins);
    }

    public function vnpay_paytuition(Request $request, $student_id, $semester)
    {
        $data = $request->all();
        $vnp_Url = "https://sandbox.vnpayment.vn/paymentv2/vpcpay.html";
        $vnp_Returnurl = "https://tancool.net/home/thanh-toan-hoc-phi/return-vnpay";
        $vnp_TmnCode = "XRIPQIHD"; //Mã website tại VNPAY
        $vnp_HashSecret = "KHDJYVFSSNPNGIRWPVGMGCJVGCOIZYKK"; //Chuỗi bí mật

        $vnp_TxnRef = 'VNPAY_' . uniqid(md5(rand())); //Mã đơn hàng. Trong thực tế Merchant cần insert đơn hàng vào DB và gửi mã này sang VNPAY
        $vnp_OrderInfo = 'Thanh toán học phí học kỳ ' . $semester . '~' . $student_id . '~' . $semester;
        $vnp_OrderType = 'billpayment';
        $vnp_Amount = (int)$data['tuition_fee'] * 100;
        $vnp_Locale = 'vn';
        $vnp_BankCode = 'NCB';
        $vnp_IpAddr = $request->ip();

        $inputData = array(
            "vnp_Version" => "2.1.0",
            "vnp_TmnCode" => $vnp_TmnCode,
            "vnp_Amount" => $vnp_Amount,
            "vnp_Command" => "pay",
            "vnp_CreateDate" => date('YmdHis'),
            "vnp_CurrCode" => "VND",
            "vnp_IpAddr" => $vnp_IpAddr,
            "vnp_Locale" => $vnp_Locale,
            "vnp_OrderInfo" => $vnp_OrderInfo,
            "vnp_OrderType" => $vnp_OrderType,
            "vnp_ReturnUrl" => $vnp_Returnurl,
            "vnp_TxnRef" => $vnp_TxnRef
        );

        if (isset($vnp_BankCode) && $vnp_BankCode != "") {
            $inputData['vnp_BankCode'] = $vnp_BankCode;
        }
        if (isset($vnp_Bill_State) && $vnp_Bill_State != "") {
            $inputData['vnp_Bill_State'] = $vnp_Bill_State;
        }

        //var_dump($inputData);
        ksort($inputData);
        $query = "";
        $i = 0;
        $hashdata = "";
        foreach ($inputData as $key => $value) {
            if ($i == 1) {
                $hashdata .= '&' . urlencode($key) . "=" . urlencode($value);
            } else {
                $hashdata .= urlencode($key) . "=" . urlencode($value);
                $i = 1;
            }
            $query .= urlencode($key) . "=" . urlencode($value) . '&';
        }

        $vnp_Url = $vnp_Url . "?" . $query;

        if (isset($vnp_HashSecret)) {
            $vnpSecureHash =   hash_hmac('sha512', $hashdata, $vnp_HashSecret); //
            $vnp_Url .= 'vnp_SecureHash=' . $vnpSecureHash;
        }
        $returnData = array(
            'code' => '00', 'message' => 'success', 'data' => $vnp_Url, 'student_id' => $student_id, 'semester' => $semester,
        );

        if (isset($data['redirect'])) {
            header('Location: ' . $vnp_Url);
            die();
        } else {
            echo json_encode($returnData);
        }
    }

    public function return_vnpay()
    {
        $student_info = explode('~', $_GET['vnp_OrderInfo']);
        if ($_GET['vnp_ResponseCode'] == 0 && $_GET['vnp_TransactionStatus'] == 0) {
            $vnpay = Payment::where('payment_student', $student_info[1])->where('payment_semester', $student_info[2])
                ->where('payment_status', 1)->first();
            $vnpay->payment_code = $_GET['vnp_TxnRef'];
            $vnpay->payment_paid = $_GET['vnp_Amount'] / 100;
            date_default_timezone_set('Asia/Ho_Chi_Minh');
            $vnpay->payment_date = now();
            $vnpay->payment_status = 0;
            $vnpay->save();
            return redirect('/home#/thanh-toan-hoc-phi');
        } else {
            return redirect('/home#/thanh-toan-hoc-phi');
        }
    }

    public function execPostRequest($url, $data)
    {
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt(
            $ch,
            CURLOPT_HTTPHEADER,
            array(
                'Content-Type: application/json',
                'Content-Length: ' . strlen($data)
            )
        );
        curl_setopt($ch, CURLOPT_TIMEOUT, 5);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);
        //execute post
        $result = curl_exec($ch);
        //close connection
        curl_close($ch);
        return $result;
    }

    public function momo_paytuition(Request $request, $student_id, $semester)
    {
        $data = $request->all();
        $endpoint = "https://test-payment.momo.vn/v2/gateway/api/create";
        $partnerCode = 'MOMOBKUN20180529';
        $accessKey = 'klm05TvNBzhg7h7j';
        $secretKey = 'at67qH6mk8w5Y1nAyMoYKMWACiEi2bsa';
        $orderInfo = 'Thanh toán học phí học kỳ ' . $semester . '~' . $student_id . '~' . $semester;
        $amount = (int)$data['tuition_fee'];
        $orderId = time() . "";
        $redirectUrl = "https://tancool.net/home/thanh-toan-hoc-phi/return-momo";
        $ipnUrl = "https://tancool.net/home/thanh-toan-hoc-phi/return-momo";
        $extraData = "";

        $requestId = time() . "";
        $requestType = "payWithATM";
        // $extraData = ($_POST["extraData"] ? $_POST["extraData"] : "");
        //before sign HMAC SHA256 signature
        $rawHash = "accessKey=" . $accessKey . "&amount=" . $amount . "&extraData=" . $extraData . "&ipnUrl=" . $ipnUrl . "&orderId=" . $orderId . "&orderInfo=" . $orderInfo . "&partnerCode=" . $partnerCode . "&redirectUrl=" . $redirectUrl . "&requestId=" . $requestId . "&requestType=" . $requestType;
        $signature = hash_hmac("sha256", $rawHash, $secretKey);
        $data = array(
            'partnerCode' => $partnerCode,
            'partnerName' => "Test",
            "storeId" => "MomoTestStore",
            'requestId' => $requestId,
            'amount' => $amount,
            'orderId' => $orderId,
            'orderInfo' => $orderInfo,
            'redirectUrl' => $redirectUrl,
            'ipnUrl' => $ipnUrl,
            'lang' => 'vi',
            'extraData' => $extraData,
            'requestType' => $requestType,
            'signature' => $signature
        );
        $result = $this->execPostRequest($endpoint, json_encode($data));
        echo $result;  // decode json
    }

    public function return_momo()
    {
        $student_info = explode('~', $_GET['orderInfo']);
        if ($_GET['resultCode'] == 0) {
            $momo = Payment::where('payment_student', $student_info[1])->where('payment_semester', $student_info[2])
                ->where('payment_status', 1)->first();
            $momo->payment_code = 'MOMO_' . uniqid(md5(rand()));
            $momo->payment_paid = $_GET['amount'];
            date_default_timezone_set('Asia/Ho_Chi_Minh');
            $momo->payment_date = now();
            $momo->payment_status = 0;
            $momo->save();
            return redirect('/home#/thanh-toan-hoc-phi');
        } else {
            return redirect('/home#/thanh-toan-hoc-phi');
        }
    }

    public function check_payment($student_id, $semester)
    {
        $joins = Payment::where('payment_student', $student_id)->where('payment_semester', $semester)->get();
        return PaymentResource::collection($joins);
    }

    public function total_payment($student_id)
    {
        $joins = Payment::where('payment_student', $student_id)->get();
        return PaymentResource::collection($joins);
    }

    public function detail_payment($payment_id)
    {
        $joins = Payment::where('payment_id', $payment_id)->get();
        return PaymentResource::collection($joins);
    }
}
