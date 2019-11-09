<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\FunctionsUser as funcUser;
use App\functions_role as funcRole;
use Response;
use DB;
use Auth;
use Validator;
use Session;

class menuEditController extends Controller
{
    public function showeditmenuPage()
    {
      if (session('locale')) {
          \App::setLocale(session('locale'));
      }

      return view('editMenu.editMenu');
    }

      public function default_menu(Request $Request)
    {
      $old_menu = funcUser::where('org_id',Auth::user()->org_id)->where('user_id',Auth::user()->id)->get();
      foreach ($old_menu as $key) {
        $key->delete();
      }

      $defult_menu = funcRole::where('role_id',Auth::user()->role_id)->where('org_id',Auth::user()->org_id)->get();
      foreach ($defult_menu as  $value) {
      $user_menu = new funcUser();
      $user_menu->user_id = Auth::user()->id;
      $user_menu->org_id  = $value->org_id;
      $user_menu->functions_id  = $value->functions_id;
      $user_menu->funcname  = $value->funcname;
      $user_menu->funcname_en  = $value->funcname_en;
      $user_menu->technical_name  = $value->technical_name;
      $user_menu->funcparent_id  = $value->funcparent_id;
      $user_menu->porder  = $value->porder;
      $user_menu->appear  = $value->appear;
      $user_menu->font  = $value->font;
       $user_menu->func_name  = $value->func_name;
      $user_menu->created_by  = $value->created_by;
      $user_menu->save();

      }
      return Response::json(
        array(
                'data'   => 'successDefault'
              ));
    }
    public function menu_list()
    {
        if (session('locale')) {
            \App::setLocale(session('locale'));
        }
          $user =Auth::user();
          $role_id = $user->role_id;
          $parents = [];
          foreach (DB::table('functions_user')->where('funcparent_id','0')->where('org_id',Auth::user()->org_id)->where('user_id',$user->id)->orderBy('porder')->get() as $key  ) {
            if ($key->funcparent_id == 0) {
              $child = [];
              foreach (DB::table('functions_user')->where('funcparent_id','>','0')->where('user_id' ,$user->id)->where('org_id',Auth::user()->org_id)->orderBy('porder')->get() as $value) {
                if ($value->funcparent_id == $key->functions_id) {
                  if (app()->getLocale() == 'ar') {
                    $child[] = ['id' => $value->id ,'org_id' => $value->org_id,'functions_id'=>$value->functions_id,  'funcparent_id' => $value->funcparent_id,'text' => $value->funcname , 'name_eng' => $value->funcname_en  ,'icon'=>$value->font,'user_id'=>$value->user_id];
                  }
                  else {
                    $child[] = ['id' => $value->id ,'org_id' => $value->org_id ,'functions_id'=>$value->functions_id, 'funcparent_id' => $value->funcparent_id,'text' => $value->funcname_en, 'name_eng' => $value->funcname  ,'icon'=>$value->font,'user_id'=>$value->user_id];
                  }
                }

              }
              if (count($child) == 0) {
                $child = '';
              }
              if (app()->getLocale() == 'ar') {
                $parents[] = ["id" =>$key->id ,'functions_id'=>$key->functions_id,'functions_id'=>$key->functions_id,'org_id' => $key->org_id,'text' => $key->funcname, 'name_eng' => $key->funcname_en, 'children' => $child  ,'icon'=>$key->font,'user_id'=>$key->user_id];

              }
              else {
                $parents[] = ['id'=> $key->id  ,'functions_id'=>$key->functions_id,'functions_id'=>$key->functions_id,'org_id' => $key->org_id,'text' => $key->funcname_en, 'name_eng' => $key->funcname ,'children' => $child  ,'icon'=>$key->font,'user_id'=>$key->user_id];
              }
            }
          }

        return $parents;
    }
    public function editMenu(Request  $Request)
    {
      if (Auth::user()->id == $Request->user_id && Auth::user()->org_id == $Request->org_id) {
      // find menu to edit it
      $editMenu =   funcUser::find($Request->menu_id);
      // edit menu after find
      $editMenu->funcname = $Request->name;
      $editMenu->funcname_en = $Request->name_en;
      // dd($Request->icon);
      if ($Request->icon != 'empty') {
        $editMenu->font = $Request->icon;
      }
      // $editMenu->technical_name = $Request->technical_name;
      // save Edit
      $editMenu->save();
      // send edit response to ajax
            }
      return Response::json(
        array(
                'data'   => 'successEdit'
              ));
    }
    // change order num , child or parent
    public function editAllMenus(Request  $Request)
    {
      // decode json data
      $data = json_decode($Request->menu);
      // dd($data);
      $i= 0; //set a variable to use it in parent order_num
      $x= 0; //set a variable to use it in child  order_num
      // foreach data for edit
      foreach ($data as $oneMenu) {
        $i++;
        // find menu with id to edit it
          $edit = funcUser::find($oneMenu->id);
          // edit menu details
            $edit->funcparent_id = 0;
            $edit->porder = $i;
            // save edit menu in DB
            $edit->save();
          // check if parent have a child or no
          if (isset($oneMenu->children)) {
            // if parent have child , foreach children data
            foreach ($oneMenu->children as $child) {
              $x++;
              // find menu child
              $editChild = funcUser::find($child->id);
              $editChild->funcparent_id = $oneMenu->functions_id ;
              $editChild->porder = $x;
              $editChild->save();
              if (isset($child->children)) {
                foreach ($child->children as $childChild) {
                  $editChildChild = funcUser::find($childChild->id);
                  $editChildChild->funcparent_id = $oneMenu->functions_id ;
                  $editChildChild->porder = $x;
                  $editChildChild->save();
                }
              }
              // save edit menu changed
            }
          }
      }
      // return repsonse to ajax function
      return Response::json(
        array(
                'data'   => 'successAllEdit'
              ));
    }
    // delete one menu function
    public function deleteMenu(Request  $Request)
    {
      // find menu with id
      $del = menuModel::find($Request->menu_id);
      // find children menus for this menu with id
      $subMenuDelete = menuModel::where('parent_id', $Request->menu_id)->get();
      // if menu has a children menus .. get menus  and delete
      if ($subMenuDelete) {
        foreach ($subMenuDelete as $key  ) {
          $key->delete();
        }
      }
      // delete menu
      $del->delete();
      // send response date to ajax
      return Response::json(
        array(
                'data'   => 'successDelete'
              ));
    }
    public function addMenu(Request  $Request)
    {
        $data = json_decode($Request->menu);
        $i = 0;
           foreach ($data as $key ) {
             $i++;
             if (isset($key->id)) {
              $edit = menuModel::find($key->id);
              $edit->delete();
             }
               $addMenu = new menuModel();
               $addMenu->name = $key->text  ;
               $addMenu->name_ar = $key->name_ar  ;
               $addMenu->dics = $key->dics  ;
               $addMenu->order_num = $i;
               $addMenu->technical_name = $key->technical_name  ;
               if (!isset($key->children)) {
                 $addMenu->parent_id = 0  ;
                 $addMenu->type = 'p'  ;
                 $addMenu->save();
               }
               else {
                 $addMenu->parent_id = 0  ;
                 $addMenu->save();
                 $x = 0;
                 foreach ($key->children as $val) {
                   $x++;
                   if (isset($val->id)) {
                     $edit = menuModel::find($val->id);
                     $edit->delete();
                   }
                   $addchild = new menuModel();
                   $addchild->name = $val->text ;
                   $addchild->name_ar = $val->name_ar ;
                   $addchild->dics = $val->dics ;
                   $addchild->order_num = $x ;
                   $addchild->technical_name = $val->technical_name ;
                   $addchild->parent_id = $addMenu->id ;
                   $addchild->type = 'c' ;
                   $addchild->save() ;
                 }
               }
           };


           $test =  menuModel::all();
           return Response::json(array(
                     'dat'   => $test
                 ));
    }
    public function menuManger()
    {
      if (session('locale')) {
          \App::setLocale(session('locale'));
      }
      $menus = DB::table('functions_user')->where('funcparent_id','0')->where('org_id',Auth::user()->org_id)->where('user_id',Auth::user()->id)->orderBy('porder')->get();

      // dd($menus);
      return view('editMenu.menuManger',['menus'=>$menus]);

    }
    public function menuMangerEdit(Request $Request)
    {
      $checkedMenu = $Request->all()['id'];
      $unCheckedMenu = $Request->all()['UnCheckedId'];
      foreach ($checkedMenu as  $menuId) {
        $editMenu = funcUser::where('org_id',Auth::user()->org_id)->where('id',$menuId)->first();
        $editMenu->appear = 1;
        $editMenu->save();
      }
      foreach ($unCheckedMenu as   $UnmenuId) {
        $editMenuUn = funcUser::where('org_id',Auth::user()->org_id)->where('id',$UnmenuId)->first();
        $editMenuUn->appear = 0;
        $editMenuUn->save();
      }
      Session::forget('partents');
       Session::forget('childs');
       Session::forget('links');
      $user =Auth::user();
             $user_id = $user->id;
             $funcs = DB::table('functions_user')->where('funcparent_id','0')->where('user_id' ,$user_id)->where('org_id',Auth::user()->org_id)->where('appear','1')->orderBy('porder')->get();
           $sub_funcs = DB::table('functions_user')->where('funcparent_id','>','0')->where('user_id' ,$user_id)->where('org_id',Auth::user()->org_id)->where('appear','1')->orderBy('porder')->get();
             $func_links = DB::table('function_new')->orderBy('porder')->get();
              
              $partents=Session::put('partents', $funcs);
              $childs=Session::put('childs',  $sub_funcs);
              $links=Session::put('links',  $func_links); 
              
      return back()->with('successMsg', 'تم التعديل بنجاح');
      //
    }
}
