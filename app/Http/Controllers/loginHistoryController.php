<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\loginHistory as logHistoryModel;
use App\NotificationsUser as activityModel;
use App\User as usersModel;
use Carbon\Carbon;
use DB;
use Response;
use App\Charts\reportchart;
use Auth;

class loginHistoryController extends Controller
{
    public function index()
    {
      if (session('locale')) {
          \App::setLocale(session('locale'));
      }
      $allHistory = logHistoryModel::where('org_id',Auth::user()->org_id)->whereDate('created_at',Carbon::today())->get();
      $login =[];
      $logout =[];
      $users=DB::table('users')->where('org_id',Auth::user()->org_id)->get();

      $chart = new reportchart;
      $chart->title('My nice chart');
      $i=0;
      foreach($users as $user){
        if (app()->getLocale() == 'ar') {
          $usersNames[$i]=$user->name;
        }else{
          $usersNames[$i]=$user->name_en;
        }
      $userLogin = abs(round(logHistoryModel::where('org_id',Auth::user()->org_id)->where('user_id', $user->id)->whereDate('created_at',Carbon::today())->where('status','login')->count()));
      $userLogout = abs(round(logHistoryModel::where('org_id',Auth::user()->org_id)->where('user_id', $user->id)->whereDate('created_at',Carbon::today())->where('status','logout')->count()));
      array_push($login,$userLogin);
      array_push($logout,$userLogout);
      $i++;
      }
      $chart->dataset(app()->getLocale() == 'ar' ? 'تسجيل دخول': 'Login', 'bar', $login)->color('#1dad1f');
      $chart->dataset(app()->getLocale() == 'ar' ? 'تسجيل خروج': 'Logout', 'bar', $logout)->color('#e6270c');
      $chart->labels($usersNames);
      return view('login_reports.loginReport',['allHistory'=>$allHistory,'chart'=>$chart]);
    }

    public function search(Request $Request)
    {
      if (session('locale')) {
          \App::setLocale(session('locale'));
      }
      $dateFrom = $Request->date_from;
      $dateTo = $Request->date_to;
      $status = $Request->status;
      $user_id = $Request->user_id;
      $orderBy = $Request->orderBy;
      if ($dateFrom == '' && $dateTo =='' ) {
        $dateFrom = Carbon::today();
        $dateTo = Carbon::today();
      }
      $org_id = Auth::user()->org_id;
      if ($dateFrom  || $dateTo || $status || $user_id || $orderBy) {
        $allHistory = logHistoryModel::when($user_id, function ($q) use ($user_id) {
              return $q->where('user_id' , $user_id);
          })
          ->when($org_id,function ($q) use ($org_id) {
            return $q->where('org_id' ,$org_id);
          })
          ->when($dateFrom,function ($q) use ($dateFrom) {
            return $q->whereDate('created_at','>=' ,$dateFrom);
          })
          ->when($dateTo,function ($q) use ($dateTo) {
            return $q->whereDate('created_at' ,'<=' ,$dateTo);
          })
          ->when($status,function ($q) use ($status) {
            return $q->where('status' ,$status);
          })
          ->orderBy($orderBy == 'date'? "created_at": "user_id" , 'desc')->get();
          }
          $usersnameHistory = [];
          $userslogin = [];
          $userslogout = [];
          $chartuserName = [];
          // get user id
          foreach (logHistoryModel::when($user_id, function ($q) use ($user_id) {
                return $q->where('user_id' , $user_id);
            })
            ->when($org_id,function ($q) use ($org_id) {
              return $q->where('org_id' ,$org_id);
            })
            ->when($dateFrom,function ($q) use ($dateFrom) {
              return $q->whereDate('created_at','>=' ,$dateFrom);
            })
            ->when($dateTo,function ($q) use ($dateTo) {
              return $q->whereDate('created_at' ,'<=' ,$dateTo);
            })
            ->when($status,function ($q) use ($status) {
              return $q->where('status' ,$status);
            })
            ->groupBy('user_id')->get() as  $value) {
              $key = usersModel::find($value->user_id);
              if (app()->getLocale() == 'ar') {
                array_push($usersnameHistory,['id'=>$key->id,'value'=>$key->name]);
              }else{
                array_push($usersnameHistory,['id'=>$key->id,'value'=>$key->name_en]);
              }
          }
          foreach ($usersnameHistory as $user) {
            array_push($chartuserName,$user['value']);
            array_push($userslogin,logHistoryModel::when($user, function ($q) use ($user) {
                  return $q->where('user_id' , $user['id']);
              })
              ->when($org_id,function ($q) use ($org_id) {
                return $q->where('org_id' ,$org_id)->where('status','login');
              })
              ->when($dateFrom,function ($q) use ($dateFrom) {
                return $q->whereDate('created_at','>=' ,$dateFrom);
              })
              ->when($dateTo,function ($q) use ($dateTo) {
                return $q->whereDate('created_at' ,'<=' ,$dateTo);
              })
              ->count());
            array_push($userslogout,logHistoryModel::when($user, function ($q) use ($user) {
                  return $q->where('user_id' , $user['id']);
              })
              ->when($org_id,function ($q) use ($org_id) {
                return $q->where('org_id' ,$org_id)->where('status','logout');
              })
              ->when($dateFrom,function ($q) use ($dateFrom) {
                return $q->whereDate('created_at','>=' ,$dateFrom);
              })
              ->when($dateTo,function ($q) use ($dateTo) {
                return $q->whereDate('created_at' ,'<=' ,$dateTo);
              })
              ->count());
          }
          $chart = new reportchart;
          $chart->title('Login History Chart');
          $chart->labels($chartuserName);
          $chart->dataset(app()->getLocale() == 'ar' ? 'تسجيل دخول': 'Login', 'bar', $userslogin)->color('#1dad1f');
          $chart->dataset(app()->getLocale() == 'ar' ? 'تسجيل خروج': 'Logout', 'bar', $userslogout)->color('#e6270c');
          return view('login_reports.loginReport',['allHistory'=>$allHistory,'chart'=>$chart,'oldData'=>$Request->all()]);
  }

  public function editNotify(Request $Request)
  {
    $activity = new activityModel;
    $activity->notification_id = $Request->id;
    $activity->user_id = Auth::user()->id;
    $activity->status = 1;
    $activity->type = $Request->type;
    $activity->save();
    return Response::json(
      array(
              'data'   => 'successNotifiy'
            ));
  }
}
