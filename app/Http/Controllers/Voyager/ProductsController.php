<?php

namespace App\Http\Controllers\Voyager;

use App\Product;
use App\Category;
use App\City;
use App\Region;
use App\Organizator;
use App\PriceProduct;
use App\ProductInventary;

use App\CategoryProduct;
use Illuminate\Http\Request;
use TCG\Voyager\Facades\Voyager;
use Illuminate\Support\Facades\DB;
use TCG\Voyager\Events\BreadDataAdded;
use Illuminate\Database\Eloquent\Model;
use TCG\Voyager\Events\BreadDataDeleted;
use TCG\Voyager\Events\BreadDataUpdated;
use TCG\Voyager\Events\BreadImagesDeleted;
use TCG\Voyager\Database\Schema\SchemaManager;
use TCG\Voyager\Http\Controllers\VoyagerBaseController;
use TCG\Voyager\Http\Controllers\Traits\BreadRelationshipParser;
use Auth;
class ProductsController extends VoyagerBaseController
{
    use BreadRelationshipParser;
    //***************************************
    //               ____
    //              |  _ \
    //              | |_) |
    //              |  _ <
    //              | |_) |
    //              |____/
    //
    //      Browse our Data Type (B)READ
    //
    //****************************************

    public function index(Request $request)
    {
        
        
        // GET THE SLUG, ex. 'posts', 'pages', etc.
        $slug = $this->getSlug($request);

        // GET THE DataType based on the slug
        $dataType = Voyager::model('DataType')->where('slug', '=', $slug)->first();

        // Check permission
        $this->authorize('browse', app($dataType->model_name));

        $getter = $dataType->server_side ? 'paginate' : 'get';

        $search = (object) ['value' => $request->get('s'), 'key' => $request->get('key'), 'filter' => $request->get('filter')];
        $searchable = $dataType->server_side ? array_keys(SchemaManager::describeTable(app($dataType->model_name)->getTable())->toArray()) : '';
        $orderBy = $request->get('order_by');
        $sortOrder = $request->get('sort_order', null);

        // Next Get or Paginate the actual content from the MODEL that corresponds to the slug DataType
        if (strlen($dataType->model_name) != 0) {
            $model = app($dataType->model_name);
            $query = $model::select('products.*');

            // If a column has a relationship associated with it, we do not want to show that field
            $this->removeRelationshipField($dataType, 'browse');

            if ($search->value && $search->key && $search->filter) {
                $search_filter = ($search->filter == 'equals') ? '=' : 'LIKE';
                $search_value = ($search->filter == 'equals') ? $search->value : '%'.$search->value.'%';
                $query->where($search->key, $search_filter, $search_value);
            }

            $countries= \Session::get('countries');
            
            $query->join("cities","cities.id","=","products.city_id");

            $query->join("regions","regions.id","=","cities.region_id");
            
            
            $query->join("countries","countries.id","=","regions.country_id");
            $query->whereIn("countries.id",$countries);
            
            if ($orderBy && in_array($orderBy, $dataType->fields())) {
                $querySortOrder = (!empty($sortOrder)) ? $sortOrder : 'DESC';
                $dataTypeContent = call_user_func([
                    $query->orderBy($orderBy, $querySortOrder),
                    $getter,
                ]);
            } elseif ($model->timestamps) {
                $dataTypeContent = call_user_func([$query->latest($model::CREATED_AT), $getter]);
            } else {
                $dataTypeContent = call_user_func([$query->orderBy($model->getKeyName(), 'DESC'), $getter]);
            }

            // Replace relationships' keys for labels and create READ links if a slug is provided.
            $dataTypeContent = $this->resolveRelations($dataTypeContent, $dataType);
        } else {
            // If Model doesn't exist, get data from table name
            $dataTypeContent = call_user_func([DB::table($dataType->name), $getter]);
            $model = false;
        }

        // Check if BREAD is Translatable
        if (($isModelTranslatable = is_bread_translatable($model))) {
            $dataTypeContent->load('translations');
        }

        // Check if server side pagination is enabled
        $isServerSide = isset($dataType->server_side) && $dataType->server_side;

        $view = 'voyager::bread.browse';

        if (view()->exists("voyager::$slug.browse")) {
            $view = "voyager::$slug.browse";
        }

        return Voyager::view($view, compact(
            'dataType',
            'dataTypeContent',
            'isModelTranslatable',
            'search',
            'orderBy',
            'sortOrder',
            'searchable',
            'isServerSide'
        ));
    }

    //***************************************
    //                ______
    //               |  ____|
    //               | |__
    //               |  __|
    //               | |____
    //               |______|
    //
    //  Edit an item of our Data Type BR(E)AD
    //
    //****************************************

    public function edit(Request $request, $id)
    {
        $slug = $this->getSlug($request);

        $dataType = Voyager::model('DataType')->where('slug', '=', $slug)->first();

        // Compatibility with Model binding.
        $id = $id instanceof Model ? $id->{$id->getKeyName()} : $id;

        $dataTypeContent = (strlen($dataType->model_name) != 0)
            ? app($dataType->model_name)->findOrFail($id)
            : DB::table($dataType->name)->where('id', $id)->first(); // If Model doest exist, get data from table name

        foreach ($dataType->editRows as $key => $row) {
            $details = ($row->details);
            $dataType->editRows[$key]['col_width'] = isset($details->width) ? $details->width : 100;
        }

        // If a column has a relationship associated with it, we do not want to show that field
        $this->removeRelationshipField($dataType, 'edit');

        // Check permission
        $this->authorize('edit', $dataTypeContent);

        // Check if BREAD is Translatable
        $isModelTranslatable = is_bread_translatable($dataTypeContent);

        $view = 'voyager::bread.edit-add';

        if (view()->exists("voyager::$slug.edit-add")) {
            $view = "voyager::$slug.edit-add";
        }
        $product = Product::find($id);

        $allCategories = Category::where("type",$product->type_id)->get();
        
        $categoriesForProduct = $product->categories()->get();
        
        $regionModel=new City();
        $allRegions=$regionModel->getAllByCountry();
        
        
        
        
        $organizators= new Organizator();
        $organizatorByCountry =$organizators->getAllByCountry();
        $regionForProduct =  $product->city()->get();
        $organizatorsForProduct =  $product->organizator()->get();
         
        
               $this->checkDefaultLatitude();

        return Voyager::view($view, compact("organizatorsForProduct","organizatorByCountry",'regionForProduct','allRegions','dataType', 'dataTypeContent', 'isModelTranslatable', 'allCategories', 'categoriesForProduct'));
    }

    
    public function updateInventary(Request $request){
        
        $priceProduct= PriceProduct::find($request->get("price_product_id"));
        
        
            $productInventary= new ProductInventary();
            $checkInventary=$productInventary->checkInventary($request->get("price_product_id"), $request->get("date"));
            if(!$checkInventary){
                $productInventary->price_product_id=$request->get("price_product_id");
                $productInventary->quantity=$request->get("quantity");
                $productInventary->date=$request->get("date");
                $productInventary->save();
            }else{
                $checkInventary->quantity=$request->get("quantity");
                $checkInventary->save();
            }
        

        
        
        return $request->all();
    }
    public function checkInventary(Request $request){
        
        if($this->checkmydate($request->get("dateProduct"))){
            
        
        $ProductInventary= new ProductInventary();
        
        if($request->get("typeProduct")==0){
            $product= Product::find($request->get("idProduct"));
            $priceProducts=$product->pricesProduct;
            $ids=$priceProducts->pluck("id");;
           
            $checkInventaryByIdsAndDate=$ProductInventary->checkInventaryByIdsAndDate($ids, $request->get("dateProduct"));
            $data=array();

            if(count($checkInventaryByIdsAndDate)>0){

                
                foreach ($checkInventaryByIdsAndDate as $pp) {
                    $PriceProduct= PriceProduct::find($pp->price_product_id);

                    $data[]=array("quantity"=>$pp->quantity,"date"=>$request->get("dateProduct"),"name"=>$PriceProduct->name,"id"=>$PriceProduct->id);
                }
                 
                 
            }else{
                foreach ($priceProducts as $pp) {
                    $data[]=array("quantity"=>$pp->quantity,"date"=>$request->get("dateProduct"),"name"=>$pp->name,"id"=>$pp->id);
                }
            }

            return array("data"=>array("status"=>200,"data"=>$data));

        }else{
            
            $PriceProduct= PriceProduct::find($request->get("typeProduct"));

            $checkInventary= $ProductInventary->checkInventary($request->get("typeProduct"), $request->get("dateProduct"));
            $data=array();
            if($checkInventary){
                $data=array("quantity"=>$checkInventary->quantity,"date"=>$request->get("dateProduct"),"name"=>$PriceProduct->name,"id"=>$PriceProduct->id);
            }else{
                $product= Product::find($request->get("idProduct"));
                
                
                
                
                
                $data=array("quantity"=>$product->quantity,"date"=>$request->get("dateProduct"),"name"=>$PriceProduct->name,"id"=>$PriceProduct->id);
            }
            
            return array("data"=>array("status"=>200,"data"=>array($data)));

        }
        }else{
            return array("data"=>array("status"=>500,"error"=>"la fecha no es valida"));
        }
       
        
    }
    
    
 public function checkmydate($date) {
  $timestamp = strtotime($date);
return $timestamp ? $date : null;
}
    
    public function updatePrices($request,$id){
        
        
        $priceProductModel= new PriceProduct();
        $priceProductModel->deleteAllById($id);
        
         if($request->has("prices")){
                $pricesJson= json_decode($request->get("prices"),true);
                
                foreach ($pricesJson as $priceJson) {
                    if(isset($priceJson["name"])){
                        $PriceProduct= new PriceProduct();
                        $PriceProduct->name=$priceJson["name"];
                        $PriceProduct->quantity=$priceJson["quantity"];
                        $PriceProduct->value=$priceJson["value"];
                        $PriceProduct->product_id=$id;
                        $PriceProduct->save();
                    }
                    
                }

            }else{
                $PriceProduct= new PriceProduct();
                
                $PriceProduct->product_id=$id;
                $PriceProduct->name="Normal";
                $PriceProduct->quantity=$request->get("quantity");
                $PriceProduct->value=$request->get("prices");
                $PriceProduct->save();
            }
    }
    // POST BR(E)AD
    public function update(Request $request, $id)
    {
        

        //config(['voyager.storage.disk' =>  "1/".config('voyager.storage.disk')]);


       
        
       // return config('voyager.storage.disk');
        $slug = $this->getSlug($request);

        $dataType = Voyager::model('DataType')->where('slug', '=', $slug)->first();
 
        // Compatibility with Model binding.
        $id = $id instanceof Model ? $id->{$id->getKeyName()} : $id;

        
        
        
        
        
        $data = call_user_func([$dataType->model_name, 'findOrFail'], $id);

        // Check permission
        $this->authorize('edit', $data);

        // Validate fields with ajax
        $val = $this->validateBread($request->all(), $dataType->editRows);

        if ($val->fails()) {
            return response()->json(['errors' => $val->messages()]);
        }

        if (!$request->ajax()) {
            $requestNew = $request;
            
           $this->updatePrices($request,$id);
            
            $requestNew['price'] = $request->price;

            $this->insertUpdateData($requestNew, $slug, $dataType->editRows, $data);

            event(new BreadDataUpdated($dataType, $data));

            CategoryProduct::where('product_id', $id)->delete();

            // Re-insert if there's at least one category checked
            $this->updateProductCategories($request, $id);

            return redirect()
                ->route("voyager.{$dataType->slug}.index")
                ->with([
                    'message'    => __('voyager.generic.successfully_updated')." {$dataType->display_name_singular}",
                    'alert-type' => 'success',
                ]);
        }
    }

    //***************************************
    //
    //                   /\
    //                  /  \
    //                 / /\ \
    //                / ____ \
    //               /_/    \_\
    //
    //
    // Add a new item of our Data Type BRE(A)D
    //
    //****************************************

    public function create(Request $request)
    {
        
        
        
        $slug = $this->getSlug($request);

        $dataType = Voyager::model('DataType')->where('slug', '=', $slug)->first();

        // Check permission
        $this->authorize('add', app($dataType->model_name));

        $dataTypeContent = (strlen($dataType->model_name) != 0)
                            ? new $dataType->model_name()
                            : false;

        foreach ($dataType->addRows as $key => $row) {
          
            try {
            $details = ($row->details);
            $dataType->addRows[$key]['col_width'] = isset($details->width) ? $details->width : 100;

            } catch (\Exception $exc) {
                dd($row,$exc->getMessage(),$exc->getLine());
            }

        }

        // If a column has a relationship associated with it, we do not want to show that field
        $this->removeRelationshipField($dataType, 'add');

        // Check if BREAD is Translatable
        $isModelTranslatable = is_bread_translatable($dataTypeContent);

        $view = 'voyager::bread.edit-add';

        if (view()->exists("voyager::$slug.edit-add")) {
            $view = "voyager::$slug.edit-add";
        }
        $allCategories = Category::where("type",$request->get("type"))->get();
        $allCities = City::all();
        $cityForProduct = collect([]);

        
                 $categoriesForProduct = collect([]);
         $regionModel=new City();
        $allRegions=$regionModel->getAllByCountry();
        
        
       $this->checkDefaultLatitude();
               $organizators= new Organizator();

                $organizatorByCountry =$organizators->getAllByCountry();

        return Voyager::view($view, compact('organizatorByCountry','allRegions','dataType', 'dataTypeContent', 'isModelTranslatable', 'allCities', 'allCategories', 'categoriesForProduct','cityForProduct'));
    }
    
    
    public function checkDefaultLatitude(){
         $lat=0;
        $lon=0;
        foreach (Auth::user()->countries as $country) {
            $lat=$country->latitude;
            $lon=$country->longitude;
        }
        
          config(["voyager.googlemaps.center.lat"=>$lat,"voyager.googlemaps.center.lng"=>$lon]);
          config()->set('voyager.googlemaps.center.lat', $lat); 
          config()->set('voyager.googlemaps.center.lng', $lon); 
    }

    /**
     * POST BRE(A)D - Store data.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
       
        $slug = $this->getSlug($request);

        $dataType = Voyager::model('DataType')->where('slug', '=', $slug)->first();

        // Check permission
        $this->authorize('add', app($dataType->model_name));

        // Validate fields with ajax
        $val = $this->validateBread($request->all(), $dataType->addRows);

        if ($val->fails()) {
            return response()->json(['errors' => $val->messages()]);
        }

        if (!$request->ajax()) {
            $requestNew = $request;
            $requestNew['price'] = $request->price;

            $data = $this->insertUpdateData($requestNew, $slug, $dataType->addRows, new $dataType->model_name());

            event(new BreadDataAdded($dataType, $data));

            $this->updateProductCategories($request, $data->id);

            return redirect()
                ->route("voyager.{$dataType->slug}.index")
                ->with([
                        'message'    => __('voyager.generic.successfully_added_new')." {$dataType->display_name_singular}",
                        'alert-type' => 'success',
                    ]);
        }
    }

    protected function updateProductCategories(Request $request, $id)
    {
        if ($request->category) {
            foreach ($request->category as $category) {
                CategoryProduct::create([
                    'product_id' => $id,
                    'category_id' => $category,
                ]);
            }
        }
    }
}
