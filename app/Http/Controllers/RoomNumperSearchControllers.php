<?php


namespace App\Http\Controllers;


use App\CategoriesType;
use App\Category;
use App\CategoryNum;
use App\ClosingDateList;
use App\Destinations;
use App\FacilityList;
use App\Locations;
use App\Property;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RoomNumperSearchControllers extends Controller
{


    public function viewSearch()
    {
        $org_id = Auth()->user()->org_id;

        // get destinations
        $destinations = Destinations::where('org_id', $org_id)->where('active', 1)->get();

        // get Property

        $property = Property::where([
            ['org_id', $org_id],
            ['prop_type', 'hotel'],
            ['active', 1]
        ])->get();

        // get Room Type
        $types = DB::table('categories_type')
            ->select('categories_type.*')
            ->where([
                ['categories_type.type', 7],
                ['categories_type.org_id', $org_id],
                ['categories_type.active', 1]
            ])->get();

        // get Faclity
        $amentities = DB::table('categories_type')
            ->join('categories', 'categories.category_type_id', '=', 'categories_type.id')
            ->select('categories.*')
            ->whereIn('categories_type.type', [5, 6])
            ->where([
                ['categories.active', 1],
                ['categories.org_id', Auth()->user()->org_id],
                ['categories_type.org_id', Auth()->user()->org_id],
                ['categories_type.active', 1]
            ])->get();

        return view('rooms.num.search')
            ->with('amentities', $amentities)
            ->with('types', $types)
            ->with('property', $property)
            ->with('destinations', $destinations);


    }

    public function searchProcess(Request $request)
    {

        // get all

        $date_form = $request->get('date_from');
        $date_to = $request->get('date_to');
        $amentities_id = $request->get('amentities');
        $property_id = $request->get('property');
        $types_id = $request->get('types');
        $destinations_id = $request->get('destinations');
        $org_id = Auth()->user()->org_id;

        // query

        $cateNum = CategoryNum::with('cate_id', 'cloth', 'facility')
            ->when($org_id, function ($q) use ($org_id) {
                $q->where('org_id', $org_id);
            })
            ->when($date_form, function ($q) use ($date_form,$date_to, $org_id) {

                $cloth = ClosingDateList::where(function ($query) use
                ($date_form,$date_to ) {
                    $query->where(function ($query) use
                    ($date_form, $date_to) {
                        $query->where('date_from', '<=',
                            $date_form)->where('date_to', '>=', $date_form);
                    })->orWhere(function ($query) use ($date_form,$date_to) {
                        $query->where('date_from',
                            '<=',$date_to)->where('date_to', '>=', $date_to);
                    })->orWhere(function ($query) use ($date_form,$date_to) {
                        $query->where('date_from','>=',$date_form )->where('date_to',
                            '<=',$date_to);
                    });})->where('org_id', $org_id)->pluck('category_num_id');
                return $q->whereIn('id', $cloth);
            })
            ->when($amentities_id, function ($q) use ($amentities_id, $org_id) {
                $facility = FacilityList::where('cat_id', $amentities_id)->where('org_id', $org_id)->pluck('category_num_id');
                return $q->whereIn('id', $facility);

            })
            ->when($property_id, function ($q) use ($property_id, $org_id) {
                $category = Category::where([['property_id', '=', $property_id], ['org_id', '=', $org_id]])->pluck('id');
                return $q->whereIn('cat_id', $category);

            })
            ->when($types_id, function ($q) use ($types_id, $org_id) {
                $category = Category::where([['category_type_id', '=', $types_id], ['org_id', '=', $org_id]])->pluck('id');
                return $q->whereIn('cat_id', $category);

            })
            ->when($destinations_id, function ($q) use ($destinations_id, $org_id) {
                $locations=Locations::where('destination_id',$destinations_id)->where('org_id',$org_id)->pluck('id');
                $hotels=Property::where('org_id',$org_id)->whereIn('location_id',$locations)->pluck('id');
                $category = Category::whereIn('property_id', $hotels)->where('org_id', '=', $org_id)->pluck('id');
                return $q->whereIn('cat_id', $category);

            })
            ->orderBy('cat_num','ASC')
            ->get();

        // get Property Name && Category_type name

        foreach ($cateNum as $cate)
        {
            $category_id = Category::where('id',$cate->cat_id)->where('org_id',$org_id)->first()->property_id;
            $cate->pro_name = app()->getLocale() == 'ar' ? Property::where('id',$category_id)->where('org_id',$org_id)->first()->name :Property::where('id',$category_id)->where('org_id',$org_id)->first()->name_en;
            $category_type = Category::where('id',$cate->cat_id)->where('org_id',$org_id)->first()->category_type_id;
            $cate->cate_type_name =app()->getLocale() == 'ar' ? CategoriesType::where('id',$category_type)->where('org_id',$org_id)->first()->name:CategoriesType::where('id',$category_type)->where('org_id',$org_id)->first()->name_en;
            foreach ($cate['facility'] as $faclist)
            {
                $amints = Category::where('id',$faclist->cat_id)->where('org_id',$org_id)->first()->category_type_id;
                $faclist->cateogry_name =app()->getLocale() == 'ar' ? CategoriesType::where('id',$amints)->where('org_id',$org_id)->first()->name:CategoriesType::where('id',$amints)->where('org_id',$org_id)->first()->name_en;
            }
        }




        $destinations = Destinations::where('org_id', $org_id)->where('active', 1)->get();

        // get Property

        $property = Property::where([
            ['org_id', $org_id],
            ['prop_type', 'hotel'],
            ['active', 1]
        ])->get();

        // get Room Type
        $types = DB::table('categories_type')
            ->select('categories_type.*')
            ->where([
                ['categories_type.type', 7],
                ['categories_type.org_id', $org_id],
                ['categories_type.active', 1]
            ])->get();

        // get Faclity
        $amentities = DB::table('categories_type')
            ->join('categories', 'categories.category_type_id', '=', 'categories_type.id')
            ->select('categories.*')
            ->whereIn('categories_type.type', [5, 6])
            ->where([
                ['categories.active', 1],
                ['categories.org_id', Auth()->user()->org_id],
                ['categories_type.org_id', Auth()->user()->org_id],
                ['categories_type.active', 1]
            ])->get();

        return view('rooms.num.search')
            ->with('cateNum',$cateNum)
            ->with('amentities',$amentities)
            ->with('types',$types)
            ->with('property',$property)
            ->with('destinations',$destinations);



    }
}